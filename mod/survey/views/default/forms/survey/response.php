<?php
/**
 * Poll voting form
 */

$survey = $vars['entity'];

$response_input = elgg_view('input/radio', array(
	'name' => 'response',
	'options' => survey_get_choice_array($survey),
));

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
