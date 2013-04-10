<?php
/**
 * Upload a new microtheme
 *
 * @package ElggMicrothemes
 */

$owner = elgg_get_page_owner_entity();

gatekeeper();
group_gatekeeper();

$title = elgg_echo('microthemes:add');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('Microthems'));
if (elgg_instanceof($owner, 'user')) {
	elgg_push_breadcrumb($owner->name, "microthemes/owner/$owner->username");
} else {
	elgg_push_breadcrumb($owner->name, "microthemes/group/$owner->guid/all");
}
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
