<?php
/**
 * Edit a microtheme
 *
 * @package ElggMicrothemes
 */

gatekeeper();

$guid = (int) get_input('guid');
$microtheme = get_entity($guid);
if (!$microtheme) {
	forward();
}
if (!$microtheme->canEdit()) {
	forward();
}

$title = elgg_echo('microthemes:edit');

elgg_push_breadcrumb(elgg_echo('microthemes'));
elgg_push_breadcrumb($microtheme->title);
elgg_push_breadcrumb($title);

elgg_set_page_owner_guid($microtheme->getContainerGUID());

$form_vars = array('enctype' => 'multipart/form-data');
$body_vars = array();

$content = elgg_view_form('microthemes/edit', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
