<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

admin_gatekeeper();

$title = "Prévisualisation des menus";

$content = "";

$name = get_input('menu', 'topbar');
$embed = get_input('embed');

$menus = elgg_get_config('menus');
$builder = new ElggMenuBuilder($menus[$name]);
$menu = $builder->getMenu($name);

$content .= '<div style="width:980px; max-width:100%; min-height:100px; background:white;">';
/*
$params = array('name' => $name, 'menu' => $menu);
$content .= elgg_view('navigation/menu/default', $params);
*/
// Besoin de lancer l'affichage pour avoir le menu complet
$dummy = elgg_view_menu($name);
$content .= elgg_view_menu($name);
$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

// Idem sur fond noir
$content .= '<div style="width:980px; max-width:100%; min-height:100px; background:black;">';
$content .= elgg_view_menu($name);
$content .= '<div class="clearfloat"></div>';
$content .= '</div>';


// Render the page
//$content = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));
if ($embed) {
	if ($embed == 'full') echo elgg_view_page($title, $content, 'iframe');
	else echo elgg_view_page($title, $content, 'iframe');
} else {
	echo elgg_view_page($title, $content);
}


