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

if ($vars['entity']->allow_delete == 'yes') { $allow_deletion = true; } else { $allow_deletion = false; }


echo '<div class="elgg-output">';

// View existing profile types and create collections for them
if (elgg_is_active_plugin('profile_manager')) {
	echo '<h3>' . elgg_echo('access_collections:collections:profiletypes') . '</h3>';
	// Always force again to 'no' (enable once for immediate modifications)
	echo '<p><label>' . elgg_echo('access_collections:delete:enable') . elgg_view('input/select', array('name' => 'params[allow_delete]', 'value' => 'no', 'options_values' => $ny_opt)) . '</label></p>';
	echo '<h4>' . elgg_echo('access_collections:profiletypes') . '</h4>';
	echo '<p>' . elgg_echo('access_collections:profiletypes:select') . '</p>';
	
	// Display current profiletypes and corresponding collections
	$profiletypes_opt = esope_get_profiletypes(true);
	$custom_profile_types = esope_get_profiletypes();
	if ($custom_profile_types) {
		echo '<ul>';
		foreach($custom_profile_types as $guid => $custom_profile_type_name) {
			// Get existing collection based by name
			$collection = access_collections_get_collection_by_name('profiletype:'.$custom_profile_type_name);
			if ($vars['entity']->{'profiletype_'.$guid} == 'yes') {
				echo '<li class="enabled">';
			} else {
				if ($collection) {
					echo '<li class="existing">';
				} else {
					echo '<li class="disabled">';
				}
			}
			// Display information and select
			echo '<label>' . $custom_profile_type_name . ' (' . $guid . ')' . elgg_view('input/select', array('name' => 'params[profiletype_'.$guid.']', 'value' => $vars['entity']->{'profiletype_'.$guid}, 'options_values' => $ny_opt)) . '</label> &nbsp; ';
			// Update corresponding collections (create or remove)
			if ($vars['entity']->{'profiletype_'.$guid} == 'yes') {
				if (!$collection) {
					// Create collection
					$new_collection_id = access_collections_profile_type_acl($guid);
					$collection = get_access_collection($new_collection_id);
					system_message(elgg_echo('access_collections:acl:created'));
				}
			} else {
				if ($collection) {
					// Add some protection to avoid accidental ACL removal
					if ($allow_deletion) {
						delete_access_collection($collection->id);
						$colelction = false;
						system_message(elgg_echo('access_collections:acl:removed'));
					} else {
						echo elgg_echo('access_collections:acl:delete:locked');
					}
				} else {
					echo elgg_echo('access_collections:noacl');
				}
			}
			if ($collection) {
				echo '<br />' . elgg_echo('access_collections:acl', array($collection->name, $collection->id));
			}
			echo '</li>';
		}
		echo '</ul>';
	}
	echo '<div class="clearfloat"></div><br />';
}


// Admin custom collections
echo '<h3>' . elgg_echo('access_collections:collections:admin') . '</h3>';
echo '<p>' . elgg_echo('access_collections:upcomingfeature') . '</p>';
echo '<div class="clearfloat"></div><br />';


echo '<h3>' . elgg_echo('access_collections:collection:new') . '</h3>';
echo '<p>' . elgg_echo('access_collections:upcomingfeature') . '</p>';
/* Create special collection
$criteria = array('metadata_name_value_pairs' => array('name' => 'custom_profile_type', 'value' => '724'));
$new_collection_id = access_collections_custom_acl($criteria);
echo '<p>' . elgg_echo('access_collections:collection:newid', array($new_collection_id)) . '</p>';

// View special collection members
echo '<p>' . elgg_echo('access_collections:collection:newmembers') . '&nbsp;:</p>';
$new_collection = get_access_collection($new_collection_id);
$members = get_members_of_access_collection($new_collection_id, false);
if ($members) {
	echo '<ul>';
	foreach($members as $ent) {
		echo '<li>' . $ent->username . ' = ' . $ent->name . ' (' . $ent->guid . ')</li>';
	}
	echo '</ul>';
}
*/
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

