<?php
/**
 * Survey result view
 */

$survey = elgg_extract('entity', $vars);

// Get array of possible responses
$questions = survey_get_question_array($survey);

$total = $survey->getResponseCount();

$allow_open_survey = elgg_get_plugin_setting('allow_open_survey', 'survey');
$open_survey = false;
if ($allow_open_survey) { $open_survey = ($survey->open_survey == 1); }

echo '<p><strong>' . elgg_echo('survey:totalresponses', array($total)) . '</strong></p>';

$response_id = 0;
foreach ($questions as $question) {
	$response_id++;
	$responded_users = '';
	$response_count = $survey->getResponseCountForQuestion($question);
	$response_label = elgg_echo('survey:result:label', array($question->title, $response_count));
	
	// Show members if this survey is an open survey, or to the owner only if not open but enabled, or to admin if logged in
	// (in the latter case open surveys must be enabled in plugin settings)
	/*
		
		$user_guids = $survey->getRespondersForQuestion($question);
		if ($user_guids) {
			// Gallery of responders
			$responded_users = elgg_list_entities(array('guids' => $user_guids, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => false));
		}
		// Values
		//if ($response_values) { $responded_values = implode('<hr />', $response_values); }

		// Display as link that toggles the user icon gallery
		$response_label = elgg_view('output/url', array('text' => $response_label, 'href' => "#survey-users-response-{$response_id}", 'rel' => 'toggle'));

		// Hide responder list of closed survey by default (admins can toggle it)
		$hidden = $open_survey ? '' : 'hidden';
	}

	//$response_title = elgg_echo("survey:show_responders");
	$response_title = elgg_echo("survey:show_responses");
	*/

	$percentage = 0;
	if ($response_count > 0) { $percentage = round($response_count / $total * 100); }

	echo '<div class="survey-result">';
	
	/*
	echo '<label title="' . $response_title . '">' . $response_label . '</label>';
	//echo '<div class="survey-progress"><div class="survey-progress-filled" style="width:' . $percentage . '%"></div></div>';
	echo '<div ' . $hidden . ' id="survey-users-response-' . $response_id . '">' . $responded_users . '</div>';
	echo '<div ' . $hidden . ' id="survey-values-response-' . $response_id . '">' . $responded_values . '</div>';
	*/
	
	// Show members if this survey is an open survey, or to the owner only if not open but enabled, or to admin if logged in
	// (in the latter case open surveys must be enabled in plugin settings)
	if ($open_survey || $survey->canEdit() || elgg_is_admin_logged_in()) {
		
		$hidden = '';
		$question_title = '<h3>'.$response_label.'</h3>';
		// Hide details if not an open survey
		if (!$open_survey) {
			$hidden = 'hidden';
			// Display as link that toggles the question response details
			$question_title = elgg_view('output/url', array('text' => '<h3>'.$response_label.'</h3>', 'href' => "#survey-response-{$response_id}", 'rel' => 'toggle'));
		}
		
		// Display nice results !
		echo $question_title;
		echo '<div ' . $hidden . ' id="survey-response-' . $response_id . '">';
		echo elgg_view('survey/output/response', array('question' => $question, 'survey' => $survey, 'i' => $response_id));
		echo '</div>';
		
	} else {
		// Display only question title
		echo '<h3>' . $question->title . '</h3>';
		if (!empty($question->description)) echo '<p>' . $question->description . '</p>';
	}
	
	// Add own response
	$responses = elgg_get_annotations(array('guid' => $question->guid, 'annotation_owner_guid' => elgg_get_logged_in_user_guid(), 'annotation_name' => 'response', 'limit' => 0));
	$own_responses = array();
	foreach($responses as $response) { $own_responses[] = $response->value; }
	if (!empty($own_responses)) {
		echo '<p>' . elgg_echo('survey:results:yourresponse') . '&nbsp;: ';
		echo implode(' &nbsp; ', $own_responses);
		echo '</p>';
	}
	
	
	echo '</div>';
}


