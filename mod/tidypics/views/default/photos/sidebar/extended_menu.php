<?php
/**
 * Extended sidebar menu entries
 */

$base = elgg_get_site_url() . 'photos/';

elgg_register_menu_item('page', [
	'name' => 'A30_tiypics_recentlyviewed',
	'text' => elgg_echo('tidypics:recentlyviewed'),
	'href' => $base . 'recentlyviewed',
	'section' => 'A'
]);
elgg_register_menu_item('page', [
	'name' => 'A40_tiypics_recentlycommented',
	'text' => elgg_echo('tidypics:recentlycommented'),
	'href' => $base . 'recentlycommented',
	'section' => 'A'
]);

elgg_register_menu_item('page', [
	'name' => 'B10_tiypics_mostviewed',
	'text' => elgg_echo('tidypics:mostviewed'),
	'href' => $base . 'mostviewed',
	'section' => 'B'
]);
elgg_register_menu_item('page', [
	'name' => 'B20_tiypics_mostviewedtoday',
	'text' => elgg_echo('tidypics:mostviewedtoday'),
	'href' => $base . 'mostviewedtoday',
	'section' => 'B'
]);
elgg_register_menu_item('page', [
	'name' => 'B30_tiypics_mostviewedthismonth',
	'text' => elgg_echo('tidypics:mostviewedthismonth'),
	'href' => $base . 'mostviewedthismonth',
	'section' => 'B'
]);
elgg_register_menu_item('page', [
	'name' => 'B40_tiypics_mostviewedlastmonth',
	'text' => elgg_echo('tidypics:mostviewedlastmonth'),
	'href' => $base . 'mostviewedlastmonth',
	'section' => 'B'
]);
elgg_register_menu_item('page', [
	'name' => 'B50_tiypics_mostviewedthisyear',
	'text' => elgg_echo('tidypics:mostviewedthisyear'),
	'href' => $base . 'mostviewedthisyear',
	'section' => 'B'
]);

elgg_register_menu_item('page', [
	'name' => 'C10_tidypics_mostcommented',
	'text' => elgg_echo('tidypics:mostcommented'),
	'href' => $base . 'mostcommented',
	'section' => 'C'
]);
elgg_register_menu_item('page', [
	'name' => 'C20_tidypics_mostcommentedtoday',
	'text' => elgg_echo('tidypics:mostcommentedtoday'),
	'href' => $base . 'mostcommentedtoday',
	'section' => 'C'
]);
elgg_register_menu_item('page', [
	'name' => 'C30_tidypics_mostcommentedthismonth',
	'text' => elgg_echo('tidypics:mostcommentedthismonth'),
	'href' => $base . 'mostcommentedthismonth',
	'section' => 'C'
]);
elgg_register_menu_item('page', [
	'name' => 'C40_tidypics_mostcommentedlastmonth',
	'text' => elgg_echo('tidypics:mostcommentedlastmonth'),
	'href' => $base . 'mostcommentedlastmonth',
	'section' => 'C'
]);
elgg_register_menu_item('page', [
	'name' => 'C50_tidypics_mostcommentedthisyear',
	'text' => elgg_echo('tidypics:mostcommentedthisyear'),
	'href' => $base . 'mostcommentedthisyear',
	'section' => 'C'
]);

if (elgg_is_active_plugin('elggx_fivestar')) {
	elgg_register_menu_item('page', [
		'name' => 'D10_tidypics_highestrated',
		'text' => elgg_echo('tidypics:highestrated'),
		'href' => $base . 'highestrated',
		'section' => 'D'
	]);
	elgg_register_menu_item('page', [
		'name' => 'D20_tidypics_highestvotecount',
		'text' => elgg_echo('tidypics:highestvotecount'),
		'href' => $base . 'highestvotecount',
		'section' => 'D'
	]);
	elgg_register_menu_item('page', [
		'name' => 'D30_tidypics_recentvotes',
		'text' => elgg_echo('tidypics:recentlyvoted'),
		'href' => $base . 'recentvotes',
		'section' => 'D'
	]);
}

if (elgg_is_logged_in()) {
	elgg_register_menu_item('page', [
		'name' => 'E10_tidypics_usertagged',
		'text' => elgg_echo('tidypics:usertagged'),
		'href' => $base . "tagged",
		'section' => 'E'
	]);
}
