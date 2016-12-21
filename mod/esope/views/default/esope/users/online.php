<?php
$max = elgg_extract('limit', $vars, 60);
$duration = elgg_extract('duration', $vars, 1800);
$online_members = find_active_users(array('seconds' => $duration, 'limit' => $max, 'count' => false));
$online_members_count = find_active_users(array('seconds' => $duration, 'count' => true));
?>

<div class="sidebarBox">
	<?php
	echo '<h3><a href="' . elgg_get_site_url() . 'members/online">' . elgg_echo('esope:members:online') . ' (' . $online_members_count . ')</a></h3>';
	echo elgg_view('esope/users/members', array('members' => $online_members));
	?>
</div>

