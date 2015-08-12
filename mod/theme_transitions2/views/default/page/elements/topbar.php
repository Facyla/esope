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
