<?php
/**
 * Group RSS feed reader module
 */

$group = elgg_get_page_owner_entity();

//if (!elgg_in_context('group_profile')) { return; }

// Display only if a RSS feed is set
$feed = $group->feed_url;
if (empty($feed)) { return true; }

global $CONFIG;

$feed = $group->feed_url;

$needle = '::';
// Separate pieces of data if set
if (strrpos($feed, $needle) !== false) {
	$feed_parts = explode($needle, $folder);
	$feed = $feed_parts[0];
	$title = $feed_parts[1];
}

if (empty($title)) $title = $feed;
$all_link = '<a href="' . $feed . '" target="_blank">' . elgg_echo('simplepie:group:feed_url:open') . '</a>';

$content = '<div style="padding:6px;">' . elgg_view('simplepie/feed_reader', array('feed_url' => $feed, 'excerpt' => true, 'num_items' => 5, 'post_date' => true)) . '</div>';


// Group module
echo elgg_view('groups/profile/module', array(
	'title' => $title,
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => false,
));

