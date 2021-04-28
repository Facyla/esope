<?php
/**
 * Main survey page
 */

$url = elgg_get_site_url();

// Main panel
$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');

$user = elgg_get_logged_in_user_entity();
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

$options['no_results'] = elgg_echo('survey:none');
$content .= elgg_list_entities($options);



$sidebar = elgg_view('survey/sidebar');

$title = elgg_echo('item:object:survey');

echo elgg_view_page($title, [
	'title' => elgg_echo('survey:index'),
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-survey-layout',
	//'filter_context' => 'all',
]);

