<?php

// This view is meant to render liked content, using various criteria, such as popularity, normal or reverse order, and by using a timeframe

// @TODO

$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);
$sortby = elgg_extract('sortby', $vars, 'latest');
$order = elgg_extract('order', $vars, 'ASC');
$container_guid = elgg_extract('container_guid', $vars, false);
// @TODO : Remove container if not site/group/user ?
if ($container_guid) { $options['annotation_owner_guids'] = $container_guid; }

// Set selection criteria
$options['annotation_names'] = array('likes');

// @TODO : Add timesframe filtering, but let's check first if we have this information !! (we should check when it has been liked, not the publication date...)
// Note : les likes concervent la date et l'auteur du like
// $sql .= " AND r.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval

if ($sortby == 'popular') {
	$dbprefix = elgg_get_config('dbprefix');
	$likes_metastring = get_metastring_id('likes');
	$options['selects'] = array("(SELECT count(distinct l.id) FROM {$dbprefix}annotations l WHERE l.name_id = $likes_metastring AND l.entity_guid = e.guid) AS likes");
	
	$options['order_by'] = 'likes ASC';
	if ($order == 'DESC') $options['order_by'] = 'likes DESC';
}

$content = elgg_list_entities_from_annotations($options);
if (!$content) $content = elgg_echo('esope:noresult');

echo $content;


