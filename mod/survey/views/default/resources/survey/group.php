<?php
/**
 * Main survey page
 */

$url = elgg_get_site_url();

// Main panel
$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');


$guid = get_input('guid');
$group = get_entity($guid);
//if (!$group instanceof ElggGroup || !survey_activated_for_group($group)) { forward(); }
if (($group->getType() != 'group') || !survey_activated_for_group($group)) { forward(); }


$container_guid = $group->guid;

$user = elgg_get_logged_in_user_entity();
$options = [
	'type'=>'object',
	'subtype'=>'survey',
	'full_view' => false,
	'limit' => 15
];

$crumbs_title = $group->name;

// set breadcrumb
elgg_push_breadcrumb($crumbs_title);

elgg_push_context('groups');

elgg_set_page_owner_guid($container_guid);
elgg_entity_gatekeeper($container_guid);

$options['container_guid'] = $container_guid;
$user_guid = elgg_get_logged_in_user_guid();
if (elgg_get_page_owner_entity()->canWriteToContainer($user_guid)){
	elgg_register_menu_item('title', array(
		'name' => 'add',
		'href' => "survey/add/".$container_guid,
		'text' => elgg_echo('survey:add'),
		'link_class' => 'elgg-button elgg-button-action'
	));
}
$options['no_results'] = elgg_echo('survey:none');
$content .= elgg_list_entities($options);


$title = elgg_echo('survey:group_survey:listing:title', array(htmlspecialchars($crumbs_title)));

echo elgg_view_page($title, [
	'title' => $title,
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-survey-layout',
]);

