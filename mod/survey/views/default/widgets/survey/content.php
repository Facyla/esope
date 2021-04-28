<?php
/**
 * Elgg survey plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

elgg_load_library('elgg:survey');

$widget = elgg_extract("entity", $vars);

// get the num of surveys the user want to display
$limit = (int) $widget->limit;
// if no number has been set, default to 4
if($limit < 1) {
	$limit = 4;
}

// the page owner
$owner = $widget->getOwnerEntity();

$options = array(
	'type' => 'object',
	'subtype' => 'survey',
	'container_guid' => $owner->getGUID(),
	'limit' => $limit
);

echo '<h3 class="survey_widget-title">' . elgg_echo('survey:widget:think', array($owner->name)) . "</h3>";

if ($surveys = elgg_get_entities($options)){
	foreach($surveys as $surveypost) {
		echo elgg_view("survey/widget", array('entity' => $surveypost));
	}
	$more_link = elgg_view('output/url', array(
		'href' => "/survey/owner/{$owner->username}/all",
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo "<p>" . elgg_echo('survey:widget:no_survey', array($owner->name)) . "</p>";
}
