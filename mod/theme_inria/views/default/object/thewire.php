<?php
/**
 * View a wire post
 * 
 * @uses $vars['entity']
 * 
 * Esope : add container support
 */

elgg_load_js('elgg.thewire');

$full = elgg_extract('full_view', $vars, FALSE);
$post = elgg_extract('entity', $vars, FALSE);

if (!$post) {
	return true;
}

// make compatible with posts created with original Curverider plugin
$thread_id = $post->wire_thread;
if (!$thread_id) {
	$post->wire_thread = $post->guid;
}

$owner = $post->getOwnerEntity();

$owner_icon = '<img src="' . $owner->getIconUrl(array('size' => 'medium')) . '" alt="' . $owner->name . '" />';
$owner_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
//$author_text = elgg_echo('byline', array($owner_link));
$author_text = $owner_link; // Iris v2
$date = elgg_view_friendly_time($post->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $post,
	'handler' => 'thewire',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";
// Esope : add group container support
if (!empty($post->container_guid)) {
	$post_container = $post->getContainerEntity();
	if (elgg_instanceof($post_container, 'group')) {
		$subtitle .= ' ' . elgg_echo('river:ingroup', array('<a href="' . $post_container->getURL() . '">' . $post_container->name . '</a>'));
	}
}

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$params = array(
	'entity' => $post,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'content' => thewire_filter($post->description),
	'tags' => false,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($owner_icon, $list_body, array('class' => 'thewire-post'));

if ($post->reply) {
	echo "<div class=\"thewire-parent hidden\" id=\"thewire-previous-{$post->guid}\">";
	echo "</div>";
}

