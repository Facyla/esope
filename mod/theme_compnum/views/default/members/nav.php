<?php
/**
 * Members navigation
 */

$tabs = array(
	'organisation' => array(
		'title' => elgg_echo('members:label:organisation'),
		'url' => "members/organisation",
		'selected' => $vars['selected'] == 'organisation',
	),
	'formateur' => array(
		'title' => elgg_echo('members:label:formateur'),
		'url' => "members/formateur",
		'selected' => $vars['selected'] == 'formateur',
	),
	'candidat' => array(
		'title' => elgg_echo('members:label:candidat'),
		'url' => "members/candidat",
		'selected' => $vars['selected'] == 'candidat',
	),
	'newest' => array(
		'title' => elgg_echo('members:label:newest'),
		'url' => "members/newest",
		'selected' => $vars['selected'] == 'newest',
	),
/*
	'popular' => array(
		'title' => elgg_echo('members:label:popular'),
		'url' => "members/popular",
		'selected' => $vars['selected'] == 'popular',
	),
*/
	'online' => array(
		'title' => elgg_echo('members:label:online'),
		'url' => "members/online",
		'selected' => $vars['selected'] == 'online',
	),
);

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
