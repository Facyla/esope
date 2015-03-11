<?php
/**
 * Survey full results view
 * Enable full view, and filtered results : by user or by question
 */


$survey = elgg_extract('entity', $vars);
$filter = elgg_extract('filter', $vars);
$filter_guid = elgg_extract('filter_guid', $vars);
$own = elgg_get_logged_in_user_entity();

$limit = get_input('limit', 100);
$offset = get_input('offset', 0);

elgg_push_breadcrumb($survey->title, $survey->getURL());
elgg_push_breadcrumb(elgg_echo('survey:results'), 'survey/results/' . $survey->guid);

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


// Display some global stats
$survey_stats .= '<ul>';
$survey_stats .= '<li>' . elgg_echo('survey:results:questionscount', array($questions_count)) . '</li>';
$survey_stats .= '<li>' . elgg_echo('survey:results:responderscount', array($total_responses_count)) . '</li>';
// Sondage actif ou non
$survey_state = $survey->isOpen() ? 'open' : 'closed';
$survey_stats .= '<li>' . elgg_echo('survey:results:open', array($survey_state)) . '</li>';
// Date de création
$survey_stats .= '<li>' . elgg_echo('survey:results:created', array(date('d/m/Y', $survey->time_created))) . '</li>';
// Date de dernière MAJ
$survey_stats .= '<li>' . elgg_echo('survey:results:updated', array(date('d/m/Y', $survey->time_updated))) . '</li>';
// Date de clôture
$survey_stats .= '<li>' . elgg_echo('survey:results:closing', array(date('d/m/Y', $survey->close_date))) . '</li>';
// Niveau d'accès
$survey_stats .= '<li>' . elgg_echo('survey:results:access', array(elgg_view('output/access', array('entity' => $survey)))) . '</li>';
// Sondage mis en Une ?
//$survey_stats .= '<li>' . elgg_echo('survey:results:featured', array(date('d/m/Y', $survey->))) . '</li>';
$survey_stats .= '</ul>';

// @TODO diagramme de répartition des réponses

// Check filter validity - forward to results page if error
if ($filter) {
	$filter_entity = get_entity($filter_guid);
	if (($filter == 'user') && !elgg_instanceof($filter_entity, 'user')) {
		register_error(elgg_echo('survey:filter:invalid'));
		forward('survey/results/' . $survey->guid);
	}
	if (($filter == 'question') && !elgg_instanceof($filter_entity, 'object', 'survey_question')) {
		register_error(elgg_echo('survey:filter:invalid'));
		forward('survey/results/' . $survey->guid);
	}
	if (in_array($filter, array('user', 'question'))) {
		//elgg_push_breadcrumb(elgg_echo('survey:results:' . $filter), 'survey/results/' . $survey->guid . '/' . $filter . '/' . $filter_guid);
		elgg_push_breadcrumb(elgg_echo('survey:results:' . $filter));
	}
}

switch($filter) {
	case 'user':
		$user = $filter_entity;
		$survey_questions .= '<br /><br />';
		$survey_questions .= '<h3>' . elgg_echo('survey:results:userdetails', array($user->name)) . '</h3>';
		$icon = elgg_view_entity_icon($user, 'small');
		$text = '<a href="' . $user->getURL() . '" >' . $user->name . '</a> ' . $user->briefdescription;
		$survey_questions .= elgg_view_image_block($icon, $text);
		/*
		$survey_questions .= '<span style="float:right;">' . $icon . '</span>';
		*/
		
		// List data on this survey for a given user
		// Get array of possible responses
		$questions = survey_get_question_array($survey);
		$survey_questions .= '<table style="width:100%;"><thead><tr>
			<th>' . elgg_echo('survey:results:question') . '</th>
			<th>' . elgg_echo('survey:results:inputtype') . '</th>
			<th>' . elgg_echo('survey:results:nbresponses') . '</th>
			<th>' . elgg_echo('survey:results:percresponses') . '</th>
			<th>' . elgg_echo('survey:results:value') . '</th>
			<th>' . elgg_echo('survey:results:moredetails') . '</th>
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
					<td>' . $question->title . '</td>
					<td>' . elgg_echo('survey:type:' . $question->input_type) . '</td>
					<td>' . $response_count . '</td>
					<td>' . $percentage . '% 
						<div class="survey-progress"><div class="survey-progress-filled" style="width:' . $percentage . '%"></div></div>
					</td>
					<td>' . implode('<br />', $responder_values) . '</td>
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
		// Or provide dataviz graph
		$survey_questions .= '<ul>';
		$survey_questions .= '<li>' . elgg_echo('survey:results:inputtype') . '&nbsp;: ' . elgg_echo('survey:type:' . $question->input_type) . '</li>';
		$survey_questions .= '<li>' . elgg_echo('survey:results:question:counts', array($response_count, $total_responses_count, $percentage));
		$survey_questions .= '<div class="survey-progress" style="width:200px; display:inline-block; margin:0 0 0 8px;"><div class="survey-progress-filled" style="width: ' . $percentage . '%"></div></div>';
		$survey_questions .= '</li>';
		$survey_questions .= '</ul>';
		
		$survey_questions .= elgg_view('survey/output/response', array('question' => $question, 'survey' => $survey));
		
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
		
		// Response values stats
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
		break;
	
	
	// Display stats and data for all survey
	default:
		$survey_questions .= '<br /><br /><h3>' . elgg_echo('survey:results:responsesbyquestion') . '</h3>';
		// Get array of possible responses
		$questions = survey_get_question_array($survey);
		// List all questions with some basic stats and responders
		$survey_questions .= '<table style="width:100%;"><thead><tr>
			<th>' . elgg_echo('survey:results:question') . '</th>
			<th>' . elgg_echo('survey:results:inputtype') . '</th>
			<th>' . elgg_echo('survey:results:nbresponses') . '</th>
			<th>' . elgg_echo('survey:results:percresponses') . '</th>
			<th>' . elgg_echo('survey:results:moredetails') . '</th>
			</tr></thead><tbody>';
		foreach ($questions as $question) {
			$response_id++;
			$response_count = $survey->getResponseCountForQuestion($question);
			$percentage = 0;
			if ($response_count > 0) { $percentage = round($response_count / $total_responses_count * 100); }
			$question_details = '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/question/' . $question->guid . '">' . elgg_echo('survey:results:question_details') . '</a>';
			
			$survey_questions .= '<tr>';
			$survey_questions .= '<td>' . $question->title . '</td>
				<td>' . elgg_echo('survey:type:' . $question->input_type) . '</td>
				<td>' . $response_count . '</td>
				<td>' . $percentage . '% 
					<div class="survey-progress"><div class="survey-progress-filled" style="width:' . $percentage . '%"></div></div>
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
			if ($responders) foreach($responders as $ent) {
				//$icon = elgg_view_entity_icon($ent, 'tiny');
				$icon = '<img src="' . $ent->getIconURL('tiny') . '" />';
				$text = $ent->name . ' &nbsp; <strong><a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/user/' . $ent->guid . '" class="">' . elgg_echo('survey:results:user_details') . '</a></strong>';
				$survey_responders .= elgg_view_image_block($icon, $text);
			}
		}
		
}






// Compose final results content
echo '<br />';
echo '<h3>' . elgg_echo('survey:results:stats') . '</h3>';
echo '<div id="survey-results-stats" class="elgg-output">' . $survey_stats . '</div>';
echo '<div id="survey-results-questions">' . $survey_questions . '</div>';
if ($survey_responders) { echo '<div id="survey-results-users">' . $survey_responders . '</div>'; }


