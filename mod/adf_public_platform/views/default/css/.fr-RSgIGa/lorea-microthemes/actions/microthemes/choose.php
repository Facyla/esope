<?php
	gatekeeper();
	$assign_to = get_input('assign_to');
	$guid = get_input('guid');
	$user = get_entity($assign_to);
	// XXX check permissions
	if ($entity = get_entity($guid) && $user) {
		$user->microtheme = $guid;
		forward("pg/microthemes/view?assign_to=".$assign_to);
	}
	
	register_error(elgg_echo("bookmarks:delete:failed"));
	forward("pg/microthemes/view?assign_to=".$assign_to);

?>
