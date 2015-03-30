<?php
/**
* Elgg menus
* 
* Menus editor page
* New menus : any menu except reserved ones
* Reserved menus : custom menu + behavior = full replacement (by a new menu) OR Add items, + Remove items (remove listed names)
* 
*/

global $CONFIG;
elgg_push_context('elgg_menus_admin');

/* Available menu vars :
name => STR Menu item identifier (required)
text => STR Menu item display text as HTML (required)
href => STR Menu item URL (required) (false for non-links.
section => STR Menu section identifier 
link_class => STR A class or classes for the tag 
item_class => STR A class or classes for the tag 
parent_name => STR Identifier of the parent menu item 
contexts => ARR Page context strings 
title => STR Menu item tooltip 
selected => BOOL Is this menu item currently selected? 
confirm => STR If set, the link will be drawn with the output/confirmlink view instead of output/url. 
data => ARR Custom attributes stored in the menu item.
$item = array('name', 'text', 'href', 'section', 'link_class', 'item_class', 'parent_name', 'contexts', 'title', 'selected', 'confirm', 'data');
*/

$content = '';

// Main action to be performed (edit|delete)
// Note : edit only when sending form, otherwise custom content will be erased
$menus_action = get_input('menus_action');

$menu_name = get_input('menu_name', false);
// Clean menu name, useful for new names
$menu_name = elgg_get_friendly_title($menu_name);

elgg_load_js('elgg.elgg_menus.edit');

$ny_opt = array('no' => elgg_echo('survey:settings:no'), 'yes' => elgg_echo('survey:settings:yes'));
// Modes du menu personnalisé
$menu_mode_opt = array('merge' => elgg_echo('elgg_menus:mode:merge'), 'replace' => elgg_echo('elgg_menus:mode:replace'), 'disabled' => elgg_echo('elgg_menus:mode:disabled'), 'clear' => elgg_echo('elgg_menus:mode:clear'));

// System menus
$system_menus = elgg_menus_get_system_menus();
// Custom menus
$custom_menus = elgg_menus_get_custom_menus();
// Sélecteur de menus
$menu_opts = elgg_menus_menus_opts($menu_name);

//$content .= "Custom $menu_name menu list : " . elgg_get_plugin_setting('menus', 'elgg_menus') . '<br />';
//$content .= "CUSTOM $menu_name : " . elgg_get_plugin_setting("menu-$menu_name", 'elgg_menus');


// PROCESS MENU FORMS FIRST : EDIT MENUS, REMOVE MENU
if ($menu_name) {
	
	/* Custom menu edit form */
	if ($menus_action == 'edit') {
		// These vars should be kept "as sent" (they are used in the menu edit form)
		//merge or replace mode
		$menu_mode = get_input('menu_mode', 'merge');
		// Entrées à retirer d'un menu pré-existant (si merge)
		// Remove dynamic items (merge mode only) => set up array from list
		$menu_remove = get_input('menu_remove');
		//class: string the class for the entire menu.
		$menu_class = get_input('menu_class');
		//sort_by => string or php callback string options: 'name', 'priority', 'title' (default), 'register' (registration order) or a php callback (a compare function for usort)
		$menu_sort_by = get_input('menu_sort_by', 'priority');
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
			if (empty($new_name_clean) && !empty($new_text[$i])) { $new_name_clean = elgg_get_friendly_title($new_name[$i]); }
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
	}
	
	// Delete custom menu and update custom menus list
	if ($menus_action == 'delete') {
		// Remove custom menu config
		elgg_unset_plugin_setting("menu-$menu_name", 'elgg_menus');
		// Remove from custom menu list
		$custom_menus = array_diff($custom_menus, array($menu_name));
		// Save updated list
		$custom_menus_data = implode(',', $custom_menus);
		elgg_set_plugin_setting('menus', $custom_menus_data, 'elgg_menus');
	}
	
	
	// Get custom menu only, for editing (if menu already exists as custom, replace system menu with custom)
	if (in_array($menu_name, $custom_menus)) {
		// Clear system menu so we can edit additions only
		$CONFIG->menus[$menu_name] = array();
		// Set up new menu
		elgg_menus_setup_menu($menu_name);
	}
	
	// Update menu selector
	$menu_opts = elgg_menus_menus_opts($menu_name);
	
}



// MAIN FORMS : SELECT, ADD, EDIT, REMOVE

// New menu form
$content .= '<form style="float:right;" id="menu-editor-form-new">';
$content .= 'ou <label>' . elgg_echo('elgg_menus:new') . elgg_view('input/text', array('name' => "menu_name", 'placeholder' => elgg_echo('elgg_menus:name'), 'style' => "width:12ex; margin-right:1ex;")) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:create')));
$content .= '</form>';

// Existing menu select form
$content .= '<form id="menu-editor-form-select">';
//$content .= '<a href="?new_menu=yes" style="float:right;" class="elgg-button elgg-button-action">Créer un nouveau menu</a>';
$content .= '<label>' . elgg_echo('elgg_menus:selectedit') . ' ' . elgg_view('input/pulldown', array('name' => 'menu_name', 'options_values' => $menu_opts, 'value' => $menu_name)) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:select'), 'style' => 'float:none;'));
$content .= '</form>';
$content .= '<div class="clearfloat"></div><hr />';



// EDIT CUSTOM MENU CONFIGURATION
if ($menu_name) {
	
	// Display current menu (= updated or replaced)
	$content .= '<span id="menu-editor-preview" style="float:right; text-align:right;">';
	$content .= elgg_view('output/url', array(
			'text' => elgg_echo('elgg_menus:preview', array($menu_name)), 
			'href' => elgg_get_site_url() . "elgg_menus/preview/$menu_name?embed=inner",
			'class' => 'elgg-lightbox elgg-button elgg-button-action',
			'style' => "margin:0;",
		));
	$content .= '<p><em>' . elgg_echo('elgg_menus:preview:details') . '</em></p>';
	$content .= '</span>';
	
	
	// MENU EDITOR FORM
	$content .= '<form id="menu-editor-form-edit" method="POST">';
	$content .= elgg_view('input/hidden', array('name' => 'menus_action', 'value' => 'edit'));
	
	//$content .= elgg_view('input/submit', array('value' => elgg_echo('save')));
	$content .= '<h2>' . elgg_echo('elgg_menus:edit:title') . '&nbsp;: ' . $menu_name . '</h2>';
	
	// Edition du titre du menu, si menu personnalisé
	$content .= '<div class="clearfloat"></div>';
	$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'name')) . '<p><label>' . elgg_echo('elgg_menus:name') . ' ' . elgg_view('input/text', array('name' => 'menu_name', 'value' => $menu_name, 'style' => "max-width:20ex;")) . '</label></p>';
	/*
	if (in_array($menu_name, $custom_menus)) {
	} else {
		$content .= elgg_view('input/hidden', array('name' => 'menu_name', 'value' => $menu_name));
	}
	*/
	$content .= '<div class="clearfloat"></div>';
	
	// Use custom menu if exists, else use system menu
	$menu = $CONFIG->menus[$menu_name];
	
	
	/* Options générales du menu */
	$content .= '<fieldset><legend>' . elgg_echo('elgg_menus:fieldset:menu_options') . '</legend>';
		$content .= '<div style="float:left; width:45%; margin:0;"';
			// CSS class
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_class')) . '<p><label>' . elgg_echo('elgg_menus:menu_class') . ' ' . elgg_view('input/text', array('name' => 'menu_class', 'value' => $menu_class, 'style' => "max-width:30ex;")) . '</label></p>';
			// URL handler
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_handler')) . '<p><label>' . elgg_echo('elgg_menus:menu_handler') . ' ' . elgg_view('input/text', array('name' => 'menu_handler', 'value' => $menu_handler, 'style' => "max-width:12ex;")) . '</label></p>';
		$content .= '</div>';
	
		$content .= '<div style="float:right; width:45%; margin:0;">';
			// Sort by
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_sort_by')) . '<p><label>' . elgg_echo('elgg_menus:menu_sort_by') . ' ' . elgg_view('input/text', array('name' => 'menu_sort_by', 'value' => $menu_sort_by, 'style' => "max-width:12ex;")) . '</label></p>';
			// Show section header
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_show_section_headers')) . '<p><label>' . elgg_echo('elgg_menus:menu_show_section_headers') . ' ' . elgg_view('input/dropdown', array('name' => 'menu_show_section_headers', 'value' => $menu_show_section_headers, 'options_values' => $ny_opt)) . '</label></p>';
		$content .= '</div>';
		$content .= '<div class="clearfloat"></div>';
	$content .= '</fieldset>';
	
	
	/* Structured menu edit (section group + tree + order) */
	$content .= '<fieldset><legend>' . elgg_echo('elgg_menus:fieldset:menu_items') . '</legend>';
		// Type de comportement : replace/merge (default merge for reserved/unset menus)
		$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'mode')) . '<p><label>' . elgg_echo('elgg_menus:mode') . ' ' . elgg_view('input/dropdown', array('name' => 'menu_mode', 'value' => $menu_mode, 'options_values' => $menu_mode_opt)) . '</label></p>';
		// Items à supprimer (mode merge)
		$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_remove')) . '<p><label>' . elgg_echo('elgg_menus:menu_remove') . ' ' . elgg_view('input/text', array('name' => 'menu_remove', 'value' => $menu_remove, 'style' => "max-width:60ex;")) . '</label></p>';
		
		/* Edit structured menu items */
		$content .= '<p><label>' . elgg_echo('elgg_menus:edit:items') . '</label><br /><em>' . elgg_echo('elgg_menus:edit:items:details') . '</em></p>';
		
		// System menu / custom menu / new_menu
		if (in_array($menu_name, $custom_menus)) {
			$content .= '<p><blockquote>' . elgg_echo('elgg_menus:edit:custom_menu:details') . '</blockquote></p>';
		} else if (!$menu) {
			$content .= '<p><blockquote>' . elgg_echo('elgg_menus:edit:new_menu:details') . '</blockquote></p>';
		} else {
			$content .= '<p><blockquote>' . elgg_echo('elgg_menus:edit:system_menu:details') . '</blockquote></p>';
		}
		
		//$menu = elgg_trigger_plugin_hook('register', "menu:$menu_name", $vars, $menus[$menu_name]);
		$builder = new ElggMenuBuilder($menu);
		$menu = $builder->getMenu($sort_by);
		if ($menu) {
			foreach ($menu as $section_name => $section_items) {
				$content .= '<fieldset class="elgg-menus-section"><legend>' . elgg_echo('elgg_menus:section') . '&nbsp;: ' . $section_name . '</legend>';
					$content .= '<div class="menu-editor-items">';
					foreach ($section_items as $menu_item) {
						if (!($menu_item instanceof ElggMenuItem)) continue;
						$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => $menu_item));
					}
					$content .= '</div>';
					// Placeholder for new items
					$content .= '<div id="menu-editor-newitems" class="menu-editor-items"></div>';
				$content .= '</fieldset>';
			}
		} else {
			// Default section + new menu item
			$content .= '<fieldset class="elgg-menus-section"><legend>' . elgg_echo('elgg_menus:section') . '&nbsp;: default</legend>';
				$content .= '<div class="menu-editor-items">';
				// Entrée par défaut si aucune n'existe encore et que le menu n'existe pas déjà
				if (!in_array($menu_name, $custom_menus)) {
					$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => false, 'id' => 'menu-editor-newitem'));
				}
				$content .= '</div>';
				// Placeholder for new items
				$content .= '<div id="menu-editor-newitems" class="menu-editor-items"></div>';
			$content .= '</fieldset>';
		}
	
		// Ajout de section : pas forcément utile car déterminé via champ texte...
		// Ou alors on créé les sections avant et on drop dans la bonne section...?
		$content .= '<h3>' . elgg_echo('elgg_menus:edit:newsection') . '</h3>';
		$content .= '<p>' . elgg_echo('elgg_menus:edit:newsection:details') . '</p.>';
		//$content .= '<p><a href="javascript:void(0)," onClick="$(\'#menu-editor-form-edit\').append(\'<fieldset><legend>TEST</legend></fieldset>\');" class="elgg-button elgg-button-action">' . elgg_echo('elgg_menus:edit:newsection') . '</a></p>';
		
		// Ajout nouvelle entrée de menu
		$content .= '<h3>' . elgg_echo('elgg_menus:edit:newitem') . '</h3>';
		$content .= elgg_view('input/button', array(
				'id' => 'menu-editor-add-item',
				'value' => elgg_echo('elgg_menus:edit:newitem'),
				'class' => 'elgg-button elgg-button-action',
			));
		
	$content .= '</fieldset>';
	
	$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:save'), 'class' => "elgg-button elgg-button-submit"));
	$content .= '</form>';
	$content .= '<div class="clearfloat"></div>';
	
	
	// Custom menu delete form
	$content .= '<form id="menu-editor-form-delete" method="POST">';
		$content .= elgg_view('input/hidden', array('name' => 'menu_name', 'value' => $menu_name));
		$content .= elgg_view('input/hidden', array('name' => 'menus_action', 'value' => "delete"));
		$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:delete'), 'class' => "elgg-button elgg-button-delete"));
	$content .= '</form>';
	
}



echo '<div id="menu-editor-admin">';
echo $content;
echo '</div>';


/* @TODO Enable parent/children structure and reordering */

/* @TODO Enable direct menu item form fields update after reordering :
 * - update section
 * - update weight
 * - parent_name
 */
?>

<script type="text/javascript">
$(document).ready(function(){
	$(".menu-editor-items").sortable({ // initialisation de Sortable sur le container parent
		placeholder: 'menu-editor-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.menu-editor-items', 
		// Custom callback function
		update: function(event, ui) {
			/*
			var priority = ui.item.val();
			var section = ui.item.children('input[name*="section"]').val();
			alert("Priority="+priority+" - Section="+section);
			ui.item.children('input[name*="priority"]').val("500");
			ui.item.children('input[name*="section"]').val("default");
			*/
			console.log(ui.item);
			//console.log(event);
			//ui.item
			// Changement d'ordre : priorité entre celle des entrées suivante et précédente 
			// (au moins identique à celle entrée précédente, car l'ordre sera conservé, de facto si on enregistre dans l'ordre)
			
			// Changement de contexte : default si default ou vide
		}
	});
});
</script>

