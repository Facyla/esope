<?php
/**
 * Iris v2 profile header info
 */

$own = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();


/* Champs LDAP Inria : 
inria_location_main [dropdown]
inria_location [multiselect]
epi_ou_service [tags]
inria_room [tags]
inria_phone [tags]
*/


$profile_type = '';
$profile_type_ent = get_entity($user->custom_profile_type);
if ($profile_type_ent instanceof ProfileManagerCustomProfileType) {
	$profile_type = $profile_type_ent->metadata_name;
	$profile_type_label = $profile_type_ent->getTitle();
}
// Archive : replace profile type by member status archived
if ($user->memberstatus == 'closed') {
	$profile_type = 'archive';
	$profile_type_label = elgg_echo('profile:types:archive');
}
$own_profile_type = esope_get_user_profile_type($own);

$show_inria_fields = false;
if (($profile_type == 'inria') && (elgg_is_admin_logged_in() || ($own_profile_type == 'inria'))) { $show_inria_fields = true; }

if (!empty($profile_type_label)) {
	echo '<div class="iris-profile-info-field">';
	echo elgg_echo('theme_inria:user:profile_type') . '<br /><strong>' . $profile_type_label . '</strong>';
	echo '</div>';
}

// Display only for Inria accounts (LDAP data), and for logged in, Inria viewers - or admins
if ($show_inria_fields) {
	if ($user->inria_location) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:inria_location') . '<br />
			<strong>' . implode(', ', (array)$user->inria_location) . '</strong>
		</div>';
	}
	if (!empty(trim($user->inria_location_main))) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:inria_location_main') . '<br />
			<strong>' . $user->inria_location_main . '</strong>
		</div>';
	}
	if ($user->epi_ou_service) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:epi_ou_service') . '<br />
			<strong>' . elgg_view('output/tags', array('value' => $user->epi_ou_service)) . '</strong>
		</div>';
	}
	if ($user->inria_room) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:inria_room') . '<br />
			<strong>' . implode(', ', (array)$user->inria_room) . '</strong>
		</div>';
	}
	/*
	if (!empty(trim($user->inria_phone))) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:inria_phone') . '<br />
			<strong>' . implode(', ', (array)$user->inria_phone) . '</strong>
		</div>';
	}
	if (!empty(trim($user->email))) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:email') . '<br />
			<strong>' . elgg_view("output/email", array("value" =>  $user->email)) . '</strong>
		</div>';
	}
	*/
}


if (strtolower($profile_type) == 'external') {
	if (!empty(trim($user->organisation))) {
		echo '<div class="iris-profile-info-field">' . elgg_echo('profile:organisation') . '<br />';
			// @TODO organisations cliquables => recherche par tag
			//echo '<strong>' . implode(', ', (array)$user->organisation) . '</strong>';
			foreach((array)$user->organisation as $organisation) {
				echo '<a href="' . $url . 'members/?q=' . $organisation . '">' . $organisation . '</a>';
			}
		echo '</div>';
	}
	if (!empty(trim($user->fonction))) {
		echo '<div class="iris-profile-info-field">
			' . elgg_echo('profile:fonction') . '<br />
			<strong>' . implode(', ', (array)$user->fonction) . '</strong>
		</div>';
	}
}



// Inria fields (from LDAP)
$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

// Display only for Inria accounts (LDAP data), and for logged in, Inria viewers - or admins
//if (($profile_type == 'inria') && (elgg_is_admin_logged_in() || ($own_profile_type == 'inria'))) {
if ($show_inria_fields) {
	// Following hasn't be modified (except the inria cat filter)
	foreach($cats as $cat_guid => $cat){
		$cat_title = "";
		$field_result = "";
		$even_odd = "even";
	
		// Display only Inria category fields (LDAP data)
		//if (($cat instanceof ProfileManagerCustomFieldCategory) && ($cat->metadata_name == 'inria')) {} else { continue; }
	
		foreach($fields[$cat_guid] as $field){
		
			$metadata_name = $field->metadata_name;
		
			if($metadata_name != "description"){
				// give correct class
				if($even_odd != "even"){
					$even_odd = "even";
				} else {
					$even_odd = "odd";
				}
			
				// make nice title
				$title = $field->getTitle();
			
				// get user value
				$value = $user->$metadata_name;
			
				// adjust output type
				if($field->output_as_tags == "yes"){
					$output_type = "tags";
					if(!is_array($value)){
						$value = string_to_tag_array($value);
					}
				} else {
					$output_type = $field->metadata_type;
				}
			
				if($field->metadata_type == "url"){
					$target = "_blank";
					// validate urls
					if (!preg_match('~^https?\://~i', $value)) {
						$value = "http://$value";
					}
				} else {
					$target = null;
				}
			
				// build result
				$field_result .= "<div class='" . $even_odd . "'>";
				$field_result .= "<b>" . $title . "</b>:&nbsp;";
				$field_result .= elgg_view("output/" . $output_type, array("value" =>  $value, "target" => $target));
				$field_result .= "</div>\n";
			}
		}
	
		if(!empty($field_result)){
			$details_result .= $cat_title;
			// Add email
			$field_result .= "<div class='" . $even_odd . "'>";
			$field_result .= "<b>" . elgg_echo('profile:email') . "</b>:&nbsp;" . elgg_view("output/email", array("value" =>  $user->email));
			$field_result .= "</div>\n";
			$details_result .= "<div>" . $field_result . "</div>";
		}
	}
	if ($details_result) {
		if ($own_profile_type && ($user->guid == $own->guid)) {
			$details_result .= '<p class="update-ldap-details">' . elgg_echo('theme_inria:ldapprofile:updatelink') . '</p>';
		}
		$inria_fields = '<div class="inria-ldap-details"><h3>' . elgg_echo('theme_inria:ldapdetails') . '</h3>' . $details_result . '</div>';
	}
}


