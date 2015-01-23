<?php

$guid = get_input('guid', false);
$lower_ts = get_input('lower_ts', 0);

$sort = get_input('sort', false);
$order = get_input('order', 'asc');
if ($order != 'desc') { $order = 'asc'; }

/* @var ElggGroup $group */
$entity = get_entity($guid);
if (!elgg_instanceof($entity, 'object')) { exit; }

$options = array(
	'guid' => $guid,
	'annotation_name' => 'group_topic_post',
	'limit' => 0,
	'order_by' => "time_created $order",
);
if ($lower_ts > 0) { $options['annotation_created_time_lower'] = $lower_ts; }

// Pour éviter les doubles tirets de séparation
// Cleaner listing : remove enclosing <ul class="elgg-list elgg-list-annotation elgg-annotation-list">...</ul>
$annotations = elgg_get_annotations($options);

// Tri par nombre de likes
if ($sort == 'likes') { usort($annotations, 'esope_annotation_likes_cmp'); }

$return = elgg_view_annotation_list($annotations, array());
$start_delimiter = '<ul class="elgg-list elgg-list-annotation elgg-annotation-list">';
$end_delimiter = '</ul>';
$start = strpos($return, $start_delimiter) + strlen($start_delimiter);
$end = strrpos($return, '</ul>') - $start;
$annotations = substr($return, $start, $end);

echo $annotations;

