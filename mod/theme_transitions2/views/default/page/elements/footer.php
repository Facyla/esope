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
echo elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => "elgg-menu-footer elgg-menu-footer-default clearfix elgg-menu-hz"));
