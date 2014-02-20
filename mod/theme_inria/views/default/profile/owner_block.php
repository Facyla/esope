<?php
/**
 * Profile owner block
 */

$user = elgg_get_page_owner_entity();

if (!$user) {
	// no user so we quit view
	echo elgg_echo('viewfailure', array(__FILE__));
	return TRUE;
}

$icon = elgg_view_entity_icon($user, 'large', array(
	'use_hover' => false,
	'use_link' => false,
));
// @TODO : Remove empty link before adding new link !
/*
if ($user->guid == elgg_get_logged_in_user_guid()) {
	$icon= '<a href="' . $vars['url'] . 'avatar/edit/' . $user->username . '" class="avatar_edit_hover">' . $icon . '</a>';
}
*/

// grab the actions and admin menu items from user hover
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
	$profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
	foreach ($actions as $action) {
		$profile_actions .= '<li>' . $action->getContent(array('class' => 'elgg-button elgg-button-action')) . '</li>';
	}
	$profile_actions .= '</ul>';
}


// Inria fields (from LDAP)
$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];
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
		$details_result .= "<div>" . $field_result . "</div>";	
	}
}
if ($details_result) $inria_fields = '<div class="inria-ldap-details"><h3>' . elgg_echo('theme_inria:ldapdetails') . '</h3>' . $details_result . '</div>';


// if admin, display admin links
$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
	$text = elgg_echo('admin:options');

	$admin_links = '<ul class="profile-admin-menu-wrapper">';
	$admin_links .= "<li><a rel=\"toggle\" href=\"#profile-menu-admin\">$text&hellip;</a>";
	$admin_links .= '<ul class="profile-admin-menu" id="profile-menu-admin">';
	foreach ($admin as $menu_item) {
		$admin_links .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
	}
	$admin_links .= '</ul>';
	$admin_links .= '</li>';
	$admin_links .= '</ul>';	
}

// content links
$content_menu = elgg_view_menu('owner_block', array(
	'entity' => elgg_get_page_owner_entity(),
	'class' => 'profile-content-menu',
));


echo <<<HTML

<div id="profile-owner-block">
	$icon
	$profile_actions
	$inria_fields
	$content_menu
	$admin_links
</div>

HTML;
