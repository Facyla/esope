<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

$url = $vars['url'];
$imgurl = $vars['url'] . 'mod/adf_public_platform/img/theme/';

echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

/*
$footer = elgg_get_plugin_setting('footer', 'adf_public_platform');
if (empty($footer)) {
  $powered_url = elgg_get_site_url() . "_graphics/powered_by_elgg_badge_drk_bckgnd.gif";
  echo '<div class="mts clearfloat right">';
  echo elgg_view('output/url', array( 'href' => 'http://elgg.org', 'text' => "<img src=\"$powered_url\" alt=\"Powered by Elgg\" width=\"106\" height=\"15\" />", 'class' => '', ));
  echo '</div>';
} else {
  echo $footer;
}
*/
?>

<footer>
	<div class="interne">
		<ul>
			<li><a href="<?php echo $url; ?>pages/view/3792/charte-de-dpartements-en-rseaux">Charte</a></li>
			<li><a href="<?php echo $url; ?>pages/view/3819/mentions-lgales">Mentions légales</a></li>
			<li><a href="<?php echo $url; ?>pages/view/3827/a-propos-de-dpartements-en-rseaux">A propos</a></li>
			<!--
			<li><a href="#">Plan du site</a></li>
			//-->
			<li><a href="<?php echo $url; ?>pages/view/4701/dpartements-en-rseaux-et-accessibilit">Accessibilité</a></li>
			<li><a href="mailto:secretariat@departementsenreseaux.fr&subject=&body=Contact%20%depuis%20la%20page%20<?php echo rawurlencode(full_url()); ?>">Contact</a></li>
		</ul>
		<a href="http://www.departement.org/" target="_blank"><img src="<?php echo $imgurl ?>logo-adf.png" alt="Assemblée des Départements de France" /></a>
	</div>
</footer>

<div id="bande"></div>
<div class="interne credits">
	<p>Conception & réalisation : Facyla ~ <a href="http://www.items.fr/" target="_blank" title="Items International (nouvelle fenêtre)">Items International</a> / <a href="http://www.urbilog.fr/" target="_blank" title="Urbilog (nouvelle fenêtre)">Urbilog</a></p>
	<p class="right">Plateforme construite avec le framework opensource Elgg 1.8</p>
</div>


