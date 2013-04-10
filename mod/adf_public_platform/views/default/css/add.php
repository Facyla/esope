<?php
/**
 * Create a new microtheme
 *
 * @package ElggMicrotheme
 */

$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();

$title = elgg_echo('microthemes:add');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('microthemes'));
elgg_push_breadcrumb($owner->name);
elgg_push_breadcrumb($title);

// create form
$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = array();
$content = elgg_view_form('microthemes/edit', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
