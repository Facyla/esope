<?php
// Copy and tweak in your custom theme depending on your exact needs and registration policy
if (!elgg_is_logged_in()) {
	echo '<div class="clearfloat"></div><br />';
	echo "<blockquote class=\"public-comments-notice\"><i class=\"fa fa-info-circle\"></i> " . elgg_echo('theme_fing:comments:publicnotice') . "<br />Veuillez vous <a href=\"" . elgg_get_site_url() . "login\" target=\"_blank\">identifier</a>, ou <a href=\"" . elgg_get_site_url() . "register\" target=\"_blank\">créer un compte</a>.</blockquote>";
	
	/*
	echo "<blockquote class=\"public-comments-notice\"><i class=\"fa fa-info-circle\"></i> " . elgg_echo('theme_fing:comments:publicnotice') . "<br />Veuillez vous <a href=\"" . $vars['url'] . "login\">connecter</a>, ou créer un compte via le formulaire ci-dessous.</blockquote>";

		// check if new registration allowed
	if (elgg_get_config('allow_registration') != false) {
		$friend_guid = (int) get_input('friend_guid', 0);
		$invitecode = get_input('invitecode');
		$content = '<div id="fing-register">';
			// create the registration url - including switching to https if configured
			$register_url = elgg_get_site_url() . 'action/register';
			if (elgg_get_config('https_login')) { $register_url = str_replace("http:", "https:", $register_url); }
			$form_params = array('action' => $register_url, 'class' => 'elgg-form-account');
			$body_params = array('friend_guid' => $friend_guid, 'invitecode' => $invitecode);
			$content .= elgg_view_form('register', $form_params, $body_params);
			$content .= elgg_view('help/register');
		$content .= '</div>';
		echo $content;
	}
	*/
	
}

