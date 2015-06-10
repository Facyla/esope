<?php
/**
 * Menus editor page
 * 
 * New menus : any menu (behaviour with existing ones can be specified)
 * Default menus : full replacement (by a new menu) OR Add items, + Remove items (remove listed names)
 * Export / Import menu(s)
 * 
 */

global $CONFIG;

$content = '';

$action_url = '';
$action_url = elgg_get_site_url() . 'action/elgg_menus/edit';

// Main action to be performed (edit|delete)
// Note : edit only when sending form, otherwise custom content will be erased
$menus_action = get_input('menus_action');

$menu_name = get_input('menu_name', false);
// Clean menu name, useful for new names
$menu_name = elgg_get_friendly_title($menu_name);

elgg_load_js('elgg.elgg_menus.edit');

$ny_opt = array('no' => elgg_echo('elgg_menus:settings:no'), 'yes' => elgg_echo('elgg_menus:settings:yes'));
// Modes du menu personnalisé
$menu_mode_opt = array('merge' => elgg_echo('elgg_menus:mode:merge'), 'replace' => elgg_echo('elgg_menus:mode:replace'), 'disabled' => elgg_echo('elgg_menus:mode:disabled'), 'clear' => elgg_echo('elgg_menus:mode:clear'));

$sort_by_opts = array('text' => elgg_echo('elgg_menus:sortby:text'), 'name' => elgg_echo('elgg_menus:sortby:name'), 'priority' => elgg_echo('elgg_menus:sortby:priority'), 'register' => elgg_echo('elgg_menus:sortby:register'), 'callback' => elgg_echo('elgg_menus:sortby:customcallback'));

// System menus
$system_menus = elgg_menus_get_system_menus();
// Custom menus
$custom_menus = elgg_menus_get_custom_menus();
// Sélecteur de menus
$menu_opts = elgg_menus_menus_opts($menu_name);

//$content .= "Custom $menu_name menu list : " . elgg_get_plugin_setting('menus', 'elgg_menus') . '<br />';
//$content .= "CUSTOM $menu_name : " . elgg_get_plugin_setting("menu-$menu_name", 'elgg_menus');



/* PROCESS MENU FORMS FIRST : EDIT MENUS, REMOVE MENU => see 'edit' action
 * IMPORT MENU(s) CONFIG : action OK
 * SAVE / EXPORT menu : action OK
 * EDIT $menu_name : action OK
 * DELETE $menu_name : action OK
 */


// Load menu config
if ($menu_name) {
	// If no form sent, get custom menu main config options
	$menu_config_data = elgg_get_plugin_setting("menu-$menu_name", 'elgg_menus');
	$menu_config = unserialize($menu_config_data);
	$menu_mode = $menu_config['mode'];
	$menu_remove = $menu_config['remove'];
	$menu_class = $menu_config['class'];
	$menu_sort_by = $menu_config['sort_by'];
	if (empty($menu_sort_by)) $menu_sort_by = 'priority';
	if (!isset($sort_by_opts[$menu_sort_by])) {
		$menu_sort_by_callback = $menu_sort_by;
		$menu_sort_by = 'callback';
	}
	$menu_sort_by_callback = $menu_config['sort_by_callback'];
	$menu_handler = $menu_config['handler'];
	$menu_show_section_headers = $menu_config['show_section_headers'];
	
	// Get custom menu only, for editing (if menu already exists as custom, replace system menu with custom to avoid duplicates)
	if (in_array($menu_name, $custom_menus)) {
		// Clear system menu so we can edit additions only
		$CONFIG->menus[$menu_name] = array();
		// Set up new menu
		elgg_menus_setup_menu($menu_name, 'replace');
	}
}


// MAIN FORMS : SELECT, ADD, EDIT, REMOVE

// NEW MENU form
$content .= '<form style="float:right;" id="menu-editor-form-new" method="GET">';
$content .= 'ou <label>' . elgg_echo('elgg_menus:new') . elgg_view('input/text', array('name' => "menu_name", 'placeholder' => elgg_echo('elgg_menus:name'), 'style' => "width:12ex; margin-right:1ex;")) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:create')));
$content .= '</form>';

// SELECT existing menu form
$content .= '<form id="menu-editor-form-select" method="GET">';
//$content .= '<a href="?new_menu=yes" style="float:right;" class="elgg-button elgg-button-action">Créer un nouveau menu</a>';
$content .= '<label>' . elgg_echo('elgg_menus:selectedit') . ' ' . elgg_view('input/pulldown', array('name' => 'menu_name', 'options_values' => $menu_opts, 'value' => $menu_name)) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:select'), 'style' => 'float:none;'));
$content .= '</form>';

$content .= '<div class="clearfloat"></div><br />';


// BACKUP OPTIONS : hide/show options
$content .= '<p><label><a href="javascript:void(0);" onClick="$(\'#elgg-menus-backups\').toggle();">' . elgg_echo('elgg_menus:backups') . ' &nbsp; <i class="fa fa-toggle-down"></i></a></label></p>';
$content .= '<div id="elgg-menus-backups" class="hidden">';
	
	// IMPORT menu(s) config form : text backup file, with menu_name::serialized_config (one per line)
	// Display import form
	$import_form .= '<h3>' . elgg_echo('elgg_menus:import:title') . '</h3>';
	$import_form .= '<p><em>' . elgg_echo('elgg_menus:import:title:details') . '</em></p>';
	$import_form .= '<form action="' . $action_url . '?menus_action=import" enctype="multipart/form-data" method="POST">';
	$import_form .= elgg_view('input/securitytoken');
	$import_form .= '<label>' . elgg_echo('elgg_menus:import:backup_file') . elgg_view('input/file', array('name' => 'backup_file')) . '</label>';
	$import_form .= ' &nbsp; ';
	$import_form .= '<label>' . elgg_echo('elgg_menus:import:filter') . elgg_view('input/text', array('name' => 'menu_name', 'value' => $menu_name, 'style' => 'width:20ex;')) . '</label><br /><em>' . elgg_echo('elgg_menus:import:filter:details') . '</em>';
	$import_form .= elgg_view('input/hidden', array('name' => 'menus_action', 'value' => 'import'));
	/// Display submit button
	$import_form .= elgg_view('input/submit', array('value' => elgg_echo('import')));
	$import_form .= '</form>';
	$content .= $import_form;
	$content .= '<div class="clearfloat"></div>';
	
	// SAVE / EXPORT menu form (links)
	$content .= '<h3>' . elgg_echo('elgg_menus:export:title') . '</h3>';
	$content .= '<p><em>' . elgg_echo('elgg_menus:export:title:details') . '</em></p>';
	$export_url = elgg_add_action_tokens_to_url($action_url) . '&menus_action=export';
	$content .= '<a href="' . $export_url . '" class="elgg-button elgg-button-action">' . elgg_echo('elgg_menus:export:all_menus') . '</a>';
	if ($menu_name) {
		$export_url .= elgg_add_action_tokens_to_url($action_url) . '&menu_name=' . $menu_name;
		$content .= '<a href="' . $export_url . '" class="elgg-button elgg-button-action">' . elgg_echo('elgg_menus:export:menu', array($menu_name)) . '</a>';
	}
	$content .= '<div class="clearfloat"></div>';
	
$content .= '</div></fieldset>';
$content .= '<hr />';



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
	$content .= '<form action="' . $action_url . '" id="menu-editor-form-edit" method="POST">';
	$content .= elgg_view('input/securitytoken');
	$content .= elgg_view('input/hidden', array('name' => 'menus_action', 'value' => 'edit'));
	
	//$content .= elgg_view('input/submit', array('value' => elgg_echo('save')));
	$content .= '<h2>' . elgg_echo('elgg_menus:edit:title') . '&nbsp;: ' . $menu_name . '</h2>';
	
	// Edition du titre du menu, si menu personnalisé
	$content .= '<div class="clearfloat"></div>';
	$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'name')) . '<p><label>' . elgg_echo('elgg_menus:name') . ' ' . elgg_view('input/text', array('name' => 'menu_name', 'value' => $menu_name, 'style' => "width:20ex;")) . '</label></p>';
	$content .= '<div class="clearfloat"></div>';
	
	// Use custom menu if exists, else use system menu
	$menu = $CONFIG->menus[$menu_name];
	//$content .= '<pre>' . print_r($menu, true) . '</pre>'; // debug
	
	/* Options générales du menu */
	$content .= '<fieldset><legend>' . elgg_echo('elgg_menus:fieldset:menu_options') . '</legend>';
	$content .= '<p><em>' . elgg_echo('elgg_menus:fieldset:menu_options:details') . '</em></p>';
		$content .= '<div style="float:left; width:46%; margin:0;">';
			// CSS class
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_class')) . '<p><label>' . elgg_echo('elgg_menus:menu_class') . ' ' . elgg_view('input/text', array('name' => 'menu_class', 'value' => $menu_class, 'style' => "max-width:30ex;")) . '</label></p>';
			// URL handler
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_handler')) . '<p><label>' . elgg_echo('elgg_menus:menu_handler') . ' ' . elgg_view('input/text', array('name' => 'menu_handler', 'value' => $menu_handler, 'style' => "max-width:12ex;")) . '</label></p>';
		$content .= '</div>';
	
		$content .= '<div style="float:right; width:46%; margin:0;">';
			// Sort by : use select + alternate text function
			$content .= elgg_view('elgg_menus/help_popup', array('style' => "float:left;", 'key' => 'menu_sort_by')) . '<p><label>' . elgg_echo('elgg_menus:menu_sort_by') . ' ' . elgg_view('input/dropdown', array('name' => 'menu_sort_by', 'value' => $menu_sort_by, 'options_values' => $sort_by_opts, 'style' => "max-width:12ex;")) . ' ' . elgg_view('input/text', array('name' => 'menu_sort_by_callback', 'value' => $menu_sort_by_callback, 'style' => "max-width:12ex;", 'placeholder' => elgg_echo('elgg_menus:sortby:customcallback:placeholder'))) . '</label></p>';
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
		
		if ($menu) {
			//$menu = elgg_trigger_plugin_hook('register', "menu:$menu_name", $vars, $menus[$menu_name]);
			$builder = new ElggMenuBuilder($menu);
			$menu = $builder->getMenu($menu_sort_by);
			foreach ($menu as $section_name => $section_items) {
				$content .= '<fieldset class="elgg-menus-section" data-section="' . $section_name . '"><legend>' . elgg_echo('elgg_menus:section') . '&nbsp;: ' . $section_name . '</legend>';
					$content .= '<div class="menu-editor-items">';
					foreach ($section_items as $menu_item) {
						if (!($menu_item instanceof ElggMenuItem)) continue;
						$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => $menu_item));
					}
					$content .= '</div>';
				$content .= '</fieldset>';
			}
			// Placeholder for new sections
			$content .= '<div id="menu-editor-newsections"></div>';
			// Placeholder for new items (after the existing sections)
			$content .= '<div id="menu-editor-newitems" class="menu-editor-items"></div>';
		} else {
			// NO MENU YET : Default section + new menu item
			$content .= '<fieldset class="elgg-menus-section"><legend>' . elgg_echo('elgg_menus:section') . '&nbsp;: default</legend>';
				$content .= '<div class="menu-editor-items">';
				// Entrée par défaut si aucune n'existe encore et que le menu n'existe pas déjà
				if (!in_array($menu_name, $custom_menus)) {
					$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => false, 'id' => 'menu-editor-newitem'));
				}
				$content .= '</div>';
			$content .= '</fieldset>';
			// Placeholder for new sections
			$content .= '<div id="menu-editor-newsections"></div>';
			// Placeholder for new items
			$content .= '<div id="menu-editor-newitems" class="menu-editor-items"></div>';
		}
		
		
		// Ajout nouvelle entrée de menu
		$content .= '<div style="width:46%; float:left;">';
		$content .= '<h3>' . elgg_echo('elgg_menus:edit:newitem') . '</h3>';
		$content .= '<em>' . elgg_echo('elgg_menus:edit:newitem:details') . '</em><br />';
		$content .= elgg_view('input/button', array(
				'id' => 'menu-editor-add-item',
				'value' => elgg_echo('elgg_menus:edit:newitem'),
				'class' => 'elgg-button elgg-button-action',
			));
		$content .= '</div>';
		
		$content .= '<div style="width:46%; float:right;">';
		// Ajout de section : pas forcément utile car déterminé via champ texte...
		// Ou alors on créé les sections avant et on drop dans la bonne section...?
		// dans ce cas il faut pouvoir donner un nom à cette section
		$content .= '<h3>' . elgg_echo('elgg_menus:edit:newsection') . '</h3>';
		$content .= '<em>' . elgg_echo('elgg_menus:edit:newsection:details') . '</em><br />';
		$new_fieldset_prompt = str_replace("'", "\'", elgg_echo('elgg_menus:edit:newsection:prompt'));
		$content .= elgg_view('input/button', array(
				'id' => 'menu-editor-add-section',
				'value' => elgg_echo('elgg_menus:edit:newsection'),
				'class' => 'elgg-button elgg-button-action',
			));
		$content .= '</div>';
		
		
	$content .= '</fieldset>';
	
	$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:save'), 'class' => "elgg-button elgg-button-submit"));
	$content .= '</form>';
	$content .= '<div class="clearfloat"></div>';
	
	
	// Custom menu delete form
	$content .= '<form action="' . $action_url . '" id="menu-editor-form-delete" method="POST">';
		$content .= elgg_view('input/securitytoken');
		$content .= elgg_view('input/hidden', array('name' => 'menu_name', 'value' => $menu_name));
		$content .= elgg_view('input/hidden', array('name' => 'menus_action', 'value' => "delete"));
		$content .= elgg_view('input/submit', array('value' => elgg_echo('elgg_menus:menu:delete', array($menu_name)), 'class' => "elgg-button elgg-button-delete"));
	$content .= '</form>';
	
}

// Add parent/children structure and reordering : see menu edit JS
?>

<div id="menu-editor-admin">
	<?php echo $content; ?>
</div>


