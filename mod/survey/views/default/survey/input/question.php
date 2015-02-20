<?php
// 1 question fieldset
// Used by input/questions with $question and $i parameters
// And also duplicated as full html in JS script
// QUestion fields : 

// TODO: add ability to reorder survey questions?
$question = elgg_extract('question', $vars);
$i = elgg_extract('i', $vars);

$question_types_opt = array('text' => elgg_echo('survey:type:text'), 'longtext' => elgg_echo('survey:type:longtext'), 'dropdown' => elgg_echo('survey:type:dropdown'), 'checkboxes' => elgg_echo('survey:type:checkboxes'), 'multiselect' => elgg_echo('survey:type:multiselect'), 'rating' => elgg_echo('survey:type:rating'), 'date' => elgg_echo('survey:type:date'));
$yes_no_opt = array('yes' => elgg_echo('survey:yes'), 'no' => elgg_echo('survey:no'));

// Modèle de question et paramètres
// Question object meta : title, description, input_type, options, empty_value, required
if ($question) {
	$question_content = '';
	
	$question_content .= '<p><label>' . elgg_echo('survey:question:title') . ' ' . elgg_view('input/text', array('name' => "question_title_{$i}", 'value' => $question->title, 'class' => 'survey_input-question-title')) . '</label></p>';
	
	$question_content .= '<p><label>' . elgg_echo('survey:question:description') . ' ' . elgg_view('input/longtext', array('name' => "question_description_{$i}", 'value' => $question->description, 'class' => 'survey_input-question-description')) . '</label></p>';
	
	$question_content .= '<p><label>' . elgg_echo('survey:question:input_type') . ' ' . elgg_view('input/dropdown', array('name' => "question_input_type_{$i}", 'value' => $question->input_type, 'options_values' => $question_types_opt, 'class' => 'survey_input-question-input-type')) . '</label></p>';
	
	$question_content .= '<p><label>' . elgg_echo('survey:question:options') . ' ' . elgg_view('input/plaintext', array('name' => "question_options_{$i}", 'value' => $question->options, 'class' => 'survey_input-question-options')) . '</label></p>';
	
	$question_content .= '<p><label>' . elgg_echo('survey:question:empty_value') . ' ' . elgg_view('input/dropdown', array('name' => "question_empty_value_{$i}", 'value' => $question->empty_value, 'options_values' => $yes_no_opt, 'class' => 'survey_input-question-empty-value')) . '</label></p>';
	
	$question_content .= '<p><label>' . elgg_echo('survey:question:required') . ' ' . elgg_view('input/dropdown', array('name' => "question_required_{$i}", 'value' => $question->required, 'options_values' => $yes_no_opt, 'class' => 'survey_input-question-required')) . '</label></p>';
	
	// @TODO later : allow to define questions dependencies : based on non-empty, or specific value(s) ?
	//$question_content .= '<p><label>Dépendances ' . elgg_view('input/text', array('name' => "question_dependency_{$i}", 'value' => $question->dependency, 'class' => 'survey_input-question-dependency')) . '</label></p>';
	
	
	$delete_icon = elgg_view('output/img', array(
		'src' => 'mod/survey/graphics/16-em-cross.png'
	));
	$delete_link = elgg_view('output/url', array(
		'href' => '#',
		'text' => $delete_icon,
		'title' => elgg_echo('survey:delete_question'),
		'class' => 'delete-question',
		'data-id' => $i,
	));
	
	

	$body .= "<div id=\"question-container-{$i}\">
			<fieldset class=\"survey_input-question\">
				<span style=\"float:right\">{$delete_link}</span>
				{$question_content}
			</fieldset>
		</div>";
}

echo $body;

