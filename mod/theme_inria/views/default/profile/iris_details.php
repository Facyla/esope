<?php
/**
 * Elgg user display (details)
 * @uses $vars['entity'] The user entity
 */

$own = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();
$own_profile_type = esope_get_user_profile_type($own);
$user_profile_type = esope_get_user_profile_type($user);

$show_inria_fields = false;
if (($profile_type == 'inria') && (elgg_is_admin_logged_in() || ($user_profile_type == 'inria'))) { $show_inria_fields = true; }

$about = "";
if ($user->isBanned()) {
	$about .= "<p class='profile-banned-user'>";
	$about .= elgg_echo('banned');
	$about .= "</p>";
} else {
	if ($user->description) {
		$about .= "<div class='profile-aboutme-contents'>";
		$about .= elgg_view('output/longtext', array('value' => $user->description, 'class' => 'mtn'));
		$about .= "</div>";
	}
}

//echo elgg_view("profile/status", array("entity" => $user));

$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

$details_result = "";

// Iris v2 : force some fields at first
$iris_skip_fields = array('briefdescription', 'description', 'phone', 'mobile', 'website', 'location', 'room', 'interests', 'skills');


$details_result .= '<div class="iris-profile-field">';
	$details_result .= '<h4>' . "Présentation" . '</h4>';
	$details_result .= $about;
	//$details_result .= elgg_view("output/longtext", array("value" =>  $user->description));

	if ($show_inria_fields) {
		if (!empty($user->inria_phone)) {
			echo '<div class="iris-profile-info-field"><i class="fa fa-phone"></i>&nbsp;' . implode(', ', $user->inria_phone) . '</div>';
		}
		if (!empty($user->email)) {
			echo '<div class="iris-profile-info-field"><i class="fa fa-envelope"></i>&nbsp;' . elgg_view("output/email", array("value" =>  $user->email)) . '</div>';
		}
	}
	
	if (!empty($user->phone) || !empty($user->mobile)) {
		$details_result .= '<p>';
		if (!empty($user->phone)) { $details_result .= '<i class="fa fa-phone"></i>&nbsp; ' . $user->phone . ' &nbsp; '; }
		if (!empty($user->mobile)) { $details_result .= '<i class="fa fa-mobile"></i>&nbsp; ' . $user->mobile . ' &nbsp; '; }
		$details_result .= '</p>';
	}
	
	if (!empty($user->website)) { $details_result .= '<p><i class="fa fa-globe"></i>&nbsp; ' . $user->website . '</p>'; }
	
	if (!empty($user->location) || !empty($user->room)) {
		$details_result .= '<p>';
		if (!empty($user->location)) { $details_result .= '<i class="fa fa-map-marker"></i>&nbsp;' . $user->location . ' &nbsp; '; }
		if (!empty($user->room)) { $details_result .= '<i class="fa fa-map-pin"></i>&nbsp;' . $user->room . ' &nbsp; '; }
		$details_result .= '</p>';
	}

$details_result .= "</div>\n";

$details_result .= '<div class="iris-profile-field">';
	$details_result .= '<h4>' . "Compétences & Centres d'intérêts" . '</h4>';
	$user_tags = array_merge((array)$user->skills, (array)$user->interests);
	$details_result .= elgg_view("output/tags", array("value" => $user_tags));
$details_result .= "</div>\n";


if(count($cats) > 0){
	foreach($cats as $cat_guid => $cat){
		// Skip Inria category fields (LDAP data)
		if (($cat instanceof ProfileManagerCustomFieldCategory) && ($cat->metadata_name == 'inria')) { continue; }
		
		foreach($fields[$cat_guid] as $field){
			$metadata_name = $field->metadata_name;
			if (in_array($metadata_name, $iris_skip_fields)) { continue; }
			
			// make nice title
			$title = $field->getTitle();
			// get user value
			$value = $user->$metadata_name;
			
			// adjust output type
			$output_type = $field->metadata_type;
			if($field->output_as_tags == "yes"){
				$output_type = "tags";
				if(!is_array($value)){ $value = string_to_tag_array($value); }
			}
			
			$target = null;
			if($field->metadata_type == "url"){
				$target = "_blank";
				// validate urls
				if (!preg_match('~^https?\://~i', $value)) { $value = "http://$value"; }
			}
			
			// build result
			//if ($cat->metadata_name == 'admin') {} else {} // display admin data after all common blocks ?
			$details_result .= '<div class="iris-profile-field">';
			$details_result .= '<h4>' . $title . '</h4>';
			$details_result .= elgg_view("output/" . $output_type, array("value" =>  $value, "target" => $target));
			$details_result .= "</div>\n";
		}
	}
}


// if admin, display admin links
$admin_links = '';
if (elgg_is_admin_logged_in() && (elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid())) {
	$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
	$builder = new ElggMenuBuilder($menu);
	$menu = $builder->getMenu();
	//$actions = elgg_extract('action', $menu, array());
	$admin = elgg_extract('admin', $menu, array());

	$text = elgg_echo('admin:options');

	$admin_links = '<div class="iris-profile-field profile-admin-menu-wrapper">';
	$admin_links .= "<h4><a rel=\"toggle\" href=\"#profile-menu-admin\">$text&hellip;</a></h4>";
	$admin_links .= '<ul class="profile-admin-menu" id="profile-menu-admin">';
	foreach ($admin as $menu_item) {
		$admin_links .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
	}
	$admin_links .= '</ul>';
	$admin_links .= '</div>';
	echo $admin_links;
}


echo $details_result;





