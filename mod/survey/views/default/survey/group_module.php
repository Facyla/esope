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

	$options = array('type' => 'object', 'subtype'=>'survey', 'limit' => 4, 'container_guid' => elgg_get_page_owner_guid());
	$content = '';
	if ($survey_found = elgg_get_entities($options)) {
		foreach ($survey_found as $survey) {
			$content .= elgg_view('survey/widget', array('entity' => $survey));
		}
	}
	elgg_pop_context();
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
