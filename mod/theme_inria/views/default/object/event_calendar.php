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

$page_owner = elgg_get_page_owner_entity();


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
	$time_bit = '<span class="elgg-event-timestamp">' . $time_bit . '</span>';
	//$icon = '<img src="'.elgg_view("icon/object/event_calendar/small").'" />';
	$month = date('n', $event->start_date);
	$month_translate = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
	//monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
	$month = $month_translate[(int)$month-1];
	$day = date('d', $event->start_date);
	$year = date('Y', $event->start_date);
	$icon = '<p class="date">' . $month . ' <span>' . $day . '</span> ' . $year . '</p>';
	$extras = array();
	//$extras = array($time_bit);
	if ($event_calendar_venue_view = elgg_get_plugin_setting('venue_view', 'event_calendar') == 'yes') { $extras[] = '<span class="elgg-event-location">' . $event->venue . '</span>'; }
	if ($event->description) { $extras[] = $event->description; }
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
	
	
	$content = '';
	if (elgg_instanceof($page_owner, 'group') && elgg_in_context('workspace')) {
		$link_title = $event->title. ' : ' . $day . ' ' . $month . ' ' . $year;
		//$icon = '<p class="date">' . $month . ' <span>' . $day . '</span> ' . $year . '</p>';
		$icon = '<a href="' . $event->getURL() . '"><div class="date-in-month" title="' . $link_title . '">' . $day . '</div></a>';

		// Add to my calendar link ?  (will be very small, is that useful ?)
		if (elgg_is_logged_in()) {
			$calendar_status = event_calendar_personal_can_manage($event, $ownguid);
			if ($calendar_status == 'open') {
				if (event_calendar_has_personal_event($event->guid, $ownguid)) {
					$icon .= elgg_view('output/url', array(
						'text' => '<i class="fa fa-minus-circle"></i>', //elgg_echo('event_calendar:remove_from_the_calendar_menu_text'),
						'title' => elgg_echo('event_calendar:remove_from_my_calendar'),
						'href' => elgg_add_action_tokens_to_url("action/event_calendar/remove_personal?guid={$event->guid}"),
						'class' => 'calendar-action',
					));
				} else {
					if (!event_calendar_is_full($event->guid) && !event_calendar_has_collision($event->guid, $ownguid)) {
						$icon .= elgg_view('output/url', array(
							'text' => '<i class="fa fa-plus-circle"></i>', //elgg_echo('event_calendar:add_to_the_calendar_menu_text'),
							'title' => elgg_echo('event_calendar:add_to_my_calendar'),
							'href' => elgg_add_action_tokens_to_url("action/event_calendar/add_personal?guid={$event->guid}"),
						'class' => 'calendar-action',
						));
					}
				}
			} else if ($calendar_status == 'closed') {
				if (!event_calendar_has_personal_event($event->guid, $ownguid) && !check_entity_relationship($ownguid, 'event_calendar_request', $event->guid)) {
					$icon .= elgg_view('output/url', array(
						'text' => '<i class="fa fa-plus-circle"></i>', //elgg_echo('event_calendar:make_request_title'),
						'title' => elgg_echo('event_calendar:make_request_title'),
						'href' => elgg_add_action_tokens_to_url("action/event_calendar/request_personal_calendar?guid={$event->guid}"),
						'class' => 'calendar-action',
					));
				}
			}
		}
		$content = elgg_view_image_block($icon, $time_bit, array('class' => 'event_calendar-date'));
		$content .= $info . $tags;
	} else {
		$content .= $time_bit . $info . $tags;
	}
	
}


echo elgg_view('page/components/iris_object', $vars + array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt));

