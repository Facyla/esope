<?php
$max = elgg_extract('limit', $vars, 60);
$duration = elgg_extract('duration', $vars, 1800);
$online_members = find_active_users($duration, $max, 0);
?>

<div class="sidebarBox">
	<?php
	echo '<h3><a href="' . $vars['url'] . 'members/online">' . elgg_echo('members:online') .'</a></h3>';
	echo elgg_view('theme_inria/users/members', array('members' => $online_members));
	?>
</div>

