<?php
/* Display more details on responses to a question
 * This should be available :
 * - to admins
 * - to survey owner (->canEdit)
 * - to any member if the survey is open
 */

$i = elgg_extract('i', $vars);
$question = elgg_extract('question', $vars);
$survey = elgg_extract('survey', $vars);
//if (!elgg_instanceof($survey, 'object', 'survey') || !$survey->canEdit()) { return; }

$add_graph = false;
if (elgg_is_active_plugin('elgg_dataviz')) {
	$add_graph = true;
	elgg_load_js('elgg:dataviz:d3');
	elgg_load_css('elgg:dataviz:nvd3');
	elgg_load_js('elgg:dataviz:nvd3');
}

// Useful vars
$guid = $question->guid;
$title = $question->title;
$description = $question->description;
$input_type = $question->input_type;
$options = survey_get_question_choices_array($question);
$empty_value = $question->empty_value;
$required = $question->required;
$display_order = $question->display_order;

$response_count = $survey->getResponseCountForQuestion($question);
$responders_guids = $survey->getRespondersForQuestion($question);
$responders_count = sizeof($responders_guids);


$yes_no_opt = array('yes' => elgg_echo('survey:option:yes'), 'no' => elgg_echo('survey:option:no'));
$question_types_opt = array('text' => elgg_echo('survey:type:text'), 'longtext' => elgg_echo('survey:type:longtext'), 'pulldown' => elgg_echo('survey:type:pulldown'), 'checkboxes' => elgg_echo('survey:type:checkboxes'), 'multiselect' => elgg_echo('survey:type:multiselect'), 'rating' => elgg_echo('survey:type:rating'), 'date' => elgg_echo('survey:type:date'));



// Plus d'infos sur la question
$content_question = '<p><em>' . $question_types_opt[$input_type];
if ($required == 'yes') { $content_question .= ', ' . elgg_echo('survey:question:required'); } else  { $content_question .= ', ' . elgg_echo('survey:question:notrequired'); }
$content_question .= ', ' . $response_count . ' réponses';
//$content_question .= ', GUID ' . $guid . ', ' . $display_order;
$content_question .= '</em></p>';
//$content_question .= '<h3>' . elgg_echo('survey:result:label', array($title, $question_types_opt[$input_type] . ', ' . $response_count)) . '</h3>';
//$content_question .= '<h3>' . $title . '</h3>';
if (!empty($description)) $content_question .= '<p>' . elgg_echo('survey:question:description') . '&nbsp;: ' . $description . '</p>';



// Responders - répondants
/*
if ($responders_guids) {
	// Gallery of responders
	//$content_responders = "<strong>Répondants ($responders_count)&nbsp;:</strong> ";
	$content_responders .= elgg_list_entities(array('guids' => $responders_guids, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => true, 'limit' => 100));
}
*/



// Détail des réponses
$responses = new ElggBatch('elgg_get_annotations', array('guid' => $question->guid, 'annotation_name' => 'response', 'limit' => 0));

// Responses stats
switch($input_type) {
	case 'text':
		foreach($responses as $response) { $content_responses .= '<q>' . $response->value . '</q>'; }
		break;
	
	case 'longtext':
		foreach($responses as $response) { $content_responses .= '<blockquote>' . $response->value . '</blockquote>'; }
		break;
	
	case 'pulldown':
	case 'dropdown':
	case 'checkboxes':
	case 'multiselect':
	case 'radio':
	case 'rating':
		// List original options (+empty value) in a table...
		$options_results = array(); // value => count
		foreach($options as $key => $value) {
			$options_keys[] = $value; // Used to map indexes to values (retroactive correction)
			$options_results["$value"] = 0;
		}
		// Count number of choices per option
		foreach($responses as $response) {
			// Retroactive correction if using numerical indexes instead of values
			if (!isset($options_results["{$response->value}"])) { $response->value = $options_keys[$response->value]; }
			$options_results["{$response->value}"] = $options_results["{$response->value}"] + 1;
		}
		$content_responses .= '<table style="width:100%;"><thead><tr>
			<th>' . elgg_echo('survey:results:value') . '</th>
			<th>' . elgg_echo('survey:results:count') . '</th>
			</tr></thead><tbody>';
		foreach($options_results as $choice => $count) { $content_responses .= '<tr><td>' . $choice . '</td><td>' . $count . '</td></tr>'; }
		$content_responses .= '</tbody></table>';
		// Add graph if enabled : pie is only for single choice, bars (and percentages) are more appropriate for multiple choices
		if ($add_graph) {
			if (in_array($input_type, array('pulldown', 'dropdown'))) {
				$content_responses .= elgg_view('elgg_dataviz/nvd3/pie_chart', array('data' => $options_results, 'width' => '100%', 'height' => '200px'));
			} else {
				$content_responses .= elgg_view('elgg_dataviz/nvd3/bar_chart', array('data' => array("{$question->guid}" => $options_results), 'width' => '100%', 'height' => '200px'));
			}
		}
		break;
	
	case 'date':
		$options_results = array();
		foreach($responses as $response) {
			// Retroactive correction if date was not a timestamp
			if (strpos($response->value, "-")) $response->value = strtotime($response->value);
			// Count responses
			if (!isset($options_results["{$response->value}"])) { $options_results["{$response->value}"] = 0; }
			$options_results["{$response->value}"] = $options_results["{$response->value}"] + 1;
		}
		// Display dates + counter
		$content_responses .= '<table style="width:100%;"><thead><tr><th>' . elgg_echo('survey:results:value') . '</th><th>' . elgg_echo('survey:results:count') . '</th></tr></thead><tbody>';
		// Sort by asscending date
		ksort($options_results);
		foreach($options_results as $choice => $count) {
			// Convert timestamps to readable date
			$content_responses .= '<tr><td>' . date("d/m/Y", $choice) . '</td><td>' . $count . '</td></tr>';
		}
		$content_responses .= '</tbody></table>';
		
		if ($add_graph) {
			// Build a more readable array for graph
			$graph_data = array();
			foreach($options_results as $choice => $count) {
				$choice = date("d/m/Y", $choice);
				$graph_data["$choice"] = $count;
			}
			// Note : bars because we have order matters when dealing with dates
			$content_responses .= elgg_view('elgg_dataviz/nvd3/bar_chart', array('data' => array("{$question->guid}" => $graph_data), 'width' => '100%', 'height' => '200px'));
		}
		break;
	
	default:
		foreach($responses as $response) { $content_responses .= '<blockquote>' . $response->value . '</blockquote>'; }
}



echo $content_question . $content_responders . '<br />' . $content_responses . '<div class="clearfloat"></div><br />';


