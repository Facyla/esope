<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('pages/all');
}

// access check for closed groups
group_gatekeeper(false); // N'éjecte pas si page accessible

$title = elgg_echo('pages:owner', array($owner->name));

elgg_push_breadcrumb($owner->name);

elgg_register_title_button();

$options = array(
	'types' => 'object',
	'subtypes' => 'page_top',
	'full_view' => false,
);
$use_owner = elgg_get_plugin_setting('pages_user_listall', 'adf_public_platform');
if (($use_owner == 'yes') && elgg_instanceof(elgg_get_page_owner_entity(), 'user')) $options['owner_guid'] = elgg_get_page_owner_guid();
else $options['container_guid'] = elgg_get_page_owner_guid();

$content = elgg_list_entities($options);
if (!$content) {
	$content = '<p>' . elgg_echo('pages:none') . '</p>';
}

$filter_context = '';
if (elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$sidebar = elgg_view('pages/sidebar/navigation');
$sidebar .= elgg_view('pages/sidebar');

$params = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

if (elgg_instanceof($owner, 'group')) {
	$params['filter'] = '';
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
