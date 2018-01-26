<?php
/**
 * Elgg comment view
 *
 * @uses $vars['entity']    ElggComment
 * @uses $vars['full_view'] Display full view or brief view
 */

$full_view = elgg_extract('full_view', $vars, true);

$comment = $vars['entity'];

$entity = get_entity($comment->container_guid);
$commenter = get_user($comment->owner_guid);
if (!$entity || !$commenter) {
	return true;
}

$friendlytime = '<span class="elgg-river-timestamp">' . elgg_view_friendly_time($comment->time_created) . '</span>';

//$commenter_icon = elgg_view_entity_icon($commenter, 'tiny');
$profile_type = esope_get_user_profile_type($commenter);
if (empty($profile_type)) { $profile_type = 'external'; }
$commenter_icon = '<span class="elgg-avatar elgg-avatar-tiny profile-type-' . $profile_type . '"><img src="' . $commenter->getIconURL(array('size' => 'tiny')) . '"></span>';
$commenter_link = "<a href=\"{$commenter->getURL()}\">$commenter->name</a>";

$entity_title = $entity->title ? $entity->title : elgg_echo('untitled');
$entity_link = "<a href=\"{$entity->getURL()}\">$entity_title</a>";

if ($full_view) {
	$anchor = "<a name=\"comment-{$comment->getGUID()}\"></a>";

	$menu = elgg_view_menu('entity', array(
		'entity' => $comment,
		'handler' => 'comment',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz float-alt',
	));
	
	if (elgg_in_context('activity')) {
		$comment_text = '<div class="elgg-output elgg-inner" data-role="comment-text">';
		$comment_text .= elgg_view('output/text', array(
			'value' => elgg_get_excerpt($comment->description),
		));
		$comment_text .= '</div>';
	} else {
		$comment_text = elgg_view('output/longtext', array(
			'value' => $comment->description,
			'class' => 'elgg-inner',
			'data-role' => 'comment-text',
		));
	}
	$body = <<<HTML
$anchor
<div class="mbn">
	$commenter_link
	<span class="elgg-subtext">
		$friendlytime
	</span>
	$comment_text
	$menu
</div>
HTML;

	//echo elgg_view_image_block($commenter_icon, $body);
	$content = $anchor . $comment_text;

} else {
	// brief view
	$excerpt = elgg_get_excerpt($comment->description, 80);
	/*
	$posted = elgg_echo('generic_comment:on', array($commenter_link, $entity_link));

	$body = <<<HTML
$commenter_link $friendlytime
<h4>$entity_link</h4>
<span class="elgg-subtext">
	<p>$excerpt</p>
</span>
HTML;

	//echo elgg_view_image_block($commenter_icon, $body);
	*/
	
	$content = $excerpt;
}

// @TODO ? Affiche toute la conversation
/*
if (!$full_view) {
	$thread_link = '<a href="' . $entity->getURL() . '">' . elgg_echo('theme_inria:comment:viewthread') . '</a>';
	echo '<div class="thewire-thread-link-reply">' . $thread_link . '</div>';
}
*/

echo elgg_view('page/components/iris_object', array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt, 'full_view' => false, 'mode' => 'listing') + $vars);

