<?php
/**
 * This page is used to provide an easy access to (own) profile user image
 * Could be easily updated to give access to any profile icon
 * Note : This respects user access level on avatar visibility
 * 
 */

global $CONFIG;

$help = get_input('help', false);
//$size = get_input('size', "small");
//$embed = get_input('embed', false);
$username = get_input('username', '');

$title = '';
$content = '';

// Couleurs
$style_h1 = 'font-family: NeoFont, Arial; color:#666; text-transform:capitalize; font-size:26px; font-weight:300; border-bottom:1px solid #DEDEDE; width:100%; margin: 0 0 0.5ex; padding: 1ex 1ex 0.5ex 1ex;';
$style_h2 = 'color:#E33729; text-transform:uppercase; font-size:14px; border-bottom:1px solid #DEDEDE; width:100%; padding: 0.5ex 0ex 0.1ex 0ex; margin: 1ex 0;';
$style_h3 = 'font-size:24px;';


if ($help) {
	header('Content-Type: text/html; charset=utf-8');
	$content .= "<p>Cette page renvoie la fiche de profil du membre souhaité, avec les informaitons de connexion de celui actuellement connecté.</p>";
	elgg_render_embed_content($content, $title);
	exit;
}

$title = '';
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
} else {
	// CAS autologin, if CAS detected
	if (elgg_is_active_plugin('elgg_cas') && function_exists('elgg_cas_autologin')) {
		//elgg_cas_autologin(); // Forwards to home if not logged in
		// CAS login
		elgg_load_library('elgg:elgg_cas');
		//require_once elgg_get_plugins_path() . 'elgg_cas/lib/elgg_cas/config.php';
		$cas_host = elgg_get_plugin_setting('cas_host', 'elgg_cas', '');
		$cas_context = elgg_get_plugin_setting('cas_context', 'elgg_cas', '/cas');
		$cas_port = (int) elgg_get_plugin_setting('cas_port', 'elgg_cas', 443);
		$cas_server_ca_cert_path = elgg_get_plugin_setting('ca_cert_path', 'elgg_cas', '');
		if (!empty($cas_host) && !empty($cas_port) && !empty($cas_context)) {
			global $cas_client_loaded;
			if (!$cas_client_loaded) {
				phpCAS::setDebug();
				phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
				$cas_client_loaded = true;
				if (!empty($cas_server_ca_cert_path)) {
					phpCAS::setCasServerCACert($cas_server_ca_cert_path);
				} else {
					phpCAS::setNoCasServerValidation();
				}
			}
			if (phpCAS::checkAuthentication()) {
				$elgg_username = phpCAS::getUser();
				$own = get_user_by_username($elgg_username);
				// Need to log in user so access levels apply
				if (elgg_instanceof($own, 'user')) login($own);
			}
		}
	}
}


// Choix de l'user à afficher
if (empty($username)) {
	// Par défaut : membre connecté
	if (elgg_instanceof($own, 'user')) { $user = $own; } 
} else {
	// Pour avoir l'image d'un autre membre
	$user = get_user_by_username($username);
}

$content = '<div style="">';

// Vérification si tout est ok pour affichage
if (elgg_instanceof($user, 'user')) {
	// Autorisé si l'user l'autorise, ou si on est connecté sur Iris ou via CAS
	$allowed = esope_user_profile_gatekeeper($user, false);
	if ($allowed || elgg_instanceof($own, 'user')) {
		
		$title = "Fiche de profil de " . $user->name;
		//$imgurl = $user->getIconURL('medium');
		//$userimg = '<img src="' . $imgurl . '" />';
	
		$profile_type = esope_get_user_profile_type($user);
		if (empty($profile_type)) $profile_type = 'external';
		$statut = elgg_echo('profile:types:'.$profile_type);
	
		$userimg = elgg_view_entity_icon($user, 'medium', array('use_hover' => true, 'use_link' => false));
		$userimg = '<span style="float:left; margin: 0 2ex 1ex 0;">' . $userimg . '</span>';
		
		/* Non utilisé car géré direct par l'intranet
		
		$content .= '<h1 style="' . $style_h1 . '">' . $user->name . '</h1>';
	
		$content .= '<div style="padding:1ex;">';
	
			$content .= '<h2 style="' . $style_h2 . '">' . elgg_echo('theme_inria:profile:maininfo') . '</h2>';
			$content .= '<div class="elgg-output" style="color:#555; width:60%; float:left;"><ul>';
				if (!empty($user->epi_ou_service)) 
				$content .= '<li><strong>' . elgg_echo('profile:epi_ou_service') . '&nbsp;:</strong> ' . $user->epi_ou_service . '</li>';
				if (!empty($user->inria_room)) 
				$content .= '<li><strong>' . elgg_echo('profile:inria_room') . '&nbsp;:</strong> ' . $user->inria_room . '</li>';
				if (!empty($user->email)) 
				$content .= '<li><strong>' . elgg_echo('email') . '&nbsp;:</strong> <a href="mailto:' . $user->email . '" target="_blank">' . $user->email . '</a></li>';
				if (!empty($user->inria_phone)) 
				$content .= '<li><strong>' . elgg_echo('profile:phone') . '&nbsp;:</strong> ' . $user->phone . '</p>';
				if (!empty($user->phone)) 
				$content .= '<li><strong>' . elgg_echo('profile:mobile') . '&nbsp;:</strong> ' . $user->mobile . '</li>';
			$content .= '</ul></div>';
	
			$content .= '<div style="color:#555; width:30%; float:right;">';
				$content .= '<p><strong>' . elgg_echo('profile:inria_location') . '&nbsp;:</strong><br />' . $user->inria_location . '</p>';
			$content .= '</div>';
			$content .= '<div class="clearfloat"></div><br />';
	
			$content .= '<h2 style="' . $style_h2 . '">' . elgg_echo('theme_inria:profile:irisprofile') . '</h2>';
			*/
			
			$content .= $userimg;
			//$content .= '<h3 style="' . $style_h3 . '"><a href="' . $user->getURL() . '">' . $user->name . '</a></h3>';
			$content .= '<h3 style="' . $style_h3 . '">' . $user->name . '</h3>';
			$content .= '<p><strong>' . elgg_echo('theme_inria:userprofile:status') . '&nbsp;:</strong> ' . $statut . '</p>';
			if (!empty($user->briefdescription)) 
			$content .= '<p><strong>' . elgg_echo('profile:briefdescription') . '&nbsp;:</strong> ' . $user->briefdescription . '</p>';
			$content .= '<div class="clearfloat"></div><br />';
			if (!empty($user->skills)) 
			$content .= '<p><strong>' . elgg_echo('skills') . '&nbsp;:</strong> ' . elgg_view('output/tags', array('tags' => $user->skills)) . '</p>';
			if (!empty($user->description)) 
			$content .= '<p><strong>' . elgg_echo('description') . '&nbsp;:</strong> ' . elgg_view('output/longtext', array('value' => $user->description)) . '</p>';
			
		// $content .= '</div>'; // Bloc d'encadrement inutile car seule une partie est utile pour l'intranet
		
	} else {
		$content = elgg_echo('InvalidParameterException:NoEntityFound');
	}
	
} else {
	$content .= elgg_echo('theme_inria:noprofilefound');
}
$content .= '<div class="clearfloat"></div><br />';

/*
if (elgg_is_logged_in()) {
	$content .= '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . '">' . elgg_echo('theme_inria:userprofile:irisopen') . '</a>';
} else {
	$content .= '<a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'login">' . elgg_echo('theme_inria:userprofile:irislogin') . '</a>';
}
*/

$content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';


//elgg_render_embed_content($content = '', $title = '', $embed_mode = 'iframe', $headers);
elgg_render_embed_content($content, $title);



