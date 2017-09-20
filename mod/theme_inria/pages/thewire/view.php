<?php
/**
 * View individual wire post
 * Iris : add conversation
 */
$guid = get_input('guid');

elgg_entity_gatekeeper($guid, 'object', 'thewire');

$post = get_entity($guid);

$owner = $post->getOwnerEntity();
if (!$owner) {
	forward();
}

$title = elgg_echo('thewire:by', array($owner->name));

elgg_push_breadcrumb(elgg_echo('thewire'), 'thewire/all');
elgg_push_breadcrumb($owner->name, 'thewire/owner/' . $owner->username);
elgg_push_breadcrumb($title);

$content = elgg_view_entity($post);

// Add conversation
if ($post->wire_thread > 0) {
	$content .= '<div class="wire-thread">';
	$content .= '<h3>' . elgg_echo('thewire:thread') . '</h3>';
	$thread = get_entity($post->wire_thread);
	$content .= elgg_list_entities_from_metadata(array(
		"metadata_name" => "wire_thread",
		"metadata_value" => $post->wire_thread,
		"type" => "object",
		"subtype" => "thewire",
		"limit" => max(20, elgg_get_config('default_limit')),
		'preload_owners' => true,
		'order_by' => 'time_created ASC',
	));
	$content .= '</div>';
}


$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
