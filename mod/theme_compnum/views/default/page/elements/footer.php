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
$email = elgg_get_plugin_setting('contactemail', 'adf_public_platform');
$rss = elgg_get_plugin_setting('rss', 'adf_public_platform');
$twitter = elgg_get_plugin_setting('twitter', 'adf_public_platform');
$facebook = elgg_get_plugin_setting('facebook', 'adf_public_platform');
//$flickr = elgg_get_plugin_setting('flickr', 'adf_public_platform');
$dailymotion = elgg_get_plugin_setting('dailymotion', 'adf_public_platform');
$slideshare = elgg_get_plugin_setting('slideshare', 'adf_public_platform');
?>


<footer>
	<div id="theme-compnum-footer">
		<?php
		echo $footer;
		echo '<div style="float:right; width:280px; margin:0 20px;">';
		echo 'CONTACT&nbsp;: ' . $email . '<br />';
		echo '<a href="" class="contact-slideshare">Slideshare</a> &nbsp; ';
		echo '<a href="" class="contact-dailymotion">Dailymotion</a> &nbsp; ';
		echo '<a href="" class="contact-twitter">Twitter</a> &nbsp; ';
		echo '<a href="" class="contact-facebook">Facebook</a> &nbsp; ';
		//echo '<a href="" class="contact-flickr">FlickR</a> &nbsp; ';
		echo '<a href="" class="contact-rss">RSS</a> &nbsp; ';
		echo '</div>';
		?>
	</div>
</footer>

<div id="bande"></div>
<div class="interne credits">
	<p>Conception & réalisation : Facyla ~ <a href="http://www.items.fr/" target="_blank" title="Items International (nouvelle fenêtre)">Items International</a></p>
	<p class="right">Plateforme construite avec le framework opensource Elgg 1.8</p>
</div>

