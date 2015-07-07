<?php
/**
 * Elgg collection delete action
 * 
 * @package Elgg
 * @subpackage collection
 * @author Facyla 2015
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

$guid = (int) get_input('guid');

gatekeeper();
if ($collection = get_entity($guid)) {
	if ($collection->canEdit()) {
		if ($collection->getSubtype() == "collection") {
			if ($collection->delete()) {
				system_message(elgg_echo("collection:deleted"));
			} else {
				register_error(elgg_echo("collection:delete:fail"));
			}
		} else {
			register_error(elgg_echo("collection:delete:fail"));
		}
	} else register_error(elgg_echo("collection:delete:fail"));
} else register_error(elgg_echo("collection:delete:fail"));

forward("collection");

