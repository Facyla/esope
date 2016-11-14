<?php
/**
* Elgg project_manager delete
* 
* @package ElggProject_manager
*/

$guid = (int) get_input('project_manager');

if (!elgg_is_logged_in()) { forward(); }
$own = elgg_get_logged_in_user_entity();

// Ajouter un admin_gatekeeper une fois que les droits d'édition auront été implémentés
if (($own->role != 'internal') && !elgg_is_admin_logged_in()) {
	register_error(elgg_echo('project_manager:delete:error:adminonly'));
	forward(); // Basic ACL
}
if (!elgg_is_admin_logged_in()) {
	register_error(elgg_echo('project_manager:delete:error:adminonly'));
	forward();
}

if ($project_manager = get_entity($guid)) {
	if ($project_manager->canEdit()) {
		//$container = get_entity($project_manager->container_guid);
		if ($project_manager->delete()) {
			system_message(elgg_echo("project_manager:deleted"));
		} else {
			register_error(elgg_echo("project_manager:deletefailed"));
		}
	} else {
		//$container = $own;
		register_error(elgg_echo("project_manager:deletefailed"));
	}
} else {
	register_error(elgg_echo("project_manager:deletefailed"));
}

forward("project_manager/" . $own->username);

