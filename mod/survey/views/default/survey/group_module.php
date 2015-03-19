<?php
/**
 * Group survey view
 *
 * @package Elggsurvey_extended
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author John Mellberg <big_lizard_clyde@hotmail.com>
 * @copyright John Mellberg - 2009
 *
 */

elgg_load_library('elgg:survey');
elgg_load_js('elgg.survey.survey');
//elgg_require_js('elgg/survey/survey'); // Elgg 1.10

$group = elgg_get_page_owner_entity();

if (survey_activated_for_group($group)) {
	
	// Check if there is any valid open survey to be displayed in this group
	$active_only = false;
	if (elgg_get_plugin_setting('show_active_only', 'survey') == 'yes') {
		$active_only = true;
		// Find and sort all group surveys
		$options = array('type' => 'object', 'subtype'=>'survey', 'limit' => 0, 'container_guid' => elgg_get_page_owner_guid());
		if ($all_surveys = elgg_get_entities($options)) {
			foreach ($all_surveys as $survey) {
				if ($survey->isOpen()) {
					$open_surveys[$survey->guid] = $survey;
				} else {
					$closed_surveys[$survey->guid] = $survey;
				}
			}
		}
		// Quit now if none open survey found
		if (empty($open_surveys)) { return; };
	}
	
	elgg_push_context('widgets');
	$all_link = elgg_view('output/url', array(
		'href' => "survey/group/$group->guid/all",
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true
	));
	$new_link = elgg_view('output/url', array(
		'href' => "survey/add/$group->guid",
		'text' => elgg_echo('survey:addpost'),
		'is_trusted' => true
	));
	
	
	$content = '';
	if ($active_only) {
		// Do not get them twice...
		$survey_found = array_slice($all_surveys, 0, 4);
	} else {
		$options = array('type' => 'object', 'subtype'=>'survey', 'limit' => 4, 'container_guid' => elgg_get_page_owner_guid());
		$survey_found = elgg_get_entities($options);
	}
	if ($survey_found) {
		foreach ($survey_found as $survey) {
			$content .= elgg_view('survey/widget', array('entity' => $survey));
		}
	}
	elgg_pop_context();
	
	// No content : say it
	if (!$content) {
		$content = '<p>'.elgg_echo("group:survey:empty").'</p>';
	}
	
	echo elgg_view('groups/profile/module', array(
		'title' => elgg_echo('survey:group_survey'),
		'content' => $content,
		'all_link' => $all_link,
		'add_link' => $new_link,
	));
}
