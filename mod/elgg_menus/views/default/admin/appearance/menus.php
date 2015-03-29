<?php
/**
* Elgg menus
* 
* Menus editor page
* New menus : any menu except reserved ones
* Reserved menus : custom menu + behavior = full replacement (by a new menu) OR Add items, + Remove items (remove listed names)
* 
*/

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

$menu_name = get_input('menu_name', false);
// Clean menu name, useful for new names
$menu_name = elgg_get_friendly_title($menu_name);

elgg_load_js('elgg.elgg_menus.edit');

// Tous les menus actuels (y compris personnalisés)...
$menus = elgg_get_config('menus');

$ny_opt = array('no' => elgg_echo('survey:settings:no'), 'yes' => elgg_echo('survey:settings:yes'));
// System menus
$system_menus = elgg_menus_get_system_menus();
// Custom menus
$custom_menus = elgg_menus_get_custom_menus();
// Sélecteur de menu
$menu_opts = elgg_menus_menus_opts($menu_name);
$menu_mode_opt = array('merge' => elgg_echo('elgg_menus:mode:merge'), 'replace' => elgg_echo('elgg_menus:mode:replace'));

// New menu form
$content .= '<form style="float:right;" id="menu-editor-form-new">';
$content .= 'ou <label>' . elgg_echo('elgg_menus:new') . elgg_view('input/text', array('name' => "menu_name", 'placeholder' => elgg_echo('elgg_menus:name'), 'style' => "width:12ex; margin-right:1ex;")) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('create')));
$content .= '</form>';

// Existing menu select form
$content .= '<form id="menu-editor-form-select">';
//$content .= '<a href="?new_menu=yes" style="float:right;" class="elgg-button elgg-button-action">Créer un nouveau menu</a>';
$content .= '<label>' . elgg_echo('elgg_menus:selectedit') . ' ' . elgg_view('input/pulldown', array('name' => 'menu_name', 'options_values' => $menu_opts, 'value' => $menu_name)) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('edit'), 'style' => 'float:none;'));
$content .= '</form>';
$content .= '<div class="clearfloat"></div><br />';


if ($menu_name) {
	
	// PROCESS POST form data => SAVE MENU CONFIG
	$new_name = get_input('name');
	//merge or replace mode
	$menu_mode = get_input('menu_mode', 'merge');
	// Entrées à retirer d'un menu pré-existant (si merge)
	$menu_remove = get_input('menu_remove');
	//class: string the class for the entire menu.
	$menu_class = get_input('menu_class');
	//sort_by => string or php callback string options: 'name', 'priority', 'title' (default), 'register' (registration order) or a php callback (a compare function for usort)
	$menu_sort_by = get_input('menu_sort_by', 'text');
	//handler: string the page handler to build action URLs entity: to use to build action URLs
	$menu_handler = get_input('menu_handler');
	//show_section_headers: bool show headers before menu sections.
	$menu_show_section_headers = get_input('menu_show_section_headers', 'no');
	
	// Count menu items from received items count
	$number_of_items = count($new_name);
	$count = 0;
	$new_items = array();
	if ($number_of_items) {
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
		// Name is the only required value for items
		for($i=0; $i<$number_of_items; $i++) {
			if ($new_name[$i]) {
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
				$new_items[] = array(
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
						// Adjust display order to received order
						//'display_order' => ($count + 1) * 10,
					);
				$count++;
			}
		}
		
		// Save custom menu configuration
		//$content .= '<pre>' . print_r($new_items, true) . '</pre>';
		$menu_config = array('name' => $menu_name, 'mode' => $menu_mode, 'class' => $menu_class, 'sort_by' => $menu_sort_by, 'handler' => $menu_handler, 'show_section_headers' => $menu_show_section_headers, 'items' => $new_items);
		$menu_config_data = serialize($menu_config);
		elgg_set_plugin_setting("menu-$menu_name", $menu_config_data, 'elgg_menus');
		// Add menu to custom menu list
		if (!in_array($menu_name, $custom_menus)) {
			$custom_menus[] = $menu_name;
			array_filter($custom_menus);
			$custom_menus_data = implode(',', $custom_menus);
			elgg_set_plugin_setting('menus', $custom_menus_data, 'elgg_menus');
		}
	}
	
	
	// GET AND SET CUSTOM MENU CONFIGURATION
	// Set up new menu
	elgg_menus_setup_menu($menu_name);
	
	// Update menus
	$menus = elgg_get_config('menus');
	//$content .= '<pre>' . print_r($menus[$menu_name], true) . '</pre>';
	
	
	// Display current menu (= updated or replaced)
	$content .= '<div id="menu-editor-preview" style="float:right;">';
	$content .= elgg_view('output/url', array(
			'text' => elgg_echo('elgg_menus:preview', array($menu_name)), 
			'href' => elgg_get_site_url() . "elgg_menus/preview/$menu_name?embed=inner",
			'class' => 'elgg-lightbox elgg-button elgg-button-action',
		));
	$content .= '</div>';
	
	
	// MENU EDITOR FORM
	$content .= '<form id="menu-editor-form-edit" method="POST">';
	
	//$content .= elgg_view('input/submit', array('value' => elgg_echo('save')));
	$content .= '<h2>' . elgg_echo('elgg_menus:edit:title') . '&nbsp;: ' . $menu_name . '</h2>';
	
	// Edition du titre du menu, si non réservé
	$content .= '<div class="clearfloat"></div>';
	//if (!in_array($menu_name, $system_menus)) {
	if (in_array($menu_name, $custom_menus)) {
		$content .= '<label>' . elgg_echo('elgg_menus:name') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'menu_name', 'value' => $menu_name, 'style' => "max-width:20ex;")) . '</label>';
	} else {
		$content .= elgg_view('input/hidden', array('name' => 'menu_name', 'value' => $menu_name));
	}
	
	// Options générales du menu
	// Type de comportement : replace/merge (default merge for reserved/unset menus)
	$menu_mode = "merge";
	if ($menu_config) $menu_mode = $menu_config['mode'];
	$content .= '<p><label>' . elgg_echo('elgg_menus:mode') . ' ' . elgg_view('input/dropdown', array('name' => 'menu_mode', 'value' => $menu_mode, 'options_values' => $menu_mode_opt)) . '</label><br /><em>' . elgg_echo('elgg_menus:mode:details') . '</em></p>';
	
	$menu_class = '';
	if ($menu_config) $menu_class = $menu_config['class'];
	$content .= '<p><label>' . elgg_echo('elgg_menus:menu_class') . ' ' . elgg_view('input/text', array('name' => 'menu_class', 'value' => $menu_class, 'style' => "max-width:40ex;")) . '</label><br /><em>' . elgg_echo('elgg_menus:menu_class:details') . '</em></p>';
	
	$menu_sort_by = 'priority';
	if ($menu_config) $menu_sort_by = $menu_config['sort_by'];
	$content .= '<p><label>' . elgg_echo('elgg_menus:menu_sort_by') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'menu_sort_by', 'value' => $menu_sort_by, 'style' => "max-width:12ex;")) . '</label><br /><em>' . elgg_echo('elgg_menus:menu_sort_by:details') . '</em></p>';
	
	$menu_handler = '';
	if ($menu_config) $menu_handler = $menu_config['handler'];
	$content .= '<p><label>' . elgg_echo('elgg_menus:menu_handler') . '&nbsp;: ' . elgg_view('input/text', array('name' => 'menu_handler', 'value' => $menu_handler, 'style' => "max-width:12ex;")) . '</label><br /><em>' . elgg_echo('elgg_menus:menu_handler:details') . '</em></p>';
	
	$menu_show_section_headers = 'no';
	if ($menu_config) $menu_show_section_headers = $menu_config['show_section_headers'];
	$content .= '<p><label>' . elgg_echo('elgg_menus:menu_show_section_headers') . '&nbsp;: ' . elgg_view('input/dropdown', array('name' => 'menu_show_section_headers', 'value' => $menu_show_section_headers, 'options_values' => $ny_opt)) . '</label><br /><em>' . elgg_echo('elgg_menus:menu_show_section_headers:details') . '</em></p>';
	
	
	// Structure the menu (section group + tree + order)
	$menu = $menus[$menu_name];
	/* Structured menu
	*/
	//$menu = elgg_trigger_plugin_hook('register', "menu:$menu_name", $vars, $menus[$menu_name]);
	$sort_by = elgg_extract('sort_by', $vars, 'priority'); // text, name, priority, register, ou callback php
	$builder = new ElggMenuBuilder($menu);
	$menu = $builder->getMenu($sort_by);
	//foreach ($menus[$menu_name] as $i => $menu_item) {
	/* Uncomment for Structured menu
	*/
	foreach ($menu as $section_name => $section_items) {
		$content .= '<fieldset><legend>' . elgg_echo('elgg_menus:section') . '&nbsp;: ' . $section_name . '</legend>';
		$content .= '<div class="menu-editor-items">';
		/* Uncomment for unstructured menu
		$content .= '<div class="menu-editor-items">';
		foreach ($menu as $menu_item) {
		*/
		foreach ($section_items as $menu_item) {
			if (!($menu_item instanceof ElggMenuItem)) continue;
			$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => $menu_item));
		}
		//$content .= '</div>';
	/* Uncomment for Structured menu
	*/
		$content .= '</div>';
		$content .= '</fieldset>';
	}
	
	$content .= '<div id="menu-editor-newitems" class="menu-editor-items"></div>';
	
	// Ajout entrée de menu
	$content .= '<h3>' . elgg_echo('elgg_menus:edit:newitem') . '</h3>';
	//$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => false, 'id' => 'menu-editor-newitem'));
	$content .= elgg_view('input/button', array(
			'id' => 'menu-editor-add-item',
			'value' => elgg_echo('elgg_menus:edit:newitem'),
			'class' => 'elgg-button elgg-button-action',
		));
	
	// Ajout de section : pas forcément utile car déterminé via champ texte...
	// Ou alors on créé les sections avant et on drop dans la bonne section...?
	$content .= '<h3>' . elgg_echo('elgg_menus:edit:newsection') . '</h3>';
	$content .= '<p>' . elgg_echo('elgg_menus:edit:newsection:details') . '</p.>';
	//$content .= '<p><a href="javascript:void(0)," onClick="$(\'#menu-editor-form-edit\').append(\'<fieldset><legend>TEST</legend></fieldset>\');" class="elgg-button elgg-button-action">' . elgg_echo('elgg_menus:edit:newsection') . '</a></p>';
	
	$content .= elgg_view('input/submit', array('value' => elgg_echo('save')));
	$content .= '</form>';
	$content .= '<div class="clearfloat"></div>';
	
}



echo '<div id="menu-editor-admin">';
echo $content;
echo '</div>';
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

