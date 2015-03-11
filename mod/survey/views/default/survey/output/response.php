<?php
// 1 response to question

$question = elgg_extract('question', $vars);
$survey = elgg_extract('survey', $vars);
if (!elgg_instanceof($survey, 'object', 'survey') || !$survey->canEdit()) { return; }

// Useful vars
$guid = $question->guid;
$title = $question->title;
$description = $question->description;
$input_type = $question->input_type;
$options = $question->options;
$empty_value = $question->empty_value;
$required = $question->required;
$display_order = $question->display_order;

$yes_no_opt = array('yes' => elgg_echo('survey:option:yes'), 'no' => elgg_echo('survey:option:no'));
$question_types_opt = array('text' => elgg_echo('survey:type:text'), 'longtext' => elgg_echo('survey:type:longtext'), 'pulldown' => elgg_echo('survey:type:pulldown'), 'checkboxes' => elgg_echo('survey:type:checkboxes'), 'multiselect' => elgg_echo('survey:type:multiselect'), 'rating' => elgg_echo('survey:type:rating'), 'date' => elgg_echo('survey:type:date'));


// Responders
$response_count = $survey->getResponseCountForQuestion($question);
$user_guids = $survey->getRespondersForQuestion($question);
if ($user_guids) {
	// Gallery of responders
	$responders_count = sizeof($user_guids);
	$responded_users = "Répondants ($responders_count)&nbsp;: " . elgg_list_entities(array('guids' => $user_guids, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => true, 'limit' => 100));
}



// Question et réponses
// Question object meta : title, description, input_type, options, empty_value, required
$question_content = '';
$question_content .= '<h3>' . elgg_echo('survey:result:label', array($title, $response_count)) . '</h3>';
$question_content .= '<p><em>' . $question_types_opt[$input_type] . ', GUID ' . $guid . ', ' . $display_order;
if ($required == 'yes') { $question_content .= ', ' . elgg_echo('survey:question:required'); }
$question_content .= '</em></p>';
if (!empty($description)) $question_content .= '<p>' . elgg_echo('survey:question:description') . '&nbsp;: ' . $description . '</p>';
if (!empty($options) && in_array($input_type, array('pulldown', 'checkboxes', 'multiselect', 'rating'))) {
	$question_content .= '<p>' . elgg_echo('survey:question:options') . '&nbsp;: <pre>' . $options . '</pre>';
	if ($empty_value == 'yes') {
		$question_content .= '+ ' . elgg_echo('survey:question:empty_value');
	}
	$question_content .= '</p>';
}


// Ajout répondants
$question_content .= $responded_users;


// Détail des réponses par répondant
$responses = new ElggBatch('elgg_get_annotations', array('guid' => $question->guid, 'annotation_name' => 'response', 'limit' => 0));
$count_values = array();
$responders_values = array();
$question_content .= "<strong>Réponses</strong><br />";
// Count each value for dropdown/radio, etc.
foreach($responses as $response) {
	// Regroupe les réponses par répondant
	$responders_values[$response->owner_guid][] = $response->value;
	// Compte le nb de réponses par valeur
	// Use hash to avoid using improper strings as array index
	$hash = md5($response->value);
	if (!isset($count_values["$hash"])) {
		$count_values["$hash"] = array('value' => $response->value, 'count' => 1);
	} else {
		$count_values["$hash"]['count'] = $count_values[$hash]['count'] + 1;
	}
}

// Responders stats
// Text : list of values
if (in_array($input_type, array('text'))) {
	foreach($count_values as $hash => $details) {
		$survey_questions .= '<q>' . $details['value'] . ' &nbsp; (' . $details['count'] . ')</q>';
	}
} else if (in_array($input_type, array('longtext'))) {
	foreach($count_values as $hash => $details) {
		$survey_questions .= '<blockquote>' . $details['value'] . ' &nbsp; (' . $details['count'] . ')</blockquote>';
	}
} else if (in_array($input_type, array('date'))) {
	foreach($count_values as $hash => $details) {
		$survey_questions .= '<p>' . $details['value'] . ' &nbsp; (' . $details['count'] . ')</p>';
	}
} else if (in_array($input_type, array('pulldown', 'checkboxes', 'multiselect', 'rating'))) {
	// @TODO List original options (+empty value) in a table...
	foreach($count_values as $hash => $details) {
		$survey_questions .= '<p>' . $details['value'] . ' &nbsp; (' . $details['count'] . ')</p>';
	}
}
$question_content .= $survey_questions;
/*
$survey_questions .= '<br /><h5>' . elgg_echo('survey:results:question_details:responses') . '</h5>';
$survey_questions .= '<table style="width:100%;"><thead><tr>
	<th>' . elgg_echo('survey:results:name') . '</th>
	<th>' . elgg_echo('survey:results:guid') . '</th>
	<th>' . elgg_echo('survey:results:value') . '</th>
	<th>' . elgg_echo('survey:results:moredetails') . '</th>
	</tr></thead><tbody>';
foreach($responders_values as $user_guid => $values) {
	$ent = get_entity($user_guid);
	$icon = '<img src="' . $ent->getIconURL('tiny') . '" />';
	$user_details = '<strong><a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/user/' . $ent->guid . '" class="">' . elgg_echo('survey:results:user_details') . '</a></strong>';
	$survey_questions .= '<tr><td>' . $icon . ' ' . $ent->name . '</td><td>' . $ent->guid . '</td><td>' . implode('<br />', $values) . '</td><td>' . $user_details . '</td></tr>';
}
$survey_questions .= '</tbody></table>';
*/

// Response values stats
/*
$survey_questions .= '<br /><h5>' . elgg_echo('survey:results:question_details:values') . '</h5>';
$survey_questions .= '<table style="width:100%;"><thead><tr>
	<th>' . elgg_echo('survey:results:value') . '</th>
	<th>' . elgg_echo('survey:results:count') . '</th>
	</tr></thead><tbody>';
//$survey_questions .= '<hr /><pre>' . print_r($count_values, true) . '</pre>';
foreach($count_values as $hash => $details) {
	$survey_questions .= '<tr><td>' . $details['value'] . '</td><td>' . $details['count'] . '</td></tr>';
}
$survey_questions .= '</tbody></table>';
*/


switch($input_type) {
	case 'text':
		break;
	
	case 'longtext':
		break;
	
	case 'pulldown':
		break;
	
	case 'checkboxes':
		break;
	
	case 'multiselect':
		break;
	
	case 'rating':
		break;
	
	case 'date':
		break;
	
	default:
}


$body .= "<div id=\"question-container-{$i}\">
		<fieldset class=\"survey-input-question\">
			{$question_content}
		</fieldset>
	</div>";


echo $body;

