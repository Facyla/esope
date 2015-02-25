<?php
/**
 * Survey full results view
 * Enable full view, and filtered results : by user or by question
 */

$survey = elgg_extract('entity', $vars);
$filter = elgg_extract('filter', $vars);
$filter_guid = elgg_extract('filter_guid', $vars);
$own = elgg_get_logged_in_user_entity();

$total = $survey->getResponseCount();

$all_responders = '';
$response_id = 0;

if ($filter) {
	$filter_entity = get_entity($filter_guid);
	if (($filter == 'user') && !elgg_instanceof($filter_entity, 'user')) {
		echo elgg_echo('survey:filter:invalid');
		return;
	} else if (($filter == 'question') && !elgg_instanceof($filter_entity, 'object', 'survey_question')) {
		echo elgg_echo('survey:filter:invalid');
		return;
	}
}

switch($filter) {
	case 'user':
		$user = $filter_entity;
		// @TODO list data on this survey for a given user
		// Get array of possible responses
		$questions = survey_get_question_array($survey);
		// List all questions with some basic stats and responders
		foreach ($questions as $question) {
			$user_details = '';
			$user_details .= elgg_echo('survey:results:user_details');
			$response_count = $survey->getResponseCountForQuestion($question);
			$response_label = elgg_echo ('survey:result:label', array($question->title, $response_count));
			// Show members if this survey
			$response_id++;
			$percentage = 0;
			if ($response_count > 0) { $percentage = round($response_count / $total * 100); }
			
			//Rresponses for this user
			$responses = new ElggBatch('elgg_get_annotations', array('guid' => $question->guid, 'owner_guid' => $question->getOwnerGUID(), 'annotation_name' => 'response', 'limit' => 0));
			foreach($responses as $response) {
				$user_details .= '<p>' . $response->value . '</p>';
			}
			
			$question_details_link = '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/question/' . $question->guid . '" target="_blank">' . elgg_echo('survey:results:question_details') . '</a>';
			
			echo <<<HTML
			<div class="survey-result">
				<h4 title="$response_title">$response_label</h4>
				<div class="survey-progress">
					<div class="survey-progress-filled" style="width: {$percentage}%"></div>
				</div>
				$user_details
				<p>{$question_details_link}</p>
			</div>
HTML;
		}
		break;
		
	case 'question':
		// Detailed data for a specific question
		$question = $filter_entity;
		$response_count = $survey->getResponseCountForQuestion($question);
		$response_label = elgg_echo ('survey:result:label', array($question->title, $response_count));
		$responded_users = '';
		// Show members if this survey
		$response_id++;
		$responded_users = '<h4>' . elgg_echo('survey:results:users') . '</h4>';
		$user_guids = $survey->getRespondersForQuestion($question);
		if ($user_guids) {
			// Gallery of responders
			$responded_users .= elgg_list_entities(array('guids' => $user_guids, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => false));
		}
		
		// Values
		$responded_values = '<h4>' . elgg_echo('survey:results:values') . '</h4>';
		$response_values = $survey->getValuesForQuestion($question);
		if ($response_values) { $responded_values .= implode('<hr />', $response_values); }
		
		// Percentage bar
		$percentage = 0;
		if ($response_count > 0) { $percentage = round($response_count / $total * 100); }
		
		// Détail des réponses
		/*
		$response_details = '';
		$responses = new ElggBatch('elgg_get_annotations', array('guid' => $question->guid, 'annotation_name' => 'response', 'limit' => 0));
		$response_details .= '<h4>' . elgg_echo('survey:results:question_details:title') . '</h4>';
		foreach($responses as $response) {
			$icon = elgg_view_entity_icon($response->getOwnerEntity(), 'tiny');
			$text = $response->value;
			$response_details .= '<div>';
			$response_details .= elgg_view_image_block($icon, $text);
			$response_details .= '</div>';
		}
		*/
		echo <<<HTML
		<div class="survey-result">
			<label title="$response_title">$response_label</label>
			<div class="survey-progress">
				<div class="survey-progress-filled" style="width: {$percentage}%"></div>
			</div>
			<div id=survey-users-response-{$response_id}>$responded_users</div>
			<div id=survey-values-response-{$response_id}>$responded_values</div>
			<div id=survey-users-values-response-{$response_id}>$response_details</div>
		</div>
HTML;
		break;
		
	default:
		// Get array of possible responses
		$questions = survey_get_question_array($survey);
		// List all questions with some basic stats and responders
		foreach ($questions as $question) {
			$response_count = $survey->getResponseCountForQuestion($question);
			$response_label = elgg_echo ('survey:result:label', array($question->title, $response_count));
			$responded_users = '';
			// Show members if this survey
			$response_id++;
			$user_guids = $survey->getRespondersForQuestion($question);
			if ($user_guids) {
				// Gallery of responders
				$responded_users = elgg_list_entities(array('guids' => $user_guids, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => false));
			}
			$percentage = 0;
			if ($response_count > 0) { $percentage = round($response_count / $total * 100); }
			
			$question_details_link = '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/question/' . $question->guid . '" target="_blank">' . elgg_echo('survey:results:question_details') . '</a>';
			
			echo <<<HTML
			<div class="survey-result">
				<h4 title="$response_title">$response_label</h4>
				<div class="survey-progress">
					<div class="survey-progress-filled" style="width: {$percentage}%"></div>
				</div>
				<div id=survey-users-response-{$response_id}>$responded_users</div>
				<div id=survey-values-response-{$response_id}>$responded_values</div>
				<p>{$question_details_link}</p>
			</div>
HTML;
		}
		
}


// All responders + details link
$user_guids = $survey->getResponders();
if ($user_guids) {
	// Gallery of responders
	$responders = elgg_get_entities(array('guids' => $user_guids, 'list_type' => 'users', 'size' => 'tiny', 'pagination' => false));
}
foreach($responders as $ent) {
	$icon = elgg_view_entity_icon($ent, 'tiny');
	$text = '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '/user/' . $ent->guid . '" target="_blank">' . elgg_echo('survey:results:user_details') . '</a>';
	$all_responders .= '<div>';
	$all_responders .= elgg_view_image_block($icon, $text);
	$all_responders .= '</div>';
}

echo '<p><strong>' . elgg_echo('survey:totalresponses', array($total)) . '</strong></p>';

echo '<div id=survey-values-response-' . $response_id . '>' . $all_responders . '</div>';


