<?php

$entity = elgg_extract('entity', $vars);
if ($entity instanceof ElggEntity) {
	echo elgg_view('input/hidden', [
		'name' => 'access_id',
		'value' => $entity->access_id,
	]);
	return;
}

$use_groups = true;
if (elgg_get_plugin_setting('enable_group', 'thewire_tools') !== 'yes') {
	$use_groups = false;
	//return;
}

$user_guid = elgg_get_logged_in_user_guid();
if (!$user_guid) {
	return;
}

if ($use_groups) {
	$count = elgg_get_entities([
		'type' => 'group',
		'count' => true,
		'relationship' => 'member',
		'relationship_guid' => $user_guid,
	]);
}
if (!$count) {
	//return;
}

$container = elgg_get_page_owner_entity();
if ($use_groups && $container instanceof \ElggGroup) {
	if ($container->getContentAccessMode() === \ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY) {
		echo elgg_view('input/hidden', [
			'name' => 'access_id',
			'value' => $container->getOwnedAccessCollection('group_acl')->id,
		]);
		return;
	}
}

$access_options = [];
$params['entity_type'] = 'object';
$params['entity_subtype'] = 'thewire';
$access_options = get_write_access_array(0, 0, false, $params);
unset($access_options[ACCESS_PRIVATE]);
//unset($access_options[ACCESS_FRIENDS]); // marche pas ?
unset($access_options[3]); // Friends

if (!elgg_get_config('walled_garden')) {
	$access_options[ACCESS_PUBLIC] = elgg_echo('thewire_tools:add:access', [elgg_echo('access:label:public')]);
} else {
	unset($access_options[ACCESS_PUBLIC]);
}

$access_options[ACCESS_LOGGED_IN] = elgg_echo('thewire_tools:add:access', [elgg_echo('access:label:logged_in')]);
$default_value = ACCESS_LOGGED_IN;
if ($use_groups) {
	$access_options[-100] = elgg_echo('thewire_tools:add:access:group');
}

$access_params = [
	'#type' => 'access',
	'name' => 'access_id',
	'options_values' => $access_options,
	'value' => $default_value,
];

if (elgg_in_context('widgets')) {
	$access_params['class'][] = 'thewire-tools-widget-access';
}

echo elgg_view_field($access_params);
