<?php
/**
 * Elgg announcements plugin everyone page
 *
 * @package ElggAnnouncements
 */

$page_owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($page_owner->name);

$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'announcement',
	'container_guid' => $page_owner->guid,
	'full_view' => false,
	'view_toggle_type' => false
));

if (!$content) {
	$content = elgg_echo('announcements:none');
}

$title = elgg_echo('announcements:owner', array($page_owner->name));

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
));

echo elgg_view_page($title, $body);