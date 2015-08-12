<?php
/**
 * Search entity view for RSS feeds.
 *
 * @uses $vars['entity']
 */

if (!array_key_exists('entity', $vars) || !($vars['entity'] instanceof ElggEntity)) {
	return FALSE;
}

// title cannot contain HTML but descriptions can.
$title = strip_tags($vars['entity']->getVolatileData('search_matched_title'));
$description = $vars['entity']->getVolatileData('search_matched_description');

echo elgg_view('transitions/transitions_event', array('entity' => $vars['entity']));

