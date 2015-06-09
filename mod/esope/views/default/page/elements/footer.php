<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
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
	echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
?>

<div class="clearfloat"></div>

<div class="credits">
	<p>Florian DANIEL aka Facyla ~ <a href="http://items.fr/" target="_blank" title="Items International">Items International</a></p>
	<p class="right"><a href="https://github.com/Facyla/esope" target="_blank" title="Elgg Social Opensource Public Environment">ESOPE</a> / <a href="http://elgg.org/about.php" target="_blank" title="Open source social framework Elgg">Elgg 1.9</a></p>
</div>

