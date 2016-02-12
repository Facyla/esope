<?php
$max = elgg_extract('limit', $vars, 60);
$duration = elgg_extract('duration', $vars, 1800);
$online_members = find_active_users(array('seconds' => $duration, 'limit' => $max, 'count' => false));
$online_members_count = find_active_users(array('seconds' => $duration, 'limit' => $max, 'count' => true));
?>

<div class="sidebarBox">
	<?php
	echo '<h3><a href="' . elgg_get_site_url() . 'members/online" title="' . elgg_echo('theme_inria:members:online:tooltip') . '">' . elgg_echo('members:online') .' (' . $online_members_count . ')<span style="float:right;">&#9654;</span></a></h3>';
	//echo elgg_view('theme_inria/users/members', array('members' => $online_members));
	?>
</div>

