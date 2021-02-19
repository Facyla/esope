<?php

$username = elgg_extract('username', $vars);
if ($username) {
	$user = get_user_by_username($username);
	$self = false;
} else {
	$user = elgg_get_logged_in_user_entity();
	$self = true;
}

$user_guid = $user ? $user->guid : 0;

elgg_entity_gatekeeper($user_guid, 'user');

//elgg_set_page_owner_guid($user_guid);
elgg_set_page_owner_guid(elgg_get_site_entity()->guid);

$content = '';

// Bandeau avec Image + Nom Prénom  + actions (tierces et propres)
//$content .= elgg_view('profile/owner_block', ['entity' => $user]);
$header = elgg_view_entity_icon($user, 'medium', [
	'use_hover' => false,
	'use_link' => false,
	'img_class' => 'photo u-photo',
	'class' => 'float',
]);
$header .= '<h2>' . $user->name . '</h2>';


// Menus and actions : grab the actions and admin menu items from user hover
$menu = elgg()->menus->getMenu('user_hover', [
	'entity' => $user,
	'username' => $user->username,
]);

// Actions
$actions_links = '';
$actions = $menu->getSection('action', []);
foreach ($actions as $menu_item) {
	$actions_links .= elgg_view('navigation/menu/elements/item', ['item' => $menu_item]);
}
$header .= '<ul class="elgg-menu-user-actions">' . $actions_links . '</ul>';

// Admin actions
$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != $user->guid) {
	$text = elgg_format_element('span', [], elgg_echo('admin:options'));

	$toggle_icons = elgg_view_icon('angle-right', ['class' => 'elgg-action-expand']);
	$toggle_icons .= elgg_view_icon('angle-down', ['class' => 'elgg-action-collapse']);
	$toggle_icons = elgg_format_element('span', [
		'class' => 'profile-admin-menu-toggle-icons',
	], $toggle_icons);

	$admin_links = '<ul class="profile-admin-menu-wrapper elgg-menu-owner-block">';
	$admin_links .= "<li><a rel=\"toggle\" href=\"#profile-menu-admin\" class=\"profile-admin-menu-toggle\">$text$toggle_icons</a>";
	$admin_links .= '<ul class="elgg-menu elgg-menu-owner-block profile-admin-menu hidden" id="profile-menu-admin">';
	$admin = $menu->getSection('admin', []);
	foreach ($admin as $menu_item) {
		$admin_links .= elgg_view('navigation/menu/elements/item', ['item' => $menu_item]);
	}
	$admin_links .= '</ul>';
	$admin_links .= '</li>';
	$admin_links .= '</ul>';
}
$header .= $admin_links;


// Contributions
//$header .= elgg_view_menu('owner_block', ['entity' => elgg_get_page_owner_entity(), 'class' => 'profile-content-menu']);



// Activité
$options = [
	'distinct' => false,
	'no_results' => elgg_echo('river:none'),
];
$options['subject_guid'] = $user->guid;
if ($self) {
	$page_filter = 'mine';
	$title = elgg_echo('river:mine');
} else {
	$page_filter = 'subject';
	$title = elgg_echo('river:owner', [htmlspecialchars($user->getDisplayName(), ENT_QUOTES, 'UTF-8', false)]);
}
$content .= elgg_list_river($options);


// Champs du profil
$profile_fields = elgg_view('profile/wrapper', [
	'entity' => $user,
]);


// Widgets
/*
$content .= elgg_view_layout('widgets', [
	'num_columns' => 2,
	'owner_guid' => $user_guid,
]);
*/



echo elgg_view_page($user->getDisplayName(), [
	'header' => $header,
	'content' => $content,
	'entity' => $user,
	'class' => 'profile',
	'sidebar_alt' => $profile_fields,
	//'sidebar_alt' => elgg_view('profile/owner_block', ['entity' => $user]),
]);
