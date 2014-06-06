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
if (empty($title)) $title = elgg_echo('simplepie:group:feed_url:open');

// Add folder link to title
$title = '<a class="elgg-button" style="float:right;" href="' . $feed . '">' . $title . '</a>';

$content = elgg_view('simplepie/feed_reader', array('feed_url' => $feed, 'excerpt' => false, 'num_items' => 5, 'post_date' => true));


// Sidebar module
echo elgg_view_module('aside', $title, $content);

