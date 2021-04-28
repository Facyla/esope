<?php
/**
 * Elgg Group Polls post widget view
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

// get the num of surveys the user want to display
$limit = (int) $widget->limit;
// if no number has been set, default to 5
if($limit < 1) {
	$limit = 5;
}

// the page owner
$options = array(
	'type' => 'object',
	'subtype'=>'survey',
	'container_guid' => $widget->getOwnerGUID(),
	'limit' => $limit,
);

if ($surveys = elgg_get_entities($options)) {
	foreach($surveys as $survey) {
		echo elgg_view("survey/widget", array('entity' => $survey));
	}
} else {
	echo "<p>" . elgg_echo("survey:widget:nonefound") . "</p>";	
}
echo elgg_view('output/url', array(
	'href' => "survey/add/" . $widget->getOwnerGUID(),
	'text' => elgg_echo('survey:addpost'),
	'is_trusted' => true
));
