<?php
/**
 * Main survey page
 */

$url = elgg_get_site_url();

// Main panel
$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');


$username = get_input('username');

global $autofeed;
$autofeed = true;
$user = elgg_get_logged_in_user_entity();
$params = [];
$options = array(
	'type'=>'object',
	'subtype'=>'survey',
	'full_view' => false,
	'limit' => 15
);



$survey_site_access = elgg_get_plugin_setting('site_access', 'survey');

if ((elgg_is_logged_in() && ($survey_site_access != 'admins')) || elgg_is_admin_logged_in()) {
	elgg_register_menu_item('title', array(
		'name' => 'add',
		'href' => "survey/add",
		'text' => elgg_echo('survey:add'),
		'link_class' => 'elgg-button elgg-button-action'
	));
}

$container_entity = get_user($container_guid);
$friends = $container_entity->getFriends(array('limit' => false));

$options['container_guids'] = [];
foreach ($friends as $friend) {
	$options['container_guids'][] = $friend->getGUID();
}

$params['filter_context'] = 'friends';
$params['title'] = elgg_echo('survey:friends');

elgg_push_breadcrumb($container_entity->name, "survey/owner/{$container_entity->username}");
elgg_push_breadcrumb(elgg_echo('friends'));

$options['no_results'] = elgg_echo('survey:none');

if (count($options['container_guids']) == 0) {
	// this person has no friends
	$params['content'] = '';
} else {
	$params['content'] = elgg_list_entities($options);
}



echo elgg_view_page($title, [
	'title' => elgg_echo('survey:owner'),
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-survey-layout',
]);

