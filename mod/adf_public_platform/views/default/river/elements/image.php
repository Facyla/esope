<?php
/**
 * Elgg river image
 *
 * Displayed next to the body of each river item
 *
 * @uses $vars['item']
 */

$subject = $vars['item']->getSubjectEntity();

if (elgg_instanceof($subject)) {
	if (elgg_in_context('digest') || elgg_in_context('cron')) {
		echo '<div class="elgg-avatar elgg-avatar-small"><a href="' .  $subject->getURL() . '"><img src="' . $subject->getIconUrl('small') .  '" /></a></div>';
	} else {
		if (elgg_in_context('widgets')) {
			echo elgg_view_entity_icon($subject, 'tiny');
		} else {
			echo elgg_view_entity_icon($subject, 'small');
		}
	}
}

