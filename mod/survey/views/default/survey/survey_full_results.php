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
		break;
		
	case 'question':
		// Detailed data for a specific question
		$question = $filter_entity;
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
		// Values
		$response_values = $survey->getValuesForQuestion($question);
		if ($response_values) { $responded_values = implode('<hr />', $response_values); }
		$percentage = 0;
		if ($response_count > 0) { $percentage = round($response_count / $total * 100); }

		echo <<<HTML
		<div class="survey-result">
			<label title="$response_title">$response_label</label>
			<div class="survey-progress">
				<div class="survey-progress-filled" style="width: {$percentage}%"></div>
			</div>
			<div id=survey-users-response-{$response_id}>$responded_users</div>
			<div id=survey-values-response-{$response_id}>$responded_values</div>
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

			echo <<<HTML
			<div class="survey-result">
				<label title="$response_title">$response_label</label>
				<div class="survey-progress">
					<div class="survey-progress-filled" style="width: {$percentage}%"></div>
				</div>
				<div id=survey-users-response-{$response_id}>$responded_users</div>
				<div id=survey-values-response-{$response_id}>$responded_values</div>
			</div>
HTML;
		}
		
}


?>

<p><strong><?php echo elgg_echo('survey:totalresponses', array($total)); ?></strong></p>

