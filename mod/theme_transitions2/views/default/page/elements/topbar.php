<?php
/**
 * Elgg topbar
 * The standard elgg top toolbar
 */

// Elgg logo
// Transitions² : use custom site menu
$menu = elgg_get_plugin_setting('menu_topbar', 'theme_transitions2');
if (empty($menu)) $menu = 'topbar';
echo elgg_view_menu($menu, array('sort_by' => 'priority', array('elgg-menu-hz'), 'class' => "elgg-menu-topbar elgg-menu-topbar-default clearfix"));

// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);

// Dropdown login box
$login_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
	$login_url = str_replace("http:", "https:", elgg_get_site_url());
}
$login_dropdown = elgg_view_form('login', array('action' => "{$login_url}action/login"), array('returntoreferer' => TRUE));
echo elgg_view_module('dropdown', '', $login_dropdown, array('id' => 'login-dropdown-box')); 

