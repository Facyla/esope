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
				//echo '<a href="http://twitter.com/home?status=' . $share_url . '"><img src="' . $CONFIG->url . 'mod/socialshare/graphics/twitter.png" /></a>';
				/*
				<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="formavia" data-lang="fr">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				<div class="clearfloat"></div>
				*/
				/*
				echo '<a href="https://twitter.com/share" class="twitter-share-button" data-lang="fr" data-hashtags="" data-dnt="true">' . elgg_echo('socialshare:twitter:title');
				echo '</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
				*/
				echo '<a target="_blank" href="https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $title . '"><img src="' . $imgurl . 'twitter/bird_blue_32.png" alt="Twitter" title="' . elgg_echo("socialshare:$key:title") . '" /></a>';
				// '&via=&hashtags=
				break;
			
			case 'linkedin':
				// See https://developer.linkedin.com/documents/share-linkedin
				echo '<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=' . $share_title . '&summary=' . $share_description . '&source=' . $share_source . '" /><img src="' . $imgurl . 'linkedin.png" alt="LinkedIn" title="' . elgg_echo("socialshare:$key:title") . '" /></a>';
				break;
			
			case 'google':
				// <!-- Placez cette balise où vous souhaitez faire apparaître le gadget Bouton +1. -->
				//echo '<span style="float:left;"><div class="g-plusone" data-size="tall" data-annotation="inline" data-width="120" data-href="' . full_url() . '"></div></span>';
				echo '<a target="_blank" href="https://plus.google.com/share?url=' . $share_url . '"><img src="' . $imgurl . 'google.png" alt="Google+" title="' . elgg_echo("socialshare:$key:title") . '" /></a>';
				break;
			
			case 'facebook':
				/*
				<div id="fb-root" style="float:right;"></div><script src="http://connect.facebook.net/en_US/all.js#appId=5936143137&amp;xfbml=1"></script><fb:like href="<?php echo $share_url; ?>" send="false" layout="button_count" width="80" show_faces="false" font=""></fb:like>
				<img src="<?php echo $CONFIG->url; ?>mod/socialshare/graphics/facebook.png" style="height:24px; margin-top:4px;" />
				*/
				//echo '<iframe src="https://www.facebook.com/plugins/like.php?locale=' . $lang . '&href=' . $share_url . '&layout=button_count" title="' . elgg_echo('socialshare:facebook:title') . '" style="width:90px; height:20px; border:0; margin-top:2px;"></iframe>';
				echo '<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=' . $share_url . '"><img src="' . $imgurl . 'facebook.png" alt="Facebook" title="' . elgg_echo("socialshare:$key:title") . '" /></a>';
				break;
			
			case 'pinterest':
				echo '<a target="_blank" href="https://pinterest.com/pin/create/button/?url=' . $share_url . '&media=' . $share_image . '&description=' . $share_description . '"><img src="' . $imgurl . 'pinterest.png" alt="Pinterest" title="' . elgg_echo("socialshare:$key:title") . '" /></a>';
				break;
			
			case 'email':
				$subject = elgg_echo('socialshare:email:subject', array($share_title));
				$subject = rawurlencode($subject);
				$body = elgg_echo('socialshare:email:body', array($share_title, $full_url_url, $share_description));
				$body = rawurlencode($body);
				echo '<a target="_blank" href="mailto:?subject=' . $subject . '&body=' . $body . '" title="' . elgg_echo('socialshare:mail:title') . '"><img src="' . $imgurl . 'mail.png" alt="Email" title="' . elgg_echo("socialshare:$key:title") . '" /></a>';
				break;
		}
	}
}


