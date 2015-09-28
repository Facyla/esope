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
$imgurl = $vars['url'] . 'mod/theme_propage_paca/img/theme/';

echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

$footer = elgg_get_plugin_setting('footer', 'adf_public_platform');
?>


<footer id="site-footer">
	<div class="interne">
		<?php echo $footer; ?>
	</div>
</footer>

<div class="interne credits">
	<p>Conception & réalisation : Florian DANIEL aka Facyla ~ <a href="http://www.items.fr/" target="_blank" title="Items International (nouvelle fenêtre)">Items International</a></p>
	<p class="right">Plateforme construite avec le framework opensource Elgg 1.8</p>
</div>

