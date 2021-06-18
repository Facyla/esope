<?php
use Elgg\EntityPermissionsException;
use Elgg\EntityNotFoundException;

$debug = false;

$group = elgg_get_page_owner_entity();
if (!$group instanceof \ElggGroup) {
	throw new EntityNotFoundException();
}

if (elgg_get_plugin_setting('enable_group_stats', 'advanced_statistics') === 'no') {
	throw new EntityPermissionsException();
}

elgg_push_entity_breadcrumbs($group);

$title = elgg_echo('advanced_statistics:group:title');
$content = '';

// Facyla : add settings and other stats

$date_limited = false; // si true, la vue utilise les ts_*
$ts_lower = get_input('ts_lower');
$ts_upper = get_input('ts_upper');
if (!empty($ts_lower) || !empty($ts_upper)) { $date_limited = true; }
$interval = get_input('interval', 'month'); // year|month
$list_entities = get_input('list_entities', 'no'); // no|yes

// Formulaire séleciton de dates : inutile car aucun effet sur les graphes par défaut...
$content .= '<form method="GET" action="">';
$content .= '<p><label>Intervalle des statistiques ' . elgg_view('input/select', ['name' => 'interval', 'value' => $interval, 'options_values' => ['month' => "Par mois", 'year' => "Par année"]]) . '</label></p>';
/*
$content .= '<label>Entre le ' . elgg_view('input/date', ['name' => 'ts_lower', 'value' => $ts_lower, 'timestamp' => false, 'style' => "max-width: 12rem"]) . '</label>';
$content .= '<label> et le ' . elgg_view('input/date', ['name' => 'ts_upper', 'value' => $ts_upper, 'timestamp' => false, 'style' => "max-width: 12rem"]) . '</label>';
//$content .= '<label>Entre le ' . elgg_view('input/date', ['name' => 'ts_lower', 'value' => $ts_lower, 'timestamp' => true, 'style' => "max-width: 12rem"]) . '</label>';
//$content .= '<label> et le ' . elgg_view('input/date', ['name' => 'ts_upper', 'value' => $ts_upper, 'timestamp' => true, 'style' => "max-width: 12rem"]) . '</label>';
$content .= elgg_view('input/submit', ['value' => "Filtrer sur cette période"]);
*/
$content .= '<p><label>Lister les contenus correspondants ' . elgg_view('input/select', ['name' => 'list_entities', 'value' => $list_entities, 'options_values' => ['no' => "Non (statistiques seules)", 'yes' => "Oui"]]) . '</label></p>';
$content .= '<p>' . elgg_view('input/submit', ['value' => "Rafraîchir"]) . '</p>';
$content .= '</form>';

// Types : pie, bar, date : cf. vues JSON dans advanced_statistics : page/section/chart.php

/* @TODO Besoins : 
 - comment analyser une période précise (1er trimestre 2019).
 - tableau des publications par type et par année dans un groupe (et totaux)
 - tableau du nb de membres du groupe par année
*/
// Par type de contenu
// Par année + Total
// Totaux

// Group tools
$tools = elgg()->group_tools->group($group)
	->filter(function (\Elgg\Groups\Tool $tool) use ($group) {
		return $group->isToolEnabled($tool->name);
	})
	->sort();
$periods = []; // année par année - ou mois par mois sur une année
$time_created_group = $group->time_created;
$i = 0;
while($time_created_group < time()) {
	$i++;
	$start_year = date('Y', $time_created_group);
	$start_month = date('m', $time_created_group);
	$start_day = date('d', $time_created_group);
	if ($debug) $content .= "$start_year/$start_month/$start_day $time_created_group = " . time() . "<br />"; // debug
	if ($i > 100) { break; }
	switch($interval) {
		case 'month':
			$periods[] = [
				'label' => "$start_year/$start_month",
				'start_ts' => mktime(0, 0, 0, (int) $start_month, 1, (int) $start_year),
				'end_ts' =>  mktime(0, 0, 0, (int) $start_month + 1, 1, (int) $start_year) - 1,
			];
			$time_created_group = mktime(0, 0, 0, (int) $start_month + 1, 1, (int) $start_year);
			if ($debug) $content .= date('Y/m/d H:i:s', mktime(0, 0, 0, (int) $start_month, 1, (int) $start_year)) . " à "; // debug
			if ($debug) $content .= date('Y/m/d H:i:s', mktime(0, 0, 0, (int) $start_month + 1, 1, (int) $start_year) - 1) . "<br />"; // debug
			break;
		case 'year':
		default:
			$periods[] = [
				'label' => $start_year,
				'start_ts' => mktime(0, 0, 0, 1, 1, (int) $start_year),
				'end_ts' =>  mktime(0, 0, 0, 1, 1, (int) $start_year + 1) - 1,
			];
			$time_created_group = mktime(0, 0, 0, 1, 1, (int) $start_year + 1);
			if ($debug) $content .= date('Y/m/d H:i:s', mktime(0, 0, 0, 1, 1, $start_year)) . " à "; // debug
			if ($debug) $content .= date('Y/m/d H:i:s', mktime(0, 0, 0, 1, 1, $start_year + 1) - 1) . "<br />"; // debug
	}
	if ($debug) $content .= " => " . date('Y/m/d H:i:s', $time_created_group) . "<br />"; // debug
}

// @TODO : utiliser plutôt cette requête, a priori plus précise 
// (ssi != entre entités actuelles et celles de la river ou pcq plus efficace)
use Elgg\Database\Select;
$qb = Select::fromTable('entities', 'e');
$qb->select('e.subtype as subtype');
$qb->addSelect('count(*) AS total');
$qb->join('e', 'river', 'r', 'e.guid = r.object_guid');
$qb->where("e.type = 'object'");
$qb->andWhere($qb->compare('e.subtype', '=', get_registered_entity_types('object'), ELGG_VALUE_STRING));
$qb->andWhere("e.container_guid = {$group->guid}");
$qb->groupBy('e.subtype');
$qb->orderBy('total', 'desc');
$query_result = $qb->execute()->fetchAll();
$data = [];
//$content .= '<pre>' . print_r($query_result, true) . '</pre>';

elgg_push_context('list');
$t_head = '';
$t_body = '';
$list_body = '';
if ($query_result) {
	// Headers
	$t_head .= '<tr style="border: 1px solid;">';
		$t_head .= '<th style="padding: .25rem .5rem;">' . "Types de contenus" . '</th>';
		foreach($periods as $period) {
			$t_head .= '<th style="border-left: 1px solid; padding: .25rem .5rem;">' . $period['label'] . '</th>';
		}
	$t_head .= '</tr>';
	
	// Body
	foreach ($query_result as $row) {
	//foreach ($tools as $tool) {
		$t_body .= '<tr style="border: 1px solid;">';
			$t_body .= '<th style="padding: .25rem .5rem;">' . elgg_echo("item:object:{$row->subtype}") . '</th>';
			if ($list_entities == 'yes') {
				$list_body .= '<h4>' . elgg_echo("item:object:{$row->subtype}") . '</h4>';
			}
			//$t_body .= '<th style="padding: .25rem .5rem;">' . elgg_echo("item:object:{$tool}") . '</th>';
			//$t_body .= '<td style="border-left: 1px solid; padding: .25rem .5rem;">' . (int) $row->total . '</td>';
			
			foreach($periods as $period) {
				$t_body .= '<td style="border-left: 1px solid; padding: .25rem .5rem;">';
					$new_entities = elgg_get_entities([
						'type' => 'object', 'subtype' => $row->subtype, 
						//'type' => 'object', 'subtype' => $tool, 
						'container_guid' => $group->guid, 
						'created_after' => $period['start_ts'],
						'created_before' => $period['end_ts'],
						'count' => true
					]);
					$t_body .= $new_entities;
				$t_body .= '</td>';
				
				// Liste des publications par date
				if ($list_entities == 'yes') {
					$list_body .= '<h5>' . $period['label'] . ' : ' . $new_entities . '</h5>';
					$list_body .= elgg_list_entities([
						'type' => 'object', 'subtype' => $row->subtype, 
						//'type' => 'object', 'subtype' => $tool, 
						'container_guid' => $group->guid, 
						'created_after' => $period['start_ts'],
						'created_before' => $period['end_ts'],
						'list_type_toggle' => true,
						'list_type' => 'table',
					]);
				}
			}
		$t_body .= '</tr>';
	}
}
$content .= '<h3>Statistiques de publication par date</h3>';
$content .= '<table style="border: 1px solid; width: 100%;">';
	$content .= '<thead>';
		$content .= '<tr style="border: 1px solid;">';
			$content .= $t_head;
		$content .= '</tr>';
	$content .= '</thead>';
	$content .= '<tbody>';
			$content .= $t_body;
	$content .= '</tbody>';
$content .= '</table>';
$content .= '<br /><br />';

if ($list_entities == 'yes') {
	$content .= '<h3>Liste des publications par type de contenu et par date</h3>';
	$content .= $list_body;
	$content .= '<br /><br />';
}



// group members join dates
$content .= elgg_view('advanced_statistics/elements/chart', [
	'title' => elgg_echo('advanced_statistics:group:members'),
	'id' => 'advanced-statistics-group-members',
	'container_guid' => $group->guid,
	'page' => 'group_data',
	'section' => 'group',
	'chart' => 'members',
	'date_limited' => $date_limited,
]);

// group content pie
$content .= elgg_view('advanced_statistics/elements/chart', [
	'title' => elgg_echo('advanced_statistics:group:contenttype'),
	'id' => 'advanced-statistics-group-contenttype',
	'container_guid' => $group->guid,
	'page' => 'group_data',
	'section' => 'group',
	'chart' => 'contenttype',
	'date_limited' => $date_limited,
]);

// content creation history
$content .= elgg_view('advanced_statistics/elements/chart', [
	'title' => elgg_echo('advanced_statistics:group:content_creation'),
	'id' => 'advanced-statistics-group-content-creation',
	'container_guid' => $group->guid,
	'page' => 'group_data',
	'section' => 'group',
	'chart' => 'content_creation',
	'date_limited' => $date_limited,
]);

// activity history
$content .= elgg_view('advanced_statistics/elements/chart', [
	'title' => elgg_echo('advanced_statistics:group:activity'),
	'id' => 'advanced-statistics-group-activity',
	'container_guid' => $group->guid,
	'page' => 'group_data',
	'section' => 'group',
	'chart' => 'activity',
	'date_limited' => $date_limited,
]);

$body = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
]);

echo elgg_view_page($title, $body);
