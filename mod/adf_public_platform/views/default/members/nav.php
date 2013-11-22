<?php
/**
 * Members navigation
 */

$members_alpha = elgg_get_plugin_setting('members_alpha', 'adf_public_platform');
$members_newest = elgg_get_plugin_setting('members_newest', 'adf_public_platform');
$members_popular = elgg_get_plugin_setting('members_popular', 'adf_public_platform');
$members_online = elgg_get_plugin_setting('members_onlinetab', 'adf_public_platform');
$members_search = elgg_get_plugin_setting('members_searchtab', 'adf_public_platform');

if ($members_alpha == 'yes') $tabs['alpha'] = array('title' => elgg_echo('members:label:alpha'), 'url' => "members/alpha", 'selected' => $vars['selected'] == 'alpha');

if ($members_newest != 'no') $tabs['newest'] = array('title' => elgg_echo('members:label:newest'), 'url' => "members/newest", 'selected' => $vars['selected'] == 'newest');

if ($members_popular != 'no') $tabs['popular'] = array('title' => elgg_echo('members:label:popular'), 'url' => "members/popular", 'selected' => $vars['selected'] == 'popular');

if ($members_online != 'no') 
$tabs['online'] = array('title' => elgg_echo('members:label:online'), 'url' => "members/online", 'selected' => $vars['selected'] == 'online');

if ($members_search == 'yes') $tabs['search'] = array('title' => elgg_echo('members:label:search'), 'url' => "members/search", 'selected' => $vars['selected'] == 'search');

echo elgg_view('navigation/tabs', array('tabs' => $tabs));

