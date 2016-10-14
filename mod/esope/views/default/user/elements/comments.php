<?php
/**
 * Comments on user
 *
 * @uses $vars['entity']    ElggUser
 */

$user = elgg_extract('entity', $vars, elgg_get_page_owner_entity());

if (elgg_instanceof($user, 'user') && !$user->isBanned()) {
	echo elgg_view_comments($user, true);
}

