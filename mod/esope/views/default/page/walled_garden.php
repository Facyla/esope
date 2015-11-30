<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

$is_sticky_register = elgg_is_sticky_form('register');
$wg_body_class = 'elgg-body-walledgarden';
$inline_js = '';
if ($is_sticky_register) {
	$wg_body_class .= ' hidden';
	$inline_js = <<<__JS
<script type="text/javascript">
elgg.register_hook_handler('init', 'system', function() {
	$('.registration_link').trigger('click');
});
</script>
__JS;
}

// render content before head so that JavaScript and CSS can be loaded. See #4032
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$content = '';

$site = elgg_get_site_entity();
$title = $site->name;
$replace_public_home = elgg_get_plugin_setting('replace_public_homepage', 'esope');

// Display reset password form if asked to
$user_guid = get_input('u', false);
$code = get_input('c', false);
if ($user_guid && $code) {
	$user = get_entity($user_guid);
	if (!$user instanceof ElggUser) {
		register_error(elgg_echo('user:passwordreset:unknown_user'));
		forward();
	}
	$params = array('guid' => $user_guid, 'code' => $code);
	
	$content .= '<header><div class="interne">';
	$headertitle = elgg_get_plugin_setting('headertitle', 'esope');
	if (empty($headertitle)) $content .= '<h1 class="invisible">' . $site->name . '</h1>';
	else $content .= '<h1><a href="' . $url . '" title="Aller sur la page d\'accueil">' . $headertitle . '</a></h1>';
	$content .= '</div></header>';
	$content .= '<div class="elgg-page-messages">';
	$content .= elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';

	$content .= '<div id="esope-homepage" class="interne">';
	$content .= '<div id="esope-loginbox">';
	$content .= elgg_view_form('user/passwordreset', array('class' => 'elgg-form-account'), $params);
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	$content .= '</div>';

	$content .= elgg_view('page/elements/footer');
}


// Display default page content if no special content has been set before
if (empty($content)) {
	if ($replace_public_home == 'cmspages') {
		if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('esope:cmspages:notactivated')); }
		define('cmspage', true);
		$pagetype = 'homepage-public';
		// Ajout des feuilles de style personnalisées
		//if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
		// Ajout des JS personnalisés
		//if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";
	
		$content .= '<div id="' . $pagetype . '">' . elgg_view('cmspages/view', array('pagetype' => $pagetype)) . '</div>';
		
	} else if ($replace_public_home == 'original') {
		// Default Elgg content
		$content = $vars["body"];
	} else {
		// ESOPE theme page
		// Formulaire de renvoi du mot de passe
		$lostpassword_form = '<div id="esope-lostpassword" style="display:none;">';
		//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
		$lostpassword_form .= elgg_view_form('user/requestnewpassword');
		$lostpassword_form .= '</div>';

		// Formulaire d'inscription
		if (elgg_get_config('allow_registration')) {
			$register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
		}
		$content .= '<header><div class="interne">';
		$headertitle = elgg_get_plugin_setting('headertitle', 'esope');
		if (empty($headertitle)) $content .= '<h1 class="invisible">' . $site->name . '</h1>';
		else $content .= '<h1><a href="' . $url . '" title="' . elgg_echo('esope:gotohomepage') . '">' . $headertitle . '</a></h1>';
		$content .= '</div></header>';

		$content .= '<div class="elgg-page-messages">';
		$content .= elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
		$content .= '</div>';
		$content .= '<div class="clearfloat"></div>';

		$content .= '<div id="esope-homepage" class="interne">';
			$content .= '<div id="esope-public-col1" class="home-static-container">';
				$intro = elgg_get_plugin_setting('homeintro', 'esope');
				if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div>';
				$content .= '<div id="esope-loginbox">';
				$content .= '<h2>' . elgg_echo('login') . '</h2>';
				// Connexion + mot de passe perdu
				$content .= elgg_view_form('login');
				$content .= $lostpassword_form;
				$content .= '<div class="clearfloat"></div>';
				$content .= '</div>';
			$content .= '</div>';

			$content .= '<div id="esope-public-col2" class="home-static-container">';
				// Création nouveau compte
				if (elgg_get_config('allow_registration')) { $content .= $register_form; }
			$content .= '</div>';
	
		$content .= '</div>';
		$content .= '<div class="clearfloat"></div>';
		
		// Footer
		$content .= '<div class="elgg-page-footer"><div class="elgg-inner">';
			$content .= elgg_view('page/elements/footer');
		$content .= '</div></div>';
	}

}


$body = <<<__BODY
<div class="elgg-page elgg-page-walledgarden">
	<div class="elgg-page-messages">
		$messages
	</div>
	<div class="$wg_body_class">
		$content
	</div>
</div>
__BODY;

$body .= elgg_view('page/elements/foot');

$body .= $inline_js;

$head = elgg_view('page/elements/head', $vars['head']);

echo elgg_view("page/elements/html", array("head" => $head, "body" => $body));
