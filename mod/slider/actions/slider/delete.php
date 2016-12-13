<?php
/**
 * Elgg slider delete action
 * 
 * @package Elgg
 * @subpackage slider
 * @author Facyla 2015
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

$guid = (int) get_input('guid');

gatekeeper();
if ($slider = get_entity($guid)) {
	if (elgg_instanceof($slider, 'object', 'slider')) {
		if ($slider->canEdit()) {
			if ($slider->delete()) {
				system_message(elgg_echo("slider:deleted"));
			} else {
				register_error(elgg_echo("slider:delete:fail"));
			}
		} else {
			register_error(elgg_echo("slider:delete:fail"));
		}
	} else { register_error(elgg_echo("slider:delete:fail")); }
} else { register_error(elgg_echo("slider:delete:fail")); }

forward("slider");

