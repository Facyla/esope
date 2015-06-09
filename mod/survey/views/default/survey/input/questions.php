<?php

// TODO: add ability to reorder survey questions?
$survey = elgg_extract('survey', $vars);

//elgg_require_js('elgg/survey/edit'); // Elgg 1.10
elgg_load_js('elgg.survey.edit');

$body = '';
$i = 0;

if ($survey) {
	$questions = $survey->getQuestions();
	foreach ($questions as $question) {
		$body .= elgg_view('survey/input/question', array('question' => $question, 'i' => $i));
		$i++;
	}
} else {
	// Add an empty question
	$body .= elgg_view('survey/input/question', array('i' => $i));
	$i++;
}

$body .= '<div id="new-questions-area"></div>';

$body .= elgg_view('input/button', array(
	'id' => 'add-question',
	'value' => elgg_echo('survey:add_question'),
	'class' => 'elgg-button elgg-button-action',
));

$body .= elgg_view('input/hidden', array(
	'name' => 'number_of_questions',
	'id' => 'number-of-questions',
	'value' => $i,
));

echo '<div id="survey-questions">' . $body . '</div>';

