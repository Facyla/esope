<?php
// My offers memorised
// Use a very basic listing, because we will embed this into other views
// ..such as widgets or profile elements

global $CONFIG;

$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') {
	$offer = elgg_extract('entity', $vars);
	$limit = elgg_extract('limit', $vars, 10);
	$offset = elgg_extract('offset', $vars, 0);
	
	$params = array('types' => 'user', 'relationship' => 'reported', 'inverse_relationship' => true, 'count' => true, 'limit' => $limit, 'offset' => $offset);
	// Optionally filter on a specific offer
	if (elgg_instanceof($offer, 'object', 'uhb_offer')) {
		$params['relationship_guid'] = $offer->guid;
	}
	$count = elgg_get_entities_from_relationship($params);
	$params['count'] = false;
	$users = elgg_get_entities_from_relationship($params);

	$title .= elgg_echo("uhb_annonces:list:reportedby") . " ($count)";
	
	if ($users) {
		foreach ($users as $ent) { $unique_users[$ent->guid] = $ent; }
		
		echo elgg_view_title($title);
		echo elgg_view_entity_list($unique_users, array('count' => $count, 'full_view' => false, 'pagination' => true, 'limit' => $limit, 'offset' => $offset));
	}
}

