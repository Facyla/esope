<?php
/**
 * Main survey page
 */

elgg_require_js('survey/survey');

$url = elgg_get_site_url();

// Main panel
$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');


$guid = get_input('guid');
$survey = get_entity($guid);
if ($survey instanceof ElggSurvey) {
	// Set the page owner
	$page_owner = $survey->getContainerEntity();
	//if ($page_owner instanceof ElggGroup) {
	if ($page_owner->getType() == 'group') {
		elgg_set_page_owner_guid($page_owner->guid);
	} else {
		elgg_set_page_owner_guid(elgg_get_site_entity()->guid);
	}
	
	$title = $survey->title;
	$content .= elgg_view_entity($survey, array('full_view' => true));
	
	//check to see if comments are on
	if ($survey->comments_on == 'yes') {
		$content .= elgg_view_comments($survey);
	}

	//if ($page_owner instanceof ElggGroup) {
	if ($page_owner->getType() == 'group') {
		elgg_push_breadcrumb($page_owner->name, "survey/group/{$page_owner->guid}");
	} else {
		//elgg_push_breadcrumb($page_owner->name, "survey/owner/{$page_owner->username}");
	}
	elgg_push_breadcrumb($survey->title);
	
} else {
	// Display the 'post not found' page instead
	$title = elgg_echo("survey:notfound");
	$content = elgg_view("survey/notfound");
	elgg_push_breadcrumb($title);
}



echo elgg_view_page($title, [
	'title' => $title,
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-survey-layout',
]);

