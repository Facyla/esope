<?php
//require_once(dirname(dirname(dirname(__FILE__))) . '/vendors/iCalcreator.class.php' );  // iCal class library

/* Get the plugin settings */
// Titre par défaut peut être défini via le fichier de langues
$title = elgg_get_plugin_setting('calendartitle', 'ical_viewer');
if (empty($title)) $title = elgg_echo('ical_viewer:title');

// Main calendar URL
$url = elgg_get_plugin_setting('defaulturl', 'ical_viewer');

// How many events should be displayed
$num_items = elgg_get_plugin_setting('num_items', 'ical_viewer');

// Timeframe for valid events
$timeframe_before = elgg_get_plugin_setting('timeframe_before', 'ical_viewer');
if (!isset($timeframe_before)) { $timeframe_before = 7; }
$timeframe_after = elgg_get_plugin_setting('timeframe_after', 'ical_viewer');
if (!isset($timeframe_after)) { $timeframe_after = 366; }

$entity = array(
		'calendar_url' => "$url",
		'title' => "$title",
		'timeframe_before' => $timeframe_before,
		'timeframe_after' => $timeframe_after,
		'num_items' => $num_items,
	);
$content = elgg_view('ical_viewer/read', array('entity' => $entity, 'full_view' => true) );


// Setup page
$body = elgg_view_layout('one_sidebar', array(
	'filter_context' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => '',
	'class' => 'calendar',
));

// Display page
echo elgg_view_page($title, $body);

