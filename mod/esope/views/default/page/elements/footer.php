<?php
/**
 * Displays custom footer
 * 3 modes : 
 * - custom HTML footer,
 * - default menu
 * - custom multilingual menu
 *
 * @package Elgg
 * @subpackage Core
 *
 */



// Custom HTML
$footer = elgg_get_plugin_setting('footer', 'esope');
// Footer menu
$menu = '';
// Esope : custom, multilingual menu
if (elgg_is_active_plugin('elgg_menus')) {
	$menu = elgg_get_plugin_setting('menu_footer', 'esope');
	// Get translated menu, if exists
	$lang = get_language();
	$lang_menu = elgg_menus_get_menu_config($menu . '-' . $lang);
	if ($lang_menu) { $menu = $menu . '-' . $lang; }
}
// Default to footer menu if no menu nor custom HTML set
if (empty($footer) && empty($menu)) { $menu = 'footer'; }

// Compute menu
if (!empty($menu)) {
	$footer_menu = elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}

// Use menu in custom HTML
if (!empty($footer) && !empty($footer_menu)) {
	$footer = str_replace('{menu}', $footer_menu, $footer);
}
// Or display menu only if no custom HTML set
if (empty($footer) && !empty($footer_menu)) {
	$footer = $footer_menu;
}

// Display footer
echo $footer
?>

<div class="clearfloat"></div>

<div class="credits">
	<p><a href="https://twitter.com/facyla" target="_blank">Florian DANIEL aka Facyla</a></p>
	<p class="right"><a href="https://github.com/Facyla/esope" target="_blank" title="Elgg Social Opensource Public Environment">ESOPE</a> / <a href="https://elgg.org/about.php" target="_blank" title="Open source social framework Elgg">Elgg 2.3</a></p>
</div>

