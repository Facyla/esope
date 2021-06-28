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
elgg_push_breadcrumb(elgg_echo('feedback'), elgg_get_site_url() . 'feedback');
elgg_push_breadcrumb($title);

// Set page owner = container group if any, or custom group if specified, or site otherwise
feedback_set_page_owner($feedback);


$content = elgg_view_entity($feedback, ['full_view' => true]);

$body = elgg_view_layout('default', [
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('feedback/sidebar'),
]);

echo elgg_view_page($title, $body);

