<?php
/**
 * Group's wire posts
 * 
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('', '404');
}

// Display only if enabled and allowed...
if (!elgg_instanceof($owner, 'group')) { forward(REFERER); }
if (!($owner->isMember() || elgg_is_admin_logged_in())) { forward(REFERER); }
$add_wire = elgg_get_plugin_setting('groups_add_wire', 'adf_public_platform');
switch ($add_wire) {
	case 'yes': break; 
	case 'groupoption':
		if ($owner->thewire_enable != 'yes') { forward(REFERER); }
		break; 
	default: forward(REFERER);
}

$title = elgg_echo('theme_inria:thewire:group:title', array($owner->name));

elgg_push_breadcrumb(elgg_echo('thewire'), "thewire/all");
elgg_push_breadcrumb($owner->name);

$context = '';
if (elgg_get_logged_in_user_guid() == $owner->guid) {
	$form_vars = array('class' => 'thewire-form');
	$content = elgg_view_form('thewire/group_add', $form_vars);
	$content .= elgg_view('input/urlshortener');
	$context = 'mine';
}

$action = elgg_get_site_url() . "action/thewire/add";
$content .= elgg_view_form('thewire/group_add', array('class' => 'thewire-form', 'action' => $action));

$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'thewire',
	'container_guid' => $owner->guid,
	'limit' => get_input('limit', 15),
));

$body = elgg_view_layout('one_sidebar', array(
	'filter_context' => $context,
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('thewire/sidebar'),
));

$title = strip_tags($title);
echo elgg_view_page($title, $body);

