<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

// Transitions² : use custom menu
$menu = elgg_get_plugin_setting('menu_footer', 'theme_transitions2');
if (empty($menu)) $menu = 'footer';

// Get translated menu, only if exists
$lang = get_language();
$lang_menu = elgg_menus_get_menu_config($menu . '-' . $lang);
if ($lang_menu) $menu = $menu . '-' . $lang;

$base_url = elgg_get_site_url() . 'mod/theme_transitions2/graphics/';

echo '<div class="static-container elgg-footer-partners" style="float:left; width:55%;">';
	// Logos des Partenaires
	//echo elgg_view('cmspages/view', array('pagetype' => "footer"));
	echo '<h2 class="elgg-footer-partners-text">' . elgg_echo('theme_transitions2:partners:title') . '</h2>';
	echo '<img src="' . $base_url . 'partenaires/logos-partenaires-transitions2.png" />';
	/*
	echo '<div class="elgg-footer-partners-logo">
		<img src="' . $partners_url . 'fing.png" />
		<img src="' . $partners_url . 'coalition-climat-21.png" />
		<img src="' . $partners_url . 'les-petits-debrouillards.png" />
		<img src="' . $partners_url . 'place-to-b.png" />
		<img src="' . $partners_url . 'poc21.png" />
		<img src="' . $partners_url . 'ouishare.png" />
		<img src="' . $partners_url . 'terraeco.png" />
		</div>';
	echo '<div class="clearfloat"></div>';
	*/
echo '</div>';

echo '<div class="static-container elgg-footer-supporters" style="float:right; width:35%;">';
	echo '<h2 class="elgg-footer-supporters-text">' . elgg_echo('theme_transitions2:supporters:title') . '</h2>';
	echo '<img src="' . $base_url . 'soutiens/logos-soutiens-transitions2.png" />';
echo '</div>';

echo '<div class="clearfloat"></div>';

// Pied de page
echo '</div></div><div class="elgg-page-footer-transitions2"><div class="elgg-inner">';

if (elgg_is_active_plugin('socialshare')) {
	echo '<span style="float:right;" class="static-container">';
	echo '<div class="transitions-socialshare">' . elgg_view('socialshare/extend', array()) . '</div>';
	echo '</span>';
}

echo '<span class="elgg-footer-logo static-container">';
	echo '<img src="' . $base_url . 'logo-transitions2-small.png" alt="' . elgg_get_site_entity()->name . '" />';
	echo '<img src="' . $base_url . 'label-COP21-small.png" alt="Label COP 21" />';
echo '</span>';

echo elgg_view_menu($menu, array('sort_by' => 'priority', 'class' => "elgg-menu-footer elgg-menu-footer-default clearfix elgg-menu-hz static-container"));

