<?php

$body = elgg_view_field([
	'#type' => 'checkbox',
	'label' => elgg_echo('installation:walled_garden:label'),
	'#help' => elgg_echo('installation:walled_garden:description'),
	'name' => 'walled_garden',
	'checked' => (bool) elgg_get_config('walled_garden'),
	'switch' => true,
]);

$body .= elgg_view_field([
	'#type' => 'access',
	'options_values' => [
		ACCESS_PRIVATE => elgg_echo('access:label:private'),
		ACCESS_LOGGED_IN => elgg_echo('access:label:logged_in'),
		ACCESS_PUBLIC => elgg_echo('access:label:public'),
	],
	'name' => 'default_access',
	'#label' => elgg_echo('installation:sitepermissions'),
	'#help' => elgg_echo('admin:site:access:warning'),
	'value' => elgg_get_config('default_access'),
]);

$body .= elgg_view_field([
	'#type' => 'checkbox',
	'label' => elgg_echo('installation:allow_user_default_access:label'),
	'#help' => elgg_echo('installation:allow_user_default_access:description'),
	'name' => 'allow_user_default_access',
	'checked' => (bool) elgg_get_config('allow_user_default_access'),
	'switch' => true,
]);

$body .= elgg_view_field([
	'#type' => 'number',
	'name' => 'default_limit',
	'#label' => elgg_echo('installation:default_limit'),
	'value' => elgg_get_config('default_limit'),
	'min' => 1,
	'step' => 1,
]);

$body .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('config:content:pagination_behaviour'),
	'#help' => elgg_echo('config:content:pagination_behaviour:help'),
	'name' => 'pagination_behaviour',
	'value' => elgg_get_config('pagination_behaviour'),
	'options_values' => [
		'navigate' => elgg_echo('config:content:pagination_behaviour:navigate'),
		'ajax-replace' => elgg_echo('config:content:pagination_behaviour:ajax-replace'),
		'ajax-append' => elgg_echo('config:content:pagination_behaviour:ajax-append'),
		'ajax-append-auto' => elgg_echo('config:content:pagination_behaviour:ajax-append-auto'),
	],
]);

$body .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('config:content:comments_max_depth'),
	'#help' => elgg_echo('config:content:comments_max_depth:help'),
	'name' => 'comments_max_depth',
	'value' => elgg_get_config('comments_max_depth'),
	'options_values' => [
		0 => elgg_echo('config:content:comments_max_depth:none'),
		2 => 2,
		3 => 3,
		4 => 4,
	],
]);

$body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('config:content:comment_box_collapses'),
	'#help' => elgg_echo('config:content:comment_box_collapses:help'),
	'name' => 'comment_box_collapses',
	'checked' => (bool) elgg_get_config('comment_box_collapses'),
	'switch' => true,
	'value' => 1,
]);

$body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('config:content:comments_latest_first'),
	'#help' => elgg_echo('config:content:comments_latest_first:help'),
	'name' => 'comments_latest_first',
	'checked' => (bool) elgg_get_config('comments_latest_first'),
	'switch' => true,
	'value' => 1,
]);

$body .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('config:content:comments_per_page'),
	'name' => 'comments_per_page',
	'value' => elgg_get_config('comments_per_page'),
	'min' => 1,
	'step' => 1,
]);

$body .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('config:content:comments_group_only'),
	'name' => 'comments_group_only',
	'checked' => (bool) elgg_get_config('comments_group_only'),
	'switch' => true,
	'value' => 1,
]);

$body .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('config:content:mentions_display_format'),
	'#help' => elgg_echo('config:content:mentions_display_format:help'),
	'name' => 'mentions_display_format',
	'value' => elgg_get_config('mentions_display_format'),
	'options_values' => [
		'display_name' => elgg_echo('config:content:mentions_display_format:display_name'),
		'username' => elgg_echo('config:content:mentions_display_format:username'),
	],
]);

echo elgg_view_module('info', elgg_echo('admin:legend:content'), $body);
