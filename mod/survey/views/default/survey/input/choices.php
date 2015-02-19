<?php

// TODO: add ability to reorder survey questions?
$survey = elgg_extract('survey', $vars);

//elgg_require_js('elgg/survey/edit'); // Elgg 1.10
elgg_load_js('elgg.survey.edit');

$body = '';
$i = 0;

if ($survey) {
	$choices = $survey->getChoices();

	foreach ($choices as $choice) {
		$text_input = elgg_view('input/text', array(
			'name' => "choice_text_{$i}",
			'value' => $choice->text,
			'class' => 'survey_input-survey-choice'
		));

		$delete_icon = elgg_view('output/img', array(
			'src' => 'mod/survey/graphics/16-em-cross.png'
		));

		$delete_link = elgg_view('output/url', array(
			'href' => '#',
			'text' => $delete_icon,
			'title' => elgg_echo('survey:delete_choice'),
			'class' => 'delete-choice',
			'data-id' => $i,
		));

		$body .= "<div id=\"choice-container-{$i}\">{$text_input}{$delete_link}</div>";

		$i++;
	}
}

$body .= '<div id="new-choices-area"></div>';

$body .= elgg_view('input/button', array(
	'id' => 'add-choice',
	'value' => elgg_echo('survey:add_choice'),
	'class' => 'elgg-button elgg-button-action',
));

$body .= elgg_view('input/hidden', array(
	'name' => 'number_of_choices',
	'id' => 'number-of-choices',
	'value' => $i,
));

echo $body;

