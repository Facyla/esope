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
		<?php echo $footer; ?><img class="footer-logo-inria" src="<?php echo $imgurl; ?>logo-inria.png">
	</div>
</footer>

