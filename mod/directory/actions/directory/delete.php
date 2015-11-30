<?php
/**
 * Elgg directory delete action
 * 
 * @package ElggDirectory
 * @subpackage directory
 * @author Facyla 2015
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

$guid = (int) get_input('guid');

gatekeeper();
if ($directory = get_entity($guid)) {
	if ($directory->canEdit()) {
		if ($directory->getSubtype() == "directory") {
			if ($directory->delete()) {
				system_message(elgg_echo("directory:deleted"));
			} else {
				register_error(elgg_echo("directory:delete:fail"));
			}
		} else {
			register_error(elgg_echo("directory:delete:fail"));
		}
	} else register_error(elgg_echo("directory:delete:fail"));
} else register_error(elgg_echo("directory:delete:fail"));

forward("directory");

