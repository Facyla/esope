<?php
/**
 * Main survey page
 */

elgg_gatekeeper();

$url = elgg_get_site_url();

// Main panel
$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');


$container_guid = get_input('container_guid');
$guid = get_input('guid');
if ($guid) { $page_type = 'edit'; } else {$page_type = 'add'; }

$form_vars = array('id' => 'survey-edit-form');

// Get the post, if it exists
if ($page_type == 'edit') {
	$survey = get_entity($guid);

	if (!$survey instanceof ElggSurvey) {
		register_error(elgg_echo('survey:not_found'));
		forward(REFERER);
	}

	if (!$survey->canEdit()) {
		register_error(elgg_echo('survey:permission_error'));
		forward(REFERER);
	}

	$container = $survey->getContainerEntity();
	elgg_set_page_owner_guid($container->guid);

	$title = elgg_echo('survey:editpost', array($survey->title));

	$body_vars = array(
		'fd' => survey_prepare_edit_body_vars($survey),
		'entity' => $survey
	);

	if ($container instanceof ElggGroup) {
		elgg_push_breadcrumb($container->name, 'survey/group/' . $container->guid);
	} else {
		// Do not show owner for site surveys ?
		elgg_push_breadcrumb($container->name, 'survey/owner/' . $container->username);
	}
	elgg_push_breadcrumb(elgg_echo("survey:edit"));
	
} else {
	
	if ($container_guid) {
		$container = get_entity($container_guid);
		elgg_push_breadcrumb($container->name, 'survey/group/' . $container->guid);
	} else {
		$container = elgg_get_logged_in_user_entity();
		elgg_push_breadcrumb($container->name, 'survey/owner/' . $container->username);
	}

	elgg_set_page_owner_guid($container->guid);

	elgg_push_breadcrumb(elgg_echo('survey:add'));

	$title = elgg_echo('survey:addpost');

	$body_vars = array(
		'fd' => survey_prepare_edit_body_vars(),
		'container_guid' => $guid
	);
}

$content = elgg_view_form("survey/edit", $form_vars, $body_vars);



echo elgg_view_page($title, [
	'title' => $title,
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-survey-layout',
]);

