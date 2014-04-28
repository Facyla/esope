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
	// CAS autologin, if CAS detected
	if (elgg_is_active_plugin('elgg_cas') && function_exists('elgg_cas_autologin')) {
		elgg_cas_autologin();
		$url = full_url();
		forward($url);
	}
	$imgurl = $CONFIG->url . '_graphics/icons/user/default' . $size . '.gif';
}

// URL or embed ?
if ($embed) {
	echo '<img src="' . $imgurl . '" />';
} else {
	echo $imgurl;
}

