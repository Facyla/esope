<?php $newest_members = find_active_users(1800, 18, 0);
?>

<div class="sidebarBox">
<?php
echo '<h3><a href="<?php echo $vars['url']; ?>members/online">' . elgg_echo('members:online') .'</a></h3>';
echo elgg_view('theme_inria/users/members', array('members' => $newest_members));
?>
</div>
