<?php

/**
 * Elgg event_calendar group profile content
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

elgg_load_library('elgg:event_calendar');

$page_owner_entity = elgg_get_page_owner_entity();

//if (event_calendar_activated_for_group($page_owner_entity) && ($page_owner_entity->isMember() || $page_owner_entity->canEdit())) {
if (event_calendar_activated_for_group($page_owner_entity)) {
	$num = 4;
	// Get the upcoming events
	$start_date = time(); // now
	$end_date = $start_date + 60*60*24*365*2; // maximum is two years from now
	//$ia = elgg_set_ignore_access(true);
	// @TODO "fatal error" lié à un pb avec accès si pas admin - cependant pas de risque car les objets non visibles ne seront pas affichés
	$events = event_calendar_get_events_between($start_date, $end_date, false, $num, 0, $page_owner_entity->guid);
	elgg_set_ignore_access($ia);

	// If there are any events to view, view them
	if (is_array($events) && sizeof($events) > 0) {
		foreach($events as $event) {
			echo elgg_view("object/event_calendar_workspace", array('entity' => $event['event']));
		}
	}
}
