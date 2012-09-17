<?php
/**
 * Elgg Simple editing of CMS "static" pages
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2008-2011
 * @link http://id.facyla.net/
*/


// Hooks
elgg_register_plugin_hook_handler('permissions_check', 'object', 'cmspages_permissions_check');

// Initialise log browser
elgg_register_event_handler('init','system','cmspages_init');
elgg_register_event_handler('pagesetup','system','cmspages_pagesetup');

// Register actions
global $CONFIG;
elgg_register_action("cmspages/edit", elgg_get_plugins_path() . "cmspages/actions/edit.php");
elgg_register_action("cmspages/delete", elgg_get_plugins_path() . "cmspages/actions/delete.php");



function cmspages_init() {
  global $CONFIG;
  elgg_extend_view('css','cmspages/css');
  
  // Register entity type
  elgg_register_entity_type('object','cmspage');
  
  // Register a URL handler for CMS pages
  elgg_register_entity_url_handler('cmspage_url','object','cmspage');
  
  elgg_register_page_handler('cmspages','cmspages_page_handler'); // Register a page handler, so we can have nice URLs
}


/* Populates the ->getUrl() method for cmspage objects */
function cmspage_url($cmspage) {
  global $CONFIG;
  return $CONFIG->url . "cmspages/read/" . $cmspage->pagetype;
}


function cmspages_page_handler($page) {
  global $CONFIG;
  if ($page[0]) {
    switch ($page[0]) {
      case "read":
        set_input('pagetype',$page[1]);
        if (@include(dirname(__FILE__) . "/read.php")) return true;
        break;
      default:
        if (@include($CONFIG->pluginspath . "cmspages/index.php")) return true;
    }
  } else {
    if (@include($CONFIG->pluginspath . "cmspages/index.php")) return true;
  }
  return false;
}

/* Page setup. Adds admin controls */
function cmspages_pagesetup() {
  global $CONFIG;
  // Facyla: allow main & local admins to use this tool
  // and also a custom editor list
  if ( (elgg_in_context('admin') || elgg_is_admin_logged_in())
    || (elgg_in_context('localmultisite')) 
    || ((elgg_in_context('cmspages_admin')) && in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))))
    ) {
    $item = new ElggMenuItem('cmspages', elgg_echo('cmspages'), 'cmspages/'); elgg_register_menu_item('topbar', $item);
  }
}

/* Permissions for the cmspages context */
function cmspages_permissions_check($hook, $type, $returnval, $params) {
  if (elgg_in_context('admin') && elgg_is_admin_logged_in()) return true;
  if (elgg_in_context('localmultisite'))  return true;
  if ( (elgg_in_context('cmspages_admin')) || in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))) )  return true;
	return NULL;
}
