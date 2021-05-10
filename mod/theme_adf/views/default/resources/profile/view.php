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
$content .= elgg_view_layout('widgets', [
	'num_columns' => 2,
	'owner_guid' => $user_guid,
]);



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



echo elgg_view_page($user->getDisplayName(), [
	//'header' => '',
	'content' => $content,
	'entity' => $user,
	//'sidebar' => elgg_view('profile/owner_block', ['entity' => $user,]),
	'class' => 'profile',
	//'sidebar' => false,
]);
