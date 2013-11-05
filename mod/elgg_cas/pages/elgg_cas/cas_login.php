<?php
$title = elgg_echo('elgg_cas:title');
$content = '';

// Uncomment to enable debugging
phpCAS::setDebug();


// Initialize phpCAS
global $cas_client_loaded;
if (!$cas_client_loaded) phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
//if (!empty($cas_server_ca_cert_path) && (phpCAS::setCasServerCACert($cas_server_ca_cert_path))) {} else 
//phpCAS::setNoCasServerValidation();


// Le plus flexible : activé si configuré seulement (attention ! une mauvaise config peut bloquer l'utilisation...)
if (!empty($cas_server_ca_cert_path)) {
	phpCAS::setCasServerCACert($cas_server_ca_cert_path);
} else {
	phpCAS::setNoCasServerValidation();
}


// logout if desired
if (isset($_REQUEST['logout'])) {
	phpCAS::logout();
}


if (elgg_is_logged_in()) {
	// Si on est déjà identifié sans CAS, inutile de se re-logguer
	$logged = elgg_get_logged_in_user_entity();
	if (phpCAS::isAuthenticated()) {
		$elgg_username = phpCAS::getUser();
		$user = get_user_by_username($elgg_username);
		if ($user->guid == $logged->guid) { $user->is_cas_logged = true; }
		$content .= '<p>' . elgg_echo('elgg_cas:logged:cas', array($user->username)) . '</p>';
		$content .= '<p>' . elgg_echo('elgg_cas:confirmchangecaslogin', array($logged->username, $logged->name)) . '</p>';
	} else {
		$content .= '<p>' . elgg_echo('elgg_cas:logged:nocas', array($user->username)) . '</p>';
		$content .= '<p>' . elgg_echo('elgg_cas:confirmcaslogin', array($logged->username, $logged->name)) . '</p>';
	}
	// Affichage
	$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
	echo elgg_view_page($title, $content);
	exit;
}



// force CAS authentication
phpCAS::forceAuthentication();

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().


// A ce stade, l'identification via CAS est OK
$elgg_username = phpCAS::getUser();
$user = get_user_by_username($elgg_username);

// Si on est identifié avec un autre compte avant de passer par CAS, on prévient et on arrête la procédure
if (elgg_is_logged_in()) {
	$logged = elgg_get_logged_in_user_entity();
	if ($user->guid != $logged->guid) {
		register_error(elgg_echo('elgg_cas:alreadylogged', array($user->username, $user->name, $logged->username, $logged->name)));
		forward();
	}
}

// Si on est bien authentifié via CAS, login
if (elgg_instanceof($user, 'user')) {
	if (!$user->isBanned()) {
		// CAS is valid, update metadata and finally log user in !
		$user->is_cas_logged = true;
		system_message(elgg_echo('elgg_cas:login:success'));
		if (login($user)) {
			forward();
			// Ou on peut aussi afficher un message...
			$content .= '<p>' . elgg_echo('elgg_cas:login:success') . '</p>';
			$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
			echo elgg_view_page($title, $content);
		} else { register_error('elgg_cas:loginfailed'); }
	} else {
		register_error(elgg_echo('elgg_cas:user:banned'));
		echo elgg_echo('elgg_cas:user:banned');
	}
} else {
	register_error(elgg_echo('elgg_cas:user:notexist'));
	echo elgg_echo('elgg_cas:user:notexist');
}


