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

elgg_set_page_owner_guid($user_guid);

$content = elgg_view('profile/wrapper', [
	'entity' => $user,
]);

// Widgets
/*
$content .= elgg_view_layout('widgets', [
	'num_columns' => 2,
	'owner_guid' => $user_guid,
]);
*/



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
//$content .= elgg_view('output/url', ['toggle' => true]')
$content .= '<h3><a href="javascript: void(0);" onClick="$(\'#user-river-history\').slideToggle();">Historique personnel <i class="fa fa-caret-down"></i></a></h3>';
$content .= '<div id="user-river-history" style="display: none;">' . elgg_list_river($options) . '</div>';


// Sidebar : photo + % complétion
$sidebar = '';
$user_icon = elgg_view_entity_icon($user, 'large', [
	'use_hover' => false,
	'use_link' => false,
	'img_class' => 'photo u-photo',
]);
$sidebar .= '<div class="" style="display: flex; justify-content: center; margin: 0 0 0rem 0;">';
$sidebar .= $user_icon;
$sidebar .= '</div>';
$sidebar .= '<div class="" style="text-align: center; margin: 0 0 2rem 0;">';
$sidebar .= elgg_view_title($user->getDisplayName());
$sidebar .= '</div>';
//$sidebar .= '<div class="">' . elgg_view('profile_manager/profile_completeness', ['entity' => $user]) . '</div>';


//$title = '<span class="hidden">' . $user->getDisplayName() . '</span>';
$title = $user->getDisplayName();


if ($user->isValidated() === false) {
	// Account not validated : disable some stuff
	$user = '<span class="account-unvalidated">' . elgg_echo('theme_adf:uservalidation:disabled') . '</span>';
	$content = '<blockquote class="account-unvalidated-notice">' . elgg_echo('theme_adf:uservalidation:disabled:notice') . '</blockquote>';
} else {
	// email address already validated (true), or not required (null)
}


$content = '<div class="" style="display: flex; flex-wrap: wrap;">
	<div class="" style="flex: 0 1 24rem; position: relative; min-width; 16rem; padding: 0 2rem;">
		' . $sidebar . '
	</div>
	<div class="" style="flex: 1 1 32rem; min-width; 24rem;">
		' . $content . '
	</div>
</div>';


echo elgg_view_page($title, [
	//'header' => '',
	'content' => $content,
	'entity' => $user,
	//'sidebar_alt' => elgg_view('profile/owner_block', ['entity' => $user,]),
	'class' => 'profile',
	'sidebar' => false,
]);
