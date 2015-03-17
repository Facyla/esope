<?php
/**
 * Survey full results view
 * Enable full view, and filtered results : by user or by question
 */


$survey = elgg_extract('entity', $vars);
$filter = elgg_extract('filter', $vars);
$filter_guid = elgg_extract('filter_guid', $vars);
$filter_entity = elgg_extract('filter_entity', $vars);
$own = elgg_get_logged_in_user_entity();

$limit = get_input('limit', 100);
$offset = get_input('offset', 0);

$survey_stats = '';
$survey_responders = '';
$survey_questions = '';
$response_id = 0;


// Get some stats on survey
$questions = survey_get_question_array($survey);
$questions_count = sizeof($questions);
// Responses count
$total_responses_count = $survey->getResponseCount();
// Get responders GUIDs
$responders_guid = $survey->getResponders();


// Survey global stats
$survey_stats .= '<h3>' . elgg_echo('survey:results:stats') . '</h3>';
$survey_stats .= '<table style="width:100%;">';
$survey_stats .= '<tbody>';
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:numquestions') . '</strong></td><td>' . $questions_count . '</td></tr>';
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:numresponders') . '</strong></td><td>' . $total_responses_count . '</td></tr>';
// Sondage actif ou non
$survey_state = $survey->isOpen() ? 'open' : 'closed';
$survey_state = elgg_echo('survey:state:' . $survey_state);
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:open') . '</strong></td><td>' . $survey_state . '</td></tr>';
// Date de création
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:created') . '</strong></td><td>' . date('d/m/Y', $survey->time_created) . '</td></tr>';
// Date de dernière MAJ
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:updated') . '</strong></td><td>' . date('d/m/Y', $survey->time_updated) . '</td></tr>';
// Date de clôture
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:closing') . '</strong></td><td>' . date('d/m/Y', $survey->close_date) . '</td></tr>';
// Niveau d'accès
$survey_stats .= '<tr><td><strong>' . elgg_echo('survey:results:access') . '</strong></td><td>' . elgg_view('output/access', array('entity' => $survey)) . '</td></tr>';
// Sondage mis en Une ?
//$survey_stats .= '<li>' . elgg_echo('survey:results:featured', array(date('d/m/Y', $survey->))) . '</li>';
$survey_stats .= '</tbody></table>';


// Results content details
switch($filter) {
	
	case 'user':
		$user = $filter_entity;
		$survey_questions .= '<br /><br />';
		$survey_questions .= '<h3>' . elgg_echo('survey:results:userdetails', array($user->name)) . '</h3>';
		$icon = elgg_view_entity_icon($user, 'small');
		$text = '<a href="' . $user->getURL() . '" >' . $user->name . '</a> ' . $user->briefdescription;
		$survey_questions .= elgg_view_image_block($icon, $text);
		$response_date = elgg_get_annotations(array('guid' => $survey->guid, 'annotation_owner_guids' => $user->guid, 'annotation_name' => 'response'));
		$survey_questions .= "<p>Date de réponse " . date('d/m/Y', $response_date[0]->time_created) . '</p>';
		/*
		$survey_questions .= '<span style="float:right;">' . $icon . '</span>';
		*/
		
		// List data on this survey for a given user
		// Get array of possible responses
		$questions = survey_get_question_array($survey);
		$survey_questions .= '<table style="width:100%;"><thead><tr>
			<th style="width:25%;">' . elgg_echo('survey:results:question') . '</th>
			<th style="width:30%;">' . elgg_echo('survey:results:value') . '</th>
			<th style="width:12%;">' . elgg_echo('survey:results:inputtype') . '</th>
			<th style="width:8%;">' . elgg_echo('survey:results:nbresponses') . '</th>
			<th style="width:10%;">' . elgg_echo('survey:results:percresponses') . '</th>
			<th style="width:15%;">' . elgg_echo('survey:results:moredetails') . '</th>
			</tr></thead><tbody>';
		// List all questions with stats and responses from responder
		foreach ($questions as $question) {
			$response_id++;
			$percentage = 0;
			$response_count = $survey->getResponseCountForQuestion($question);
			// Show members if this survey
			if ($response_count > 0) { $percentage = round($response_count / $total_responses_count * 100); }
			// Responses from this user
			$responses = elgg_get_annotations(array('guid' => $question->guid, 'annotation_owner_guids' => $user->guid, 'annotation_name' => 'response', 'limit' => 0));
			$responder_values = array();
			foreach($responses as $response) {
				//$survey_questions .= '<p>' . $response->value . '</p>';
				$responder_values[] = $response->value;
			}
			$question_details = '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/question/' . $question->guid . '">' . elgg_echo('survey:results:question_details') . '</a>';
			$survey_questions .= '<tr>
					<td><strong>' . $question->title . '</strong></td>
					<td><q>' . implode('</q><q>', $responder_values) . '</q></strong></td>
					<td>' . elgg_echo('survey:type:' . $question->input_type) . '</td>
					<td style="text-align:right;">' . $response_count . '</td>
					<td>
						<div class="survey-progress"><div class="survey-progress-filled" style="width:' . $percentage . '%"></div></div>
						' . $percentage . '%
					</td>
					<td><strong>' . $question_details . '</strong></td>
				</tr>';
		}
		$survey_questions .= '</tbody></table>';
		break;
	
	
	// Detailed data for a specific question
	case 'question':
		$question = $filter_entity;
		$survey_questions .= '<br /><br /><h3>' . elgg_echo('survey:results:questiondetails', array($question->title)) . '</h3>';
		$response_count = $survey->getResponseCountForQuestion($question);
		// Show members if this survey
		$response_id++;
		// Percentage bar
		$percentage = 0;
		if ($response_count > 0) { $percentage = round($response_count / $total_responses_count * 100); }
		
		// Plus d'infos sur la question
		$survey_questions .= '<table style="width:100%;"><tbody>';
		$survey_questions .= '<tr><td>' . elgg_echo('survey:results:inputtype') . '</td><td>' . elgg_echo('survey:type:' . $question->input_type) . '</td></tr>';
		//if ($question->required == 'yes') { $survey_questions .= '<tr><td>' . elgg_echo('survey:response:required') . '</td></tr>'; } else  { $survey_questions .= '<tr><td>' . elgg_echo('survey:response:notrequired') . '</td></tr>'; }
		$survey_questions .= '<tr><td>' . elgg_echo('survey:question:required') . '</td><td>' . elgg_echo('survey:settings:' . $question->required) . '</td></tr>';
		$survey_questions .= '<tr><td>' . elgg_echo('survey:results:nbresponses') . '</td><td>' . elgg_echo('survey:results:question:counts', array($response_count, $total_responses_count, $percentage));
		$survey_questions .= '<div class="survey-progress" style="width:200px; display:inline-block; margin:0 0 0 8px;"><div class="survey-progress-filled" style="width: ' . $percentage . '%"></div></div>';
		$survey_questions .= '</td></tr>';
		if (elgg_is_admin_logged_in()) {
			$survey_questions .= '<tr><td>' . elgg_echo('survey:question:display_order') . '</td><td>' . $question->display_order . '</td></tr>';
			$survey_questions .= '<tr><td>' . elgg_echo('survey:question:guid') . '</td><td>' . $question->guid . '</td></tr>';
		}
		if (!empty($question->description)) $survey_questions .= '<tr><td>' . elgg_echo('survey:question:description') . '</td><td>' . $question->description . '</td></tr>';
		$survey_questions .= '</tbody></table>';
		
		// Detailed data + dataviz graph
		if (!in_array($question->input_type, array('text', 'longtext'))) {
			$survey_questions .= elgg_view('survey/output/response', array('question' => $question, 'survey' => $survey));
		}
		
		// Détail des réponses par répondant
		$responses = new ElggBatch('elgg_get_annotations', array('guid' => $question->guid, 'annotation_name' => 'response', 'limit' => 0));
		$count_values = array();
		$responders_values = array();
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
		$survey_questions .= '<br /><h5>' . elgg_echo('survey:results:question_details:responses') . '</h5>';
		$survey_questions .= '<table style="width:100%;"><thead><tr>
			<th style="width:10%;">' . elgg_echo('survey:results:guid') . '</th>
			<th style="width:20%;">' . elgg_echo('survey:results:name') . '</th>
			<th style="width:50%;">' . elgg_echo('survey:results:value') . '</th>
			<th style="width:20%;">' . elgg_echo('survey:results:moredetails') . '</th>
			</tr></thead><tbody>';
		foreach($responders_values as $user_guid => $values) {
			$ent = get_entity($user_guid);
			$icon = '<img src="' . $ent->getIconURL('tiny') . '" />';
			$user_details = '<strong><a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/user/' . $ent->guid . '" class="">' . elgg_echo('survey:results:user_details') . '</a></strong>';
			$survey_questions .= '<tr>
					<td>' . $ent->guid . '</td>
					<td>' . $icon . ' ' . $ent->name . '</td>
					<td><q>' . implode('</q><q>', $values) . '</q></td>
					<td>' . $user_details . '</td>
				</tr>';
		}
		$survey_questions .= '</tbody></table>';
		
		// Results data table is not displayed as graph+table only by text and longtext
		if (in_array($question->input_type, array('text', 'longtext'))) {
			// Response values stats
			$survey_questions .= '<br /><h5>' . elgg_echo('survey:results:question_details:values') . '</h5>';
			$survey_questions .= '<table style="width:100%;"><thead><tr>
				<th style="width:80%;">' . elgg_echo('survey:results:value') . '</th>
				<th style="width:80%;">' . elgg_echo('survey:results:count') . '</th>
				</tr></thead><tbody>';
			//$survey_questions .= '<hr /><pre>' . print_r($count_values, true) . '</pre>';
			foreach($count_values as $hash => $details) {
				$survey_questions .= '<tr><td><q>' . $details['value'] . '</q></td><td style="width:80%; text-align:right;">' . $details['count'] . '</td></tr>';
			}
			$survey_questions .= '</tbody></table>';
		}
		break;
	
	
	// Display stats and data for all survey
	default:
		$survey_questions .= '<br /><br /><h3>' . elgg_echo('survey:results:responsesbyquestion') . '</h3>';
		// Get array of possible responses
		$questions = survey_get_question_array($survey);
		// List all questions with some basic stats and responders
		$survey_questions .= '<table style="width:100%;"><thead><tr>
			<th><i class="fa fa-question-circle"></i> ' . elgg_echo('survey:results:question') . '</th>
			<th>' . elgg_echo('survey:results:inputtype') . '</th>
			<th>' . elgg_echo('survey:results:nbresponses') . '</th>
			<th>' . elgg_echo('survey:results:percresponses') . '</th>
			<th><i class="fa fa-eye"></i> ' . elgg_echo('survey:results:moredetails') . '</th>
			</tr></thead><tbody>';
		foreach ($questions as $question) {
			$response_id++;
			$response_count = $survey->getResponseCountForQuestion($question);
			$percentage = 0;
			if ($response_count > 0) { $percentage = round($response_count / $total_responses_count * 100); }
			$question_details = '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/question/' . $question->guid . '">' . elgg_echo('survey:results:question_details') . '</a>';
			
			$survey_questions .= '<tr>';
			$survey_questions .= '<td><strong>' . $question->title . '</strong></td>
				<td>' . elgg_echo('survey:type:' . $question->input_type) . '</td>
				<td style="text-align:right;">' . $response_count . '</td>
				<td>
					<div class="survey-progress"><div class="survey-progress-filled" style="width:' . $percentage . '%"></div></div>
					' . $percentage . '%
				</td>';
			$survey_questions .= '<td><strong>' . $question_details . '</strong></td>';
			$survey_questions .= '</tr>';
		}
		$survey_questions .= '</tbody></table>';
		
		// Add full responders list
		$survey_responders .= '<br /><br /><h3>' . elgg_echo('survey:results:responders') . '</h3>';
		// Build gallery of responders
		if ($responders_guid) {
			$responders = elgg_get_entities(array('guids' => $responders_guid, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => false, 'limit' => $limit, 'offset' => $offset));
			if ($responders) {
				$survey_responders .= '<table style="width:100%;"><thead><tr>
					<th style="width:40%;"><i class="fa fa-user"></i> ' . elgg_echo('survey:results:users') . '</th>
					<th><i class="fa fa-eye"></i> ' . elgg_echo('survey:results:moredetails') . '</th>
					</tr></thead><tbody>';
				foreach($responders as $ent) {
					//$icon = elgg_view_entity_icon($ent, 'tiny');
					$icon = '<img src="' . $ent->getIconURL('tiny') . '" style="float:left; margin-right:1ex;" />';
					$survey_responders .= '<tr><td>' . $icon . $ent->name . '</td><td>' . '<strong><a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/user/' . $ent->guid . '" class="">' . elgg_echo('survey:results:user_details') . '</a></strong></td></tr>';
				}
				$survey_responders .= '</tbody></table>';
			}
		}
		
}



// Compose final results content
echo '<div id="survey-results" class="elgg-output">';
if (elgg_get_plugin_setting('results_export', 'survey') == 'yes') {
	echo '<p><a href="' . elgg_get_site_url() . 'survey/export/' . $survey->guid . '" class="elgg-button elgg-button-action survey-results-export">' . elgg_echo('survey:results:export') . '</a></p>';
}
echo '<div id="survey-results-stats">' . $survey_stats . '</div>';
echo '<div id="survey-results-questions">' . $survey_questions . '</div>';
if ($survey_responders) { echo '<div id="survey-results-users">' . $survey_responders . '</div>'; }
echo '</div>';


