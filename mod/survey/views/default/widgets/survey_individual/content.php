<?php
/**
 * Individual featured survey view
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 */

elgg_load_library('elgg:survey');

$widget = elgg_extract("entity", $vars);

$options = array(
	'type' => 'object',
	'subtype' => 'survey',
	'metadata_name_value_pairs' => array(array('name' => 'front_page','value' => 1)),
	'limit' => 1
);

if($survey_found = elgg_get_entities($options)){
	$body = elgg_view('survey/survey_widget', array('entity' => $survey_found[0]));
} else {
	$body = elgg_echo('survey:widget:nonefound');
}

echo $body;
