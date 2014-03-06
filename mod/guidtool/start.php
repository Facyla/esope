<?php
/**
 * Elgg GUID Tool
 * 
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

/**
 * Initialise the tool and set menus.
 */
function guidtool_init()
{
	global $CONFIG;
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('guidtool','guidtool_page_handler');
	
	// Register some actions
	$action_path = $CONFIG->pluginspath . 'guidtool/actions/guidtool/';
	elgg_register_action("guidtool/delete", $action_path . 'delete.php', 'admin');
	elgg_register_action("guidtool/edit", $action_path . 'edit.php', 'admin');
	
}

/**
 * Post init gumph.
 */
function guidtool_page_setup() {
	global $CONFIG;
	
	if ((elgg_is_admin_logged_in()) && (elgg_get_context()=='admin')) {
		elgg_register_menu_item('admin', array('name' => 'guidtool:browse', 'href' => $CONFIG->wwwroot."guidtool/", 'text' => elgg_echo('guidtool:browse')));
		elgg_register_menu_item('admin', array('name' => 'guidtool:import', 'href' => $CONFIG->wwwroot."guidtool/import/", 'text' => elgg_echo('guidtool:import')));
	}
}

/**
 * Log browser page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function guidtool_page_handler($page) {
	global $CONFIG;
	$base = $CONFIG->pluginspath . 'guidtool/pages/guidtool/';
	
	if (isset($page[0])) {
		switch ($page[0]) {
			
			case 'view' :
				if ((isset($page[1]) && (!empty($page[1])))) {
					set_input('entity_guid', $page[1]);
					elgg_register_menu_item('page', array('name' => 'guidtool:view', 'href' => $CONFIG->url . "guidtool/view/{$page[1]}/", 'text' => 'View GUID&nbsp;: '.$page[1]));
					elgg_register_menu_item('page', array('name' => 'guidtool:export', 'href' => $CONFIG->url . "guidtool/export/{$page[1]}/", 'text' => elgg_echo('guidbrowser:export')));
					elgg_register_menu_item('page', array('name' => 'guidtool:edit', 'href' => $CONFIG->url . "guidtool/edit/{$page[1]}/", 'text' => 'Edit GUID&nbsp;: '.$page[1]));
					include($base . 'view.php');
				} else include($base . 'index.php'); 
				break;
				
			case 'edit' :
				if ((isset($page[1]) && (!empty($page[1])))) {
					set_input('entity_guid', $page[1]);
					elgg_register_menu_item('page', array('name' => 'guidtool:view', 'href' => $CONFIG->url . "guidtool/view/{$page[1]}/", 'text' => 'View GUID&nbsp;: '.$page[1]));
					elgg_register_menu_item('page', array('name' => 'guidtool:export', 'href' => $CONFIG->url . "guidtool/export/{$page[1]}/", 'text' => elgg_echo('guidbrowser:export')));
					elgg_register_menu_item('page', array('name' => 'guidtool:edit', 'href' => $CONFIG->url . "guidtool/edit/{$page[1]}/", 'text' => 'Edit GUID&nbsp;: '.$page[1]));
					include($base . 'edit.php');
				} else include($base . 'index.php'); 
				break;
				
			case 'export':
				if ((isset($page[1]) && (!empty($page[1])))) {
					set_input('entity_guid', $page[1]);
					if ((isset($page[2]) && (!empty($page[2])))) {
						set_input('format', $page[2]); 
						include($base . 'export.php');
					} else {
						set_input('forward_url', $CONFIG->url . "guidtool/export/$page[1]/"); 
						include($base . 'format_picker.php');
					}
				} else include($base . 'index.php'); 
				break;
			
			case 'import' :
				if ((isset($page[1]) && (!empty($page[1])))) {
					set_input('format', $page[1]);
					include($base . 'import.php');
				} else {
					set_input('forward_url', $CONFIG->url . "guidtool/import/");	
					include($base . 'format_picker.php');
				} 
				break;
			
			default:
				include($base . 'index.php'); 
		}
	} else include($base . 'index.php');
	return true;
}

/**
 * Get a list of import actions
 *
 */
function guidtool_get_import_actions() {
	global $CONFIG;
	$return = array();
	
	foreach ($CONFIG->actions as $action => $handler) {
		if (strpos($action, "import/")===0)
			$return[] = substr($action, 7);
	}
	
	return $return;
}

// Initialise log
elgg_register_event_handler('init','system','guidtool_init');
elgg_register_event_handler('pagesetup','system','guidtool_page_setup');

