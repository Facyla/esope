<?php
// My offers candidated
// Use a very basic listing, because we will embed this into other views
// ..such as widgets or profile elements

global $CONFIG;

$user = elgg_extract('user', $vars);
$limit = elgg_extract('limit', $vars, 10);
$offset = elgg_extract('offset', $vars, 0);

if (!$user) { $user = elgg_get_logged_in_user_entity(); }

if (elgg_instanceof($user, 'user')) {
	//$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'has_candidated', 'metadata_names' => 'followstate', 'metadata_values' => array('published', 'archive', 'filled'), 'count' => true, 'limit' => $limit, 'offset' => $offset);
	$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'has_candidated', 'relationship_guid' => $user->guid, 'count' => true, 'limit' => $limit, 'offset' => $offset);
	$count = elgg_get_entities_from_relationship($params);
	$params['count'] = false;
	$offers = elgg_get_entities_from_relationship($params);
	
	$title .= elgg_echo("uhb_annonces:list:mine:candidated") . " ($count)";
	
	if ($offers) {
		echo elgg_view_title($title);
		echo elgg_view_entity_list($offers, array('count' => $count, 'full_view' => false, 'pagination' => true, 'limit' => $limit, 'offset' => $offset));
	}
}

