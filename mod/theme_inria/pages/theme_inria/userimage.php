<?php
/**
 * This page is used to provide an easy access to (own) profile user image
 * Could be easily updated to give access to any profile icon
 * Note : This respects user access level on avatar visibility
 * 
 */

global $CONFIG;

$size = get_input('size', "small");
$embed = get_input('embed', false);
$debug = get_input('debug', false);

if ($size == 'help') {
	header('Content-Type: text/html; charset=utf-8');
	echo "<p>Cette page renvoie l'url de la photo de l'user actuellement connecté. Si l'user n'est pas connecté, l'image par défaut est renvoyée.</p>";
	echo "<p>D'autres dimensions sont disponibles en ajoutant un paramètre ?size=large ; valeurs possibles : topbar, tiny, small, medium, large, master</p>";
	echo "<p>Il est possible de renvoyer une page ne contenant que l'image en ajoutant un paramètre &embed=true</p>";
	echo "<p>Attention : en cas d'image non disponible (ou non configurée par la personne), l'image par défaut de dimensions \"master\" renvoie une image vide (gif de 1x1)</p>";
	echo "<p>Exemple d'URL valides :<br />";
	echo ' - <a href="' . $CONFIG->url . 'inria/userimage">URL standard de la photo</a><br />';
	echo ' - <a href="' . $CONFIG->url . 'inria/userimage?size=master">URL de la photo originale</a> (attention : dimensions variables)<br />';
	echo ' - <a href="' . $CONFIG->url . 'inria/userimage?size=medium&embed=true">URL pour embedder une photo de taille moyenne</a><br />';
	echo "</p>";
	exit;
}

$title = '';
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	//$own = get_user_by_username('test2'); // Pour avoir l'image d'un autre membre
	$imgurl = $own->getIconURL($size);
} else {
	$imgurl = $CONFIG->url . '_graphics/icons/user/default' . $size . '.gif';
	// CAS autologin, if CAS detected
	//if (elgg_is_active_plugin('elgg_cas') && function_exists('elgg_cas_autologin')) {
	if ($debug) echo "Not logged in<br />";
	if (elgg_is_active_plugin('elgg_cas')) {
		//elgg_cas_autologin(); // Forwards to home if not logged in
		// CAS login
		if ($debug) echo "CAS active<br />";
		elgg_load_library('elgg:elgg_cas');
		//require_once elgg_get_plugins_path() . 'elgg_cas/lib/elgg_cas/config.php';
		$cas_host = elgg_get_plugin_setting('cas_host', 'elgg_cas', '');
		$cas_context = elgg_get_plugin_setting('cas_context', 'elgg_cas', '/cas');
		$cas_port = (int) elgg_get_plugin_setting('cas_port', 'elgg_cas', 443);
		$cas_server_ca_cert_path = elgg_get_plugin_setting('ca_cert_path', 'elgg_cas', '');
		if (!empty($cas_host) && !empty($cas_port) && !empty($cas_context)) {
			global $cas_client_loaded;
			if ($debug) echo "CAS test<br />";
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
				if ($debug) echo "AUTH OK<br />";
				$elgg_username = phpCAS::getUser();
				if ($debug) echo "Username : $elgg_username<br />";
				$own = get_user_by_username($elgg_username);
				if (elgg_instanceof($own, 'user')) {
					if ($debug) echo "User OK<br />";
					if (!$own->isBanned()) {
						if ($debug) echo "User not banned<br />";
						$imgurl = $own->getIconURL($size);
						if ($debug) echo "User img url : $imgurl<br />";
					}
				}
			}
		}
	}
}

// URL or embed ?
if ($embed) {
	echo '<img src="' . $imgurl . '" />';
} else {
	echo $imgurl;
}

