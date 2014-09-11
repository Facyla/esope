<?php
/* Social share sharing links 
 * All sharing links must be only links, no API, no iframe, no embed, no external cookie
 */
global $CONFIG;

$lang = get_current_language();
$full_url = elgg_extract('shareurl', $vars, full_url());
$share_url = rawurlencode($full_url);
$share_title = '';
$share_description = '';
$share_source = $CONFIG->site->name;
$share_image = '';
$imgurl = $CONFIG->url . 'mod/socialshare/graphics/';

$providers = array('email' => 'Email', 'twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google', 'pinterest' => 'Pinterest', 'facebook' => 'Facebook');

foreach ($providers as $key => $name) {
	// Add provider only if activated
	if (elgg_get_plugin_setting($key.'_enable', 'socialshare') == 'yes') {
		
		switch($key) {
			
			case 'twitter':
				// See https://dev.twitter.com/docs/intents#tweet-intent
				//$img = '<img src="' . $imgurl . 'twitter/bird_blue_32.png" alt="Twitter" />';
				$img = '<i class="fa fa-twitter-square"></i>';
				echo '<a target="_blank" href="https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $title . '" title="' . elgg_echo("socialshare:$key:title") . '">' . $img . '</a>';
				// '&via=&hashtags=
				break;
			
			case 'linkedin':
				// See https://developer.linkedin.com/documents/share-linkedin
				//$img = '<img src="' . $imgurl . 'linkedin.png" alt="LinkedIn" />';
				$img = '<i class="fa fa-linkedin-square"></i>';
				echo '<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=' . $share_title . '&summary=' . $share_description . '&source=' . $share_source . '" title="' . elgg_echo("socialshare:$key:title") . '">' . $img . '</a>';
				break;
			
			case 'google':
				//$img = '<img src="' . $imgurl . 'google.png" alt="Google+" />';
				$img = '<i class="fa fa-google-plus-square"></i>';
				// <!-- Placez cette balise où vous souhaitez faire apparaître le gadget Bouton +1. -->
				echo '<a target="_blank" href="https://plus.google.com/share?url=' . $share_url . '" title="' . elgg_echo("socialshare:$key:title") . '">' . $img . '</a>';
				break;
			
			case 'facebook':
				//$img = '<img src="' . $imgurl . 'facebook.png" alt="Facebook" />';
				$img = '<i class="fa fa-facebook-square"></i>';
				echo '<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=' . $share_url . '" title="' . elgg_echo("socialshare:$key:title") . '">' . $img . '</a>';
				break;
			
			case 'pinterest':
				//$img = '<img src="' . $imgurl . 'pinterest.png" alt="Pinterest" />';
				$img = '<i class="fa fa-pinterest-square"></i>';
				echo '<a target="_blank" href="https://pinterest.com/pin/create/button/?url=' . $share_url . '&media=' . $share_image . '&description=' . $share_description . '" title="' . elgg_echo("socialshare:$key:title") . '">' . $img . '</a>';
				break;
			
			case 'email':
				//$img = '<img src="' . $imgurl . 'mail.png" alt="Email" />';
				$img = '<i class="fa fa-envelope-square"></i>';
				$subject = elgg_echo('socialshare:email:subject', array($share_title));
				$subject = rawurlencode($subject);
				$body = elgg_echo('socialshare:email:body', array($share_title, $full_url, $share_description));
				$body = rawurlencode($body);
				echo '<a target="_blank" href="mailto:?subject=' . $subject . '&body=' . $body . '" title="' . elgg_echo('socialshare:email:title') . '" title="' . elgg_echo("socialshare:$key:title") . '">' . $img . '</a>';
				break;
			
		}
	}
}


