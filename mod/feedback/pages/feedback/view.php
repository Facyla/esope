<?php
/**
 * View a feedback
 *
 * @package ElggFeedback
 */

$feedback = get_entity(get_input('guid'));
if (!$feedback) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

elgg_set_context('feedback');

$title = $feedback->title;
$feedback_url = $feedback->getURL();

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('feedback'), $CONFIG->url . 'feedback');
elgg_push_breadcrumb($title);


$content = elgg_view_entity($feedback, array('full_view' => true));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);

