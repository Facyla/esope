<?php $newest_members = find_active_users(1800, 18, 0);
?>

<div class="sidebarBox">
<?php
echo '<h3>' . elgg_echo('members:online') .'</h3>';
echo elgg_view('theme_inria/users/members', array('members' => $newest_members));
?>
</div>
