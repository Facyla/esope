<?php
/**
 * Elgg survey plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

$survey = $vars['entity'];

$owner = $survey->getOwnerEntity();
$friendlytime = elgg_get_friendly_time($survey->time_created);
$owner_link = elgg_view('output/url', array(
				'href' => "survey/owner/$owner->username",
				'text' => $owner->name,
				'is_trusted' => true,
	));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $survey->tags));

$responses = $survey->countAnnotations('response');

$allow_close_date = elgg_get_plugin_setting('allow_close_date','survey');
if (($allow_close_date == 'yes') && (isset($survey->close_date))) {
	$show_close_date = true;
	$date_day = gmdate('j', $survey->close_date);
	$date_month = gmdate('m', $survey->close_date);
	$date_year = gmdate('Y', $survey->close_date);
	$friendly_time = $date_day . '. ' . elgg_echo("survey:month:$date_month") . ' ' . $date_year;

	$survey_state = $survey->isOpen() ? 'open' : 'closed';

	$closing_date = "<div class='survey_closing-date-{$survey_state}'><b>" . elgg_echo('survey:survey_closing_date', array($friendly_time)) . '</b></div>';
}

// TODO: support comments off
// The "on" status changes for comments, so best to check for !Off
$comments_link = '';
if ($survey->comments_on == 'yes') {
	$comments_count = $survey->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $survey->getURL() . '#survey-comments',
			'text' => $text,
			'is_trusted' => true
		));
	}
}

/*
$icon = '<img src="'.elgg_get_site_url().'mod/survey/graphics/survey.png" />';
$owner = $survey->getOwnerEntity();
//$icon = '<img src="'.elgg_get_site_url().'mod/survey/graphics/survey.png" />';
$icon = elgg_view_entity_icon($owner, 'tiny');
*/

$info = "<h4><a href=\"{$survey->getURL()}\">{$survey->title}</a></h4>";
if ($responses == 1) {
	$noun = elgg_echo('survey:noun_response');
} else {
	$noun = elgg_echo('survey:noun_responses');
}
$info .= "$closing_date";
$info .= "$responses $noun<br>";
$info .= "<div class=\"elgg-subtext\">{$author_text} {$friendlytime} {$comments_link}</div>";
$info .= $tags;

// Bouton de réponse si en cours et pas déjà répondu
if ($survey->isOpen() && !$survey->hasResponded()) {
	$info .= '<a href="' . $survey->getURL() . '" class="elgg-button elgg-button-action">' . elgg_echo('survey:respond') . '</a>';
}

echo elgg_view_image_block($icon, $info);
//echo $info;

