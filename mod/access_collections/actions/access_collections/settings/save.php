<?php
/**
 * Admin action: access_collections/settings/save
 *
 * Overrides the default plugin settings save action to handle creation,
 * member-sync, and optional deletion of profile-type ACLs.
 * Only accessible by admins.
 */

use Facyla\AccessCollections\ProfileTypes;

// Only admins can use this (enforced by 'access' => 'admin' in elgg-plugin.php)

$params = get_input('params', []);

if (empty($params)) {
	return elgg_error_response(elgg_echo('access_collections:action:nothing'));
}

$allow_delete = ($params['allow_delete'] ?? 'no') === 'yes';
$updated = false;

$custom_profile_types = ProfileTypes::getProfileTypes();

foreach ($custom_profile_types as $guid => $name) {
	$key = 'profiletype_' . $guid;
	$setting_value = $params[$key] ?? null;

	// Save the enable/disable setting
	elgg_set_plugin_setting($key, $setting_value ?? 'no', 'access_collections');
	elgg_set_plugin_setting("profiletype_label_{$guid}", $params["profiletype_label_{$guid}"] ?? '', 'access_collections');

	$collection_name = 'profiletype:' . $name;
	$collection = access_collections_get_collection_by_name($collection_name);

	if ($setting_value === 'yes') {
		if (!$collection) {
			// Create new ACL via modern API
			$site_guid = elgg_get_site_entity()->guid;
			$collection = elgg_create_access_collection($collection_name, $site_guid, 'profiletype');
			if ($collection) {
				$updated = true;
				elgg_register_success_message(elgg_echo('access_collections:acl:created') . ' ' . $collection_name);
			} else {
				elgg_register_error_message(elgg_echo('access_collections:action:error') . ' ' . $collection_name);
				continue;
			}
		}

		// Sync members: diff current vs target
		$target_users = elgg_get_entities([
			'type' => 'user',
			'limit' => false,
			'metadata_name_value_pairs' => [
				['name' => 'custom_profile_type', 'value' => (int) $guid],
			],
		]);

		$target_guids = [];
		if ($target_users) {
			foreach ($target_users as $u) {
				$target_guids[] = (int) $u->guid;
			}
		}

		$current_members = $collection->getMembers(['limit' => 0]);
		$current_guids = is_array($current_members) ? array_map(fn($u) => (int) $u->guid, $current_members) : [];

		$to_add = array_diff($target_guids, $current_guids);
		$to_remove = array_diff($current_guids, $target_guids);

		foreach ($to_add as $ug) {
			$collection->addMember($ug);
		}
		foreach ($to_remove as $ug) {
			$collection->removeMember($ug);
		}

		$updated = true;

	} else {
		// Disabled
		if ($collection && $allow_delete) {
			$collection->delete();
			$updated = true;
			elgg_register_success_message(elgg_echo('access_collections:acl:removed') . ' ' . $collection_name);
		}
	}
}

// Always reset allow_delete to 'no' after the action runs
elgg_set_plugin_setting('allow_delete', 'no', 'access_collections');

if ($updated) {
	return elgg_ok_response('', elgg_echo('access_collections:action:updated'), REFERRER);
}

return elgg_ok_response('', elgg_echo('access_collections:action:nothing'), REFERRER);
