<?php
/**
 * Owner / friends survey page
 */

// @TODO listing et filtres

$url = elgg_get_site_url();

$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');


$username = get_input('username');
$owner = get_user_by_username($username);
$user = elgg_get_logged_in_user_entity();

$options = [
	'type'=>'object',
	'subtype'=>'survey',
	'full_view' => false,
	'limit' => 15
];

$survey_site_access = elgg_get_plugin_setting('site_access', 'survey');

if ((elgg_is_logged_in() && ($survey_site_access != 'admins')) || elgg_is_admin_logged_in()) {
	elgg_register_menu_item('title', array(
		'name' => 'add',
		'href' => "survey/add",
		'text' => elgg_echo('survey:add'),
		'link_class' => 'elgg-button elgg-button-action'
	));
}

$options['owner_guid'] = $owner->guid;

elgg_push_breadcrumb($owner->name);

if ($user->guid == $owner->guid) {
	$title = elgg_echo('survey:your');
	$filter_context = 'mine';
} else {
	$title = elgg_echo('survey:not_me', array(htmlspecialchars($owner->name)));
	$filter_context = "";
}
$sidebar = elgg_view('survey/sidebar');

$options['no_results'] = elgg_echo('survey:none');

$content .= elgg_list_entities($options);


echo elgg_view_page($title, [
	'title' => $title,
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'filter_context' => $filter_context,
	'class' => 'elgg-survey-layout',
]);

