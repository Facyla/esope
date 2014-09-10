<?php
/**
 * Layout of the groups profile page
 *
 * @uses $vars['entity']
 */

// Note : access rights are set up for each content anyway, and we don't want to block reading published content, 
// so tell it's restricted membership but do not block access
echo elgg_view('groups/profile/summary', $vars);
if (!group_gatekeeper(false)) {
	if (elgg_is_logged_in()) {
		echo '<p><blockquote>' . elgg_view('groups/profile/closed_membership') . '</blockquote></p>';
	}
}
echo elgg_view('groups/profile/widgets', $vars);

