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

//$own = elgg_get_logged_in_user_entity();
$ownguid = elgg_get_logged_in_user_guid();

// Listing view
$time_bit = event_calendar_get_formatted_time($event);
//$icon = '<img src="'.elgg_view("icon/object/event_calendar/small").'" />';
$month = date('n', $event->start_date);
$month_translate = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
//monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
$month = $month_translate[(int)$month-1];
$day = date('d', $event->start_date);
$year = date('Y', $event->start_date);

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


/*
$extras = array($time_bit);
if ($event->description) { $extras[] = $event->description; }
if ($event_calendar_venue_view = elgg_get_plugin_setting('venue_view', 'event_calendar') == 'yes') { $extras[] = $event->venue; }
if ($extras) { $info = "<p>".implode("<br />",$extras)."</p>"; } else { $info = ''; }

$tags = elgg_view('output/tags', array('tags' => $event->tags));

$params = array(
	'entity' => $event,
	'metadata' => false,
	'title' => $event->title,
	'subtitle' => $time_bit,
	'tags' => $tags,
);
$list_body = elgg_view('object/elements/summary', $params);
*/

$list_body = '<h4><a href="' . $event->getURL() . '" title="' . $link_title . '">' . $event->title . '</a></h4>';
$list_body .= '<span class="elgg-river-timestamp">' . $time_bit . '</span>';


//echo '<h3><a href="'.$event->getURL().'">' . $event->title . '</a></h3>' . '<br class="clearfloat" />';
echo elgg_view_image_block($icon, $list_body);

