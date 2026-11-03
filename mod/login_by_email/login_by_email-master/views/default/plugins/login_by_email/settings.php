<?php

/** @var \ElggPlugin $plugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('login_by_email:settings:code_validity'),
	'#help' => elgg_echo('login_by_email:settings:code_validity:help'),
	'name' => 'params[code_validity]',
	'value' => $plugin->code_validity,
	'min' => 1,
]);

echo elgg_view_field([
	'#type' => 'switch',
	'#label' => elgg_echo('login_by_email:settings:disable_classic_login'),
	'#help' => elgg_echo('login_by_email:settings:disable_classic_login:help'),
	'name' => 'params[disable_classic_login]',
	'value' => $plugin->disable_classic_login,
]);

// whitelist users
$users = $plugin->whitelist_users;
if (!empty($users)) {
	$users = json_decode($users, true);
}

$whitelist = elgg_view('output/longtext', [
	'value' => elgg_echo('login_by_email:settings:whitelist:description'),
]);

$whitelist .= elgg_view_message('info', elgg_view('output/longtext', [
	'value' => elgg_echo('login_by_email:settings:whitelist:admin'),
]));

$whitelist .= elgg_view_field([
	'#type' => 'userpicker',
	'#label' => elgg_echo('login_by_email:settings:whitelist:users'),
	'#help' => elgg_echo('login_by_email:settings:whitelist:users:help'),
	'name' => 'params[whitelist_users]',
	'value' => $users,
	'show_friends' => false,
]);

echo elgg_view_module('info', elgg_echo('login_by_email:settings:whitelist'), $whitelist);
