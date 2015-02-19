<?php
/**
 * Elgg Survey plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

// Get input data
$response = get_input('response');
$guid = get_input('guid');

//get the survey entity
$survey = get_entity($guid);

if (!$survey instanceof Survey) {
	register_error(elgg_echo('survey:notfound'));
	forward(REFERER);
}

// Make sure the response isn't blank
if (empty($response)) {
	register_error(elgg_echo("survey:noresponse"));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

// Check if user has already responded
if ($survey->hasResponded($user)) {
	register_error(elgg_echo('survey:alreadyresponded'));
	forward(REFERER);
}

// add response as an annotation
$survey->annotate('response', $response, $survey->access_id);

// Add to river
$survey_response_in_river = elgg_get_plugin_setting('response_in_river', 'survey');
if ($survey_response_in_river != 'no') {
	elgg_create_river_item(array(
		'view' => 'river/object/survey/response',
		'action_type' => 'response',
		'subject_guid' => $user->guid,
		'object_guid' => $survey->guid,
	));
}

if (get_input('callback')) {
	echo elgg_view('survey/survey_widget_content', array('entity' => $survey));
}

// Success message
system_message(elgg_echo("survey:responded"));

// Forward to the survey page
forward($survey->getUrl());

