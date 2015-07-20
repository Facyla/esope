<?php
/**
 * Elgg custom menus: add/edit action
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.net/
 */

// @TODO : implement MVC model, see view admin/appearance/menus


admin_gatekeeper();


// Cache to the session
elgg_make_sticky_form('elgg_menus');

/* Get input data */
$menus_action = get_input('menus_action');
$menu_name = get_input('menu_name', false);
// Clean menu name, useful for new names
$menu_name = elgg_get_friendly_title($menu_name);

$custom_menus = elgg_menus_get_custom_menus();



// PROCESS ACTIONS : EDIT MENUS, REMOVE MENU

switch ($menus_action) {
	
	// IMPORT MENU(s) CONFIG : menu_name::serialized_config (one per line)
	// Note : import *adds and replaces* menus, but will not erase menus that are not in the backup
	case 'import':
		$import_data = get_uploaded_file('backup_file');
		if ($import_data) {
			$import_data = explode("\n", $import_data);
			foreach ($import_data as $import_line) {
				if (empty($import_line)) continue;
				$pos = strpos($import_line, '::');
				$import_name = substr($import_line, 0, $pos);
				$import_config = substr($import_line, $pos + 2);
				if (empty($import_name) || empty($import_config)) continue;
				// Save menu config (optionally only selected one)
				if (empty($menu_name) || ($import_name == $menu_name)) {
					//$content .= "$import_name : <pre>$import_config</pre> vs <pre>" . elgg_get_plugin_setting("menu-$import_name", 'elgg_menus') . "</pre>";
					elgg_set_plugin_setting("menu-$import_name", $import_config, 'elgg_menus');
					if (!in_array($menu_name, $custom_menus)) { $custom_menus[] = $menu_name; }
					system_message(elgg_echo('elgg_menus:imported:menu', array($import_name)));
				}
			}
			// Save updated custom menus list
			array_filter($custom_menus);
			$custom_menus_data = implode(',', $custom_menus);
			elgg_set_plugin_setting('menus', $custom_menus_data, 'elgg_menus');
		}
		break;
	
	// SAVE / EXPORT menu : menu_name::serialized_config (one per line)
	case 'export':
		$export = '';
		// Export custom menu config
		if ($menu_name) {
			$export_names = array($menu_name);
			$export_filename = $menu_name;
		} else {
			// Export all custom menus config
			$export_names = elgg_menus_get_custom_menus();
			$export_filename = 'all-menus';
		}
		// Export filename
		$export_filename = 'elgg_menus_' . $export_filename . '_' . date('Y-m-d-H-i-s') . '.backup';
		// Notification messages
		if ($export_names) {
			foreach ($export_names as $export_name) {
				$export .= $export_name . '::';
				$export .= elgg_get_plugin_setting("menu-$export_name", 'elgg_menus');
				$export .= "\n";
			}
			// Nonsense if we send a file (cannot forward after that)
			//system_message(elgg_echo('elgg_menus:export:message', array(count($export_names), $export_filename)));
			// Send file using headers for download
			header('Content-Type: text/plain; charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $export_filename);
			echo $export;
			// Exit is required if we want to send a file
			exit;
		} else {
			register_error(elgg_echo('elgg_menus:export:error:nomenu'));
		}
		break;
	
	// DELETE : $menu_name
	case 'delete':
		if (!empty($menu_name)) {
			// Delete custom menu config
			elgg_unset_plugin_setting("menu-$menu_name", 'elgg_menus');
			// Remove from custom menu list
			$custom_menus = array_diff($custom_menus, array($menu_name));
			// Save updated list
			$custom_menus_data = implode(',', $custom_menus);
			elgg_set_plugin_setting('menus', $custom_menus_data, 'elgg_menus');
			system_message(elgg_echo('elgg_menus:delete:message', array($menu_name)));
			$menu_name = '';
		} else {
			register_error(elgg_echo('elgg_menus:delete:error:empty'));
		}
		break;
	
	// EDIT : $menu_name
	case 'edit':
		if ($menu_name) {
			/* Custom menu edit form */
			// These vars should be kept "as sent" (they are used in the menu edit form)
			//merge or replace mode
			$menu_mode = get_input('menu_mode', 'merge');
			// Entrées à retirer d'un menu pré-existant (si merge)
			// Remove dynamic items (merge mode only) => set up array from list
			$menu_remove = get_input('menu_remove');
			//class: string the class for the entire menu.
			$menu_class = get_input('menu_class');
			//sort_by => string or php callback string options: 'name', 'priority', 'text' (default), 'register' (registration order) or a php callback (a compare function for usort)
			$menu_sort_by = get_input('menu_sort_by', 'priority');
			if ($menu_sort_by == 'callback') {
				$menu_sort_by = '';
				$menu_sort_by_callback = get_input('menu_sort_by_callback');
				if (!empty($menu_sort_by_callback)) $menu_sort_by = $menu_sort_by_callback;
			}
			//handler: string the page handler to build action URLs entity: to use to build action URLs
			$menu_handler = get_input('menu_handler');
			//show_section_headers: bool show headers before menu sections.
			$menu_show_section_headers = get_input('menu_show_section_headers', 'no');
	
			// Menu items names array (used to count items)
			$new_name = get_input('name');
			// Count menu items from received items count (item name is the only required value for items)
			$number_of_items = count($new_name);
			// Other items parameters
			$new_items = array();
			$new_href = get_input('href');
			$new_text = get_input('text');
			$new_title = get_input('title');
			$new_confirm = get_input('confirm');
			$new_item_class = get_input('item_class');
			$new_link_class = get_input('link_class');
			$new_section = get_input('section');
			$new_priority = get_input('priority');
			$new_contexts = get_input('contexts');
			$new_selected = get_input('selected');
			$new_parent_name = get_input('parent_name');
			// Process each menu item
			for($i=0; $i<$number_of_items; $i++) {
				$new_name_clean = $new_name[$i];
				// Try to guess name from text, if no name (should not happen)
				if (empty($new_name_clean) && !empty($new_text[$i])) { $new_name_clean = $new_text[$i]; }
				// Ensure proper name formatting
				$new_name_clean = elgg_get_friendly_title($new_name_clean);
				// Avoid name duplicates by incrementing duplicate names with index
				if (isset($new_items[$new_name_clean])) { $new_name_clean .= $i; }
				// Set up new menu item
				if ($new_name_clean) {
					// Set defaults
					if (empty($new_section[$i])) { $new_section[$i] = 'default'; }
					if (empty($new_priority[$i])) { $new_priority[$i] = 100; }
					if (empty($new_contexts[$i])) { $new_contexts[$i] = array('all'); }
					// Cleanup some inputs
					if (!empty($new_section[$i])) $new_section[$i] = elgg_get_friendly_title($new_section[$i]);
					if (!empty($new_parent_name[$i])) $new_parent_name[$i] = elgg_get_friendly_title($new_parent_name[$i]);
					if (!empty($new_item_class[$i])) {
						$new_item_class[$i] = explode(' ', $new_item_class[$i]);
						$new_item_class[$i] = array_unique($new_item_class[$i]);
						$new_item_class[$i] = implode(' ', $new_item_class[$i]);
					}
					// Add/update item
					$new_items[$new_name_clean] = array(
							'name' => $new_name[$i],
							'href' => $new_href[$i],
							'text' => $new_text[$i],
							'title' => $new_title[$i],
							'confirm' => $new_confirm[$i],
							'item_class' => $new_item_class[$i],
							'link_class' => $new_link_class[$i],
							'section' => $new_section[$i],
							'priority' => $new_priority[$i],
							'contexts' => $new_contexts[$i],
							'selected' => $new_selected[$i],
							'parent_name' => $new_parent_name[$i],
						);
				}
			}
			//$content .= '<pre>' . print_r($new_items, true) . '</pre>'; // debug
	
			// Define custom menu configuration
			$menu_config = array('name' => $menu_name, 'items' => $new_items, 'mode' => $menu_mode, 'class' => $menu_class, 'sort_by' => $menu_sort_by, 'handler' => $menu_handler, 'show_section_headers' => $menu_show_section_headers, 'remove' => $menu_remove);
			// Transform some values we want more directly usable
			if ($menu_config['remove']) {
				$menu_config['remove'] = explode(',', $menu_config['remove']);
				$menu_config['remove'] = array_map('trim', $menu_config['remove']);
			}
			if ($menu_config['show_section_headers'] == 'yes') { $menu_config['show_section_headers'] = true; } else { $menu_config['show_section_headers'] = false; }
			// Save menu configuration data
			$menu_config_data = serialize($menu_config);
			elgg_set_plugin_setting("menu-$menu_name", $menu_config_data, 'elgg_menus');
			//$content .= "CONFIG $menu_name : $menu_config_data<br />";
			//$content .= "CUSTOM $menu_name : " . elgg_get_plugin_setting("menu-$menu_name", 'elgg_menus') . '<br />';
	
			// Update custom menu list (add menu)
			if (!in_array($menu_name, $custom_menus)) {
				$custom_menus[] = $menu_name;
				array_filter($custom_menus);
				$custom_menus_data = implode(',', $custom_menus);
				elgg_set_plugin_setting('menus', $custom_menus_data, 'elgg_menus');
			}
			system_message(elgg_echo('elgg_menus:edit:message', array($menu_name)));
		} else {
			register_error(elgg_echo('elgg_menus:edit:error:empty'));
		}
		break;
	
	default:
		// Nothing to do
}



// Set some useful URL params
$forward = "admin/appearance/menus";
$params = array();
if ($menu_name) $params[] = "menu_name=$menu_name";
if (!empty($params)) $forward .= '?' . implode('&', $params);

// Forward back to the admin page
forward($forward);

