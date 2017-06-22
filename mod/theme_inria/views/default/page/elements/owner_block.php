<?php
/**
 * Elgg owner block
 * Displays page ownership information
 *
 * @package Elgg
 * @subpackage Core
 *
 */

elgg_push_context('owner_block');

// groups and other users get owner block
$owner = elgg_get_page_owner_entity();
//if ($owner instanceof ElggGroup || $owner instanceof ElggUser) {
//if ($owner instanceof ElggGroup || ($owner instanceof ElggUser && $owner->guid != elgg_get_logged_in_user_guid())) {
if ($owner instanceof ElggGroup) {

	$header = elgg_view_entity($owner, array('full_view' => false));

	$body = elgg_view_menu('owner_block', array('entity' => $owner));

	$body .= elgg_view('page/elements/owner_block/extend', $vars);

	echo elgg_view('page/components/module', array(
		'header' => $header,
		'body' => $body,
		'class' => 'elgg-owner-block',
	));
} else if ($owner instanceof ElggUser) {
	//echo elgg_view_entity_icon($owner, array('size' => 'small'));
	//echo elgg_view_menu('owner_block', array('entity' => $owner));
}

elgg_pop_context();
