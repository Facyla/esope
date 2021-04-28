<?php

// Is survey enabled in group ?
function survey_activated_for_group($group) {
	$group_survey = elgg_get_plugin_setting('group_survey', 'survey');
	if ($group && ($group_survey != 'no')) {
		if (($group->survey_enable == 'yes') || (!$group->survey_enable && ($group_survey == 'yes_default'))) {
			return true;
		}
	}
	return false;
}


// Has user rights to add survey in group ?
function survey_can_add_to_group($group, $user = null) {
	$survey_group_access = elgg_get_plugin_setting('group_access', 'survey');
	if (!$survey_group_access || $survey_group_access == 'admins') {
		return $group->canEdit();
	} else {
		if (!$user) {
			$user = elgg_get_logged_in_user_guid();
		}
		return $group->canEdit() || $group->isMember($user);
	}
}


/* Get options and formats them in a suitable array for input views
 * @param $question : the question object
 * @param $reverse : reverse return array key <=> values order
 * Notes : we do not need to reverse order, as we use no keys here (will be numerical)
           use regular options_values (option=>value) for : dropdown, pulldown, multiselect
           use reverse options for : checkboxes, radio, rating
 */
// @TODO à déplacer dans la classe ElggQuestionSurvey, ssi tous les objets sont bien convertis de manière à utiliser cette classe !
function survey_get_question_choices_array($question) {
	$choices = explode("\n", $question->options);
	if (is_array($choices)) {
		$choices = array_map('trim', $choices);
		// Remove empty values
		$choices = array_filter($choices);
		$choices = array_unique($choices);
	}
	// Build clean array with choices both as key and value
	$options = array();
	foreach($choices as $option) { $options["$option"] = $option; }
	// Add optional empty option
	if ($question->empty_value == 'yes') { array_unshift($options, ''); }
	return $options;
}


/**
 * Prepare variables for the edit form
 * @param ElggObject $survey
 * @return array
 */
function survey_prepare_edit_body_vars($survey = null) {
	// input names => defaults
	$values = array(
		'title' => null,
		'description' => null,
		'close_date' => null,
		'open_survey' => null,
		'tags' => null,
		'front_page' => null,
		'comments_on' => null,
		'access_id' => ACCESS_DEFAULT,
		'guid' => null
	);
	
	// Load current values
	if ($survey) {
		foreach (array_keys($values) as $field) {
			if (isset($survey->$field)) {
				$values[$field] = $survey->$field;
			}
		}
	}
	// Load sticky forms values
	if (elgg_is_sticky_form('survey')) {
		$sticky_values = elgg_get_sticky_values('survey');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	// @TODO Save and load questions to sticky form as well
	
	elgg_clear_sticky_form('survey');

	return $values;
}


// Format date for display
function survey_format_date($ts) {
	$format = "d/m/Y";
	return date($format, $ts);
}



// @TODO ? Upgrade function
function survey_upgrade_to_3_3() {
	// @TODO use batch if many objects $responses = new ElggBatch('elgg_get_annotations', array('guid' => $guid, 'annotation_name' => 'response', 'limit' => false));
	$survey_questions = elgg_get_entities(['type' => 'object', 'subtype' => 'survey_question', 'limit' => false]);
	foreach($survey_questions as $entity) {
		if (!$entity instanceof ElggSurveyQuestion) {
			// update class ?
		}
	}
	
	
}


