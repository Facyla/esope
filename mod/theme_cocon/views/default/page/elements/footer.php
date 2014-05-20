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


<footer class="footer-cocon">
	<div class="interne">
	  <?php echo $footer; ?>
	</div>
</footer>

<!--
Conception & réalisation : Florian DANIEL / Items International
Plateforme construite avec le framework opensource Elgg 1.8, distribution ESOPE https://github.com/Facyla/esope
//-->

