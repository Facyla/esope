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
$size = elgg_extract('size', $vars, 'medium');

if (!$post) { return true; }

// make compatible with posts created with original Curverider plugin
$thread_id = $post->wire_thread;
if (!$thread_id) { $post->wire_thread = $post->guid; }

$owner = $post->getOwnerEntity();
$owner_icon = '<a href="' . $owner->getURL() . '"><img src="' . $owner->getIconUrl(array('size' => $size)) . '" alt="' . $owner->name . '" /></a>';
$owner_link = elgg_view('output/url', array(
	//'href' => "thewire/owner/$owner->username",
	'href' => $owner->getURL(),
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

/*
$subtitle = "$author_text $date";
// Esope : add group container support
if (!empty($post->container_guid)) {
	$post_container = $post->getContainerEntity();
	if (elgg_instanceof($post_container, 'group')) {
		$subtitle .= ' ' . elgg_echo('river:ingroup', array('<a href="' . $post_container->getURL() . '">' . $post_container->name . '</a>'));
	}
}
*/

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) { $metadata = ''; }

// Post parent ?
$parent = thewire_get_parent($post->guid);

// Seulement pour les posts faisant partie d'une conversation
// mais y compris le post initial s'il a des réponses
$num_thread = elgg_get_entities_from_metadata(array(
	"type" => "object", "subtype" => "thewire",
	"metadata_name" => "wire_thread", "metadata_value" => $post->wire_thread,
	'count' => true,
));
$thread_link = false;
if ($num_thread > 1) {
	if (!elgg_in_context('thewire-thread')) {
		// Affiche toute la conversation
		$thread_link = elgg_view('output/url', array(
			'text' => elgg_echo('thewire:thread:viewnum', array($num_thread)),
			'href' => "thewire/thread/$post->wire_thread",
		));
		$metadata_alt .= '<li>' . $thread_link . '</li>';
	}
}

if ($post->reply) {
	// Iris : no more "previous" link
	/*
	// @TODO Display reply link if not direct parent ? or better organise content in threaded view ?
	// For now, list all messages by date, and add special class to tell apart direct replies from others
	//if ($parent && ($parent->guid != $post->wire_thread)) {
	if (!elgg_in_context('thewire-thread')) {
		// Affiche le précédent
		$metadata_alt .= '<li>' . elgg_view('output/url', array(
			'text' => elgg_echo('previous'),
			'href' => "thewire/previous/$post->guid",
			'class' => 'thewire-previous',
			'title' => elgg_echo('thewire:previous:help'),
		)) . '</li>';
	}
	*/
}

/*
$params = array(
	'entity' => $post,
	'title' => false,
	'metadata' => $metadata,
	'metadata_alt' => $metadata_alt,
	'subtitle' => $subtitle,
	'content' => thewire_filter($post->description),
	'tags' => false,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);
*/

//echo elgg_view_image_block($owner_icon, $list_body, array('class' => 'thewire-post'));
//$content = thewire_filter($post->description);
// Inria : support line breaks
$content = nl2br(thewire_filter($post->description));


$after = '';
/* Iris : no more "previous" link
//if ($post->reply && $parent && ($parent->guid != $post->wire_thread)) {
if ($post->reply && !elgg_in_context('thewire-tread')) {
	//echo "<div class=\"thewire-parent hidden\" id=\"thewire-previous-{$post->guid}\">";
	//echo "</div>";
	$after = '<div class="thewire-parent hidden" id="thewire-previous-' . $post->guid . '"></div>';
}
*/

// Add classes for reply level (top parent, direct reply, other replies)
if (!$parent) {
	$class = 'thewire-parent-top';
} else {
	$class .= ' thewire-reply';
	if ($parent->guid == $post->wire_thread) { $class .= ' thewire-reply-top'; }
	$class .= ' thewire-reply-to-' . $parent->guid;
}

/* A valider 
if ($parent && $thread_link) { echo '<div class="thewire-thread-link-reply">' . $thread_link . '</div>'; }
*/

echo elgg_view('page/components/iris_object', $vars + array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt, 'after' => $after, 'class' => $class));

/* A valider 
if (!$parent && $thread_link) { echo '<div class="thewire-thread-link-parent">' . $thread_link . '</div>'; }
*/


