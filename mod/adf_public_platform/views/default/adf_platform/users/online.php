<?php
// Timeframe : 30 minutes (30*60)
// Max : 50
$max = elgg_extract('limit', $vars, 60);
$duration = elgg_extract('duration', $vars, 1800);
$online_members = find_active_users($duration, $max, 0); ?>

<div class="sidebarBox">
	<?php
	echo '<h3><a href="' . $vars['url'] . 'members/online">' . elgg_echo('adf_platform:members:online') .'</a></h3>';
	echo elgg_view('adf_platform/users/members', array('members' => $online_members));
	?>
</div>

