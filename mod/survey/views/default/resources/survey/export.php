<?php
/**
 * Main survey page
 */

elgg_gatekeeper();

$url = elgg_get_site_url();

// Main panel
$content = '';
//$content .= elgg_echo('basket:description');
//elgg_register_title_button('basket', 'add', 'object', 'basket');


$guid = get_input('guid');
$display = get_input('display');

/* Export survey data as CSV
 * Header : - | Q1  | Q2  | Q3  | etc.
 * Rows : Responder | R1  | R2  | R3  | etc.
 */
$user = elgg_get_logged_in_user_entity();

$survey = get_entity($guid);
if (!$survey instanceof ElggSurvey) {
	elgg_echo('survey:invalid');
	forward(REFERER);
}

// Access control
if (!$survey->canEdit($user) && !elgg_is_admin_logged_in()) {
	elgg_echo('survey:no_access');
	forward(REFERER);
}

// CSV EXPORT
set_time_limit(0);
$ia = elgg_set_ignore_access(true);
$filename = 'survey_' . $survey->guid . '_' . date('Y-m-d-H-i-s') . '.csv';
$delimiter = ";";

// Send file using headers for download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
// output up to 5MB is kept in memory, if it becomes bigger it will automatically be written to a temporary file
//$output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

// Add Headings : Question titles
$questions = $survey->getQuestionsArray();
$headings[] = elgg_echo('survey:results:name');
$i = 0;
foreach ($questions as $question) {
	$i++;
	$headings[] = $i . " " . $question->title;
}
fputcsv($output, $headings, $delimiter);

// Output the CSV responses row for each responder
$responders_guid = $survey->getResponders();
foreach ($responders_guid as $guid) {
	if ($user = get_entity($guid)) {
		$row_array = array("{$user->name} ({$user->guid})");
		foreach ($questions as $i => $question) {
			$values = [];
			$responses = elgg_get_annotations(array('guid' => $question->guid, 'annotation_owner_guids' => $user->guid, 'annotation_name' => 'response', 'limit' => 0));
			foreach($responses as $response) { $values[] = $response->value; }
			$row_array[] = implode("\n", $values);
		}
		fputcsv($output, $row_array, $delimiter);
	} else {
		fputcsv($output, array('Error'), $delimiter);
	}
}

elgg_set_ignore_access($ia);

// Return actual file
exit;


// Alternatively display content in regular page
/*
if ($display == 'yes') {
	echo elgg_view_page($title, [
		'title' => elgg_echo('survey:export'),
		'content' =>  $content,
		'sidebar' => $sidebar,
		'sidebar_alt' => $sidebar_alt,
		'class' => 'elgg-survey-layout',
	]);
}
*/


