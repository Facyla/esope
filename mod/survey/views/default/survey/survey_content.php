<?php
// View is used both by entity, and widget

$survey = elgg_extract('entity', $vars);
$nowrapper = elgg_extract('nowrapper', $vars, false);

elgg_load_library('elgg:survey');

// Set defaults, override if logged in
$can_respond = false;
$results_display = "block";
$show_text = elgg_echo('survey:show_survey');
$responded_text = elgg_echo('survey:login');
if (elgg_is_logged_in()) {
	$user = elgg_get_logged_in_user_entity();
	$can_respond = !$survey->hasResponded($user);
	//if user has responded, show the results
	if (!$can_respond) {
		$responded_text = elgg_echo("survey:alreadyresponded");
	} else {
		$allow_close_date = elgg_get_plugin_setting('allow_close_date','survey');
		if ($allow_close_date == 'yes' && !$survey->isOpen()) {
			$date_day = date('j', $survey->close_date);
			$date_month = date('m', $survey->close_date);
			$date_year = date('Y', $survey->close_date);
			$friendly_time = $date_day . '. ' . elgg_echo("survey:month:$date_month") . ' ' . $date_year;
			$responded_text = elgg_echo("survey:voting_ended", array($friendly_time));
			$can_respond = false;
		} else {
			$results_display = "none";
			$show_text = elgg_echo('survey:show_results');
		}
	}
}


// Note : we use nowrapper for callback
if (!$nowrapper) {
	if (!elgg_in_context('widget')) { echo '<div class="clearfloat"></div>'; }
	echo '<div id="survey-container-' . $survey->guid . '" class="survey_post">';
}

if ($msg = elgg_extract('msg', $vars)) { echo '<blockquote class="survey-message">'.$msg.'</blockquote>'; }
?>

<div id="survey-post-body-<?php echo $survey->guid; ?>" class="survey_post_body" style="display:<?php echo $results_display ?>;">
	<?php
	if (!$can_respond) { echo '<blockquote class="survey-responded">'.$responded_text.'</blockquote>'; }
	echo elgg_view('survey/survey_results', array('entity' => $survey));
	?>
</div>

<?php
if ($can_respond) {
	echo elgg_view_form('survey/response', array('id' => "survey-response-form-{$survey->guid}"), array('entity' => $survey, 'callback' => 1));
	$toggle = elgg_view('output/url', array(
			'href' => '', 'text' => $show_text,
			'data-guid' => $survey->guid,
			'class' => 'survey-show-link',
		));
	echo "<p class=\"center\">$toggle</p>";
}

// Note : we use nowrapper for callback
if (!$nowrapper && !elgg_in_context('widget')) { echo '</div>'; }


