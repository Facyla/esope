<?php
/**
 * access_collections plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015-2021
 * @link https://facyla.fr/
 * Inspirations from roles_acl and elgg_quasi_access plugin for Elgg 1.8
 */

// Include hooks functions
//include_once(elgg_get_plugins_path() . 'access_collections/lib/access_collections/hooks.php');

/**
 * Get collection by its name
 *  @return object $collection
 */
function access_collections_get_collection_by_name($name) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT * FROM {$dbprefix}access_collections WHERE name = '{$name}'";
	//$collection = get_data_row($query);
	$collection = elgg()->db->getDataRow($query);
	return $collection;
}



// Get all ACL based on profile types
// Note : this currently doesn't clean old collections based on roles that have been removed
// ..and it should not (too risky, keep control over deletion)
// @return array($profile_type_guid => $collection)
function access_collections_get_profile_types_acls($include_disabled = false) {
	// Use caching
	static $profiletypes_all_acls = false;
	static $profiletypes_acls = false;
	if ($include_disabled && $profiletypes_all_acls) { return $profiletypes_all_acls; }
	if (!$include_disabled && $profiletypes_acls) { return $profiletypes_acls; }
	
	/*
	// Get profile types and check corresponding collections
	$custom_profile_types = esope_get_profiletypes();
	if ($custom_profile_types) {
		foreach($custom_profile_types as $guid => $custom_profile_type_name) {
			// Check if the custom_profile_type ACL is enabled
			$collection = access_collections_get_collection_by_name('profiletype:'.$custom_profile_type_name);
			if (elgg_get_plugin_setting('access_collections', 'profiletype_'.$guid) == 'yes') {
				if (!$collection) {
					// Create collection
					$new_collection_id = access_collections_create_profile_type_acl($guid);
					$collection = get_access_collection($new_collection_id);
				}
				if ($collection) { $profiletypes_acls[] = $collection; }
			} else {
				if ($collection) { delete_access_collection($collection->id); }
			}
		}
	}
	*/
	
	
	if ($include_disabled) {
		// Get all existing profilteype collections by using prefix filter
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT * FROM {$dbprefix}access_collections WHERE name LIKE 'profiletype:%'";
		//$collections = get_data($query);
		$collections = elgg()->db->getData($query);
		if ($collections) {
			$profiletypes_all_acls = array();
			foreach($collections as $collection) {
				// Get profile_type guid from its name (remove prefix)
				$guid = esope_get_profiletype_guid(substr($collection->name, 12));
				if ($guid) {
					$profiletypes_all_acls[$guid] = $collection;
				} else {
					$profiletypes_all_acls[] = $collection;
				}
			}
		}
		return $profiletypes_all_acls;
	} else {
		// Get only enabled profiletype collections
		$profiletypes_acls = array();
		$custom_profile_types = esope_get_profiletypes();
		if ($custom_profile_types) {
			foreach($custom_profile_types as $guid => $custom_profile_type_name) {
				if (elgg_get_plugin_setting('profiletype_'.$guid, 'access_collections') == 'yes') {
					// Get existing collection based on name
					$collection = access_collections_get_collection_by_name('profiletype:'.$custom_profile_type_name);
					if ($collection) { $profiletypes_acls[$guid] = $collection; }
				}
			}
		}
		return $profiletypes_acls;
	}
	//return array();
}



/** 
 * Create / update members of an access collection
 *
 * @param array $criteria array any getter parameters that are valid with elgg_get_entities_from_relationship
 * @param array $collection_name optional name, requires to ensure that name is unique and that it doesn't overwrite an existing collection!
 * @param array $update_members
 * @return int $collection_id
 */
function access_collections_create_custom_acl($criteria = array(), $collection_name = '', $update_members = false) {
	
	// Membership criteria
	$select_criteria = '';
	foreach($criteria as $name => $value) {
		$select_criteria .= $name . '=' . implode(',', $value) . '|';
	}
	
	if (empty($collection_name)) {
		// Create new name based on unique membership criteria
		$collection_name = 'acl:' . md5($select_criteria);
	}
	
	// get collection
	$collection = access_collections_get_collection_by_name($collection_name);
	// Create collection (params name, owner GUID, site GUID)
	if (!$collection) {
		$owner_guid = elgg_get_site_entity()->guid;
		$collection_subtype = 'profiletype';
		$collection_id = create_access_collection($collection_name, $owner_guid, $collection_subtype);
		$update_members = true;
	} else {
		$collection_id = $collection->id;
	}
	
	if ($update_members) {
		// Select collection members based on criteria
		$params = array(
				'type' => 'user',
				'limit' => 0,
			);
		// Add custom criteria
		foreach($criteria as $name => $value) { $params[$name] = $value; }
		$members = elgg_get_entities($params);
		$member_guids = array();
		if ($members) {
			foreach ($members as $m) {
				$member_guids[] = $m->guid;
			}
		}
		// Update collection members (even if empty list)
		// Note : real usage should add/remove users based on hooks
		update_access_collection($collection_id, $member_guids);
	}
	
	return $collection_id;
}



/** Allow read access to entities that have a custom ACL
 * 
 * @param string $hook Equals 'access:collections:read'
 * @param string $type Equals 'all'
 * @param array $return An array of ACLs before the hook
 * @param array $params Additional params
 * @uses $params['user_id'] GUID of the user whose read access array is being obtained
 *
 * @return array An array of ACLs : array($collection_id)
 */
function access_collections_add_read_acl(\Elgg\Hook $hook) {
	$access_array = $hook->getValue();
	$params = $hook->getParams();
	
	static $custom_collections = false;
	$user_guid = sanitize_int($params['user_id']);
	$dbprefix = elgg_get_config('dbprefix');
	
	// Use cached results if already computed
	if (is_array($custom_collections[$user_guid])) {
		return $access_array + $custom_collections[$user_guid];
	}
	
	// Add custom collections to ACL select
	// Save data to static cache
	// @TODO Get collections that user can access to (member of or owner)
	$collections = array();
	
	/* Note : there is actually no need to add collections a user is member of
	// Add custom profile types collections (including disabled -but existing- collections for BC reasons with old ACL)
	$profile_types_acls = access_collections_get_profile_types_acls(true);
	if ($profile_types_acls) foreach($profile_types_acls as $collection) {
		if (!in_array($collection->id, $access_array)) {
			// Is user in this collection ?
			// Ensure that user is a member of that collection before adding to read access list
			$query = "SELECT * FROM {$dbprefix}access_collection_membership WHERE user_guid = '{$user_guid}' AND access_collection_id = '{$collection->id}'";
			$result = get_data_row($query);
			$result = elgg()->db->getDataRow($query);
			if ($result) {
				$custom_collections[$user_guid][] = $collection->id;
			}
		}
	}
	*/
	
	// Add admin-tailored collections
	
	// Add criteria-based collections
	/*
	foreach($collections as $collection) {
		// @TODO Check if member is owner or member of collection ?
		// Avoid duplicates
		$custom_collections[$user_guid][] = elgg_echo($collection->name);
	}
	*/
	
	if (is_array($custom_collections[$user_guid])) {
		$access_array = $access_array + $custom_collections[$user_guid];
	}
	
	return $access_array;
}

/** Add custom ACLs to write access select
 *
 * @param string $hook Equals 'access:collections:write'
 * @param string $type Equals 'all'
 * @param array $access_array An array of ACLs before the hook
 * @param array $params Additional params
 * @uses $params['user_id'] GUID of the user whose read access array is being obtained
 *
 * @return array An array of ACLs : array($collection_id => $collection_name)
 */
function access_collections_add_write_acl(\Elgg\Hook $hook) {
	$access_array = $hook->getValue();
	$params = $hook->getParams();
	
	static $custom_collections = false;
	$user_guid = sanitize_int($params['user_id']);
	// Use cached results if already computed
	if (is_array($custom_collections[$user_guid])) {
		return $access_array + $custom_collections[$user_guid];
	}
	
	$dbprefix = elgg_get_config('dbprefix');
	
	// Add custom collections to ACL select
	// @TODO Get collections that user can access to (member of or owner)
	$user_custom_collections = access_collections_get_custom_collections($user_guid);
	// Add custom profile types collections
	$custom_collections[$user_guid] = $user_custom_collections;
	
	/* Same as read : no need to add if user is member of collection
	
	// Add admin-tailored collections
	
	// Add criteria-based collections
	
	foreach($collections as $collection) {
		// @TODO Check if member is owner or member of collection ?
		$custom_collections[$user_guid][$collection->id] = elgg_echo($collection->name);
	}
	*/
	
	if (is_array($custom_collections[$user_guid])) {
		$access_array = $access_array + $custom_collections[$user_guid];
	}
	//error_log(print_r($profile_types_acls, true));
	//error_log(print_r($custom_collections, true));
	//error_log(print_r($access_array, true));
	return $access_array;
}

function access_collections_get_custom_collections($user_guid) {
	// Add custom collections to ACL select
	// @TODO Get collections that user can access to (member of or owner)
	$collections = [];
	$dbprefix = elgg_get_config('dbprefix');
	
	// Add custom profile types collections
	$profile_types_acls = access_collections_get_profile_types_acls();
	if ($profile_types_acls) {
		foreach($profile_types_acls as $guid => $collection) {
			// Ensure that user is a member of that collection before adding to write access select
			$query = "SELECT * FROM {$dbprefix}access_collection_membership WHERE user_guid = '{$user_guid}' AND access_collection_id = '{$collection->id}'";
			//$result = get_data_row($query);
			$result = elgg()->db->getDataRow($query);
			if ($result) {
				$collection_label = elgg_echo($collection->name);
				if ($collection_label == $collection->name) { $collection_label = $collection->name; }
				$collection_label = elgg_get_plugin_setting("profiletype_label_$guid", 'access_collections');
				$custom_collections[$collection->id] = $collection_label;
			}
		}
	}
	return $custom_collections;
}

// Adds the access collections to an existing access options array
function access_collections_add_custom_collections_options($access_options = [], $user_guid = false) {
	if (!$user_guid) {
		if (!elgg_is_logged_in()) { return $access_options; }
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	$custom_collections = access_collections_get_custom_collections($user_guid);
	foreach($custom_collections as $collection_id => $collection_name) {
		if (!isset($access_options[$collection_id])) {
			$access_options[$collection_id] = $collection_name;
		}
	}
	return $access_options;
}


/**
 * Populates access WHERE sql clauses
 *
 * @param string $hook   "get_sql"
 * @param string $type   "access"
 * @param array  $return Clauses
 * @param array  $params Hook params
 * @return array
 */
/*
// Add new option for a valid access (keep previous clauses)
function access_collections_get_sql($hook, $type, $return, $params) {

	$ignore_access = elgg_extract('ignore_access', $params);
	if ($ignore_access) {
		return;
	}

	$user_guid = elgg_extract('user_guid', $params);
	if (!$user_guid) {
		return;
	}

	$prefix = elgg_get_config('dbprefix');
	$table_alias = $params['table_alias'] ? $params['table_alias'] . '.' : '';
	$guid_column = $params['guid_column'];

	if (strpos($table_alias, 'n_table') === 0) {
		// temp fix for https://github.com/Elgg/Elgg/pull/9290
		$guid_column = 'entity_guid';
	}
	
	// Based on access grant special access
	$return['ors'][] = "(EXISTS(SELECT 1 FROM {$prefix}entity_relationships er_access_grant
					WHERE er_access_grant.guid_one = {$table_alias}{$guid_column}
						AND er_access_grant.relationship = 'access_grant'
						AND er_access_grant.guid_two = {$user_guid}))";
	
	// Based on new friendsof access
	$id = ACCESS_FRIENDS_OF;
	$return['ors'][] = "{$table_alias}{$access_column} = {$id}
			AND {$table_alias}{$owner_guid_column} IN (
				SELECT guid_two FROM {$prefix}entity_relationships
				WHERE relationship='friend' AND guid_one = {$user_guid}
			)";

	return $return;
}
*/



// Creates ACL based on a profile type (requires profile manager for profile types)
function access_collections_create_profile_type_acl($custom_profile_type_id = false) {
	if (elgg_is_active_plugin('profile_manager')) {
		$profiletype = get_entity($custom_profile_type_id);
		if ($profiletype instanceof ElggObject && $profiletype->getSubtype() == CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE) {
			return access_collections_create_custom_acl(
					array(
							'metadata_name_value_pairs' => array('name' => 'custom_profile_type', 'value' => $custom_profile_type_id)
						),
						'profiletype:' . strtolower($profiletype->metadata_name),
						true
				);
		} else {
			register_error(elgg_echo('access_collections:invalidprofiletype'));
		}
	} else {
		register_error(elgg_echo('access_collections:profile_manager:disabled'));
	}
	return false;
}


// Adds or removes members from collections based on metadata changes
function access_collections_metadata_update(\Elgg\Event $event) {
	$metadata = $event->getObject();
	$entity = get_entity($metadata->entity_guid); // user
	$new_value = $metadata->value; // new profile type value
	if ($metadata->name == 'custom_profile_type') {
		// Update all profiletype-based collections on custom_profile_type update
		if ($entity instanceof ElggUser) {
			// Apply collection membership rules on updated entity
			// Check (all existing) profiletype-based ACLs
			$profiletype_acls = access_collections_get_profile_types_acls(true);
			foreach($profiletype_acls as $profiletype_guid => $collection) {
				// Note : for some reason, $user->custom_profile_type is not accessible anymore from here ; we don't need it anyway, as new metadata value is already known
				if ($profiletype_guid == $new_value) {
					//error_log("ACL : add user {$metadata->entity_guid} to ".$collection->id);
					add_user_to_access_collection($metadata->entity_guid, $collection->id);
				} else {
					//error_log("ACL : remove user {{$metadata->entity_guid}} from ".$collection->id);
					remove_user_from_access_collection($metadata->entity_guid, $collection->id);
				}
			}
		}
	}
}

// Fonctions liées à Profile_manager
if (elgg_is_active_plugin('profile_manager') && !elgg_is_active_plugin('esope')) {
	/* Returns all profile types as array of $profiletype_guid => $profiletype_name
	 * Can also return translated name (for use in a dropdown input)
	 * And also use metadata name as key (only when using translated name)
	 */
	function esope_get_profiletypes($use_translation = false, $use_meta_key = false) {
		$profile_types_options = array(
				"type" => "object", "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				"owner_guid" => elgg_get_site_entity()->getGUID(), "limit" => false,
			);
		if ($custom_profile_types = elgg_get_entities($profile_types_options)) {
			foreach($custom_profile_types as $type) {
				$profile_type = strtolower($type->metadata_name);
				if ($use_translation) {
					//$profiletypes[$type->guid] = elgg_echo('profile:types:' . $profile_type);
					if (!empty($type->metadata_label)) {
						$profile_type_name = $type->metadata_label;
					} else {
						$profile_type_name = elgg_echo('profile:types:' . $profile_type);
					}
					if ($use_meta_key) {
						$profiletypes[$profile_type] = $profile_type_name;
					} else {
						$profiletypes[$type->guid] = $profile_type_name;
					}
				} else {
					$profiletypes[$type->guid] = $profile_type;
				}
			}
		}
		return $profiletypes;
	}
	
	/* Returns guid for a specific profile type name (false if not found) */
	function esope_get_profiletype_guid($profiletype_name) {
		$profile_types = esope_get_profiletypes();
		if ($profile_types) foreach ($profile_types as $guid => $name) {
			if ($name == $profiletype_name) { return $guid; }
		}
		return false;
	}
	
}

