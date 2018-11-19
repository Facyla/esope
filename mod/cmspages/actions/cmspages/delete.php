<?php
/**
 * Elgg cmspage delete action
 * 
 * @package Elgg
 * @subpackage cmspage
 * @author Facyla 2010-2014
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

$guid = (int) get_input('guid');
// BC : now deprecated, use GUID instead
if (!$guid) { $guid = (int) get_input('cmspage_guid'); }

gatekeeper();

// Check if allowed user = admin or GUID in editors list
if (!cmspage_is_editor()) { forward(); }

if ($cmspage = get_entity($guid)) {
	//$container_guid = $cmspage->getContainer();
	if ($cmspage->canEdit()) {
		if ($cmspage->getSubtype() == "cmspage") {
			if ($cmspage->delete()) {
				system_message(elgg_echo("cmspages:deleted"));
			} else {
				register_error(elgg_echo("cmspages:delete:fail3"));
			}
		} else {
			register_error(elgg_echo("cmspages:delete:fail2"));
		}
	} else register_error(elgg_echo("cmspages:delete:fail"));
} else register_error(elgg_echo("cmspages:delete:fail1"));

forward("cmspages");

