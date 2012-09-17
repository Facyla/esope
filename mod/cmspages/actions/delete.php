<?php
/**
 * Elgg cmspage delete action
 * 
 * @package Elgg
 * @subpackage cmspage
 * @author Facyla 2011
 * @license 	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

$cmspage_guid = (int) get_input('cmspage_guid');

gatekeeper();
action_gatekeeper();

if (in_array(elgg_get_logged_in_user_guid(), explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) {
} else {
  if (elgg_is_active_plugin('multisite')) { multisite_admin_gatekeeper(); } else { admin_gatekeeper(); }
}

if ($cmspage = get_entity($cmspage_guid)) {
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

forward("cmspages/");
