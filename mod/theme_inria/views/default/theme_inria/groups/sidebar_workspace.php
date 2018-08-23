<?php
$group = elgg_get_page_owner_entity();
// Determine main group
$main_group = theme_inria_get_main_group($group);
$is_main_group = true;
if ($group->guid != $main_group->guid) { $is_main_group = false; }

// Set title excerpt length
$excerpt_limit = 70;


if ($is_main_group) {
	$sidebar .= '<h3>' . elgg_echo('groups:briefdescription') . '</h3>';
} else {
	$sidebar .= '<h3>' . elgg_echo('workspace:groups:briefdescription', array($group->name)) . '</h3>';
	$sidebar .= '<div class="iris-workspace-rules">';
		// Access
		$sidebar .= '<span class="group-access">' . elgg_echo('theme_inria:access:groups') . '&nbsp;: ' . elgg_view('output/access', array('entity' => $group)) . '</span><br />';
		// Membership
		$sidebar .= elgg_echo('theme_inria:groupmembership') . '&nbsp;: ';
		if ($group->membership == ACCESS_PUBLIC) {
			//echo '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open") . ' - ' . elgg_echo("theme_inria:groupmembership:open:details");
			$sidebar .= '<span class="membership-group-open">' . elgg_echo("theme_inria:groupmembership:open");
		} else {
			//echo '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed") . ' - ' . elgg_echo("theme_inria:groupmembership:closed:details");
			$sidebar .= '<span class="membership-group-closed">' . elgg_echo("theme_inria:groupmembership:closed");
		}
		$sidebar .= '</span>';
	$sidebar .= '</div>';
}

$desc = $group->briefdescription;
if (empty($desc)) { $desc = elgg_get_excerpt($group->description); }
if (empty($desc)) { $desc = '<em>' . elgg_echo('theme_inria:group:nodescription') . '</em>'; }
$sidebar .= '<div class="elgg-workspace-description">' . $desc . '</div>';


// Spécifique espaces de travail : liens vers gestion de l'espace
if (!$is_main_group) {
	$sidebar .= elgg_view('theme_inria/groups/workspace_sidebar', $vars);
}


// Contenu réservés aux membres
if (elgg_group_gatekeeper(false)) {
	$sidebar .= elgg_view('theme_inria/groups/sidebar_thewire', ['excerpt_limit' => $excerpt_limit]);

	$sidebar .= elgg_view('theme_inria/groups/sidebar_discussion', ['excerpt_limit' => $excerpt_limit]);

	$sidebar .= elgg_view('theme_inria/groups/sidebar_blog', ['excerpt_limit' => $excerpt_limit]);

	$sidebar .= elgg_view('theme_inria/groups/sidebar_pages', ['excerpt_limit' => $excerpt_limit]);

	$sidebar .= elgg_view('theme_inria/groups/sidebar_bookmarks', ['excerpt_limit' => $excerpt_limit]);

	$sidebar .= elgg_view('theme_inria/groups/sidebar_newsletter', ['excerpt_limit' => $excerpt_limit]);

	$sidebar .= elgg_view('theme_inria/groups/sidebar_file', ['excerpt_limit' => $excerpt_limit]);
}

if (!elgg_in_context('workspace')) {
	$sidebar .= elgg_view('theme_inria/groups/sidebar_feedback', ['excerpt_limit' => $excerpt_limit]);
}


echo $sidebar;

