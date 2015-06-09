<?php
// Init custom CMS header and menu (based on categories)
//cmspages_set_categories_menu();


// Get direct setting from view
$cms_header = elgg_extract('header', $vars, '');
// Fallback to global setting if cmspage doesn't define any cutom setting
if (empty($cms_header)) { $cms_header = elgg_get_plugin_setting('cms_header', 'cmspages'); }
// If nothing defined (no custom nor global config), use site default
if (empty($cms_header)) $cms_header = 'initial';

// Render header
if (!empty($cms_header)) {
	switch ($cms_header) {
		// No header
		case 'no': break;
		// Initial site header
		case 'initial': echo elgg_view('adf_platform/adf_header'); break;
		// Some custom cmspage
		default: echo elgg_view('cmspages/view', array('pagetype' => $cms_header));
	}
}



// Get direct setting
$cms_menu = elgg_extract('menu', $vars, '');
// Fallback to global setting
if (empty($cms_menu)) { $cms_menu = elgg_get_plugin_setting('cms_menu', 'cmspages'); }
if ($cms_menu == 'no') { return; }
// Render menu
if (elgg_is_active_plugin('elgg_menus')) {
	if (empty($cms_menu)) {
		$menu = elgg_view_menu('cmspages_categories', array('class' => 'elgg-menu-hz menu-navigation', 'sort_by' => 'weight'));
	} else {
		//$menu = elgg_view('elgg_menus/menu', array('name' => $cms_menu, 'class' => 'elgg-menu-hz menu-navigation'));
		$menu = elgg_view_menu($cms_menu, array('class' => 'elgg-menu-hz menu-navigation', 'sort_by' => 'weight'));
	}
} else {
	// Default to categories (if menu enabled)
	$menu = elgg_view_menu('cmspages_categories', array('class' => 'elgg-menu-hz menu-navigation', 'sort_by' => 'weight'));
}
if (!empty($menu)) {
	echo '<div id="transverse"><div class="interne"><nav>';
	echo $menu;
	echo '</nav></div></div>';
}

