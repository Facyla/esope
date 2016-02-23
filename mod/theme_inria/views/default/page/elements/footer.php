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

$url = elgg_get_site_url();
$imgurl = $url . 'mod/theme_inria/graphics/';

// Display default footer if no specific footer set in theme settings
$footer = elgg_get_plugin_setting('footer', 'esope');
if (empty($footer)) {
	// Esope : custom, multilingual menu
	$menu = elgg_get_plugin_setting('menu_footer', 'esope');
	if (empty($menu)) { $menu = 'footer'; }

	// Get translated menu, only if exists
	$lang = get_language();
	$lang_menu = elgg_menus_get_menu_config($menu . '-' . $lang);
	if ($lang_menu) $menu = $menu . '-' . $lang;

	$footer = elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
?>

<div class="footer-inria">
	<!--
	<a class="print-page" href="javascript:window.print();"><i class="fa fa-print"></i> <?php echo elgg_echo('theme_inria:print'); ?></a>
	//-->
	<?php echo $footer; ?>
	<img class="footer-logo-inria" src="<?php echo $imgurl; ?>logo-inria.png">
</div>

