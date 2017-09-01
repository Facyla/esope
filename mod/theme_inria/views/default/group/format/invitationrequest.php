<?php

/**
 * Group view for an invitation request
 *
 * @uses $vars['entity'] Group entity
 */

$group = elgg_extract('entity', $vars);

if (!$group instanceof \ElggGroup) {
	return true;
}

$user = elgg_get_logged_in_user_entity();

$icon = '<img src="' . $group->getIconURL(array('size' => 'small')) . '" />';
$menu = elgg_view_menu('invitationrequest', array(
	'entity' => $group,
	'user' => $user,
	'order_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
));

$summary = $menu . '<h4>' . $group->name . '</h4>' . $group->briefdescription;

echo elgg_view_image_block($icon, $summary, array('class' => "notifications-pending-invitations"));
