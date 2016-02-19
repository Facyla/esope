<?php
if (!project_manager_gatekeeper(false, true, false)) return;

// Accès réservé aux managers, et aux admins
$is_manager = project_manager_manager_gatekeeper(false, true, false);
if (elgg_in_context('time_tracker')) $vars['selected'] = 'time_tracker';
if (elgg_in_context('expenses')) $vars['selected'] = 'expenses';

$tabs = array(
	'time_tracker' => array(
		'title' => elgg_echo('project_manager:menu:time_tracker'),
		'url' => "time_tracker",
		'selected' => $vars['selected'] == 'time_tracker',
	),
	'expenses' => array(
		'title' => elgg_echo('project_manager:menu:expenses'),
		'url' => "project_manager/expenses",
		'selected' => $vars['selected'] == 'expenses',
	),
	/*
	'time_tracker/summary' => array(
		'title' => elgg_echo('project_manager:menu:time_tracker:summary'),
		'url' => "time_tracker/summary",
		'selected' => $vars['selected'] == 'time_tracker/summary',
	),
	*/
	'project_manager' => array(
		'title' => elgg_echo('project_manager:menu:projects'),
		'url' => "project_manager",
		'selected' => $vars['selected'] == 'project_manager',
	),
);

if ($is_manager) {
  $tabs['production'] = array(
		  'title' => elgg_echo('project_manager:menu:production'),
		  'url' => "project_manager/production", 'selected' => $vars['selected'] == 'production',
	  );
  $tabs['consultants'] = array(
		  'title' => elgg_echo('project_manager:menu:consultants'),
		  'url' => "project_manager/consultants", 'selected' => $vars['selected'] == 'consultants',
	  );
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs));

if (!empty($vars['title'])) echo elgg_view_title($vars['title']);

