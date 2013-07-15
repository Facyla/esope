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
$imgurl = $vars['url'] . 'mod/adf_public_platform/img/social-icons/';

echo elgg_view_menu('footer', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));

$footer = elgg_get_plugin_setting('footer', 'adf_public_platform');
$email = elgg_get_plugin_setting('contactemail', 'adf_public_platform');
$rss = elgg_get_plugin_setting('rss', 'adf_public_platform');
$twitter = elgg_get_plugin_setting('twitter', 'adf_public_platform');
$facebook = elgg_get_plugin_setting('facebook', 'adf_public_platform');
//$flickr = elgg_get_plugin_setting('flickr', 'adf_public_platform');
$dailymotion = elgg_get_plugin_setting('dailymotion', 'adf_public_platform');
$slideshare = elgg_get_plugin_setting('slideshare', 'adf_public_platform');

// Construction contenu
$side_content = '';
if (!empty($email)) $side_content .= 'CONTACT&nbsp;: <a href="' . $email . '">' . $email . '</a><br />';
if (!empty($slideshare)) $side_content .= '<a href="' . $slideshare . '" class="contact-slideshare"><img src="' . $imgurl . 'slideshare-16.png" alt="Slideshare" /></a> &nbsp; ';
if (!empty($dailymotion)) $side_content .= '<a href="' . $dailymotion . '" class="contact-dailymotion"><img src="' . $imgurl . 'dailymotion-16.png" alt="Dailymotion" /></a> &nbsp; ';
if (!empty($twitter)) $side_content .= '<a href="' . $twitter . '" class="contact-twitter"><img src="' . $imgurl . 'twitter-16.png" alt="Twitter" /></a> &nbsp; ';
if (!empty($facebook)) $side_content .= '<a href="' . $facebook . '" class="contact-facebook"><img src="' . $imgurl . 'facebook-16.png" alt="Facebook" /></a> &nbsp; ';
//if (!empty($flickr)) $side_content .= '<a href="' . $flickr . '" class="contact-flickr"><img src="' . $imgurl . 'flickr-16.png" alt="FlickR" /></a> &nbsp; ';
if (!empty($rss)) $side_content .= '<a href="' . $rss . '" class="contact-rss"><img src="' . $imgurl . 'rss-16.png" alt="RSS" /></a> &nbsp; ';
?>


<footer style="background:#92B025;">
	<div id="theme-compnum-footer">
		<?php
		if (!empty($side_content)) {
			echo '<div style="{ float:right; width:280px; margin: 12px 20px; padding: 8px 12px; background:#92B025; box-shadow: 0 1px 3px 2px #669966; }">' . $side_content . '</div>';
		}
		echo $footer;
		?>
	</div>
</footer>

<div class="interne credits">
	<p>Conception & réalisation : Facyla ~ <a href="http://www.items.fr/" target="_blank" title="Items International (nouvelle fenêtre)">Items International</a></p>
	<p class="right">Plateforme construite avec le framework opensource Elgg 1.8</p>
</div>

