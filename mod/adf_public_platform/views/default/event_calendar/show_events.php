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

$page_url = full_url();
$page_url = explode($vars['start_date'], $page_url);
$start_date = $vars['start_date'];
$start_date = explode('-', $start_date);
$prev_start_date = ($start_date[0]-1) .'-'. (string)$start_date[1] .'-'. (string)$start_date[2];
$prev_startdate = (string)$start_date[2] .'/'. (string)$start_date[1] .'/'. ($start_date[0]-1);
$next_start_date = ($start_date[0]+1) .'-'. (string)$start_date[1] .'-'. (string)$start_date[2];
$next_startdate = (string)$start_date[2] .'/'. (string)$start_date[1] .'/'. ($start_date[0]+1);
$calendar_nav = '<a href="' . $page_url[0] . $prev_start_date . $page_url[1] . '">&laquo;&nbsp;A partir du '.$prev_startdate.'</a>';
$calendar_nav .= '<a href="' . $page_url[0] . $next_start_date . $page_url[1] . '" style="float:right;">A partir du '.$next_startdate.'&nbsp;&raquo;</a>';
$calendar_nav = '<div class="calendar-navigation">' . $calendar_nav . '</div>';

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
  echo $calendar_nav;
	echo $event_list;
	// Pas très clean mais ça évite de réécrire tous les models du plugin event_calendar
	// Choix car ce plugin est susceptible d'être mis à jour régulièrement
  //elgg_extend_view('page/elements/sidebar', 'event_calendar/calendar', 600);
} else {
  ?>
  <div style="width:100%">
    <?php echo $calendar_nav; ?>
    <div id="event_list" style="float:left;">
      <?php echo $event_list; ?>
    </div>
    <div style="float:right;">
      <?php echo elgg_view('event_calendar/calendar',$vars); ?>
    </div>
  </div>
  <?php
}

