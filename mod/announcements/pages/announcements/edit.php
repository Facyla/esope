<?php
/**
 * Edit announcement page
 *
 * @package ElggAnnouncements
 */

$announcement_guid = get_input('guid');
$announcement = get_entity($announcement_guid);

if (!elgg_instanceof($announcement, 'object', 'announcement') || !$announcement->canEdit()) {
	register_error(elgg_echo('announcements:nopermission'));
	forward(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('announcements:edit');
elgg_push_breadcrumb($title);

$vars = array(
	'entity' => $announcement,
);
$content = elgg_view_form('announcements/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'buttons' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);