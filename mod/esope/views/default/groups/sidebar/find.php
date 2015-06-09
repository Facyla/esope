<?php
/**
 * Group search
 *
 * @package ElggGroups
 */

$url = elgg_get_site_url() . 'search';
$body = elgg_view_form('groups/regular_find', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true,
));

//echo elgg_view_module('aside', elgg_echo('groups:searchtag'), $body);
echo elgg_view_module('aside', '', $body);

