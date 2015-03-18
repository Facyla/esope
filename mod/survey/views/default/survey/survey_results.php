<?php
/**
 * Survey result view
 */

$survey = elgg_extract('entity', $vars);
elgg_push_context('survey-results');

// Get array of possible responses
$questions = survey_get_question_array($survey);

$total = $survey->getResponseCount();

$allow_open_survey = elgg_get_plugin_setting('allow_open_survey', 'survey');
$open_survey = false;
if ($allow_open_survey) { $open_survey = ($survey->open_survey == 1); }

echo '<br />';
echo '<h3>' . elgg_echo('survey:results') . '</h3>';
echo '<p><strong>' . elgg_echo('survey:totalresponses', array($total)) . '</strong></p>';

$response_id = 0;
foreach ($questions as $question) {
	$response_id++;
	$responded_users = '';
	$response_count = $survey->getResponseCountForQuestion($question);
	$response_label = elgg_echo('survey:result:label', array($question->title, $response_count));
	
	$percentage = 0;
	if ($response_count > 0) { $percentage = round($response_count / $total * 100); }

	// Add own response
	$own_response = '';
	if (elgg_is_logged_in()) {
		$responses = elgg_get_annotations(array('guid' => $question->guid, 'annotation_owner_guid' => elgg_get_logged_in_user_guid(), 'annotation_name' => 'response', 'limit' => 0));
		$own_responses = array();
		foreach($responses as $response) {
			switch($question->input_type) {
				case 'date':
					if (strpos($response->value, '-')) { $response->value = strtotime($response->value); }
					$own_responses[] = date('d/m/Y', $response->value);
					break;
				default:
					$own_responses[] = $response->value;
			}
		}
		if (!empty($own_responses)) {
			$own_response .= '<p>' . elgg_echo('survey:results:yourresponse') . '&nbsp;: <q>' . implode('</q><q>', $own_responses) . '</q></p>';
		}
	}
	
	
	// Render question content
	echo '<div class="survey-result">';
		// Show members if this survey is an open survey, or to the owner only if not open but enabled, or to admin if logged in
		// (in the latter case open surveys must be enabled in plugin settings)
		if ($open_survey || $survey->canEdit() || elgg_is_admin_logged_in()) {
		
			$hidden = '';
			$question_title = '<h4>'.$response_label.'</h4>';
			// Hide details if not an open survey
			if (!$open_survey) {
				$hidden = 'hidden';
				// Note : do not hide when using dataviz plugin (svg requires to be displayed, and can be hidden afterwards only)
				if (elgg_is_active_plugin('elgg_dataviz')) { $hidden = ''; }
				// Display as link that toggles the question response details
				$question_title = elgg_view('output/url', array('text' => '<h4>'.$response_label.'</h4>', 'href' => "#survey-response-{$response_id}", 'rel' => 'toggle'));
			}
		
			// Display nice results !
			echo $question_title;
			echo $own_response;
			echo '<div ' . $hidden . ' id="survey-response-' . $response_id . '">';
			echo elgg_view('survey/output/response', array('question' => $question, 'survey' => $survey));
			echo '</div>';
		
		} else {
			// Display only question title, description, and own response (no stat, even not number of responders)
			echo '<h4>' . $question->title . '</h4>';
			if (!empty($question->description)) echo '<p>' . $question->description . '</p>';
			echo $own_response;
		}
	echo '</div>';
}


