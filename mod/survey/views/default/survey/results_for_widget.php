<?php
/**
 * Survey result view
 */

$survey = elgg_extract('entity', $vars);

// Get array of possible responses
$choices = survey_get_choice_array($survey);

$total = $survey->getResponseCount();

$allow_open_survey = elgg_get_plugin_setting('allow_open_survey', 'survey');
if ($allow_open_survey) {
	$open_survey = ($survey->open_survey == 1);
} else {
	$open_survey = false;
}

$response_id = 0;

foreach ($choices as $choice) {
	$response_count = $survey->getResponseCountForChoice((string)$choice);

	$response_label = elgg_echo ('survey:result:label', array($choice, $response_count));

	$responded_users = '';

	// Show members if this survey is an open survey or if an admin is logged in
	// (in the latter case open surveys must be enabled in plugin settings)
	if ($open_survey || ($allow_open_survey && elgg_is_admin_logged_in())) {
		$response_id++;

		// TODO Would it be possible to use elgg_list_annotations() with
		// custom view that displays only annotation owner icons?
		$response_annotations = elgg_get_annotations(array(
			'guid' => $survey->guid,
			'annotation_name' => 'response',
			'annotation_value' => $choice,
		));

		$user_guids = array();
		foreach ($response_annotations as $ur) {
			$user_guids[] = $ur->owner_guid;
		}

		if ($user_guids) {
			// Gallery of responders
			$responded_users = elgg_list_entities(array(
				'guids' => $user_guids,
				'pagination' => false,
				'list_type' => 'users',
				'size' => 'tiny',
			));
		}

		// Display as link that toggles the user icon gallery
		$response_label = elgg_view('output/url', array(
			'text' => $response_label,
			'href' => "#survey-users-response-{$response_id}",
			'rel' => 'toggle',
		));

		// Hide responder list of closed survey by default (admins can toggle it)
		$hidden = $open_survey ? '' : 'hidden';
	}

	$response_title = elgg_echo("survey:show_responders");

	if ($response_count == 0) {
		$percentage = 0;
	} else {
		$percentage = round($response_count / $total * 100);
	}

	echo <<<HTML
	<div class="survey-result">
		<label title="$response_title">$response_label</label>
		<div class="survey-progress">
			<div class="survey-progress-filled" style="width: {$percentage}%"></div>
		</div>
		<div $hidden id=survey-users-response-{$response_id}>$responded_users</div>
	</div>
HTML;
}

?>

<p><?php echo elgg_echo('survey:totalresponses', array($total)); ?></p>
