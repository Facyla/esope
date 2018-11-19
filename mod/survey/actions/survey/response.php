<?php
/**
 * Elgg Survey plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

// Get input data
$responses = get_input('response');
$guid = get_input('guid');

//get the survey entity
$survey = get_entity($guid);

if (!elgg_instanceof($survey, 'object', 'survey')) {
	register_error(elgg_echo('survey:notfound'));
	forward(REFERER);
}

// Make sure the response isn't blank
if (empty($responses)) {
	register_error(elgg_echo("survey:noresponse"));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

// Check if user has already responded
if ($survey->hasResponded($user)) {
	register_error(elgg_echo('survey:alreadyresponded'));
	forward(REFERER);
}

foreach ($responses as $question_guid => $response) {
	//error_log("Response : q $question_guid => $response");
	// add response as an annotation
	//$survey->annotate("response_$question_guid", $response, $survey->access_id);
	// Annotate the question itself instead, so we can use a single annotation name
	$question = get_entity($question_guid);
	if (elgg_instanceof($question, 'object', 'survey_question')) {
		// Convert dates to timestamp
		if (($question->input_type == "date") && strpos($response, '-')) { $response = strtotime($response); }
		if (is_array($response)) {
			foreach($response as $response_item) {
				if (!empty($response_item) || ($question->empty_value == 'yes')) {
					$question->annotate("response", $response_item, $survey->access_id);
				}
			}
		} else {
			if (!empty($response) || ($question->empty_value == 'yes')) {
				$question->annotate("response", $response, $survey->access_id);
			}
		}
	}
}
// Anotate also the survey so we can know we have answered (and when)
$survey->annotate("response", time(), $survey->access_id);

// Add to river
$survey_response_in_river = elgg_get_plugin_setting('response_in_river', 'survey');
if ($survey_response_in_river == 'yes') {
	//add_to_river('river/object/survey/response', 'response' , $user->guid, $survey->guid);
	elgg_create_river_item(array(
		'view' => 'river/object/survey/response',
		'action_type' => 'response',
		'subject_guid' => $user->guid,
		'object_guid' => $survey->guid,
	));
}

if (get_input('callback')) {
	echo elgg_view('survey/survey_content', array('entity' => $survey, 'nowrapper' => true));
}

// Success message
system_message(elgg_echo("survey:responded"));

// Forward to the survey page
forward($survey->getUrl());

