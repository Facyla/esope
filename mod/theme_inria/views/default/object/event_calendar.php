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
$full = elgg_extract('full_view', $vars, FALSE);


if ($full) {
	// Full view
	$body = elgg_view('event_calendar/strapline',$vars);
	$event_items = event_calendar_get_formatted_full_items($event);
	$body .= '<br />';
	
	foreach($event_items as $item) {
		$value = $item->value;
		if (!empty($value)) {
				
			//This function controls the alternating class
			$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
			$body .= "<p class=\"{$even_odd}\"><b>";
			$body .= $item->title.':</b> ';
			$body .= $item->value;
		}
	}
	$metadata = elgg_view_menu('entity', array(
		'entity' => $event,
		'handler' => 'event_calendar',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	
	$tags = elgg_view('output/tags', array('tags' => $event->tags));
	
	$params = array(
		'entity' => $event,
		'metadata' => $metadata,
		'tags' => $tags,
		'title' => false,
	);
	$list_body = elgg_view('object/elements/summary', $params);
	
	
	$content = '<a class="event-ical-file" href="' . $event->getURL . '?view=ical" title="' . elgg_echo('event_calendar:ical_popup_message') . ' ' . $event->getURL . '?view=ical"><i class="fa fa-calendar-o"></i> ' . elgg_echo('feed:ical') . '</a>';
	//$content .= $list_body;
	$content .= $tags;
	$content .= $body;
	
	if ($event->long_description) {
		$content .= '<p>'.$event->long_description.'</p>';
	} else {
		$content .= '<p>'.$event->description.'</p>';
	}
	
	if (elgg_get_plugin_setting('add_to_group_calendar', 'event_calendar') == 'yes') {
		$content .= elgg_view('event_calendar/forms/add_to_group',array('event' => $event));
	}
	
} else {
	
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
	
	$list_body = elgg_view('object/elements/summary', $params);
	
	
	if (elgg_in_context('workspace')) {
		// Icon = auteur
		$owner = $event->getOwnerEntity();
		$icon = '<a href="' . $owner->getURL() . '" class="elgg-avatar"><img src="' . $owner->getIconURL(array('medium')) . '" style="width:54px;" /></a>';
		$metadata_alt = '';
	}
	
	$content = $info . $tags;
}


echo elgg_view('page/components/iris_object', array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt));
/*
echo elgg_view('page/components/iris_object', array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt, 'mode' => 'listing'));
echo elgg_view('page/components/iris_object', array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt, 'mode' => 'content'));
echo elgg_view('page/components/iris_object', array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt, 'mode' => 'full'));
*/

