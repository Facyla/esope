<?php
/** Survey voting form
 * Send responses for each question in indexed array by question guid
 */

$survey = $vars['entity'];
$response_input = '';
$i = 0;
$questions = survey_get_question_array($survey);
foreach($questions as $question) {
	// Common params
	$response_input .= '<div class="survey-question-reply"><label for="response_' . $i . '">' . $question->title . '</label> ';
	$input_params = array('name' => "response[{$question->guid}]", 'id' => "response_$i");
	if ($question->required == 'yes') { $input_params['required'] = 'required'; }
	
	switch($question->input_type) {
		case 'plaintext':
		case 'longtext':
			$response_input .= elgg_view('input/plaintext', $input_params);
			break;
		
		case 'dropdown':
		case 'pulldown':
			$options_values = explode("\n", $question->options);
			$options_values = array_map('trim', $options_values);
			$options_values = array_filter($options_values);
			if ($question->empty_value == 'yes') { array_unshift($options_values, ''); }
			$input_params['options_values'] = $options_values;
			$response_input .= elgg_view('input/pulldown', $input_params);
			break;
		
		case 'checkboxes':
			$options_values = explode("\n", $question->options);
			$options_values = array_map('trim', $options_values);
			$options_values = array_filter($options_values);
			if ($question->empty_value == 'yes') { array_unshift($options_values, ''); }
			$input_params['options'] = $options_values;
			$response_input .= elgg_view('input/checkboxes', $input_params);
			break;
		
		case 'radio':
		case 'rating':
			$options = explode("\n", $question->options);
			$options = array_map('trim', $options);
			$options = array_filter($options);
			if ($question->empty_value == 'yes') { array_unshift($options, ''); }
			$input_params['options'] = $options;
			$response_input .= elgg_view('input/radio', $input_params);
			//$response_input .= elgg_view('input/rating', $input_params);
			break;
		
		case 'multiselect':
			$options_values = explode("\n", $question->options);
			$options_values = array_map('trim', $options_values);
			$options_values = array_filter($options_values);
			if ($question->empty_value == 'yes') { array_unshift($options, ''); }
			$input_params['options_values'] = $options_values;
			$response_input .= elgg_view('input/multiselect', $input_params);
			break;
		
		case 'date':
			$response_input .= elgg_view('input/date', $input_params);
			break;
		
		case 'text':
		default:
			$response_input .= elgg_view('input/text', $input_params);
	}
	
	$response_input .= '</div>';
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

