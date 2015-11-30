<?php
/**
 * Group search
 *
 * @package ElggGroups
 */

// Don't display this block at all if we have a search tab
$groups_tags = elgg_get_plugin_setting('groups_tags', 'esope');
if ($groups_tags == 'yes') { $groups_tags_block = elgg_view('groups/sidebar/tags'); }

$groups_search = elgg_get_plugin_setting('groups_searchtab', 'esope');
if ($groups_search == 'yes') {
	echo $groups_tags_block;
	return;
}


/*
$url = elgg_get_site_url() . 'groups/search';
$body = elgg_view_form('groups/find', array('action' => $url, 'method' => 'get', 'disable_security' => true));
*/
// We prefer a regular search : more efficient
$url = elgg_get_site_url() . 'search';
$body = elgg_view_form('groups/regular_find', array('action' => $url, 'method' => 'get', 'disable_security' => true));

//echo elgg_view_module('aside', elgg_echo('groups:searchtag'), $body);
echo $body;
echo $groups_tags_block;

