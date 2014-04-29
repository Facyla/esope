<?php
$max = elgg_extract('limit', $vars, 60);
$duration = elgg_extract('duration', $vars, 1800);
$online_members = find_active_users($duration, $max, 0);
$online_members_count = find_active_users($duration, 10, 0, true);
?>

<div class="sidebarBox">
	<?php
	echo '<h3><a href="' . $vars['url'] . 'members/online">' . elgg_echo('adf_platform:members:online') . ' (' . $online_members_count . ')</a></h3>';
	echo elgg_view('adf_platform/users/members', array('members' => $online_members));
	?>
</div>

