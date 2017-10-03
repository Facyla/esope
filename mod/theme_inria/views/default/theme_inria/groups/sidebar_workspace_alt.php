<?php
//$group = elgg_get_page_owner_entity();

echo elgg_view('theme_inria/groups/workspace_sidebar_members');

// Contenus réservés aux membres
if (elgg_group_gatekeeper(false)) {
	echo elgg_view('theme_inria/groups/sidebar_agenda');

	echo elgg_view('theme_inria/groups/sidebar_poll');

	echo elgg_view('theme_inria/groups/sidebar_alt_feedback');
}

