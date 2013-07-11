<?php $newest_members = find_active_users(1800, 18, 0); ?>

<div class="sidebarBox">
  <?php
  echo '<h3><a href="' . $vars['url'] . 'members/online">' . elgg_echo('adf_platform:members:online') .'</a></h3>';
  echo elgg_view('adf_platform/users/members', array('members' => $newest_members));
  ?>
</div>

