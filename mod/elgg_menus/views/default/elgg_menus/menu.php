<?php
/**
* Elgg renders custom menu
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2015
* @link http://id.facyla.fr/
*/

$menu_name = elgg_extract('menu_name', $vars);
if (!$menu_name) $menu_name = elgg_extract('name', $vars);
if (!$menu_name) return;


// Prepare menu config vars
$menu_config = elgg_menus_get_menu_config($menu_name);
if ($menu_config) {
	// Use menu config as defaults, but allow to override with view call vars (if not empty)
	if (empty($vars['sort_by'])) $vars['sort_by'] = $menu_config['sort_by'];
	if (empty($vars['class'])) $vars['class'] = $menu_config['class'];
	if (empty($vars['item_class'])) $vars['item_class'] = $menu_config['item_class'];
	if (empty($vars['show_section_headers'])) $vars['show_section_headers'] = $menu_config['show_section_headers'];
}


/*
$menus = elgg_get_config('menus');
$menu = $menus[$name];
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu($sort_by);
*/


// @TODO : add a mobile toggle if we have more than 1 menu entry
// <div class="menu-topbar-toggle"><i class="fa fa-bars"></i> <?php echo elgg_echo('esope:menu:topbar'); ?></div>

// Render menu
//echo '<div class="elgg-menu elgg-menu-' . $name . ' elgg-menu-' . $name . '-' . $section . ' ' . $class . '">';
echo elgg_view_menu($menu_name, $vars);
//echo '<div class="clearfloat"></div>';
//echo '</div>';

