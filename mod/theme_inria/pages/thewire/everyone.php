<?php
/**
 * All wire posts
 * 
 */

elgg_push_breadcrumb(elgg_echo('thewire'));

$title = elgg_echo('thewire:everyone');

$content = '';

if (elgg_is_logged_in()) {
	$form_vars = array('class' => 'thewire-form');
	$content .= elgg_view_form('thewire/add', $form_vars);
	$content .= elgg_view('input/urlshortener');
}

$content .= '<div class="clearfloat"></div>';
// Iris v2 : message supprimé ?
//$content .= '<blockquote class="thewire-inria-info">' . elgg_echo('theme_inria:thewire:explanations') . '</blockquote>';

$content .= '<div class="iris-box">';
$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => get_input('limit', 15),
));
$content .= '</div>';

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('thewire/sidebar'),
));

echo elgg_view_page($title, $body);
