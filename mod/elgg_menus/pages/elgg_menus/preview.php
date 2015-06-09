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

$menu_name = get_input('menu', 'topbar');
$embed = get_input('embed');


// Pass menu name to the view
$vars['menu_name'] = $menu_name;


//$content .= "CONFIG : {$vars['sort_by']} / {$vars['class']} / {$vars['item_class']} / {$vars['show_section_headers']}<br />";

// Besoin de lancer l'affichage (n'importe quel elgg_view) pour avoir le menu complet (passage de pagesetup)
$dummy = elgg_view('dummy');

// Sur fond blanc
$content .= '<div style="width:980px; max-width:100%; min-height:100px; background:white;">';
$content .= elgg_view('elgg_menus/menu', $vars);
$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

// Idem sur fond noir
$content .= '<div style="width:980px; max-width:100%; min-height:100px; background:black;">';
$content .= elgg_view('elgg_menus/menu', $vars);
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


