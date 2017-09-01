<?php
/**
 * Group RSS feed reader module
 */

$group = elgg_get_page_owner_entity();

//if (!elgg_in_context('group_profile')) { return; }

// Display only if a RSS feed is set
$feed = $group->feed_url;
if (empty($feed)) { return true; }

$feed = $group->feed_url;

$needle = '::';
// Separate pieces of data if set
if (strrpos($feed, $needle) !== false) {
	$feed_parts = explode($needle, $feed);
	$feed = $feed_parts[0];
	$title = $feed_parts[1];
	$num = $feed_parts[2];
}

// A défaut on prend l'host du fil RSS comme titre
if (empty($title)) {
	$feed_elements = parse_url($feed);
	$title = $feed_elements['host'];
}
// 10 éléments par défaut
if (empty($num)) $num = 10; else $num = (int) $num;

$all_link = '<a href="' . $feed . '" target="_blank">' . elgg_echo('simplepie:group:feed_url:open') . '</a>';

$content = '<div style="padding:6px;">' . elgg_view('simplepie/feed_reader', array('feed_url' => $feed, 'excerpt' => false, 'num_items' => $num, 'post_date' => false)) . '</div>';
$content .= '<span class="elgg-widget-more">' . $all_link . '</span>';


// Group module
// Note: we don't use groups/profile/module view because we're not inside a list
echo '<br />';
echo elgg_view_module('info', '', $content, array(
	'header' => '<h3>' . $title . '</h3>',
	'class' => 'elgg-module-group',
));


