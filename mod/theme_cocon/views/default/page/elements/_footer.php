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
$imgurl = $vars['url'] . 'mod/theme_inria/graphics/';

echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

$footer = elgg_get_plugin_setting('footer', 'adf_public_platform');
?>

<footer class="footer-inria">
	<div class="interne">
		<!--
		<a class="print-page" href="javascript:window.print();"><i class="fa fa-print"></i> <?php echo elgg_echo('theme_inria:print'); ?></a>
		//-->
		<?php echo $footer; ?><img class="footer-logo-inria" src="<?php echo $imgurl; ?>logo-inria.png">
	</div>
</footer>

