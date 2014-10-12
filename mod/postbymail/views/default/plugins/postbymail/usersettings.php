<?php
/* Paramètres personnels de chacun des membres concernant ce plugin
 * => adresses email supplémentaires rattachées à ce compte
 * Process pour ajouter une nouvelle adresse mail :
	- champ nouvelle adresse puis Envoi
	- au rechargement de la page, si $vars['entity']->new_alternatemail est une adresse email valide, on l'ajoute à $alternatemail_setting'
 * Process pour retirer une adresse mail :
	- lien sur les adresses existantes, avec la valeur de l'adresse et un param pour la retirer
	- confirmation JS de la suppression
	- au rechargement de la page, si get_input('delete_alternatemail') est renseigné et correspond à une adresse existante de $alternatemail_setting, on la retire du tableau
 *
 */
global $CONFIG;

// $yesno_opt = array('no' => elgg_echo('postbymail:settings:no'), 'yes' => elgg_echo('postbymail:settings:yes'));

$user = elgg_get_logged_in_user_entity();
$user_guid = $user->guid;

// Les adresses enregistrées, avant toute autre action
$alternatemail_setting = elgg_get_plugin_user_setting('alternatemail', $user_guid, 'postbymail');
$alternatemails = explode(',', $alternatemail_setting);
// Valeur par défaut (utilisée si échec d'ajout d'une nouvelle adresse)
$new_alternatemail = '';
$delete_email = '';


// AJOUT EMAIL

// Si une nouvelle adresse doit être ajoutée, vérification et ajout
$new_email = elgg_get_plugin_user_setting('new_alternatemail', $user_guid, 'postbymail');

// Si on a une nouvelle adresse à ajouter à la liste
if (!empty($new_email)) {
	if (is_email_address($new_email)) {
		$new_alternatemail = $new_email;
		// Pas de doublon d'email avec ce système sinon on ne va plus savoir qui est qui...
		$existing_user = get_user_by_email($new_email);
		// 2e niveau de vérification pour éviter les doublons dans les adresses déclarées
		// ça n'empêchera pas un nouveau membre inscrit directement sur l'une de ces adresses de se l'approprier
		// (ce qui est normal car dans son cas on vérifie que l'auteur a bien accès à ce mail - ici non), 
		// mais dans ce cas le mail du nouveau membre prendra le pas sur ce paramètre car on prend les emails légitimes en priorité
		if (!$existing_user) {
			// L'email ne doit pas être déjà enregistré dans la liste de *tous* les paramètres privés
			if ($results = get_data("SELECT * from {$CONFIG->dbprefix}private_settings where name = 'plugin:user_setting:postbymail:alternatemail'")) {
				foreach ($results as $r) {
					$emails = $r->value;
					if (!empty($emails)) {
						$emails = explode(',', $emails);
						foreach ($emails as $email) {
							//$alternatemails[$r->entity_guid] = $email; // utiliserait pls clefs identiques - on évite..
							// L'important est de trouver un user valide, donc on arrête dès qu'on trouve..
							// sauf si on veut permettre des envois depuis pls adresses mais a priori on évite
							echo ", $email";
							if (($email == $sendermail) || ($email == $realsendermail)) {
								$existing_user = true;
								break;
							}
						}
					}
					// On s'arrête si on a trouvé
					if ($existing_user) break;
				}
			}
		}
		if (!$existing_user && !empty($new_email)) {
			if (empty($alternatemail) || !in_array($new_email, $alternatemails)) {
				if (empty($alternatemail_setting) || (sizeof($alternatemails) == 0) || (sizeof($alternatemails) == 1 && empty($alternatemails[0]))) {
					$alternatemails = array($new_email);
				} else {
					$alternatemails[] = $new_email;
				}
				// Suppression des entrées vides
				$alternatemails = array_filter($alternatemails);
				system_message(elgg_echo('postbymail:usersettings:success:emailadded', array($new_email)));
			} else {
				register_error(elgg_echo('postbymail:usersettings:error:alreadyregistered'));
			}
		} else {
			register_error(elgg_echo('postbymail:usersettings:error:alreadyused', array($new_email)));
		}
		// Si OK ou déjà enregistré, on supprime la valeur par défaut et l'adresse à ajouter
		$new_alternatemail = '';
		$alternatemail_setting = implode(',', $alternatemails);
		elgg_set_plugin_user_setting('alternatemail', $alternatemail_setting, $user_guid, 'postbymail');
		elgg_set_plugin_user_setting('new_alternatemail', '', $user_guid, 'postbymail');
		// On nettoie l'URL des variables passées..
		forward($vars['url'] . 'settings/plugins/' . $_SESSION['user']->username);
	} else {
		register_error(elgg_echo('postbymail:usersettings:error:invalidemeail'));
	}
}


// SUPPRESSION EMAILS

// Si une adresse doit être retirée, on le fait
$delete_email = get_input('delete_alternatemail', 'false');
if ($delete_email != 'false') {
	$delete_email = urldecode($delete_email);
	// On ne supprime que s'il y a qqch à supprimer ou si vide..
	if (!empty($alternatemail_setting) && (in_array($delete_email, $alternatemails) || empty($delete_email))) {
		foreach ($alternatemails as $key => $alternatemail) {
			if (empty($alternatemail) || ($alternatemail == $delete_email)) { unset($alternatemails[$key]); }
		}
		// Suppression des entrées vides
		$alternatemails = array_filter($alternatemails);
		// Save updated email list into usersettings
		$alternatemail_setting = implode(',', $alternatemails);
		//set_plugin_usersetting('alternatemail', $alternatemail_setting, $_SESSION['user']->guid, 'postbymail');
		elgg_set_plugin_user_setting('alternatemail', $alternatemail_setting, $user_guid, 'postbymail');
		system_message(elgg_echo('postbymail:usersettings:success:emailremoved', array($delete_email)));
		// On nettoie l'URL des variables passées..
		forward($vars['url'] . 'settings/plugins/' . $_SESSION['user']->username);
	}
}



// FORMULAIRE

// Explications
echo '<p>' . elgg_echo('postbymail:usersettings:alternatemail:help') . '</p>';

// Adresse principale = d'inscription
echo '<p>' . sprintf(elgg_echo('postbymail:usersettings:accountemail'), $_SESSION['user']->email) . '</p>';

// Listing des adresses enregistrées et lien pour en retirer une
echo '<h4>' . elgg_echo('postbymail:usersettings:alternatemail:list') . '</h4>';
if (!empty($alternatemail_setting)) {
	$alternatemails = explode(',', $alternatemail_setting);
	echo '<ul>';
	foreach ($alternatemails as $alternatemail) {
		echo '<li>' . $alternatemail . ' &nbsp; <span class="delete_alternatemail"><a href="?delete_alternatemail='.rawurlencode($alternatemail).'"><i class="fa fa-trash-o"></i></a></span></li>';
	}
	echo '</ul>';
} else {
	echo elgg_echo('postbymail:usersettings:alternatemail:none');
}

// Ajout d'une nouvelle adresse
echo '<br />';
echo '<br /><label style="clear:left;">' . elgg_echo('postbymail:usersettings:alternatemail:add') . ' ' . elgg_view('input/text', array('name' => 'params[new_alternatemail]', 'value' => $new_alternatemail)) . '</label>';

// Passage valeur pour mise à jour rapide du champ
//echo elgg_view('input/hidden', array('name' => 'params[alternatemail]', 'value' => $alternatemail_setting));



