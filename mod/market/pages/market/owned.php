<?php
/**
 * Elgg Market Plugin
 * @package market
 */

		
// Get input
$offset = get_input('offset', 0);
$owner_name = get_input('username');
$owner = get_user_by_username($owner_name);

elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
elgg_push_breadcrumb($owner->name);

elgg_register_title_button();

//set market title
if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
	$title = elgg_echo('market:mine:title');
} else {
	$title = sprintf(elgg_echo('market:user:title'),$owner->name);
}
		
// Get a list of market posts
$content = elgg_list_entities(array(
				'type' => 'object',
				'subtype' => 'market',
				'owner_guid' => $owner->guid,
				'limit' => 5,
				'full_view' => false,
				'pagination' => true,
				'list_type_toggle' => FALSE));

if (empty($content)) {
	$content = elgg_echo('market:none:found');
}

// Show market sidebar
//$sidebar = elgg_view("market/sidebar");

$params = array(
		'filter' => false,
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
