<?php
/**
 * Profile info box
 */

$content = '';

$user = elgg_extract('user', $vars, false);

if ($user->isBanned()) {
	echo "<p class='profile-banned-user'>" . elgg_echo('banned') . "</p>";
	return;
}

/*
// Get menus
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();

// Get admin menu
$admin = elgg_extract('admin', $menu, array());

// Get actions
$actions = elgg_extract('action', $menu, array());

// Get profile links
$content_menu = elgg_view_menu('owner_block', array('entity' => $user, 'class' => 'profile-content-menu'));
*/


// Get profile card fields config - if any
$profile_card = elgg_get_plugin_setting("profile_card", 'esope');
if (!empty($profile_card)) {
	$profile_card = str_replace(array(' ', ';', '|'), ',', $profile_card);
	$fields = explode(',', $profile_card);
} else {
	$fields = array('briefdescription', 'skills');
}

$content .= elgg_view_entity_icon($user, 'medium', array('use_hover' => false, 'use_link' => false));

$content .= '<h3><a href="' . $user->getURL() . '" target="_blank">' . $user->name . '</a></h3>';

// Display profile types - if used
$profiletypes_opt = esope_get_profiletypes(); // $guid => $title
$profiletypes_opt[0] = '';
$profiletypes_opt = array_reverse($profiletypes_opt, true); // We need to keep the keys here !
if (sizeof($profiletypes_opt > 2)) {
	$content .= '<p class="profile-type"><strong>' . elgg_echo('esope:search:members:role') . '</strong>&nbsp;: ' . $profiletypes_opt[$user->custom_profile_type] . '</p>';
}

if ($fields) {
	foreach ($fields as $field) {
		$field_content = $user->{$field};
		$field_title = '<strong>' . elgg_echo('profile:'.$field) . '</strong>&nbsp;: ';
		if (is_array($field_content)) { $field_content = implode(', ', $field_content); }
		$content .= '<p>' . $field_title . $field_content . '</p>';
	}
}


echo $content;

