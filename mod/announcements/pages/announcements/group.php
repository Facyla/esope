<?php
/**
 * Elgg announcements plugin group page
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

elgg_register_title_button();

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
	'filter' => '', // Removes filter menu (nonsense for announcements)
));

echo elgg_view_page($title, $body);
