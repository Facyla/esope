<?php
/**
 * Poll voting form
 */

$survey = $vars['entity'];

$questions = survey_get_question_array($survey);
// @TODO build response form
// Store responses for each question in indexed array by question guid
$response_input = '';
$i = 0;
foreach($questions as $question) {
	switch($question->input_type) {
		case 'plaintext':
		case 'longtext':
			$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label>' . elgg_view('input/plaintext', array('name' => "response[{$question->guid}]", 'id' => "response_$i")). '</div>';
			break;
		
		case 'dropdown':
			$options_values = explode("\n", $question->options);
			if ($question->empty_value == 'yes') { $options_values[''] = ''; }
			$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label>' . elgg_view('input/dropdown', array('name' => "response[{$question->guid}]", 'id' => "response_$i", 'options_values' => $options_values)). '</div>';
			break;
		
		case 'checkboxes':
			$options_values = explode("\n", $question->options);
			//$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label>' . elgg_view('input/checkboxes', array('name' => "response[{$question->guid}]", 'id' => "response_$i")). '</div>';
			break;
		
		case 'radio':
			$options_values = explode("\n", $question->options);
			break;
		
		case 'date':
			$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label>' . elgg_view('input/date', array('name' => "response[{$question->guid}]", 'id' => "response_$i")). '</div>';
			break;
		
		case 'rating':
			//$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label>' . elgg_view('input/rating', array('name' => "response[{$question->guid}]", 'id' => "response_$i", 'options' => '')). '</div>';
			break;
		
		case 'text':
		default:
			$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label>' . elgg_view('input/text', array('name' => "response[{$question->guid}]", 'id' => "response_$i")). '</div>';
	}
	$i++;
}

$submit_input = elgg_view('input/submit', array(
	'name' => 'submit_response',
	'value' => elgg_echo('survey:respond'),
	'class' => 'elgg-button-submit survey-response-button',
	'rel' => $survey->guid,
));

$guid_input = elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $survey->guid,
));

$callback_input = elgg_view('input/hidden', array(
	'name' => 'callback',
	'value' => $vars['callback'],
));

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

