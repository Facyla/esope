<?php
//$newest_members = elgg_get_entities(array('types' => 'user', 'limit' => 24));
?>

<div class="sidebarBox">
	<?php
	echo '<h3><a href="' . elgg_get_site_url() . 'members/newest" title="' . elgg_echo('theme_inria:members:newest:tooltip') . '">' . elgg_echo('inria:members:newest') . '<span style="float:right;">&#9654;</span></a></h3>';
	//echo elgg_view('theme_inria/users/members', array('members' => $newest_members));
	?>
</div>


