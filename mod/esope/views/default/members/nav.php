<?php
/**
 * Members navigation
 */

$members_alpha = elgg_get_plugin_setting('members_alpha', 'esope');
$members_newest = elgg_get_plugin_setting('members_newest', 'esope');
$members_popular = elgg_get_plugin_setting('members_popular', 'esope');
$members_online = elgg_get_plugin_setting('members_onlinetab', 'esope');
$members_search = elgg_get_plugin_setting('members_searchtab', 'esope');
$members_profiletypes = elgg_get_plugin_setting('members_profiletypes', 'esope');

if ($members_alpha == 'yes') $tabs['alpha'] = array('title' => elgg_echo('members:label:alpha'), 'url' => "members/alpha", 'selected' => $vars['selected'] == 'alpha');

if ($members_newest != 'no') $tabs['newest'] = array('title' => elgg_echo('members:label:newest'), 'url' => "members/newest", 'selected' => $vars['selected'] == 'newest');

if ($members_popular != 'no') $tabs['popular'] = array('title' => elgg_echo('members:label:popular'), 'url' => "members/popular", 'selected' => $vars['selected'] == 'popular');

// List profile types
if ($members_profiletypes == 'yes') {
	$profiletypes = esope_get_profiletypes();
	foreach ($profiletypes as $id => $profiletype) {
		$tabs[$profiletype] = array('title' => elgg_echo('profile:types:' . $profiletype), 'url' => "members/$profiletype", 'selected' => $vars['selected'] == $profiletype);
	}
}

if ($members_online != 'no') 
$tabs['online'] = array('title' => elgg_echo('members:label:online'), 'url' => "members/online", 'selected' => $vars['selected'] == 'online');

if ($members_search == 'yes') $tabs['search'] = array('title' => elgg_echo('members:label:search'), 'url' => "members/search", 'selected' => $vars['selected'] == 'search');

echo elgg_view('navigation/tabs', array('tabs' => $tabs));

