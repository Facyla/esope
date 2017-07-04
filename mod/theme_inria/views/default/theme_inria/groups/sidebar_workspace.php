<?php
$group = elgg_get_page_owner_entity();


$sidebar .= '<h3>' . elgg_echo('groups:briefdescription') . '</h3>';
$desc = $group->briefdescription;
if (empty($desc)) { $desc = elgg_get_excerpt($group->description); }
$sidebar .= '<p>' . $desc . '</p>';

$sidebar .= elgg_view('theme_inria/groups/sidebar_discussion');

$sidebar .= elgg_view('theme_inria/groups/sidebar_file');

$sidebar .= elgg_view('theme_inria/groups/sidebar_blog');

$sidebar .= elgg_view('theme_inria/groups/sidebar_pages');

$sidebar .= elgg_view('theme_inria/groups/sidebar_bookmarks');

$sidebar .= elgg_view('theme_inria/groups/sidebar_newsletter');


echo $sidebar;

