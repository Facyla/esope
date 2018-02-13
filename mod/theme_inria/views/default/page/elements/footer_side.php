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

$url = elgg_get_site_url();
$imgurl = $url . 'mod/theme_inria/graphics/';

/*
// Display default footer if no specific footer set in theme settings
$footer = elgg_get_plugin_setting('footer', 'esope');
// Footer menu
$menu = '';
// Esope : custom, multilingual menu
if (elgg_is_active_plugin('elgg_menus')) {
	$menu = elgg_get_plugin_setting('menu_footer', 'esope');
	if (empty($menu)) { $menu = 'footer'; }
	// Get translated menu, only if exists
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
*/

// Inria static override (=> move to site settings)
$lang_select = elgg_view('language_selector/default', $vars);
$footer = <<<FOOTER
<ul>
	<li><a href="https://intranet.inria.fr/" class="inria-intranet" target="_blank"><i class="fa fa-external-link"></i>&nbsp;Intranet</a></li>
	<li>$lang_select</li>
</ul>
FOOTER;
?>

<div class="footer-inria">
	<!--
	<a class="print-page" href="javascript:window.print();"><i class="fa fa-print"></i> <?php echo elgg_echo('theme_inria:print'); ?></a>
	//-->
	<?php echo $footer; ?>
	<img class="footer-logo-inria" src="<?php echo $imgurl; ?>logo-inria.png">
</div>




