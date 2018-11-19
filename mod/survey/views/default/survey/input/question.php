<?php
// 1 question fieldset
// Used by input/questions with $question and $i parameters
// And also duplicated as full html in JS script
// QUestion fields : 

// TODO: add ability to reorder survey questions?
$i = elgg_extract('i', $vars);
$question = elgg_extract('question', $vars);
// Set defaults or current values
$guid = 0;
$display_order = $i * 10;
$title = '';
$description = '';
$input_type = 'text';
$options = '';
$empty_value = 'no';
$required = 'no';
if ($question) {
	$guid = $question->guid;
	$display_order = $question->display_order;
	$title = $question->title;
	$description = $question->description;
	$input_type = $question->input_type;
	$options = $question->options;
	$empty_value = $question->empty_value;
	$required = $question->required;
}

$question_types_opt = array('text' => elgg_echo('survey:type:text'), 'longtext' => elgg_echo('survey:type:longtext'), 'pulldown' => elgg_echo('survey:type:pulldown'), 'checkboxes' => elgg_echo('survey:type:checkboxes'), 'multiselect' => elgg_echo('survey:type:multiselect'), 'rating' => elgg_echo('survey:type:rating'), 'date' => elgg_echo('survey:type:date'));
$yes_no_opt = array('yes' => elgg_echo('survey:option:yes'), 'no' => elgg_echo('survey:option:no'));
$no_yes_opt = array('no' => elgg_echo('survey:option:no'), 'yes' => elgg_echo('survey:option:yes'));

// Modèle de question et paramètres
// Question object meta : title, description, input_type, options, empty_value, required
$question_content = '';

// Load GUID, if entity exists
if (!empty($guid)) $question_content .= elgg_view('input/hidden', array('name' => 'question_guid[]', 'value' => $guid));
// Set display order
//$question_content .= elgg_view('input/hidden', array('name' => 'question_display_order_' . $i, 'value' => $display_order));

$question_content .= '<p class="question_title_' . $i . '"><label>' . elgg_echo('survey:question:title') . ' ' . elgg_view('input/text', array('name' => "question_title[]", 'value' => $title, 'class' => 'survey-input-question-title', 'placeholder' => elgg_echo('survey:question:title:placeholder'))) . '</label></p>';

// Group all other input elements to we can hide them on-demand
$question_content .= '<div class="survey-input-question-details">';
	
	$question_content .= '<p class="question_required_' . $i . '" style="float:right;"><label>' . elgg_echo('survey:question:required') . ' ' . elgg_view('input/select', array('name' => "question_required[]", 'value' => $required, 'options_values' => $yes_no_opt, 'class' => 'survey-input-question-required')) . '</label></p>';

	$question_content .= '<p class="question_input_type_' . $i . '"><label>' . elgg_echo('survey:question:input_type') . ' ' . elgg_view('input/select', array('name' => "question_input_type[]", 'value' => $input_type, 'options_values' => $question_types_opt, 'class' => 'survey-input-question-input-type', 'data-id' => $i)) . '</label>';
	// Add some help for each input type
	$question_content .= elgg_view('survey/input/question_type_help', array('input_type' => $input_type));
	$question_content .= '</p>';

	// Hide conditionnal elements
	if (!in_array($input_type, array('dropdown', 'pulldown', 'checkboxes', 'multiselect', 'rating'))) { $hide = 'display:none;'; } else { $hide = ''; }
	$question_content .= '<p class="question_options_' . $i . '" style="' . $hide . '"><label>' . elgg_echo('survey:question:options') . ' ' . elgg_view('input/plaintext', array('name' => "question_options[]", 'value' => $options, 'class' => 'survey-input-question-options', 'placeholder' => elgg_echo('survey:question:options:placeholder'))) . '</label></p>';

	// Hide conditionnal elements
	if (!in_array($input_type, array('dropdown', 'pulldown', 'rating'))) { $hide = 'display:none;'; } else { $hide = ''; }
	$question_content .= '<p class="question_empty_value_' . $i . '" style="' . $hide . '"><label>' . elgg_echo('survey:question:empty_value') . ' ' . elgg_view('input/select', array('name' => "question_empty_value[]", 'value' => $empty_value, 'options_values' => $no_yes_opt, 'class' => 'survey-input-question-empty-value')) . '</label></p>';

	// @TODO later : allow to define questions dependencies : based on non-empty, or specific value(s) ?
	//$question_content .= '<p><label>Dépendances ' . elgg_view('input/text', array('name' => "question_dependency[]", 'value' => $question->dependency, 'class' => 'survey-input-question-dependency')) . '</label></p>';
	
	/*
	if (empty($description)) { $hide = 'display:none;'; } else { $hide = ''; }
	$question_content .= '<p class="question_description_' . $i . '"><a href="#" class="survey-input-toggle" data-id="question_description_' . $i . '">' . elgg_echo('survey:question:toggle') . '</a> <label>' . elgg_echo('survey:question:description') . ' ' . elgg_view('input/plaintext', array('name' => "question_description[]", 'value' => $description, 'class' => 'survey-input-question-description', 'style' => $hide)) . '</label></p>';
	*/
	$question_content .= '<p class="question_description_' . $i . '"><label>' . elgg_echo('survey:question:description') . ' ' . elgg_view('input/plaintext', array('name' => "question_description[]", 'value' => $description, 'class' => 'survey-input-question-description', 'placeholder' => elgg_echo('survey:question:description:placeholder'))) . '</label></p>';
	
$question_content .= '</div>';


//$delete_icon = elgg_view('output/img', array('src' => 'mod/survey/graphics/16-em-cross.png'));
$delete_link = elgg_view('output/url', array(
	'href' => '#',
	'text' => '<i class="fa fa-trash"></i>', // $delete_icon
	'title' => elgg_echo('survey:delete_question'),
	'class' => 'delete-question',
	'data-id' => $i,
));



$body .= "<div id=\"question-container-{$i}\">
		<fieldset class=\"survey-input-question\">
			<span style=\"float:right\">{$delete_link}</span>
			{$question_content}
		</fieldset>
	</div>";


echo $body;

