<?php
/**
 * Elgg primary CSS view
 *
 * @package Elgg.Core
 * @subpackage UI
 */

/* 
 * Colors:
 *  #4690D6 - elgg light blue
 *  #0054A7 - elgg dark blue
 *  #e4ecf5 - elgg very light blue
 */

// check if there is a theme overriding the old css view and use it, if it exists
if (elgg_view_exists('css')) {
	// note: _elgg_services is private API, DO NOT USE.
	$old_css_view = _elgg_services()->views->getViewLocation('css');
	if ($old_css_view != elgg_get_config('viewpath')) {
		echo elgg_view('css', $vars);
		return true;
	}
}

// ESOPE : Configurable elements : pass theme as $vars['theme-config-css']
$url = elgg_get_site_url();
// Image de fond du header
$headerimg = elgg_get_plugin_setting('headerimg', 'esope');
if (!empty($headerimg)) $headerimg = $url . $headerimg;
$backgroundcolor = elgg_get_plugin_setting('backgroundcolor', 'esope');
$backgroundimg = elgg_get_plugin_setting('backgroundimg', 'esope');
if (!empty($backgroundimg)) $backgroundimg = $url . $backgroundimg;
// Couleur des titres
$titlecolor = elgg_get_plugin_setting('titlecolor', 'esope');
$textcolor = elgg_get_plugin_setting('textcolor', 'esope');
// Couleur des liens
$linkcolor = elgg_get_plugin_setting('linkcolor', 'esope');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'esope');
// Couleur 1 : Haut dégradé header
$color1 = elgg_get_plugin_setting('color1', 'esope');
// Couleur 4 : Bas dégradé header
$color4 = elgg_get_plugin_setting('color4', 'esope');
// Couleur 2 : Haut dégradé widgets/modules
$color2 = elgg_get_plugin_setting('color2', 'esope');
// Couleur 3 : Bas dégradé widgets/modules
$color3 = elgg_get_plugin_setting('color3', 'esope');
// Couleur 5-8 : Dégradés des boutons + dégradé hover
$color5 = elgg_get_plugin_setting('color5', 'esope');
$color6 = elgg_get_plugin_setting('color6', 'esope');
$color7 = elgg_get_plugin_setting('color7', 'esope');
$color8 = elgg_get_plugin_setting('color8', 'esope');
// Divers tons de gris par défaut et éléments de l'interface
$color9 = elgg_get_plugin_setting('color9', 'esope'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'esope'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'esope'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'esope'); // #DEDEDE
// Couleur de fond du sous-menu déroulant
$color13 = elgg_get_plugin_setting('color13', 'esope');
// Module title
$color14 = elgg_get_plugin_setting('color14', 'esope');
// Button title
$color15 = elgg_get_plugin_setting('color15', 'esope');
// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'esope');
// Fonts
$font1 = elgg_get_plugin_setting('font1', 'esope');
$font2 = elgg_get_plugin_setting('font2', 'esope');
$font3 = elgg_get_plugin_setting('font3', 'esope');
$font4 = elgg_get_plugin_setting('font4', 'esope');
$font5 = elgg_get_plugin_setting('font5', 'esope');
$font6 = elgg_get_plugin_setting('font6', 'esope');
// @TODO : Force set fonts, for the moment
/*
$font1 = 'Lato, sans-serif';
$font2 = 'Lato-bold, sans-serif';
$font3 = 'Puritan, sans-serif';
$font4 = 'Puritan, Arial, sans-serif';
$font5 = 'Monaco, "Courier New", Courier, monospace';
$font6 = 'Georgia, times, serif';
*/

$vars['theme-config-css'] = array(
  'urlicon' => $url . 'mod/esope/img/theme/',
  'headerimg' => $headerimg,
  'backgroundcolor' => $backgroundcolor,
  'backgroundimg' => $backgroundimg,
  'titlecolor' => $titlecolor,
  'linkcolor' => $linkcolor,
  'linkhovercolor' => $linkhovercolor,
  'textcolor' => $textcolor,
  'color1' => $color1,
  'color2' => $color2,
  'color3' => $color3,
  'color4' => $color4,
  'color5' => $color5,
  'color6' => $color6,
  'color7' => $color7,
  'color8' => $color8,
  'color9' => $color9,
  'color10' => $color10,
  'color11' => $color11,
  'color12' => $color12,
  'color13' => $color13,
  'color14' => $color14,
  'color15' => $color15,
  'footercolor' => $footercolor,
  'font1' => $font1,
  'font2' => $font2,
  'font3' => $font3,
  'font4' => $font4,
  'font5' => $font5,
  'font6' => $font6,
);
/* Use in subsequent CSS views like this :
  // Get all needed vars
  $css = elgg_extract('theme-config-css', $vars);
  $urlicon = $css['urlicon'];
  $titlecolor = $css['titlecolor'];
  $linkcolor = $css['linkcolor'];
  $color1 = $css['color1'];
  $color2 = $css['color2'];
  $color3 = $css['color3'];
*/
// Additional config CSS
//$config_css = elgg_get_plugin_setting('css', 'esope');


/*******************************************************************************

Base CSS
 * CSS reset
 * core
 * helpers (moved to end to have a higher priority)
 * grid

*******************************************************************************/
echo elgg_view('css/elements/reset', $vars);
echo elgg_view('css/elements/core', $vars);
echo elgg_view('css/elements/grid', $vars);


/*******************************************************************************

Skin CSS
 * typography     - fonts, line spacing
 * forms          - forms, inputs
 * buttons        - action, cancel, delete, submit, dropdown, special
 * navigation     - menus, breadcrumbs, pagination
 * icons          - icons, sprites, graphics
 * modules        - modules, widgets
 * layout_objects - lists, content blocks, notifications, avatars
 * layout         - page layout
 * misc           - to be removed/redone

*******************************************************************************/
echo elgg_view('css/elements/typography', $vars);
echo elgg_view('css/elements/forms', $vars);
echo elgg_view('css/elements/buttons', $vars);
echo elgg_view('css/elements/icons', $vars);
echo elgg_view('css/elements/navigation', $vars);
echo elgg_view('css/elements/modules', $vars);
echo elgg_view('css/elements/components', $vars);
echo elgg_view('css/elements/layout', $vars);
echo elgg_view('css/elements/misc', $vars);
echo elgg_view('css/elements/misc/spinner.css', $vars);


// included last to have higher priority
echo elgg_view('css/elements/helpers', $vars);


// in case plugins are still extending the old 'css' view, display it
echo elgg_view('css', $vars);


// ESOPE : CSS complémentaire configurable
$config_css = elgg_get_plugin_setting('css', 'esope');
if (!empty($config_css)) {
	echo "\n<style>" . html_entity_decode($config_css) . "</style>\n";
}
