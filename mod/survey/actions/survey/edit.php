<?php
/*
 * Elgg Survey plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 * add/edit action
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('survey');

// Get input data
$title = get_input('title');
$description = get_input('description');
$front_page = get_input('front_page');
$close_date = get_input('close_date');
$open_survey = (int)get_input('open_survey');
$tags = get_input('tags');
$access_id = get_input('access_id');
$container_guid = get_input('container_guid');
$guid = get_input('guid');
$number_of_questions = (int) get_input('number_of_questions', 0);
$comments_on = get_input('comments_on', 'no');

// Get questions data
// Question object meta : title, description, input_type, options, empty_value, required
$count = 0;
$new_questions = array();
if ($number_of_questions) {
	$q_guid = get_input('question_guid');
	//$q_display_order = get_input('question_display_order');
	$q_title = get_input('question_title');
	$q_description = get_input('question_description');
	$q_input_type = get_input('question_input_type');
	$q_options = get_input('question_options');
	$q_empty_value = get_input('question_empty_value');
	$q_required = get_input('question_required');
	//error_log("Loading question $i data : $q_title / $q_input_type / $q_empty_value / $q_required"); // debug
	// Title is the only required value for questions (default on text input)
	for($i=0; $i<$number_of_questions; $i++) {
		if ($q_title[$i]) {
			// Set defaults
			if (empty($q_input_type[$i])) { $q_input_type[$i] = 'text'; }
			if (empty($q_empty_value[$i])) { $q_empty_value[$i] = 'yes'; }
			if (empty($q_required[$i])) { $q_required[$i] = 'no'; }
			// Add/update question
			$new_questions[] = array(
					'guid' => $q_guid[$i],
					// Adjust display order to received order
					'display_order' => ($count + 1) * 10,
					'title' => $q_title[$i],
					'description' => $q_description[$i],
					'input_type' => $q_input_type[$i],
					'options' => $q_options[$i],
					'empty_value' => $q_empty_value[$i],
					'required' => $q_required[$i],
				);
			$count++;
		}
	}
}
//echo $number_of_questions . '<pre>' . print_r($new_questions, true) . '</pre>';


// Make sure the question and the response options aren't empty
// Or we may have less valid questions than expected ?
//if ($count < $number_of_questions) {
if ($count == 0) {
	register_error(elgg_echo("survey:blank"));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

// Check whether non-admins are allowed to create site-wide surveys
$survey_site_access = elgg_get_plugin_setting('site_access', 'survey');
if ($survey_site_access == 'admins' && !$user->isAdmin()) {
	$container = get_entity($container_guid);
	// Regular users are allowed to create surveys only inside groups (any group subtype)
	//if (!$container instanceof ElggGroup) {
	if ($container->getType() != 'group') {
		register_error(elgg_echo('survey:can_not_create'));
		elgg_clear_sticky_form('survey');
		forward('survey/all');
	}
}

// Use existing entity or create a new one
if ($guid) {
	$new = false;
	// editing an existing survey
	$survey = get_entity($guid);

	if (!$survey instanceof ElggSurvey) {
		register_error(elgg_echo('survey:notfound'));
		forward(REFERER);
	}

	if (!$survey->canEdit()) {
		register_error(elgg_echo('survey:permission_error'));
		forward(REFERER);
	}

	// Success message
	$message = elgg_echo("survey:edited");
	
} else {
	$new = true;
	// Initialise a new ElggSurvey
	$survey = new ElggSurvey();

	// Set its owner to the current user
	$survey->owner_guid = $user->guid;
	$survey->container_guid = $container_guid;

	// Success message
	$message = elgg_echo("survey:added");
}


// Save base survey data
$survey->access_id = $access_id;
$survey->title = $title;
$survey->description = $description;
$survey->open_survey = $open_survey ? 1 : 0;
$survey->close_date = empty($close_date) ? null : $close_date;
$survey->tags = string_to_tag_array($tags);
$survey->comments_on = $comments_on;

if (!$survey->save()) {
	register_error(elgg_echo("survey:error"));
	forward(REFERER);
}

// Add questions
$survey->setQuestions($new_questions);

// Set Front page featured status
$survey->setFrontPage($front_page);

elgg_clear_sticky_form('survey');


// River
if ($new) {
	$survey_create_in_river = elgg_get_plugin_setting('create_in_river', 'survey');
	if ($survey_create_in_river == 'yes') {
		//add_to_river('river/object/survey/create', 'create' , $user->guid, $survey->guid);
		elgg_create_river_item(array(
			'view' => 'river/object/survey/create',
			'action_type' => 'create',
			'subject_guid' => $user->guid,
			'object_guid' => $survey->guid,
		));
	}
}

system_message($message);

// Forward to the survey page
forward($survey->getURL());

