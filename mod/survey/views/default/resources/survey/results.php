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



// Display results page

$guid = get_input('guid');
$filter = get_input('filter');
$filter_guid = get_input('filter_guid');

$user = elgg_get_logged_in_user_entity();

$survey = get_entity($guid);
if (!$survey instanceof ElggSurvey) {
	elgg_echo('survey:invalid');
	forward(REFERER);
}

// Set the page owner
$page_owner = $survey->getContainerEntity();
//if ($page_owner instanceof ElggGroup) {
if ($page_owner->getType() == 'group') {
	elgg_set_page_owner_guid($page_owner->guid);
} else {
	elgg_set_page_owner_guid(elgg_get_site_entity()->guid);
}

// Access control
if (!$survey->canEdit($user->guid) && !elgg_is_admin_logged_in()) {
	elgg_echo('survey:no_access');
	forward(REFERER);
}

elgg_push_breadcrumb($survey->title, $survey->getURL());
elgg_push_breadcrumb(elgg_echo('survey:results'), 'survey/results/' . $survey->guid);

$title = elgg_echo('survey:results');
// Check filter validity - forward to results page if error
if ($filter) {
	$filter_entity = get_entity($filter_guid);
	if (($filter == 'user') && !($filter_entity instanceof ElggUser)) {
		register_error(elgg_echo('survey:filter:invalid'));
		forward('survey/results/' . $survey->guid);
	}
	if (($filter == 'question') && !$filter_entity instanceof ElggSurveyQuestion) {
		register_error(elgg_echo('survey:filter:invalid'));
		forward('survey/results/' . $survey->guid);
	}
	if (in_array($filter, array('user', 'question'))) {
		//elgg_push_breadcrumb(elgg_echo('survey:results:' . $filter), 'survey/results/' . $survey->guid . '/' . $filter . '/' . $filter_guid);
		if ($filter == 'question') {
			$title = elgg_echo('survey:results:questiondetails', array($filter_entity->title));
		} else if ($filter == 'user') {
			$title = elgg_echo('survey:results:userdetails', array($filter_entity->name));
		}
		elgg_push_breadcrumb(elgg_echo('survey:results:' . $filter));
	}
}

$content = '';
/*
$content .= '<h3>' . elgg_echo('survey:results:summary') . '</h3>';
$content .= elgg_view('survey/survey_results', array('entity' => $survey));
$content .= '<br />';
$content .= '<h3>' . elgg_echo('survey:results:full') . '</h3>';
*/
$content .= elgg_view('survey/survey_full_results', array('entity' => $survey, 'filter' => $filter, 'filter_guid' => $filter_guid, 'filter_entity' => $filter_entity));





echo elgg_view_page($title, [
	'title' => $params['title'],
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-survey-layout',
]);

