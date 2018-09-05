<?php
/**
 * Elgg poll individual post view
 *
 * @uses $vars['entity'] Optionally, the poll post to view
 */

$poll = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars);

if (!$poll) { return TRUE; }

$page_owner = elgg_get_page_owner_entity();

$owner = $poll->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
		'href' => "poll/owner/$owner->username",
		'text' => $owner->name,
		'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$tags = elgg_view('output/tags', array('tags' => $poll->tags));
$categories = elgg_view('output/categories', $vars);
$container = $poll->getContainerEntity();
$date = elgg_view_friendly_time($poll->time_created);

$own = elgg_get_logged_in_user_entity();


$allow_close_date = elgg_get_plugin_setting('allow_close_date','poll');
if (($allow_close_date == 'yes') && (isset($poll->close_date))) {
	$date_day = gmdate('j', $poll->close_date);
	$date_month = gmdate('m', $poll->close_date);
	$date_year = gmdate('Y', $poll->close_date);
	$friendly_time = $date_day . '. ' . elgg_echo("poll:month:$date_month") . ' ' . $date_year;
	$poll_state = $poll->isOpen() ? 'open' : 'closed';
	$closing_date .= "<div class='poll_closing-date-{$poll_state}'><b>" . elgg_echo('poll:poll_closing_date', array($friendly_time)) . '</b></div>';
}

$responses = $poll->countAnnotations('vote');
if ($responses == 1) {
	$noun = elgg_echo('poll:noun_response');
} else {
	$noun = elgg_echo('poll:noun_responses');
}
$responses = "<div>" . $responses . " " . $noun . "</div>";


// TODO: support comments off
// The "on" status changes for comments, so best to check for !Off
$comments_link = '';
/*
if ($poll->comments_on != 'Off') {
	$comments_count = $poll->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $poll->getURL() . '#poll-comments',
			'text' => $text,
			'is_trusted' => true
		));
	}
}
*/

// do not show the metadata and controls in widget view
$metadata = '';
if (!elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
			'entity' => $poll,
			'handler' => 'poll',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz'
	));
}

if ($full) {
	$description = $poll->description;
} else {
	if ($poll->isOpen() && !$poll->hasVoted($own)) {
		$description = '<a href="' . $poll->getUrl() . '" class="iris-object-readmore">' . elgg_get_excerpt($poll->description) . '<span class="readmore">' . elgg_echo('theme_inria:readmore:vote') . '</span></a>';
	} else {
		$description = '<a href="' . $poll->getUrl() . '" class="iris-object-readmore">' . elgg_get_excerpt($poll->description) . '<span class="readmore">' . elgg_echo('theme_inria:readmore:view') . '</span></a>';
	}
}
if (!empty($description)) { $description = '<div class="" style="padding: 0.5rem 0">' . $description . '</div>'; }



if ($full) {
	/*
	$subtitle = "$closing_date $comments_link $categories";
	$params = array(
		'entity' => $poll,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	*/

	
	$content = '';
	$content .= $closing_date . $tags . $categories . $description;

	//echo elgg_view('poll/body', $vars);
	$content .= elgg_view('poll/body', $vars);

} else {
	// brief view

	/*
	$subtitle = "$comments_link $categories";
	$params = array(
		'entity' => $poll,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	*/

	//echo elgg_view_image_block($owner_icon, $list_body);
	$content = $closing_date /* . $tags . $categories . $responses */;
	$content .= $description;
	if (elgg_instanceof($page_owner, 'group') && !elgg_in_context('workspace') && !elgg_in_context('workspace-content')) {
		$content .= elgg_view('object/poll_content', $vars);
	}
	
}

echo elgg_view('page/components/iris_object', $vars + array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt));


