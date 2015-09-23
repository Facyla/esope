<?php

if (elgg_is_active_plugin('event_calendar')) {
	elgg_load_library('elgg:event_calendar');
	elgg_push_context('widgets');
	$start_ts = time() - 24*3600; // Starting date D-1
	$end_ts = $start_ts + 366*24*3600; // End date D+1 year
	$count_recent_events = event_calendar_get_events_between($start_ts,$end_ts,true,0,0,0,false);
	$recent_events = event_calendar_get_events_between($start_ts,$end_ts,false,$count_recent_events,0,0,false);
	// Tri des events "atelier" et du reste de l'agenda
	$atelier_events = array();
	$agenda_events = array();
	if ($recent_events) foreach ($recent_events as $ent) {
		if (in_array('atelier', $ent->tags) || ($ent->tags == 'atelier')) { $atelier_events[] = $ent; } else $agenda_events[] = $ent;
	}
	// Timeline = 5 derniers events taggués "atelier"
	$atelier_events = array_slice($atelier_events, 0, 5);
	$ateliers .= '<div class="home-events-ateliers">';
	foreach ($atelier_events as $ent) {
		$ateliers .= elgg_view_entity($ent, array('full_view' => false));
	}
	$ateliers .= '</div>';
	$ateliers .= '<div class="clearfloat"></div>';
	elgg_pop_context();
	if (elgg_is_admin_logged_in()) {
		$ateliers .= '<p><a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'event_calendar/add?tags=atelier"><i class="fa fa-gears"></i>' . elgg_echo('theme_afparh:atelier:add') . '</a><br /><em>' . elgg_echo('theme_afparh:atelier:add:details') . '</em></p>';
	}
	echo $ateliers;
}

