<?php
$limit = elgg_extract('limit', $vars, 24);
$newest_members = elgg_get_entities(array('types' => 'user', 'limit' => $limit));
?>

<div class="sidebarBox">
	<h3><a href="<?php echo elgg_get_site_url(); ?>members/newest"><?php echo elgg_echo('esope:members:newest'); ?></a></h3>
	<?php echo elgg_view('esope/users/members', array('members' => $newest_members)); ?>
</div>


