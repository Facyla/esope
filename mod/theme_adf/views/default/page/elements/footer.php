<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 */

$url = elgg_get_site_url();

echo '<div class="footer-logo"><img class="logo" src="' . $url . 'mod/theme_adf/graphics/logo-ADF-assemblee-des-departements-de-france_long.png" /></div>';

// Menu du footer
//echo elgg_view_menu('footer');

$custom_footer = elgg_get_plugin_setting('footer_text', 'theme_adf');
if (!empty($custom_footer)) {
	$custom_footer = elgg_view('output/longtext', ['value' => $custom_footer]);
} else {
	if (elgg_is_admin_logged_in()) {
		$custom_footer = '<p>Admin, vous pouvez <a href="' . $url . 'admin/plugin_settings/theme_adf">intégrer ici un texte et des liens, via la configuration du thème</a>.</p>';
	}
}
echo '<div class="footer-adf">' . $custom_footer . '</div>';

/*  
Twitter https://twitter.com/adepartementsf
Facebook https://www.facebook.com/departements/
Instagram https://www.instagram.com/le_tour_des_departements/
Extranet http://extranet.departements.fr/
Site de l'ADF https://www.departements.fr/  avec agenda, actualités, presse...
IFET http://www.ifet.fr/ https://www.departements.fr/wp-content/uploads/2016/09/logo_ifet-e1501159360207.png
Cercle des élus http://cercledeselus.departements.fr/ https://www.departements.fr/wp-content/uploads/2017/07/logoCDE-e1501253118422.png
*/
