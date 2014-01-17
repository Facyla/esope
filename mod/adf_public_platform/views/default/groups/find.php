<?php
/**
 * Group search
 *
 * @package ElggGroups
 */

// Don't display this block at all if we have a search tab
$groups_search = elgg_get_plugin_setting('groups_searchtab', 'adf_public_platform');
if ($groups_search == 'yes') return;


/*
$url = elgg_get_site_url() . 'groups/search';
$body = elgg_view_form('groups/find', array('action' => $url, 'method' => 'get', 'disable_security' => true));
*/
// We prefer a regular search : more efficient
$url = elgg_get_site_url() . 'search';
$body = elgg_view_form('groups/regular_find', array('action' => $url, 'method' => 'get', 'disable_security' => true));

//echo elgg_view_module('aside', elgg_echo('groups:searchtag'), $body);
echo $body;

