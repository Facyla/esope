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
// Any post may have direct replies (same parent relationship), but also nested replies (same thread)
if ($post->wire_thread > 0) {
	// Count message in thread
	/*
	$num_replies = elgg_get_entities_from_relationship(array(
		'relationship' => 'parent', 'relationship_guid' => $post->guid, 'inverse_relationship' => true, 
		"metadata_name" => "wire_thread", "metadata_value" => $post->wire_thread,
		'count' => true,
	));
	*/
	$num_thread = elgg_get_entities_from_metadata(array(
		"type" => "object", "subtype" => "thewire",
		"metadata_name" => "wire_thread", "metadata_value" => $post->wire_thread,
		'count' => true,
	));
	//if (($num_replies > 0) || ($num_thread > 1)) {
	if ($num_thread > 1) {
		$content .= '<div class="wire-thread">';
			/* Iris : info pas utile
			if ($num_replies > 0) {
				$content .= '<p>' . elgg_echo('theme_inria:wire:num_replies', array($num_replies)) . '</p>';
			}
			*/
			// Note: thread count includes post itself
			if ($num_thread > 1) {
				if ($post->wire_thread == $post->guid) {
					$content .= '<p>' . elgg_echo('theme_inria:wire:startthread', array($num_thread)) . '</p>';
				} else {
					$content .= '<p>' . elgg_echo('theme_inria:wire:inthread', array($num_thread)) . '</p>';
				}
				$content .= '<p><a href="' . elgg_get_site_url() . 'thewire/thread/' . $post->wire_thread . '" class="elgg-button elgg-button-action">' . elgg_echo('theme_inria:wire:viewthread', array($num_thread)) . '</a></p>';
			}
		$content .= '</div>';
	}
		
		/*
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
		*/
}


$body = elgg_view_layout('content', array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
