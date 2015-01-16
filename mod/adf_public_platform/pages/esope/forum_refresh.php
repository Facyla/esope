<?php

$guid = get_input('guid', false);
$lower_ts = get_input('lower_ts', 0);

/* @var ElggGroup $group */
$entity = get_entity($guid);
if (!elgg_instanceof($entity, 'object')) {
	echo '0';
	exit;
}

$options = array(
	'guid' => $guid,
	'annotation_name' => 'group_topic_post',
	'limit' => 0,
	'order_by' => 'time_created desc',
);
if ($lower_ts > 0) { $options['annotation_created_time_lower'] = $lower_ts; }

// Pour éviter les doubles tirets de séparation
// Cleaner listing : remove enclosing <ul class="elgg-list elgg-list-annotation elgg-annotation-list">...</ul>
$annotations = elgg_list_annotations($options);
$start_delimiter = '<ul class="elgg-list elgg-list-annotation elgg-annotation-list">';
$end_delimiter = '</ul>';
$start = strpos($annotations, $start_delimiter) + strlen($start_delimiter);
$end = strrpos($annotations, '</ul>') - $start;
$annotations = substr($annotations, $start, $end);

echo $annotations;

