<?php
/**
 * Elgg dossierdepreuve auto-positionnement *public form
 * 
 * @package Elggdossierdepreuve
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

/* Comportement en mode public :
 * On doit afficher une alerte + un moyen pour se connecter pour ceux qui ont déjà un compte
 * Pour les autres, le process doit permettre de conserver les données si c'est souhaité :
 * On peut générer un code qui permet de reprendre sa saisie à partir des réponses faites (via l'URL)
 * Pour conserver les données, on peut aussi proposer de créer un compte et d'associer a posteriori ce dossier à un compte (via l'URL par exemple)
 */

if (elgg_is_logged_in()) {
	elgg_set_page_owner_guid($_SESSION['guid']);
	/*
	// Selon les types de profil
	if (elgg_is_admin_logged_in()) {
		$profile_type = 'admin';
	} else {
		$profile_type = dossierdepreuve_get_rights('edit', elgg_get_logged_in_user_entity());
	}
	*/
} else {
	$public_mode = true;
	elgg_set_page_owner_guid($CONFIG->site->guid);
}
$page_owner = elgg_get_page_owner_entity(); // Get the page owner : logged in user, or site
$content = '';

// Render the dossierdepreuve autopositionnement form page
//$pagetitle = elgg_echo("dossierdepreuve:auto:new");
$pagetitle = elgg_echo("dossierdepreuve:auto:title");
$title = elgg_view_title($pagetitle);
$content .= '<div id="autopositionnement">' . elgg_view("forms/dossierdepreuve/autopositionnement", array()) . '</div>';


$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));
echo elgg_view_page($pagetitle, $body);


