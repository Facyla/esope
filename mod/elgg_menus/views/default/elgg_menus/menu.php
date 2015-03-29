<?php
/**
* Elgg renders custom menu
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2015
* @link http://id.facyla.fr/
*/

$name = elgg_extract('menu', $vars);
if (!$name) return;

$config_data = elgg_get_plugin_setting("menu-$name", 'elgg_menus');
if ($config_data) {
	$config = unserialize($menu_config_data);
	$class = $menu_config['class'];
	$sort_by = $menu_config['sort_by'];
	$handler = $menu_config['handler'];
	$show_section_headers = $menu_config['show_section_headers'];
}

// @TODO : si vue d'affichage du menu existe, l'utiliser

// Sinon on définit nos propres paramètres et on l'affiche

$menus = elgg_get_config('menus');
$menu = $menus[$name];
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu($sort_by);


$content .= '<div class="elgg-menu elgg-menu-' . $name . ' elgg-menu-' . $name . '-' . $section . ' ' . $class . '">';
$content .= elgg_view_menu($name);
$content .= '<div class="clearfloat"></div>';
$content .= '</div>';


