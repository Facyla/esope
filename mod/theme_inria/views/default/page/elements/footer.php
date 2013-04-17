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

$footer = elgg_get_plugin_setting('footer', 'adf_public_platform');
?>


<footer>
	<div class="interne">
	  <?php echo $footer; ?>
	</div>
</footer>

<div id="bande"></div>
<div class="interne credits">
	<p>Conception & réalisation : Florian DANIEL ~ <a href="http://www.items.fr/" target="_blank" title="Items International (nouvelle fenêtre)">Items International</a> </p>
	<p class="right">Plateforme construite avec le framework opensource Elgg 1.8</p>
</div>

