<?php
/**
* Elgg dossierdepreuve delete
* 
* @package Elggdossierdepreuve
* @author Facyla
* @copyright Items International 2010-2012
* @link http://items.fr/
*/

elgg_make_sticky_form('dossierdepreuve');

$guid = (int) get_input('dossierdepreuve');

if ($dossierdepreuve = get_entity($guid)) {
	if ($dossierdepreuve->canEdit()) {
		if (elgg_is_admin_logged_in()) {
			if ($dossierdepreuve->delete()) { system_message(elgg_echo("dossierdepreuve:deleted")); } 
			else { register_error(elgg_echo("dossierdepreuve:deletefailed")); }
		} else { register_error(elgg_echo('dossierdepreuve:error:adminonly')); }
	} else { register_error(elgg_echo("dossierdepreuve:error:cantedit")); }
} else { register_error(elgg_echo("dossierdepreuve:deletefailed")); }
forward(REFERRER);

