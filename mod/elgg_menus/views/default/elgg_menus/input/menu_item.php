<?php
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


$yn_opt = array('yes' => elgg_echo('elgg_menus:settings:yes'), 'no' => elgg_echo('elgg_menus:settings:no'));
$ny_opt = array('no' => elgg_echo('elgg_menus:settings:no'), 'yes' => elgg_echo('elgg_menus:settings:yes'));

$menu_item = elgg_extract('menu_item', $vars);
//echo '<pre>' . print_r($menu_item, true) . '</pre>'; // debug


$name = $text = $href = $section = $link_class = $item_class = $parent_name = $contexts = $title = $selected = $confirm = $data = $priority = '';
if ($menu_item instanceof ElggMenuItem) {
	$name = $menu_item->getName();
	$text = $menu_item->getText();
	$href = $menu_item->getHref();
	$section = $menu_item->getSection();
	$link_class = $menu_item->getLinkClass();
	$item_class = $menu_item->getItemClass();
	$parent_name = $menu_item->getParentName();
	$contexts = $menu_item->getContext();
	$title = $menu_item->getTooltip();
	$selected = $menu_item->getSelected();
	$confirm = $menu_item->getConfirmText();
	$data = '';
	$priority = $menu_item->getPriority();
}

$content .= '<div class="menu-editor-item">';

$content .= '<a href="javascript:void(0);" class="menu-editor-delete-item" title="' . elgg_echo('elgg_menus:delete') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';

$content .= '<a href="javascript:void(0);" class="menu-editor-toggle-details"><i class="fa fa-cog"></i>' . elgg_echo('elgg_menus:item:edit') . '</a>';
if ($menu_item) {
	//$content .= '<strong class="menu-editor-item-title">' . $text . ' (' . $name . ', ' . $priority . ') => ' . $href . '</strong>';
	$content .= '<strong class="menu-editor-item-title">' . $text . ' (' . $name . ') => ' . $href . '</strong>';
	$content .= '<div class="menu-editor-item-content hidden">';
} else {
	$content .= '<strong class="menu-editor-item-title"></strong>';
	$content .= '<div class="menu-editor-item-content">';
}

// Nommage des entrées : permettre de récupérer toute la liste sans devoir compter => variable[]
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:name')) . '<label>' . elgg_echo('elgg_menus:item:name') . ' ' . elgg_view('input/text', array('name' => "name[]", 'value' => $name, 'style' => "width:20ex;", 'required' => 'required')) . '</label>';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:text')) . '<label>' . elgg_echo('elgg_menus:item:text') . ' ' . elgg_view('input/text', array('name' => "text[]", 'value' => $text, 'style' => "width:30ex;")) . '</label>';
$content .= '<br />';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:title')) . '<label>' . elgg_echo('elgg_menus:item:title') . ' ' . elgg_view('input/text', array('name' => "title[]", 'value' => $title, 'style' => "width:60ex;")) . '</label>';
$content .= '<br />';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:href')) . '<label>' . elgg_echo('elgg_menus:item:href') . ' ' . elgg_view('input/text', array('name' => "href[]", 'value' => $href, 'style' => "width:60ex;")) . '</label>';
$content .= '<br />';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:confirm')) . '<label>' . elgg_echo('elgg_menus:item:confirm') . ' ' . elgg_view('input/text', array('name' => "confirm[]", 'value' => $confirm, 'style' => "width:60ex;")) . '</label>';
$content .= '<br />';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:contexts')) . '<label>' . elgg_echo('elgg_menus:item:contexts') . ' ' . elgg_view('input/text', array('name' => "contexts[]", 'value' => $contexts, 'style' => "width:40ex;")) . '</label>';
$content .= '<br />';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:item_class')) . '<label>' . elgg_echo('elgg_menus:item:item_class') . ' ' . elgg_view('input/text', array('name' => "item_class[]", 'value' => $item_class, 'style' => "width:30ex;")) . '</label>';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:link_class')) . '<label>' . elgg_echo('elgg_menus:item:link_class') . ' ' . elgg_view('input/text', array('name' => "link_class[]", 'value' => $link_class, 'style' => "width:30ex;")) . '</label>';
$content .= '<br />';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:section')) . '<label>' . elgg_echo('elgg_menus:item:section') . ' ' . elgg_view('input/text', array('name' => "section[]", 'value' => $section, 'style' => "width:12ex;")) . '</label>';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:parent_name')) . '<label>' . elgg_echo('elgg_menus:item:parent_name') . ' ' . elgg_view('input/text', array('name' => "parent_name[]", 'value' => $parent_name, 'style' => "width:20ex;")) . '</label>';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:priority')) . '<label>' . elgg_echo('elgg_menus:item:priority') . ' ' . elgg_view('input/text', array('name' => "priority[]", 'value' => $priority, 'style' => "width:6ex;")) . '</label>';
$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:selected')) . '<label>' . elgg_echo('elgg_menus:item:selected') . ' ' . elgg_view('input/dropdown', array('name' => "selected[]", 'value' => $selected, 'options_values' => $ny_opt)) . '</label>';

$content .= '</div>';


// Submenu ?   Add sub-level items, or add placeholder for submenu
if (($menu_item instanceof ElggMenuItem) && ($children = $menu_item->getChildren())) {
	$content .= '<div class="menu-editor-items">';
	foreach ($children as $child) {
		$content .= elgg_view('elgg_menus/input/menu_item', array('menu_item' => $child));
	}
	$content .= '</div>';
} else {
	// Placeholder for submenu
	$content .= '<div class="menu-editor-items"></div>';
}

$content .= '</div>';

// Render menu item
echo $content;



