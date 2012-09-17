<?php
	gatekeeper();
	$assign_to = get_input('assign_to');
	$user = get_entity($assign_to);
	// XXX check permissions
	if ($user && $user->canEdit()) {
		$user->clearMetaData('microtheme');
		forward("pg/microthemes/view?assign_to=".$assign_to);
	}
	
	register_error(elgg_echo("bookmarks:clear:failed"));
	forward("pg/microthemes/view?assign_to=".$assign_to);

?>
