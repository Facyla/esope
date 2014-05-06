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
if (!empty($email)) $side_content .= '<p>CONTACT&nbsp;: <a href="mailto:' . $email . '">' . $email . '</a></p><br />';
if (!empty($slideshare)) $side_content .= '<a target="_blank" href="' . $slideshare . '" class="contact-slideshare" title="Présentations et diaporamas via Slideshare"><img src="' . $imgurl . 'slideshare-32.png" alt="Slideshare" /></a> &nbsp; ';
if (!empty($dailymotion)) $side_content .= '<a target="_blank" href="' . $dailymotion . '" class="contact-dailymotion" title="Vidéos"><img src="' . $imgurl . 'dailymotion-32.png" alt="Dailymotion" /></a> &nbsp; ';
if (!empty($twitter)) $side_content .= '<a target="_blank" href="' . $twitter . '" class="contact-twitter" title="Informations via Twitter"><img src="' . $imgurl . 'twitter-32.png" alt="Twitter" /></a> &nbsp; ';
if (!empty($facebook)) $side_content .= '<a target="_blank" href="' . $facebook . '" class="contact-facebook" title="Historique via Facebook"><img src="' . $imgurl . 'facebook-32.png" alt="Facebook" /></a> &nbsp; ';
if (!empty($flickr)) $side_content .= '<a target="_blank" href="' . $flickr . '" class="contact-flickr" title="Images partagées via FlickR"><img src="' . $imgurl . 'flickr-32.png" alt="FlickR" /></a> &nbsp; ';
if (!empty($rss)) $side_content .= '<a target="_blank" href="' . $rss . '" class="contact-rss" title="Activité (publique) récente du site via RSS"><img src="' . $imgurl . 'rss-32.png" alt="RSS" /></a> &nbsp; ';
?>


<footer>
	<div id="theme-compnum-footer" class="interne">
		<?php
		if (!empty($side_content)) {
			echo '<div id="footer-contacts">' . $side_content . '<div class="clearfloat"></div><br /></div>';
		}
		echo $footer;
		?>
		<div class="clearfloat"></div>
	</div>
</footer>

<!--
<div class="interne credits">
	<p>Conception & réalisation : Facyla ~ <a href="http://www.items.fr/" target="_blank" title="Items International (nouvelle fenêtre)">Items International</a></p>
	<p class="right">Plateforme construite avec le framework opensource Elgg 1.8</p>
</div>
//-->

