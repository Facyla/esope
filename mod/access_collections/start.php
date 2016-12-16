<?php
/**
 * access_collections plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 * Inspirations from roles_acl and elgg_quasi_access plugin for Elgg 1.8
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'access_collections_init');


/**
 * Init access_collections plugin.
 */
function access_collections_init() {
	
	elgg_extend_view('css', 'access_collections/css');
	
	// Add custom collections to user read access list
	elgg_register_plugin_hook_handler('access:collections:read', 'all', 'access_collections_add_read_acl', 999);
	
	// Add custom collections to user write access list
	elgg_register_plugin_hook_handler('access:collections:write', 'all', 'access_collections_add_write_acl', 999);
	
	/* Available access and collections hooks
	
	// Determines SQL where clauses for read access to data (return valid SQL clauses)
	elgg_register_plugin_hook_handler('get_sql', 'access', 'access_collections_get_sql', 999);
	//$clauses = _elgg_services()->hooks->trigger('get_sql', 'access', $options, $clauses);
	
	// Not so useful hooks (for this plugin)
	// When adding a collection (return false interrupts collection creation)
	// Note: the collection is created, but doesn't return the collection ID
	elgg_register_plugin_hook_handler('access:collections:addcollection', 'collection', 'access_collections_addcollection')
	// When deleting a collection (return false interrupts collection deletion)
	elgg_register_plugin_hook_handler('access:collections:deletecollection', 'collection', 'access_collections_deletecollection')
	// Add user to collection (return false interrupts user addition)
	elgg_register_plugin_hook_handler('access:collections:add_user', 'collection', 'access_collections_add_user')
	// Remove user from collection (return false interrupts user removal)
	elgg_register_plugin_hook_handler('access:collections:remove_user', 'collection', 'access_collections_remove_user')
	*/
	
	/* Some useful elements :
	
	*/
	
	
}


// Include hooks functions
//include_once(elgg_get_plugins_path() . 'access_collections/lib/access_collections/hooks.php');

/**
 * Get collection by its name
 *  @return object $collection
 */
function access_collections_get_collection_by_name($name) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT * FROM {$dbprefix}access_collections WHERE name = '{$name}'";
	$collection = get_data_row($query);
	return $collection;
}



// Get all ACL based on profile types
// Note : this currently doesn't clean old collections based on roles that have been removed
function access_collections_get_profile_types_acls() {
	static $profiletypes_acls = false;
	if (!$profiletypes_acls) {
		$profiletypes_acls = array();
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
						$new_collection_id = access_collections_profile_type_acl($guid);
						$collection = get_access_collection($new_collection_id);
					}
					if ($collection) { $profiletypes_acls[] = $collection; }
				} else {
					if ($collection) { delete_access_collection($collection->id); }
				}
			}
		}
		*/
		
		/* Get existing collections by using prefix filter
		*/
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT * FROM {$dbprefix}access_collections WHERE name LIKE 'profiletype:%'";
		$collections = get_data($query);
		foreach($collections as $collection) {
			// Check if the custom_profile_type ACL is enabled
			//if (elgg_get_plugin_setting('access_collections', 'profiletype_'.$guid) == 'yes') {
				$profiletypes_acls[] = $collection;
			//}
		}
		
	}
	return $profiletypes_acls;
}



/** 
 * Create / update an access collection
 *
 * @param array $criteria array any getter parameters that are valid with elgg_get_entities_from_relationship
 * @param array $collection_name optional name, requires to ensure that name is unique and that it doesn't overwrite an existing collection!
 * @param array $update_members
 * @return int $collection_id
 */
function access_collections_custom_acl($criteria = array(), $collection_name = '', $update_members = false) {
	
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
		$site_guid = elgg_get_site_entity()->guid;
		$collection_id = create_access_collection($collection_name, $owner_guid, $site_guid);
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
		$members = elgg_get_entities_from_relationship($params);
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



/** Allow access to entities that have a custom collection access id
 * 
 * @param string $hook Equals 'access:collections:read'
 * @param string $type Equals 'all'
 * @param array $return An array of ACLs before the hook
 * @param array $params Additional params
 * @uses $params['user_id'] GUID of the user whose read access array is being obtained
 *
 * @return array An array of ACLs : array($collection_id)
 */
function access_collections_add_read_acl($hook, $type, $access_array, $params) {
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
	// Add custom profile types collections
	$profile_types_acls = access_collections_get_profile_types_acls();
	if ($profile_types_acls) foreach($profile_types_acls as $collection) {
		if (!in_array($collection->id, $access_array)) {
			// Is user in this collection ?
			// Ensure that user is a member of that collection before adding to read access list
			$query = "SELECT * FROM {$dbprefix}access_collection_membership WHERE user_guid = '{$user_guid}' AND access_collection_id = '{$collection->id}'";
			$result = get_data_row($query);
			if ($result) {
				$custom_collections[$user_guid][] = $collection->id;
			}
		}
	}
	
	// Add admin-tailored collections
	
	// Add criteria-based collections
	
	foreach($collections as $collection) {
		// @TODO Check if member is owner or member of collection ?
		// Avoid duplicates
		$custom_collections[$user_guid][] = $collection->name;
	}
	*/
	
	if (is_array($custom_collections[$user_guid])) {
		$access_array = $access_array + $custom_collections[$user_guid];
	}
	
	return $access_array;
}

/** Add custom access to write access select
 *
 * @param string $hook Equals 'access:collections:write'
 * @param string $type Equals 'all'
 * @param array $access_array An array of ACLs before the hook
 * @param array $params Additional params
 * @uses $params['user_id'] GUID of the user whose read access array is being obtained
 *
 * @return array An array of ACLs : array($collection_id => $collection_name)
 */
function access_collections_add_write_acl($hook, $type, $access_array, $params) {
	static $custom_collections = false;
	$user_guid = sanitize_int($params['user_id']);
	$dbprefix = elgg_get_config('dbprefix');
	
	// Use cached results if already computed
	if (is_array($custom_collections[$user_guid])) {
		return $access_array + $custom_collections[$user_guid];
	}
	
	// Add custom collections to ACL select
	// @TODO Get collections that user can access to (member of or owner)
	$collections = array();
	
	// Add custom profile types collections
	$profile_types_acls = access_collections_get_profile_types_acls();
	foreach($profile_types_acls as $collection) {
		// Ensure that user is a member of that collection before adding to write access select
		$query = "SELECT * FROM {$dbprefix}access_collection_membership WHERE user_guid = '{$user_guid}' AND access_collection_id = '{$collection->id}'";
		$result = get_data_row($query);
		if ($result) {
			$custom_collections[$user_guid][$collection->id] = $collection->name;
		}
	}
	/* Same as read : no need to add if user is member of colelction
	
	// Add admin-tailored collections
	
	// Add criteria-based collections
	
	foreach($collections as $collection) {
		// @TODO Check if member is owner or member of collection ?
		$custom_collections[$user_guid][$collection->id] = $collection->name;
	}
	*/
	
	if (is_array($custom_collections[$user_guid])) {
		$access_array = $access_array + $custom_collections[$user_guid];
	}
	
	return $access_array;
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



// Create ACL based on a profile type (requires profile manager for profile types)
function access_collections_profile_type_acl($custom_profile_type_id = false) {
	if (elgg_is_active_plugin('profile_manager')) {
		$profiletype = get_entity($custom_profile_type_id);
		if (elgg_instanceof($profiletype, 'object', CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE)) {
			return access_collections_custom_acl(
					array(
							'metadata_name_value_pairs' => array('name' => 'custom_profile_type', 'value' => $custom_profile_type_id)
						),
						'profiletype:' . strtolower($profiletype->metadata_name),
						true
				);
		} else {
			register_error('Access collections error : Invalid profile type.');
		}
	} else {
		register_error('Access collections error : Profile manager is not enabled.');
	}
	return false;
}



