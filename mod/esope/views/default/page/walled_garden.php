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

$url = elgg_get_site_url();
$current_url = full_url();
$reserved_urls = array($url.'login', $url.'register');

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

// Display custom home page if not asking for a special page
if (in_array($current_url, $reserved_urls)) { $replace_public_home = 'original'; }

if ($replace_public_home == 'original') {
	// Default Elgg content
	$content = $vars["body"];

} else if ($replace_public_home == 'cmspages') {
	// CMSPages-based content
	if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('esope:cmspages:notactivated')); }
	define('cmspage', true);
	$pagetype = 'homepage-public';
	// Ajout des feuilles de style personnalisées
	//if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
	// Ajout des JS personnalisés
	//if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";

	$content .= '<div id="' . $pagetype . '">' . elgg_view('cmspages/view', array('pagetype' => $pagetype)) . '</div>';

} else {
	// ESOPE theme page

	// Formulaire de renvoi du mot de passe
	$lostpassword_form = '<div id="esope-lostpassword" class="hidden">';
		$lostpassword_form .= '<h2>' . elgg_echo('accessibility:requestnewpassword') . '</h2>';
		$lostpassword_form .= elgg_view_form('user/requestnewpassword');
	$lostpassword_form .= '</div>';

	// Login form
	$login_form = '<div id="esope-loginbox">';
		$login_form .= '<h2>' . elgg_echo('login') . '</h2>';
		// Connexion + mot de passe perdu
		$login_form .= elgg_view_form('login');
		$login_form .= $lostpassword_form;
		$login_form .= '<div class="clearfloat"></div>';
	$login_form .= '</div>';

	// Formulaire d'inscription
	$register_form = false;
	if (elgg_get_config('allow_registration')) {
		$register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
	}

	// Intro block
	$intro = elgg_get_plugin_setting('homeintro', 'esope');
	if (!empty($intro)) { $intro .= '<div class="clearfloat"></div>'; }


	// Header block
	/* Use custom header instead ?
	$header = '';
	$header .= '<header><div class="interne">';
	$headertitle = elgg_get_plugin_setting('headertitle', 'esope');
	if (empty($headertitle)) {
		$header .= '<h1 class="invisible">' . $site->name . '</h1>';
	} else {
		$header .= '<h1><a href="' . $url . '" title="' . elgg_echo('esope:gotohomepage') . '">' . $headertitle . '</a></h1>';
	}
	$header .= '</div></header>';
	//$header .= '<div class="elgg-page-messages">' . $messages . '</div>';
	$header .= '<div class="clearfloat"></div>';
	*/
	$header = elgg_view('page/elements/header', $vars);
	$content .= $header;

	// Compose page content
// Note : enable content loading using the normal Elgg way
// It can replace the default homepage content eg. for password change
	$col1 = $col2 = false;
	if (!empty($vars["body"]) && !empty($_GET)) {
		// Use single column, full-size
		$col1 = $vars["body"];
	} else if (!empty($register_form)) {
		$col1 = $intro . $login_form;
		$col2 = $register_form;
	} else if (!empty($intro)) {
		$col1 = $intro;
		$col2 = $login_form;
	} else {
		$col1 = $login_form;
		$col2 = ' ';
	}

	$content .= '<div id="esope-homepage" class="interne">';
		if ($col1 && $col2) {
			$content .= '<div id="esope-public-col1" class="home-static-container">' . $col1 . '</div>';
			$content .= '<div id="esope-public-col2" class="home-static-container">' . $col2 . '</div>';
		} else {
			$content .= $col1;
		}
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';

	// Footer
	$content .= '<div class="elgg-page-footer"><div class="elgg-inner">';
		$content .= elgg_view('page/elements/footer');
	$content .= '</div></div>';
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

