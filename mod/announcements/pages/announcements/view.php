<?php
/**
 * View a announcement
 *
 * @package ElggAnnouncements
 */

$announcement = get_entity(get_input('guid'));

$page_owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($page_owner->name, "announcements/group/$page_owner->guid/all");

$title = $announcement->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($announcement, true);
$content .= elgg_view_comments($announcement);

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
	'header' => '',
));

echo elgg_view_page($title, $body);
