<?php
// Init custom CMS menu based on categories
//cmspages_set_categories_menu();

echo elgg_view('cmspages/view', array('pagetype' => 'cms-header'));

if (elgg_is_active_plugin('elgg_menus')) {
	// Get direct setting
	$cms_menu = elgg_extract('menu', $vars, '');
	// Fallback to global setting
	if (empty($cms_menu)) { $cms_menu = elgg_get_plugin_setting('cms_menu', 'cmspages'); }
	
	// Set up chosen menu
	if (empty($cms_menu) || ($cms_menu == 'cmspages_categories')) {
		$menu = elgg_view_menu('cmspages_categories', array('class' => 'elgg-menu-hz menu-navigation', 'sort_by' => 'weight'));
	} else {
		//$menu = elgg_view('elgg_menus/menu', array('name' => $cms_menu, 'class' => 'elgg-menu-hz menu-navigation'));
		$menu = elgg_view_menu($cms_menu, array('class' => 'elgg-menu-hz menu-navigation', 'sort_by' => 'weight'));
	}
}

echo '<div id="transverse"><div class="interne"><nav>';
echo $menu;
echo '</nav></div></div>';

