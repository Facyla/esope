<?php
/**
 * Survey result view
 */

$survey = elgg_extract('entity', $vars);

// Get array of possible responses
$questions = survey_get_question_array($survey);

$total = $survey->getResponseCount();

$allow_open_survey = elgg_get_plugin_setting('allow_open_survey', 'survey');
$open_survey = false;
if ($allow_open_survey) { $open_survey = ($survey->open_survey == 1); }

$response_id = 0;

foreach ($questions as $question) {
	$response_count = $survey->getResponseCountForQuestion($question);
	$response_label = elgg_echo ('survey:result:label', array($question->title, $response_count));

	$responded_users = '';

	// Show members if this survey is an open survey or if an admin is logged in
	// (in the latter case open surveys must be enabled in plugin settings)
	if ($open_survey || ($allow_open_survey && elgg_is_admin_logged_in())) {
		$response_id++;
		
		$user_guids = $survey->getRespondersForQuestion($question);
		if ($user_guids) {
			// Gallery of responders
			$responded_users = elgg_list_entities(array(
				'guids' => $user_guids,
				'pagination' => false,
				'list_type' => 'users',
				'size' => 'tiny',
			));
		}
		// Values
		//if ($response_values) { $responded_values = implode('<hr />', $response_values); }

		// Display as link that toggles the user icon gallery
		$response_label = elgg_view('output/url', array('text' => $response_label, 'href' => "#survey-users-response-{$response_id}", 'rel' => 'toggle'));

		// Hide responder list of closed survey by default (admins can toggle it)
		$hidden = $open_survey ? '' : 'hidden';
	}

	$response_title = elgg_echo("survey:show_responders");

	$percentage = 0;
	if ($response_count > 0) { $percentage = round($response_count / $total * 100); }

	echo <<<HTML
	<div class="survey-result">
		<label title="$response_title">$response_label</label>
		<div class="survey-progress">
			<div class="survey-progress-filled" style="width: {$percentage}%"></div>
		</div>
		<div $hidden id="survey-users-response-{$response_id}">$responded_users</div>
		<div $hidden id="survey-values-response-{$response_id}">$responded_values</div>
	</div>
HTML;
}
?>

<p><strong><?php echo elgg_echo('survey:totalresponses', array($total)); ?></strong></p>

