<?php

$user = get_user(get_input('guid'));

$session = new ElggSession();
$forward = $session->get('user_deleted_from');
if (!$forward) {
	if (!strpos($_SERVER['HTTP_REFERER'], 'action/admin/user/delete')) {
		if ($user && !strpos($_SERVER['HTTP_REFERER'], $user->username)) {
			$session->set('user_deleted_from', $_SERVER['HTTP_REFERER']);
		}
	}
	$forward = 'admin/users/newest';
}

if (!$user) {
	$session->del('user_deleted_from');
	// note we can't redirect to REFERER due to redirect loop with the action
	forward($forward);
}

$title = elgg_view_entity($user, array('full_view' => false));

$user_link = elgg_view('output/url', array('text' => $user->name, 'href' => $user->getURL()));
$body = elgg_view('output/longtext', array(
	'value' => elgg_echo('duc:delete:user', array($user_link)),
	));


$body .= '<label>' . elgg_echo('duc:label:content_policy') . '</label>';
$body .= elgg_view('input/radio', array(
	'name' => 'content_policy',
	'value' => 'delete',
	'options' => array(
		elgg_echo('duc:option:delete') => 'delete',
		elgg_echo('duc:option:reassign') => 'reassign',
	)
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('duc:label:content_policy:help'),
	'class' => 'elgg-subtext'
));

$body .= '<label>' . elgg_echo('duc:label:reassign_member') . '</label>';
$body .= elgg_view('input/userpicker', array(
	'name' => 'members', // declare same name as default in case input/userpicker is overridden for better ui
	'multiple' => false // same as above
));
$body .= elgg_view('output/longtext', array(
	'value' => elgg_echo('duc:label:reassign_member:help') . '</label>',
	'class' => 'elgg-subtext'
));

$body .= elgg_view('input/hidden', array('name' => 'content_policy_seen', 'value' => 1));
$body .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
$body .= elgg_view('input/submit', array(
	'value' => elgg_echo('submit')
));

$form = elgg_view('input/form', array(
	'action' => 'action/admin/user/delete',
	'body' => $body
));

echo elgg_view_module('main', $title, $form);


$title = elgg_echo('duc:title:stats');
$body = elgg_view('deleted_user_content/stats', array('entity' => $user));

echo elgg_view_module('main', $title, $body);