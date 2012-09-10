<?php
/**
 * Elgg announcements plugin everyone page
 *
 * @package ElggAnnouncements
 */

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'announcement',
	'full_view' => false,
	'view_toggle_type' => false
));

$title = elgg_echo('announcements:everyone');

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
));

echo elgg_view_page($title, $body);