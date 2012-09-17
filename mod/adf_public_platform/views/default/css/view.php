<?php
/**
 * Shows curent microtheme and lists possible new ones.
 *
 * @package ElggMicrothemes
 */

// access check for closed groups
group_gatekeeper();

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('profile/' . elgg_get_logged_in_user_entity()->name);
}

elgg_register_title_button();

$params = array();

$title = elgg_echo("microthemes:user", array($owner->name));

// List files
$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'microtheme',
	'full_view' => false,
	'list_type' => 'gallery',
));
if (!$content) {
	$content = elgg_echo("microthemes:none");
}

$sidebar = elgg_view('microthemes/sidebar');

$params['content'] = $content;
$params['title'] = $title;
$params['sidebar'] = $sidebar;
$params['filter'] = '';

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
