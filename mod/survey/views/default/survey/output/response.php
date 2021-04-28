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
//if (!$survey instanceof ElggSurvey || !$survey->canEdit()) { return; }

$add_graph = false;
if (elgg_is_active_plugin('dataviz')) {
	$add_graph = true;
	//elgg_load_js('elgg:dataviz:d3');
	//elgg_require_js('elgg:dataviz:d3');
	
	//elgg_load_js('elgg:dataviz:nvd3');
	//elgg_require_js('elgg:dataviz:nvd3');
	
	// Set of predefined colors
	$colors = [
		"#7D74FE","#7DFF26","#F84F1B","#28D8D5","#FB95B6","#9D9931","#F12ABF","#27EA88","#549AD5","#FEA526","#7B8D8B","#BB755F","#432E16",
		"#D75CFB","#44E337","#51EBE3","#ED3D24","#4069AE","#E1CC72","#E33E88","#D8A3B3","#428B50","#66F3A3","#E28A2A","#B2594D","#609297",
		"#E8F03F","#3D2241","#954EB3","#6A771C","#58AE2E","#75C5E9","#BBEB85","#A7DAB9","#6578E6","#932C5F","#865A26","#CC78B9","#2E5A52",
		"#8C9D79","#9F6270","#6D3377","#551927","#DE8D5A","#E3DEA8","#C3C9DB","#3A5870","#CD3B4F","#E476E3","#DCAB94","#33386D","#4DA284",
		"#817AA5","#8D8384","#624F49","#8E211F","#9E785B","#355C22","#D4ADDE","#A98229","#E88B87","#28282D","#253719","#BD89E1","#EB33D8",
		"#6D311F","#DF45AA","#E86723","#6CE5BC","#765175","#942C42","#986CEB","#8CC488","#8395E3","#D96F98","#9E2F83","#CFCBB8","#4AB9B7",
		"#E7AC2C","#E96D59","#929752","#5E54A9","#CCBA3F","#BD3CB8","#408A2C","#8AE32E","#5E5621","#ADD837","#BE3221","#8DA12E","#3BC58B",
		"#6EE259","#52D170","#D2A867","#5C9CCD","#DB6472","#B9E8E0","#CDE067","#9C5615","#536C4F","#A74725","#CBD88A","#DF3066","#E9D235",
		"#EE404C","#7DB362","#B1EDA3","#71D2E1","#A954DC","#91DF6E","#CB6429","#D64ADC"
	];
	if (function_exists('dataviz_get_colors')) { $colors = dataviz_get_colors(); }
	
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
	
	case 'select':
	case 'pulldown':
	case 'dropdown':
	case 'checkboxes':
	case 'multiselect':
	case 'radio':
	case 'rating':
		// Dataviz data structure
		$dataviz_data = [
			'labels' => [],   // ['Série A','Série B','Série C'],
			'datasets' => [
				'data' => [],   // [10, 20, 30], 
				'backgroundColor' => [],   // ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
				'borderColor' => [],   // ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', ],
				'borderWidth' => 1,
			],
			'cutoutPercentage' => 75,
		];
		
		// List original options (+empty value) in a table...
		$options_results = []; // value => count
		foreach($options as $key => $value) {
			$options_keys[] = $value; // Used to map indexes to values (retroactive correction)
			$options_results["$value"] = 0;
		}
		
		// Count number of choices per option
		foreach($responses as $i => $response) {
			// Retroactive correction if using numerical indexes instead of values
			if (!isset($options_results["{$response->value}"])) { $response->value = $options_keys[$response->value]; }
			$options_results["{$response->value}"] = $options_results["{$response->value}"] + 1;
			
		}
		
		// Add graph if enabled : pie is only for single choice, bars (and percentages) are more appropriate for multiple choices
		if ($add_graph) {
			// Comute graph data
			$i = 0;
			foreach($options as $key => $value) {
				if (empty($value)) continue;
				$dataviz_data['labels'][] = $value;
				$dataviz_data['datasets']['data'][] = $options_results[$key];
				$dataviz_data['datasets']['backgroundColor'][] = $colors[$i];
				$dataviz_data['datasets']['borderColor'][] = $colors[$i];
				$i++;
				if ($i >= count($colors)) { $i = 0;  }
			}
			// 2 chart types depending on input type
			if (in_array($input_type, array('pulldown', 'dropdown', 'select', 'rating', 'radio'))) {
				// Format data for chart
				$js_data = "{
					labels: ['" . implode("','", $dataviz_data['labels']) . "'],
					datasets: [{
						data: [" . implode(', ', $dataviz_data['datasets']['data']) . "], 
						backgroundColor: ['" . implode("','", $dataviz_data['datasets']['backgroundColor']) . "'],
						borderColor: ['" . implode("','", $dataviz_data['datasets']['borderColor']) . "'],
						borderWidth: {$dataviz_data['datasets']['borderWidth']}
					}],
					cutoutPercentage: {$dataviz_data['cutoutPercentage']}
				}";
				$content_responses .= elgg_view('dataviz/pie', ['jsdata' => $js_data, 'width' => '100%', 'height' => '200px']);
				
			} else {
				// checkboxes, multiselect...
				$js_data = "{
					labels: ['" . implode("','", $dataviz_data['labels']) . "'],
					datasets: [{
						label: '# de choix', 
						data: [" . implode(', ', $dataviz_data['datasets']['data']) . "], 
						backgroundColor: ['" . implode("','", $dataviz_data['datasets']['backgroundColor']) . "'],
						borderColor: ['" . implode("','", $dataviz_data['datasets']['borderColor']) . "'],
						borderWidth: {$dataviz_data['datasets']['borderWidth']}
					}]
				}";
				$content_responses .= elgg_view('dataviz/bar', ['jsdata' => $js_data, 'width' => '100%', 'height' => '200px']);
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
		$options_results = [];
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
			$dataviz_data = [
				'labels' => [],   // ['Série A','Série B','Série C'],
				'datasets' => [
					'label' => '',   // Label de la série (si plusieurs séries)
					'data' => [],   // [10, 20, 30], 
					'backgroundColor' => [],   // ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
					'borderColor' => [],   // ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', ],
					'borderWidth' => 1,
				],
			];
			$i = 0;
			foreach($options_results as $choice => $count) {
				$choice = date("d/m/Y", $choice);
				$dataviz_data['labels'][] = $choice;
				$dataviz_data['datasets']['data'][] = $count;
				$dataviz_data['datasets']['backgroundColor'][] = $colors[$i];
				$dataviz_data['datasets']['borderColor'][] = $colors[$i];
				$i++;
				if ($i >= count($colors)) { $i = 0;  }
			}
			
			$js_data = "{
				labels: ['" . implode("','", $dataviz_data['labels']) . "'],
				datasets: [{
					label: '# de choix', 
					data: [" . implode(', ', $dataviz_data['datasets']['data']) . "], 
					backgroundColor: ['" . implode("','", $dataviz_data['datasets']['backgroundColor']) . "'],
					borderColor: ['" . implode("','", $dataviz_data['datasets']['borderColor']) . "'],
					borderWidth: {$dataviz_data['datasets']['borderWidth']}
				}]
			}";
			
			$content_responses .= elgg_view('dataviz/bar', array('jsdata' => $js_data, 'width' => '100%', 'height' => '200px'));
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


