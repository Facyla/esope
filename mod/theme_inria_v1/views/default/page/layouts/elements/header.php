<?php
/**
 * Header for layouts
 *
 * @uses $vars['title']  Title
 * @uses $vars['header'] Optional override for the header
 */


if (isset($vars['header'])) {
	echo '<div class="elgg-head clearfix">';
	echo $vars['header'];
	echo '</div>';
	return;
}

$title = elgg_extract('title', $vars, '');

// Groups : we use a different layout on group homepage
$owner = elgg_get_page_owner_entity();
if (!(elgg_instanceof($owner, 'group') && (elgg_get_context() == 'group_profile'))) {
	if (isset($vars['buttons']) && $vars['buttons']) {
		$buttons = $vars['buttons'];
	} else {
		$buttons = elgg_view_menu('title', array(
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		));
	}
}

if ($title || $buttons) {
	echo '<div class="elgg-head clearfix">';
	// @todo .elgg-heading-main supports action buttons - maybe rename class name?
	echo $buttons;
	echo elgg_view_title($vars['title'], array('class' => 'elgg-heading-main'));
	echo '</div>';
}
