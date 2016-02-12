<?php
/**
 * Members sidebar
 */

/* That one give bad results => let's prefere a regular search for users
// Tag search
$params = array(
	'method' => 'get',
	'action' => elgg_get_site_url() . 'members/search/tag',
	'disable_security' => true,
);

$body = elgg_view_form('members/tag_search', $params);

echo elgg_view_module('aside', '', $body);
*/

// regular search, with user results only
/*
$params = array(
	'method' => 'get',
	'action' => elgg_get_site_url() . 'search',
	'disable_security' => true,
);
$body = elgg_view_form('members/regular_search', $params);
echo elgg_view_module('aside', '', $body);
*/

// Name search gives better results than regular search for some names
$members_onesearch = elgg_get_plugin_setting('members_onesearch', 'esope');
if ($members_onesearch != 'yes') {
	// It performs also username search, not only name
	// name search
	$params = array(
		'method' => 'get',
		'action' => elgg_get_site_url() . 'members/search/name',
		'disable_security' => true,
	);
	$body = elgg_view_form('members/name_search', $params);
	echo elgg_view_module('aside', '', $body);
}

$members_online = elgg_get_plugin_setting('members_online', 'esope');
if ($members_online == 'yes') {
	$body = elgg_view('adf_platform/users/online');
	echo elgg_view_module('aside', '', $body);
}

