<?php
$group = elgg_get_page_owner_entity();

$content .= '<a href="' . elgg_get_site_url() . 'groups/members/' . $group->guid . '" class="iris-manage">' . elgg_echo('theme_inria:viewall') . '</a>';
$content .= '<h3>' . elgg_echo('members') . '</h3>';
$content .= '<div class="group-members-count">' . theme_inria_get_group_active_members($group, array('count' => true)) . '</div>';
//$content .= '<h3>' . elgg_echo('members:online') . '</h3>';
$content .= elgg_view('groups/sidebar/online_groupmembers', array('entity' => $group, 'limit' => 25));

echo '<div class="iris-sidebar-content">' . $content . '</div>';

