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
if ($owner instanceof ElggGroup ||
	($owner instanceof ElggUser && $owner->getGUID() != elgg_get_logged_in_user_guid())) {
	
	if (elgg_instanceof($owner, 'group') && !elgg_is_logged_in()) {
		// FING : Don't display owner_block (and menu !) is group and in public mode
		// Note : see also views in groups/profile
	} else {
		$header = elgg_view_entity($owner, array('full_view' => false));

		$body = elgg_view_menu('owner_block', array('entity' => $owner));

		$body .= elgg_view('page/elements/owner_block/extend', $vars);

		echo elgg_view('page/components/module', array(
			'header' => $header,
			'body' => $body,
			'class' => 'elgg-owner-block',
		));
	}
}

elgg_pop_context();

