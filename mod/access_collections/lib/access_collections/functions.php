<?php
/**
 * access_collections plugin — Rewritten for Elgg 7.1.2 / PHP 8.3
 *
 * Uses \ElggAccessCollection API (Elgg 7 native).
 * No deprecated Elgg 3 functions.
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author  Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015-2026
 * @link    https://facyla.fr/
 */

use Elgg\Database\Select;
use Facyla\AccessCollections\ProfileTypes;

// ---------------------------------------------------------------------------
// 1. Lookup helpers
// ---------------------------------------------------------------------------

/**
 * Find an access collection by its exact name (raw SQL: read-only).
 */
function access_collections_get_collection_by_name(string $name): ?\ElggAccessCollection {
	// Direct DB lookup by exact name — elgg_get_access_collections() does not
	// support filtering by 'name' (only 'owner_guid' and 'subtype' are supported).
	$qb = Select::fromTable('access_collections');
	$qb->select('*')
		->where($qb->compare('name', '=', $name, ELGG_VALUE_STRING));
	$row = elgg()->db->getDataRow($qb);
	if ($row) {
		return new \ElggAccessCollection($row);
	}
	return null;
}

/**
 * Return the ACL id for a given profile type metadata name.
 */
function access_collections_get_acl_from_profile_type(string $name): int|false {
	$profile_type_acls = access_collections_get_profile_types_acls();
	foreach ($profile_type_acls as $guid => $collection) {
		if (str_starts_with($collection->name, 'profiletype:') && substr($collection->name, 12) === $name) {
			return (int) $collection->id;
		}
	}
	return false;
}

// ---------------------------------------------------------------------------
// 2. Profile-type ACL listing
// ---------------------------------------------------------------------------

/**
 * Get all ACLs based on profile types.
 *
 * @param bool $include_disabled If true, return *all* profiletype-named collections
 * @return array  [profiletype_guid => \ElggAccessCollection]
 */
function access_collections_get_profile_types_acls(bool $include_disabled = false): array {
	static $profiletypes_all_acls = null;
	static $profiletypes_acls = null;

	if ($include_disabled && $profiletypes_all_acls !== null) {
		return $profiletypes_all_acls;
	}
	if (!$include_disabled && $profiletypes_acls !== null) {
		return $profiletypes_acls;
	}

	// Get all existing profiletype collections by name prefix
	$qb = Select::fromTable('access_collections');
	$qb->select('*')
		->where($qb->compare('name', 'like', 'profiletype:%', ELGG_VALUE_STRING));
	$rows = elgg()->db->getData($qb);

	$all = [];
	if ($rows) {
		foreach ($rows as $row) {
			$collection = new \ElggAccessCollection($row);
			$guid = ProfileTypes::getProfileTypeGuid(substr($collection->name, 12));
			if ($guid !== false) {
				$all[$guid] = $collection;
			} else {
				$all['orphan_' . $collection->id] = $collection;
			}
		}
	}

	if ($include_disabled) {
		$profiletypes_all_acls = $all;
		return $all;
	}

	// Only enabled
	$enabled = [];
	$custom_profile_types = ProfileTypes::getProfileTypes();
	foreach ($custom_profile_types as $guid => $name) {
		if (elgg_get_plugin_setting('profiletype_' . $guid, 'access_collections') === 'yes') {
			if (isset($all[$guid])) {
				$enabled[$guid] = $all[$guid];
			}
		}
	}

	$profiletypes_acls = $enabled;
	return $enabled;
}

// ---------------------------------------------------------------------------
// 3. ACL creation / member sync (Elgg 7 API)
// ---------------------------------------------------------------------------

/**
 * Create or reuse a custom ACL and optionally sync its members.
 *
 * @param array  $criteria         e.g. ['metadata_name_value_pairs' => [...]]
 * @param string $collection_name  Unique name for the collection
 * @param bool   $update_members   Whether to diff-add/remove members
 * @return \ElggAccessCollection|null
 */
function access_collections_create_custom_acl(array $criteria = [], string $collection_name = '', bool $update_members = false): ?\ElggAccessCollection {
	if (empty($collection_name)) {
		// Derive a deterministic name from criteria
		$hash = '';
		foreach ($criteria as $k => $v) {
			$hash .= $k . '=' . (is_array($v) ? implode(',', $v) : $v) . '|';
		}
		$collection_name = 'access_collections:' . md5($hash);
	}

	// Reuse existing
	$collection = access_collections_get_collection_by_name($collection_name);
	if (!$collection) {
		$site_guid = elgg_get_site_entity()->guid;
		$collection = elgg_create_access_collection($collection_name, $site_guid, 'profiletype');
		if (!$collection) {
			return null;
		}
		$update_members = true; // first creation always needs members
	}

	if ($update_members) {
		$params = array_merge([
			'type'  => 'user',
			'limit' => false,
		], $criteria);

		$members = elgg_get_entities($params);
		$target_guids = [];
		if ($members) {
			foreach ($members as $m) {
				$target_guids[] = (int) $m->guid;
			}
		}

		// Diff: current vs target
		$current_members = $collection->getMembers(['limit' => 0]);
		$current_guids = is_array($current_members) ? array_map(fn($u) => (int) $u->guid, $current_members) : [];

		$to_add = array_diff($target_guids, $current_guids);
		$to_remove = array_diff($current_guids, $target_guids);

		foreach ($to_add as $guid) {
			$collection->addMember($guid);
		}
		foreach ($to_remove as $guid) {
			$collection->removeMember($guid);
		}
	}

	return $collection;
}

/**
 * Create an ACL for a specific profile type.
 *
 * @param int|false $custom_profile_type_id Guid of the profile type entity
 * @return \ElggAccessCollection|null
 */
function access_collections_create_profile_type_acl(int|false $custom_profile_type_id = false): ?\ElggAccessCollection {
	if (!elgg_is_active_plugin('profile_manager')) {
		elgg_register_error_message(elgg_echo('access_collections:profile_manager:disabled'));
		return null;
	}

	$profiletype = get_entity($custom_profile_type_id);

	// Define constant if not already done
	if (!defined('CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE')) {
		define('CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE', 'custom_profile_type');
	}

	if (!$profiletype instanceof \ElggObject || $profiletype->getSubtype() !== CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE) {
		elgg_register_error_message(elgg_echo('access_collections:invalidprofiletype'));
		return null;
	}

	return access_collections_create_custom_acl(
		[
			'metadata_name_value_pairs' => [
				['name' => 'custom_profile_type', 'value' => (int) $custom_profile_type_id],
			],
		],
		'profiletype:' . strtolower((string) $profiletype->metadata_name),
		true
	);
}

// ---------------------------------------------------------------------------
// 4. Event handlers — read/write access and metadata sync
// ---------------------------------------------------------------------------

/**
 * add custom ACLs to read access select
 *
 * @param \Elgg\Event $event  'access:collections:read', 'user'
 * @return array
 */
function access_collections_add_read_acl(\Elgg\Event $event): array {
	$access_array = $event->getValue();
	$params = $event->getParams();
	$user_guid = (int) $params['user_id'];

	// ---- static cache ----
	static $custom_collections = [];
	if (isset($custom_collections[$user_guid])) {
		return $access_array + $custom_collections[$user_guid];
	}

	$custom_collections[$user_guid] = [];

	// Add profile-type collections the user is a member of
	$profile_types_acls = access_collections_get_profile_types_acls(true);
	foreach ($profile_types_acls as $collection) {
		if ($collection->hasMember($user_guid)) {
			$custom_collections[$user_guid][] = $collection->id;
		}
	}

	return $access_array + $custom_collections[$user_guid];
}

/**
 * add custom ACLs to write access select
 *
 * @param \Elgg\Event $event  'access:collections:write', 'user'
 * @return array
 */
function access_collections_add_write_acl(\Elgg\Event $event): array {
	$access_array = $event->getValue();
	$params = $event->getParams();
	$user_guid = (int) $params['user_id'];

	static $custom_collections = [];
	if (isset($custom_collections[$user_guid])) {
		return $access_array + $custom_collections[$user_guid];
	}

	$custom_collections[$user_guid] = access_collections_get_custom_collections($user_guid);
	return $access_array + $custom_collections[$user_guid];
}

/**
 * Build the map [collection_id => display_name] for a given user.
 */
function access_collections_get_custom_collections(int $user_guid): array {
	$collections = [];
	$profile_types_acls = access_collections_get_profile_types_acls();

	foreach ($profile_types_acls as $guid => $collection) {
		if ($collection->hasMember($user_guid)) {
			$label = (string) elgg_get_plugin_setting("profiletype_label_{$guid}", 'access_collections');
			if ($label === '' || $label === '0') {
				$label = elgg_echo($collection->name);
				if ($label === $collection->name) {
					$label = $collection->name;
				}
			}
			$collections[$collection->id] = $label;
		}
	}

	return $collections;
}

/**
 * Merge custom collections into an existing access options array.
 */
function access_collections_add_custom_collections_options(array $access_options = [], int|false $user_guid = false): array {
	if ($user_guid === false) {
		if (!elgg_is_logged_in()) {
			return $access_options;
		}
		$user_guid = elgg_get_logged_in_user_guid();
	}

	$custom_collections = access_collections_get_custom_collections((int) $user_guid);
	foreach ($custom_collections as $collection_id => $collection_name) {
		if (!isset($access_options[$collection_id])) {
			$access_options[$collection_id] = $collection_name;
		}
	}

	return $access_options;
}

// ---------------------------------------------------------------------------
// 5. Metadata update handler — sync ACL membership on profile_type change
// ---------------------------------------------------------------------------

/**
 * Adds or removes members from profile-type collections on metadata change
 *
 * @param \Elgg\Event $event  'create'|'update', 'metadata'
 * @return void
 */
function access_collections_metadata_update(\Elgg\Event $event): void {
	$metadata = $event->getObject();
	if (!$metadata instanceof \ElggMetadata || $metadata->name !== 'custom_profile_type') {
		return;
	}

	$entity = get_entity($metadata->entity_guid);
	if (!$entity instanceof \ElggUser) {
		return;
	}

	$new_value = (int) $metadata->value;

	// Iterate all profiletype ACLs (including disabled) and sync membership
	$profiletype_acls = access_collections_get_profile_types_acls(true);
	foreach ($profiletype_acls as $profiletype_guid => $collection) {
		if ((int) $profiletype_guid === $new_value) {
			$collection->addMember($metadata->entity_guid);
		} else {
			$collection->removeMember($metadata->entity_guid);
		}
	}
}

// ---------------------------------------------------------------------------
// 6. Fallback esope_get_profiletypes / esope_get_profiletype_guid
//    (defined here when esope/theme_linagora_start doesn't provide them)
// ---------------------------------------------------------------------------

// These are provided by theme_linagora_start for the active site, but we
// define them as passthrough to ProfileTypes for standalone/dependency safety.
if (!function_exists('esope_get_profiletypes')) {
	function esope_get_profiletypes(bool $use_translation = false, bool $use_meta_key = false): array {
		return ProfileTypes::getProfileTypes($use_translation, $use_meta_key);
	}
}

if (!function_exists('esope_get_profiletype_guid')) {
	function esope_get_profiletype_guid(string $profiletype_name): int|false {
		return ProfileTypes::getProfileTypeGuid($profiletype_name);
	}
}
