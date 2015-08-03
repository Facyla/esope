<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

// Transitions² : use custom menu
$menu = elgg_get_plugin_setting('menu_footer', 'theme_transitions2');
if (empty($menu)) $menu = 'footer';

// Get translated menu, only if exists
$lang = get_language();
$lang_menu = elgg_menus_get_menu_config($menu . '_' . $lang);
if ($lang_menu) $menu = $menu . '_' . $lang;

echo elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => "elgg-menu-footer elgg-menu-footer-default clearfix elgg-menu-hz"));
echo '<div class="clearfloat"></div>';
echo elgg_view('cmspages/view', array('pagetype' => "footer"));

