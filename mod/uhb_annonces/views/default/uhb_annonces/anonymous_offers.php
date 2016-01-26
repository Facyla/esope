<?php
// My offers
// Use a very basic listing, because we will embed this into other views
// ..such as widgets or profile elements

global $CONFIG;

$user = elgg_extract('user', $vars);
$limit = elgg_extract('limit', $vars, 10);
$offset = elgg_extract('offset', $vars, 0);

$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'count' => true, 'limit' => $limit, 'offset' => $offset, 'owner_guid' => $user->guid);
$count = elgg_get_entities($params);
$params['count'] = false;
$offers = elgg_get_entities($params);

$title .= elgg_echo("uhb_annonces:list:anonymous") . " ($count)";

if ($offers) {
	echo elgg_view_title($title);
	echo elgg_view_entity_list($offers, array('count' => $count, 'full_view' => false, 'pagination' => true, 'limit' => $limit, 'offset' => $offset, 'owner_guid' => $CONFIG->site->guid));
}

