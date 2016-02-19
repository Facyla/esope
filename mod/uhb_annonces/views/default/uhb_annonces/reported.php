<?php
// My offers memorised
// Use a very basic listing, because we will embed this into other views
// ..such as widgets or profile elements

global $CONFIG;

$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') {
	$limit = elgg_extract('limit', $vars, 10);
	$offset = elgg_extract('offset', $vars, 0);
	
	$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'relationship' => 'reported', 'count' => true, 'limit' => $limit, 'offset' => $offset);
	$count = elgg_get_entities_from_relationship($params);
	$params['count'] = false;
	$offers = elgg_get_entities_from_relationship($params);

	$title .= elgg_echo("uhb_annonces:list:reported") . " ($count)";
	
	if ($offers) {
		echo elgg_view_title($title);
		echo elgg_view_entity_list($offers, array('count' => $count, 'full_view' => false, 'pagination' => true, 'limit' => $limit, 'offset' => $offset));
	}
}

