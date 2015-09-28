<?php

if (elgg_is_active_plugin('event_calendar')) {
	elgg_load_library('elgg:event_calendar');
	elgg_push_context('widgets');
	$start_ts = time() - 24*3600; // Starting date D-1
	$end_ts = $start_ts + 366*24*3600; // End date D+1 year
	$count_recent_events = event_calendar_get_events_between($start_ts,$end_ts,true,0,0,0,false);
	$recent_events = event_calendar_get_events_between($start_ts,$end_ts,false,$count_recent_events,0,0,false);
	// Tri des events "rencontre" et du reste de l'agenda
	$atelier_events = array();
	$agenda_events = array();
	if ($recent_events) foreach ($recent_events as $ent) {
		if (in_array('rencontre', $ent->tags) || ($ent->tags == 'rencontre')) { $atelier_events[] = $ent; } else $agenda_events[] = $ent;
	}
	// Timeline = 5 derniers events taggués "atelier"
	$atelier_events = array_slice($atelier_events, 0, 3);
	$ateliers .= '<div class="home-events-ateliers">';
	foreach ($atelier_events as $ent) {
		$ateliers .= elgg_view_entity($ent, array('full_view' => false));
	}
	$ateliers .= '</div>';
	elgg_pop_context();
	// @TODO : lien direct que pour admin ET référents des groupes (de formation)
	$special_groups_guids = elgg_get_plugin_setting('special_groups');
	$special_groups_guids = esope_get_input_array($special_groups_guids);
	$is_learning_group_admin = false;
	foreach($special_groups_guids as $group_guid) {
		if ($group = get_entity($group_guid)) {
			if ($group->canEdit()) $is_learning_group_admin = true;
		}
	}
	
	if (elgg_is_admin_logged_in() || $is_learning_group_admin) {
		$ateliers .= '<p><a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'event_calendar/add?tags=rencontre"><i class="fa fa-gears"></i>' . elgg_echo('theme_propage_paca:atelier:add') . '</a><br /><em>' . elgg_echo('theme_propage_paca:atelier:add:details') . '</em></p>';
	}
	echo $ateliers;
	echo '<p><a href="' . elgg_get_site_url() . 'search?q=rencontre&entity_subtype=event_calendar&entity_type=object&search_type=entities"><i class="fa fa-search-plus"></i>&nbsp;' . elgg_echo('theme_propage_paca:view:more') . '</a></p>';
	echo '<div class="clearfloat"></div>';
}


