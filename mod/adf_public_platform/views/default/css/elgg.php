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
$old_css_view = elgg_get_view_location('css');
if ($old_css_view != elgg_get_config('viewpath')) {
	echo elgg_view('css', $vars);
	return true;
}

// Configurable elements : pass theme as $vars['theme-config-css']
// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'adf_public_platform');
// Couleur des titres
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
// Couleur des liens
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
// Couleur 1
$color1 = elgg_get_plugin_setting('color1', 'adf_public_platform');
// Couleur 2
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
// Couleur 3
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');

$vars['theme-config-css'] = array(
  'urlicon' => $vars['url'] . 'mod/adf_public_platform/img/theme/',
  'footercolor' => $footercolor,
  'titlecolor' => $titlecolor,
  'linkcolor' => $linkcolor,
  'color1' => $color1,
  'color2' => $color2,
  'color3' => $color3,
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
$config_css = elgg_get_plugin_setting('css', 'adf_public_platform');


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


// included last to have higher priority
echo elgg_view('css/elements/helpers', $vars);


// in case plugins are still extending the old 'css' view, display it
echo elgg_view('css', $vars);


// CSS complémentaire configurable
if (!empty($config_css)) { echo $config_css; }


