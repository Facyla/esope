<?php
/**
 * View conversation thread
 */

$thread_id = get_input('thread_id');

$title = elgg_echo('thewire:thread');

elgg_push_breadcrumb(elgg_echo('thewire'), 'thewire/all');
elgg_push_breadcrumb($title);

elgg_push_context('thewire-thread');

$thread = get_entity($thread_id);
elgg_set_page_owner_guid($thread->container_guid);

$content = '';
$content .= elgg_list_entities(array('guid' => $thread_id, 'list_class' => "elgg_list-entity elgg-list-entity-top",));
$content .= '<div class="elgg-comments">' . elgg_list_entities_from_metadata(array(
	"metadata_name" => "wire_thread",
	"metadata_value" => $thread_id,
	"type" => "object",
	"subtype" => "thewire",
	"limit" => max(20, elgg_get_config('default_limit')),
	'preload_owners' => true,
	'order_by' => 'time_created ASC',
	'wheres' => array("e.guid <> {$thread_id}"),
	'list_class' => "elgg_list-entity elgg-list-entity-replies",
)) . '</div>';

$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
