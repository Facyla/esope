<?php
/* Social share sharing links 
 * All sharing links must be only links, no API, no iframe, no embed, no external cookie
 */

if (elgg_get_plugin_setting('extend_owner_block', 'socialshare') != 'yes') { return; }

$guid = $vars['entity']->guid;
$mode = elgg_extract('mode', $vars, '');

if ($mode == 'lightbox') {
	
	// Socialshare lightbox
	$text = elgg_echo('socialshare:share');
	$params = array(
			'text' => '<i class="fa fa-share-alt"></i> ' . $text, 
			'rel' => 'popup', 
			'href' => "#socialshare-$guid"
		);
	$body .= elgg_view('output/url', $params);
	$body .= '<div class="elgg-module elgg-module-popup elgg-socialshare hidden clearfix" id="socialshare-' . $guid . '">';
		$body .= '<div class="socialshare-links-popup">';
			$body .= elgg_view('socialshare/extend', array('shareurl' => $vars['entity']->getURL()));
			$body .= '<div class="clearfloat"></div>';
		$body .= '</div>';
	$body .= '</div>';
	
} else {
	
	// Socialshare direct extend
	$body .= '<div class="socialshare-links-menu">';
		$body .= elgg_view('socialshare/extend', array('shareurl' => $vars['entity']->getURL()));
	$body .= '</div>';
}


echo $body;

