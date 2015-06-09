<?php

// This view is meant to render liked content, using various criteria, such as popularity, normal or reverse order, and by using a timeframe

// @TODO

$ts_lower = (int) elgg_extract("ts_lower", $vars, false);
$ts_upper = (int) elgg_extract("ts_upper", $vars, false);
$sortby = elgg_extract('sortby', $vars, 'latest');
$order = elgg_extract('order', $vars, 'DESC');
$full = elgg_extract('full_view', $vars, false);
$container_guid = elgg_extract('container_guid', $vars, false);


// Set selection criteria
$options['annotation_names'] = array('likes');
$options['limit'] = elgg_extract('limit', $vars, 5);
$options['pagination'] = elgg_extract('pagination', $vars, false);
$options['full_view'] = $full;
// Use container only if set
if ($container_guid) { $options['annotation_owner_guids'] = $container_guid; }

// @TODO : Add timesframe filtering, but let's check first if we have this information !! (we should check when it has been liked, not the publication date...)
// Note : les likes conservent la date et l'auteur du like
// $sql .= " AND r.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval
// 'wheres' => "l.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval

if ($sortby == 'popular') {
	$dbprefix = elgg_get_config('dbprefix');
	$likes_metastring = get_metastring_id('likes');
	$options['selects'] = array("(SELECT count(distinct l.id) FROM {$dbprefix}annotations l WHERE l.name_id = $likes_metastring AND l.entity_guid = e.guid) AS likes");
	$options['order_by'] = 'likes DESC';
	if ($order == 'DESC') $options['order_by'] = 'likes ASC';
} else if ($sortby == 'latest') {
	$options['order_by'] = 'time_created DESC';
	if ($order == 'ASC') $options['order_by'] = 'time_created ASC';
}


$content = elgg_list_entities_from_annotations($options);
if (!$content) $content = elgg_echo('esope:noresult');

echo $content;


