<?php
/**
 * Elgg show events view
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008-12
 * @link http://radagast.biz/
 * 
 */

$listing_format = $vars['listing_format'];

if ($vars['events']) {
	if ($listing_format == 'agenda') {
		$event_list = elgg_view('event_calendar/agenda_view',$vars);
	} else if ($listing_format == 'paged') {
		$event_list = elgg_view('event_calendar/paged_view',$vars);
	} else if ($listing_format == 'full') {
		$event_list = elgg_view('event_calendar/full_calendar_view',$vars);
	} else {
		$options = array(
			'list_class' => 'elgg-list-entity',
			'full_view' => FALSE,
			'pagination' => TRUE,
			'list_type' => 'listing',
			'list_type_toggle' => FALSE,
			'offset' => $vars['offset'],
			'limit' => $vars['limit'],
		);
		$event_list = elgg_view_entity_list($vars['events'], $options);
	}
} else {
	$event_list = '<p>'.elgg_echo('event_calendar:no_events_found').'</p>';
}
if ($listing_format == 'paged' || $listing_format == 'full') {
	echo $event_list;
} else {
	// Facyla : we need to pass the useful vars to the view before calling it
	$event_calendar_vars = array(
		'original_start_date' => $vars['original_start_date'],
		'start_date'	=> $vars['start_date'],
		'end_date'		=> $vars['end_date'],
		'first_date'	=> $vars['event_calendar_first_date'],
		'last_date'		=> $vars['event_calendar_last_date'],
		'mode'			=> $vars['mode'],
		'events'		=> $vars['events'],
		'count'			=> $vars['count'],
		'offset'		=> $vars['offset'],
		'limit'			=> $vars['limit'],
		'group_guid'	=> $vars['group_guid'],
		'filter'		=> $vars['filter'],
		'region'		=> $vars['region'],
		'listing_format' => $vars['event_calendar_listing_format'],
		);
	set_input('event_calendar_vars', $event_calendar_vars);
	elgg_extend_view('page/elements/sidebar', 'event_calendar/calendar', 600);
  ?>
  <div style="width:100%">
    <div id="event_list" style="">
      <?php echo $event_list; ?>
    </div>
    <?php /* Replaced by extending sidebar with agenda
    <div style="float:right;">
      <?php echo elgg_view('event_calendar/calendar',$vars); ?>
    </div>
    */ ?>
  </div>
  <?php
}
