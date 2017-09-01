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

$menu = elgg_view('output/url', array('href' => 'javascript:void(0)', 'text' => elgg_echo('theme_inria:group:pending_request'), 'class' => 'float-alt', 'style' => "padding: 0.5rem 1rem;"));

$summary = $menu . '<h4>' . $group->name . '</h4>' . $group->briefdescription;

echo '<a href="' . $group->getURL() . '">' . elgg_view_image_block($icon, $summary, array('class' => "notifications-pending-invitations")) . '</a>';

