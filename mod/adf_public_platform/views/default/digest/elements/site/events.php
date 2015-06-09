<?php
$news_group = get_entity(152);

/**
* Shows the latests blogs in the Digest
*
*/

$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

if (elgg_is_active_plugin('event_calendar')) {
	$title = elgg_echo('adf_platform:event_calendar');
	elgg_load_library('elgg:event_calendar');
	elgg_push_context('widgets');
	$start_ts = time() - 24*3600; // Starting date
	$end_ts = $start_ts + 3*366*24*3600; // End date
	$events_limit = 3;
	$events = event_calendar_get_events_between($start_ts,$end_ts,false,$events_limit,0);
	
	if ($events) {
		$agenda = '<div class="digest-events">';
		$agenda .= elgg_view_entity_list($events, $events_limit, 0, $events_limit, false, false);
		$agenda .= '</div>';
		
		echo elgg_view_module("digest", $title, $agenda);
		
		// @TODO A intégrer dans une CSS propre
		echo '<style>
.elgg-image .date, .elgg-module-group-event-calendar p.date, .elgg-widget-instance-event_calendar p.date {
	background: none repeat scroll 0 0 #666666;
	color: white;
	font-size: 90%;
	line-height: 130%;
	padding: 1px;
	text-align: center;
	width: 9ex;
}
.elgg-image .date span {
	background: none repeat scroll 0 0 white;
	color: #666666;
	display: block;
	font-size: 2em;
	font-weight: bold;
	padding: 4px 0;
}
.digest-events .elgg-image { float: left; margin-right: 2ex; }
/* Doublon */
.digest-events .entity_title { display: none; }
.digest-events .elgg-tags { list-style-type: none; padding: 0; }
.digest-events .elgg-tags li { display: inline; margin-right: 2ex; }
		</style>';
	}
	
	elgg_pop_context();
}

