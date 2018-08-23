<?php
//$group = elgg_get_page_owner_entity();

// Set title excerpt length
$excerpt_limit = 70;

echo elgg_view('theme_inria/groups/workspace_sidebar_members');

// Contenus réservés aux membres
if (elgg_group_gatekeeper(false)) {
	echo elgg_view('theme_inria/groups/sidebar_agenda', ['excerpt_limit' => $excerpt_limit]);

	echo elgg_view('theme_inria/groups/sidebar_poll', ['excerpt_limit' => $excerpt_limit]);

	echo elgg_view('theme_inria/groups/sidebar_alt_feedback', ['excerpt_limit' => $excerpt_limit]);
}

