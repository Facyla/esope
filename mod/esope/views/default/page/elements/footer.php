<?php
/**
 * Elgg footer
 * 3 modes : 
 * - custom HTML footer,
 * - default menu
 * - custom multilingual menu
 *
 * @package Elgg
 * @subpackage Core
 *
 */


// Display default footer if no specific footer set in theme settings
$footer = elgg_get_plugin_setting('footer', 'esope');
if (!empty($footer)) {
	echo $footer;
} else {
	// Esope : custom, multilingual menu
	$menu = elgg_get_plugin_setting('menu_footer', 'esope');
	if (empty($menu)) $menu = 'footer';

	// Get translated menu, only if exists
	$lang = get_language();
	$lang_menu = elgg_menus_get_menu_config($menu . '-' . $lang);
	if ($lang_menu) $menu = $menu . '-' . $lang;

	echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
?>

<div class="clearfloat"></div>

<div class="credits">
	<p><a href="https://twitter.com/facyla" target="_blank">Florian DANIEL aka Facyla</a></p>
	<p class="right"><a href="https://github.com/Facyla/esope" target="_blank" title="Elgg Social Opensource Public Environment">ESOPE</a> / <a href="http://elgg.org/about.php" target="_blank" title="Open source social framework Elgg">Elgg 1.12</a></p>
</div>

