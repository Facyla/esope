<?php
/**
 * Elgg event_calendar object view
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

// Avoids undefined function errors when from outside event_calendar
elgg_load_library('elgg:event_calendar');

$event = $vars['entity'];


// Listing view
$time_bit = event_calendar_get_formatted_time($event);
//$icon = '<img src="'.elgg_view("icon/object/event_calendar/small").'" />';
$month = date('n', $event->start_date);
$month_translate = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
//monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
$month = $month_translate[(int)$month-1];
$day = date('d', $event->start_date);
$year = date('Y', $event->start_date);
$icon = '<p class="date">' . $month . ' <span>' . $day . '</span> ' . $year . '</p>';
$extras = array($time_bit);
if ($event->description) { $extras[] = $event->description; }

if ($event_calendar_venue_view = elgg_get_plugin_setting('venue_view', 'event_calendar') == 'yes') { $extras[] = $event->venue; }
if ($extras) { $info = "<p>".implode("<br />",$extras)."</p>"; } else { $info = ''; }

$metadata = '';
if (!elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $event,
		'handler' => 'event_calendar',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$tags = elgg_view('output/tags', array('tags' => $event->tags));

$params = array(
	'entity' => $event,
	'metadata' => $metadata,
	'subtitle' => $info,
	'tags' => $tags,
);
$list_body = elgg_view('object/elements/summary', $params);

//echo '<h3><a href="'.$event->getURL().'">' . $event->title . '</a></h3>' . '<br class="clearfloat" />';
echo elgg_view_image_block($icon, $list_body);

