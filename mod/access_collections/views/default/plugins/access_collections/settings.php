<?php

/* Settings :
 * ACL based on profile types : select which should be created and added to read/write access select
 * Custom ACL based on admin-picked members : direct members list configuration through settings
 * Custom ACL based on criteria : selection criteria through settings
*/


$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


echo '<div class="elgg-output">';

// View existing profile types and create collections for them
if (elgg_is_active_plugin('profile_manager')) {
	echo '<h3>Custom profile types collections</h3>';
	echo '<h4>Custom profile types</h4>';
	echo '<p>Select which custom types should have their own access collection</p>';
	$profiletypes_opt = esope_get_profiletypes(true);
	//echo '<p><label>' . elgg_view('input/checkboxes', array('name' => 'params[profiletypes]', 'value' => $vars['entity']->profiletypes, 'options' => $profiletypes_opt)) . '</label></p>';
	// Display current profiletypes and correpsonding collections
	$custom_profile_types = esope_get_profiletypes();
	if ($custom_profile_types) {
		echo '<ul>';
		foreach($custom_profile_types as $guid => $custom_profile_type_name) {
			echo '<p>';
			echo '<label>' . $custom_profile_type_name . ' (' . $guid . ')' . elgg_view('input/select', array('name' => 'params[profiletype_'.$guid.']', 'value' => $vars['entity']->{'profiletype_'.$guid}, 'options_values' => $ny_opt)) . '</label> &nbsp; ';
			// Get existing collection based by name
			$collection = access_collections_get_collection_by_name('profiletype:'.$custom_profile_type_name);
			// Update corresponding collections (create or remove)
			if ($vars['entity']->{'profiletype_'.$guid} == 'yes') {
				if (!$collection) {
					// Create collection
					$new_collection_id = access_collections_profile_type_acl($guid);
					$collection = get_access_collection($new_collection_id);
					echo 'creating ';
				}
				echo 'ACL = ' . $collection->name . ' (' . $collection->id . ')';
			} else {
				if ($collection) {
					delete_access_collection($collection->id);
					echo ' existing ACL removed</li>';
				} else {
					echo 'no ACL';
				}
			}
			echo '</p>';
		}
		echo '</ul>';
	}
	echo '<div class="clearfloat"></div><br />';
}


// Admin custom collections
echo '<h3>Admin-defined collections</h3>';
echo '<div class="clearfloat"></div><br />';


echo '<h3>Create new collection</h3>';
$criteria = array('metadata_name_value_pairs' => array('name' => 'custom_profile_type', 'value' => '724'));
$new_collection_id = access_collections_custom_acl($criteria);
echo '<p>New collection id : ' . $new_collection_id . '</p>';

// View special collection members
echo '<p>New collection members :</p>';
$new_collection = get_access_collection($new_collection_id);
$members = get_members_of_access_collection($new_collection_id, false);
if ($members) {
	echo '<ul>';
	foreach($members as $ent) {
		echo '<li>' . $ent->username . ' = ' . $ent->name . ' (' . $ent->guid . ')</li>';
	}
	echo '</ul>';
}
echo '<div class="clearfloat"></div><br />';



/*
// View existing collections
echo '<h4>Existing collections</h4>';
echo '<div class="clearfloat"></div><br />';

// View user read collections
echo '<h4>User read collections</h4>';
echo '<div class="clearfloat"></div><br />';

// View user write collections
echo '<h4>User write collections</h4>';
echo '<div class="clearfloat"></div><br />';
*/




echo '</div>';

