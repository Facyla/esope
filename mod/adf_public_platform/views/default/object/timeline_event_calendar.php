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

$time_bit = event_calendar_get_formatted_time($event);
//$icon = '<img src="'.elgg_view("icon/object/event_calendar/small").'" />';
$month = date('F', $event->start_date);
$day = date('d', $event->start_date);
$year = date('Y', $event->start_date);


echo '<div class="timeline-event"><div class="timeline-event-content"><h3 class="timeline-title"><a href="'.$event->getURL().'">' . $month . ' ' . $day . '</a></h3><div class="timeline-event-description">' . $event->description . '</div></div></div>';


