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

// Responses stats & graphs
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
		// Add graph if enabled : pie is only for single choice, bars (and percentages) are more appropriate for multiple choices
		if ($add_graph) {
			if (in_array($input_type, array('pulldown', 'dropdown', 'rating', 'radio'))) {
				$content_responses .= elgg_view('elgg_dataviz/nvd3/pie_chart', array('data' => $options_results, 'width' => '100%', 'height' => '200px'));
			} else {
				$content_responses .= elgg_view('elgg_dataviz/nvd3/bar_chart', array('data' => array("{$question->guid}" => $options_results), 'width' => '100%', 'height' => '200px'));
			}
		}
		// Table of results
		$content_responses .= '<table style="width:100%;"><thead><tr>
			<th>' . elgg_echo('survey:results:value') . '</th>
			<th>' . elgg_echo('survey:results:count') . '</th>
			</tr></thead><tbody>';
		foreach($options_results as $choice => $count) { $content_responses .= '<tr><td>' . $choice . '</td><td>' . $count . '</td></tr>'; }
		$content_responses .= '</tbody></table>';
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
		// Add graph if enabled : dates use bars rather than pie because axis order matters when dealing with dates
		if ($add_graph) {
			// Build a more readable array for graph
			$graph_data = array();
			foreach($options_results as $choice => $count) {
				$choice = date("d/m/Y", $choice);
				$graph_data["$choice"] = $count;
			}
			$content_responses .= elgg_view('elgg_dataviz/nvd3/bar_chart', array('data' => array("{$question->guid}" => $graph_data), 'width' => '100%', 'height' => '200px'));
		}
		// Results table : display dates + counter
		$content_responses .= '<table style="width:100%;"><thead><tr><th>' . elgg_echo('survey:results:value') . '</th><th>' . elgg_echo('survey:results:count') . '</th></tr></thead><tbody>';
		// Sort by asscending date
		ksort($options_results);
		foreach($options_results as $choice => $count) {
			// Convert timestamps to readable date
			$content_responses .= '<tr><td><q>' . date("d/m/Y", $choice) . '</q></td><td style="text-align:right;">' . $count . '</td></tr>';
		}
		$content_responses .= '</tbody></table>';
		break;
	
	default:
		foreach($responses as $response) { $content_responses .= '<blockquote>' . $response->value . '</blockquote>'; }
}



echo $content_question . $content_responders . '<br />' . $content_responses . '<div class="clearfloat"></div><br />';


