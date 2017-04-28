<?php
/**
 * Iris v2 profile header info
 */

$own = elgg_get_page_owner_entity();
$user = elgg_get_page_owner_entity();


/* Champs LDAP Inria : 
inria_location_main [dropdown]
inria_location [multiselect]
epi_ou_service [tags]
inria_room [tags]
inria_phone [tags]
*/
?>

<div class="iris-profile-info-field">
	<?php
	$profile_type = '';
	$profile_type_guid = $user->custom_profile_type;
	if(($profile_type_ent = get_entity($profile_type_guid)) && ($profile_type_ent instanceof ProfileManagerCustomProfileType)){
		$profile_type = $profile_type_ent->getTitle();
		echo elgg_echo("profile_manager:user_details:profile_type") . '<br /><strong>' . $profile_type_ent->getTitle() . '</strong>';
	}
	?>
</div>
<div class="iris-profile-info-field">
	Localisation<br />
	<strong><?php echo $user->inria_location; ?></strong>
</div>
<div class="iris-profile-info-field">
	Rattachement<br />
	<strong><?php echo $user->inria_location_main; ?></strong>
</div>
<div class="iris-profile-info-field">
	EPI ou service<br />
	<strong><?php echo $user->epi_ou_service; ?></strong>
</div>
<div class="iris-profile-info-field">
	Bureau<br />
	<strong><?php echo $user->inria_room; ?></strong>
</div>
	<?php


// Inria fields (from LDAP)
$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

// Display only for Inria accounts (LDAP data), and for logged in, Inria viewers - or admins
if ( ($profile_type == 'inria') && (elgg_is_admin_logged_in() || $user_profile_type == 'inria') ) {
	// Following hasn't be modified (except the inria cat filter)
	foreach($cats as $cat_guid => $cat){
		$cat_title = "";
		$field_result = "";
		$even_odd = "even";
	
		// Display only Inria category fields (LDAP data)
		if (($cat instanceof ProfileManagerCustomFieldCategory) && ($cat->metadata_name == 'inria')) {} else { continue; }
	
		if($show_header){
			// make nice title
			if($cat_guid == -1){
				$title = elgg_echo("profile_manager:categories:list:system");
			} elseif($cat_guid == 0){
				if(!empty($cat)){
					$title = $cat;
				} else {
					$title = elgg_echo("profile_manager:categories:list:default");
				}
			} elseif($cat instanceof ProfileManagerCustomFieldCategory) {
				$title = $cat->getTitle();
			} else {
				$title = $cat;
			}
		
			$params = array(
				'text' => ' ',
				'href' => "#",
				'class' => 'elgg-widget-collapse-button',
				'rel' => 'toggle',
			);
			$collapse_link = elgg_view('output/url', $params);
		
			$cat_title = "<h3>" . $title . "</h3>\n";
		}
	
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
			$field_result .= "<b>Email</b>:&nbsp;" . elgg_view("output/email", array("value" =>  $user->email));
			$field_result .= "</div>\n";
			$details_result .= "<div>" . $field_result . "</div>";
		}
	}
	if ($details_result) {
		if ($user_profile_type && ($user->guid == $own->guid)) {
			$details_result .= '<p class="update-ldap-details">' . elgg_echo('theme_inria:ldapprofile:updatelink') . '</p>';
		}
		$inria_fields = '<div class="inria-ldap-details"><h3>' . elgg_echo('theme_inria:ldapdetails') . '</h3>' . $details_result . '</div>';
	}
}
echo $inria_fields;


