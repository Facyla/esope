<?php
// Renvoie les réponses à un sujet de forum
// Utile pour actualiser automatiquement une discussion dans un forum

$guid = get_input('guid', false);
$lower_ts = get_input('lower_ts', 0);

$sort = get_input('sort', false);
// Default sort to most likes first
if ($sort == 'likes') { $default_order = 'desc'; }
$order = get_input('order', $default_order);
if ($order != 'desc') { $order = 'asc'; }

/* @var ElggGroup $group */
$entity = get_entity($guid);

// Do not return anything (used for AJAX refresh)
if (!elgg_instanceof($entity, 'object', 'groupforumtopic')) { exit; }


$options = array(
	'type' => 'object',
	'subtype' => 'discussion_reply',
	'container_guid' => $guid,
	'limit' => 0,
	'full_view' => true,
	'pagination' => false,
	'no_results' => elgg_echo('discussion:none'),
	//'distinct' => false,
	'url_fragment' => 'group-replies',
	'order_by' => "time_created $order",
);
if ($lower_ts > 0) { $options['annotation_created_time_lower'] = $lower_ts; }

// Pour éviter les doubles tirets de séparation
// Cleaner listing : remove enclosing <ul class="elgg-list elgg-list-entity">...</ul>
$forum_replies = elgg_get_entities($options);

// Tri par nombre de likes (croissant)
if ($sort == 'likes') {
	usort($forum_replies, 'esope_annotation_likes_cmp');
	if ($order == 'desc') { $forum_replies = array_reverse($forum_replies); }
}

$content = elgg_view_entity_list($forum_replies, array('items' => $forum_replies));

//echo htmlentities($content) . '<hr />'; // debug
$start = '<ul class="elgg-list elgg-list-entity">';
$end = '</ul>';
$start = strpos($content, $start) + strlen($start);
$end = strrpos($content, '</ul>') - $start;
if ($start && $end) { $content = substr($content, $start, $end); }

echo $content;

/*
$body = elgg_view_layout('one_column', array('content' => $content));
// Affichage
echo elgg_view_page($title, $body);
*/

