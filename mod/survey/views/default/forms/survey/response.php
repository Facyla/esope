<?php
/** Survey voting form
 * Send responses for each question in indexed array by question guid
 */

$survey = $vars['entity'];
$response_input = '';
$i = 0;
$questions = survey_get_question_array($survey);
foreach($questions as $question) {
	$i++;
	// Common params
	$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label> ';
	// Add some more text/tips/help
	if (!empty($question->description)) { $response_input .= '<p><em><i class="fa fa-info-circle"></i> ' . $question->description . '</em></p>'; }
	
	$input_params = array('name' => "response[{$question->guid}]", 'id' => "response_$i");
	if ($question->required == 'yes') { $input_params['required'] = 'required'; }
	
	switch($question->input_type) {
		case 'dropdown':
		case 'pulldown':
			$input_params['options_values'] = survey_get_question_choices_array($question);
			$response_input .= elgg_view('input/pulldown', $input_params);
			break;
		
		case 'multiselect':
			$input_params['options_values'] = survey_get_question_choices_array($question);
			$response_input .= elgg_view('input/multiselect', $input_params);
			break;
		
		case 'checkboxes':
			$input_params['options'] = survey_get_question_choices_array($question);
			$response_input .= elgg_view('input/checkboxes', $input_params);
			break;
		
		case 'radio':
		case 'rating':
			$input_params['options'] = survey_get_question_choices_array($question);
			$response_input .= elgg_view('input/radio', $input_params);
			//$response_input .= elgg_view('input/rating', $input_params);
			break;
		
		case 'date':
			//$input_params['timestamp'] = true; // Note : cannot use it for some reason - no value passed to the action
			$response_input .= elgg_view('input/date', $input_params);
			break;
		
		case 'plaintext':
		case 'longtext':
			$response_input .= elgg_view('input/plaintext', $input_params);
			break;
		
		case 'text':
		default:
			$response_input .= elgg_view('input/text', $input_params);
	}
	
	$response_input .= '</div>';
}

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit_response', 'value' => elgg_echo('survey:respond'),
	'class' => 'elgg-button-submit survey-response-button', 'rel' => $survey->guid,
));

$guid_input = elgg_view('input/hidden', array('name' => 'guid', 'value' => $survey->guid));

$callback_input = elgg_view('input/hidden', array('name' => 'callback', 'value' => $vars['callback']));

echo <<<HTML
	<div>
		$response_input
	</div>
	<div>
		$guid_input
		$submit_input
		$callback_input
	</div>
HTML;

