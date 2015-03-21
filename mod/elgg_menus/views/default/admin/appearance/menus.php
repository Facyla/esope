<?php
/**
* Elgg menus
* 
* Menus editor page
* 
*/

$content = '';

global $CONFIG;
$menus = $CONFIG->menus;
$menu_name = get_input('menu_name', false);
$new_menu = get_input('new_menu', false);

// Site default menus
$reserved_menus = array('page', 'topbar', 'site', 'extras', 'embed', 'footer', 'filter', 'admin', 'title', 'admin_title');

// Sélecteur de menu
$menu_opts = array('' => '');
foreach ($menus as $name => $menu_items) { $menu_opts[$name] = $name; }
$content .= '<form>';
$content .= '<p>';
$content .= '<a href="?new_menu=yes" style="float:right;" class="elgg-button elgg-button-action">Créer un nouveau menu</a>';
$content .= '<label>Menu à éditer ' . elgg_view('input/pulldown', array('name' => 'menu_name', 'options_values' => $menu_opts, 'value' => $menu_name)) . '</label>';
$content .= elgg_view('input/submit', array('value' => elgg_echo('select'), 'style' => 'float:none;'));
$content .= '</p>';
$content .= '</form>';
$content .= '<div class="clearfloat"></div>';


if ($new_menu) {
	$content .= '<form>';
	$content .= '<h2>Créer un nouveau menu</h2>';
	$content .= elgg_view('input/hidden', array('name' => "new_menu", 'value' => "yes"));
	$content .= '<label>Menu name ' . elgg_view('input/text', array('name' => "menu_name", 'placeholder' => "Identifiant du menu", 'value' => $menu_name)) . '</label>';
	$content .= elgg_view('input/submit', array('value' => elgg_echo('submit')));
	$content .= '</form>';
	$content .= '<div class="clearfloat"></div>';
}

if ($menu_name) {
	$content .= '<form>';
	$content .= elgg_view('input/submit', array('value' => elgg_echo('Save menu')));
	$content .= '<h2>Edition du menu : ' . $menu_name . '</h2>';
	$content .= '<div class="clearfloat"></div>';
	if (!in_array($menu_name, $reserved_menus)) {
		$content .= '<label>Menu name : ' . $menu_name . '</label>';
	}
	
	
	$menu = elgg_trigger_plugin_hook('register', "menu:$menu_name", $vars, $menus[$menu_name]);
	$sort_by = elgg_extract('sort_by', $vars, 'priority'); // text, name, priority, register, ou callback php
	$builder = new ElggMenuBuilder($menu);
	$menu = $builder->getMenu($sort_by);
	
	//foreach ($menus[$menu_name] as $i => $menu_item) {
	foreach ($menu as $section_name => $section_items) {
		$content .= '<fieldset><legend>Section : ' . $section_name . '</legend>';
		$content .= '<div class="menu-editor-items">';
		foreach ($section_items as $i => $menu_item) {
			if (!($menu_item instanceof ElggMenuItem)) continue;
			$content .= '<div class="menu-editor-item" id="menu-editor-item-' . $menu_name . '-' . $i . '">';
				$content .= '<a href="javascript:void(0);" onClick="$(\'#menu-editor-item-' . $menu_name . '-' . $i . ' .menu-editor-item-content\').toggle();" style="float:right;"><i class="fa fa-toggle-down"></i> Edition</a>';
				//$content .= '<pre>' . print_r($menu_item, true) . '</pre>' . '</label>';
				$content .= '<strong>' . $menu_item->getPriority() . ' - ' . $menu_item->getName() . ' : ' . $menu_item->getHref() . '</strong>';
				$content .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
				$content .= '<div class="menu-editor-item-content">';
					$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getName())) . '</label>';
					$content .= '<label>URL ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getHref())) . '</label>';
					$content .= '<label>Text ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getText())) . '</label>';
					$content .= '<label>Tooltip ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getTooltip())) . '</label>';
					$content .= '<label>Confirm ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getConfirmText())) . '</label>';
					$content .= '<label>Item class ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getItemClass())) . '</label>';
					$content .= '<label>Link class ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getLinkClass())) . '</label>';
					$content .= '<label>Section ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getSection())) . '</label>';
					$content .= '<label>Priority ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getPriority())) . '</label>';
					$content .= '<label>Context ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getContext())) . '</label>';
					$content .= '<label>Selected ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getSelected())) . '</label>';
					$content .= '<label>Parent name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getParentName())) . '</label>';
					$content .= '<label>Parent ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getParent())) . '</label>';
					$content .= '<label>Children ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getChildren())) . '</label>';
				$content .= '</div>';
			$content .= '</div>';
		}
		$content .= '</div>';
		$content .= '</fieldset>';
	}
	$content .= '</form>';
}

/*
foreach ($menus as $name => $menu_items) {
	$content .= '<h3>' . $name . '</h3>';
	foreach ($menu_items as $name => $menu_item) {
		//$content .= '<pre>' . print_r($menu_item, true) . '</pre>' . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->name . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->contexts . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->section . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->priority . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->selected . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->parent_name . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->parent . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->children . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->itemClass . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->linkClass . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getText())) . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getHref())) . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getTooltip())) . '</label>';
		$content .= '<label>Name ' . elgg_view('input/text', array('name' => "", 'value' => $menu_item->getConfirmText();
	}
}
*/


echo '<div id="menu-editor-admin">';
echo $content;
echo '</div>';
?>

<script type="text/javascript">
$(document).ready(function(){
	$(".menu-editor-items").sortable({ // initialisation de Sortable sur le container parent
		placeholder: 'menu-editor-highlight', // classe du placeholder ajouté lors du déplacement
		// Custom callback function
		update: function( event, ui ) {
			
		}
	});
});
</script>

