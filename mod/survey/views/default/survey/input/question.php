<?php
// 1 question fieldset
// Used by input/questions with $question and $i parameters
// And also duplicated as full html in JS script
// QUestion fields : 

// TODO: add ability to reorder survey questions?
$i = elgg_extract('i', $vars);
$question = elgg_extract('question', $vars);
// Set defaults or current values
$title = '';
$description = '';
$input_type = 'text';
$options = '';
$empty_value = 'yes';
$required = 'no';
if ($question) {
	$title = $question->title;
	$description = $question->description;
	$input_type = $question->input_type;
	$options = $question->options;
	$empty_value = $question->empty_value;
	$required = $question->required;
}

$question_types_opt = array('text' => elgg_echo('survey:type:text'), 'longtext' => elgg_echo('survey:type:longtext'), 'dropdown' => elgg_echo('survey:type:dropdown'), 'checkboxes' => elgg_echo('survey:type:checkboxes'), 'multiselect' => elgg_echo('survey:type:multiselect'), 'rating' => elgg_echo('survey:type:rating'), 'date' => elgg_echo('survey:type:date'));
$yes_no_opt = array('yes' => elgg_echo('survey:option:yes'), 'no' => elgg_echo('survey:option:no'));

// Modèle de question et paramètres
// Question object meta : title, description, input_type, options, empty_value, required
$question_content = '';

$question_content .= '<p class="question_options_' . $i . '"><label>' . elgg_echo('survey:question:title') . ' ' . elgg_view('input/text', array('name' => "question_title_{$i}", 'value' => $title, 'class' => 'survey_input-question-title')) . '</label></p>';

if (empty($description)) { $hide = 'display:none;'; } else { $hide = ''; }
$question_content .= '<p class="question_descripion_' . $i . '"><a href="#" class="survey_input-toggle" data-id="question_description_' . $i . '">' . elgg_echo('survey:question:toggle') . '</a> <label>' . elgg_echo('survey:question:description') . ' ' . elgg_view('input/plaintext', array('name' => "question_description_{$i}", 'value' => $description, 'class' => 'survey_input-question-description', 'style' => $hide)) . '</label></p>';

$question_content .= '<p class="question_required_' . $i . '"><label>' . elgg_echo('survey:question:required') . ' ' . elgg_view('input/dropdown', array('name' => "question_required_{$i}", 'value' => $required, 'options_values' => $yes_no_opt, 'class' => 'survey_input-question-required')) . '</label></p>';

$question_content .= '<p class="question_input_type_' . $i . '"><label>' . elgg_echo('survey:question:input_type') . ' ' . elgg_view('input/dropdown', array('name' => "question_input_type_{$i}", 'value' => $input_type, 'options_values' => $question_types_opt, 'class' => 'survey_input-question-input-type')) . '</label></p>';

// Hide conditionnal elements
if (!in_array($input_type, array('dropdown', 'checkboxes', 'multiselect', 'rating'))) { $hide = 'display:none;'; } else { $hide = ''; }

$question_content .= '<p class="question_empty_value_' . $i . '" style="' . $hide . '"><label>' . elgg_echo('survey:question:empty_value') . ' ' . elgg_view('input/dropdown', array('name' => "question_empty_value_{$i}", 'value' => $empty_value, 'options_values' => $yes_no_opt, 'class' => 'survey_input-question-empty-value')) . '</label></p>';

$question_content .= '<p class="question_options_' . $i . '" style="' . $hide . '"><label>' . elgg_echo('survey:question:options') . ' ' . elgg_view('input/plaintext', array('name' => "question_options_{$i}", 'value' => $options, 'class' => 'survey_input-question-options')) . '</label></p>';

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


echo $body;

