<?php
/**
 * Elgg Poll post widget view
 *
 * @package Elggsurvey
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg
 * @copyright John Mellberg 2009
 *
 * @uses $vars['entity'] Optionally, the survey post to view
 */

elgg_load_library('elgg:survey');

$widget = elgg_extract("entity", $vars);

// get the num of surveys to display
$limit = (int) $widget->limit;
// if no number has been set, default to 5
if($limit < 1) {
	$limit = 5;
}

$options = array(
	'type' => 'object',
	'subtype'=>'survey',
	'limit' => $limit,
);

if ($surveys = elgg_get_entities($options)) {
	foreach($surveys as $survey) {
		echo elgg_view("survey/widget", array('entity' => $survey));
	}
} else {
	echo "<p>" . elgg_echo("survey:widget:nonefound") . "</p>";
}
