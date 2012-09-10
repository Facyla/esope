<?php
/**
 * Elgg announcements inbox page
 *
 * @package ElggAnnouncements
 */

$page_owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb(elgg_echo('messages:inbox'));

$title = elgg_echo('announcements:user', array($page_owner->name));

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'announcement',
	'full_view' => false,
));

$body = elgg_view_layout('content', array(
	'title' => elgg_echo('announcements:inbox'),
	'content' => $content,
	'filter' => '',
	'buttons' => '',
));

echo elgg_view_page($title, $body);
