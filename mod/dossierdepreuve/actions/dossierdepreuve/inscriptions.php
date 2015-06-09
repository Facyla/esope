<?php
/**
 * Edit members properties
 */
global $CONFIG;
gatekeeper();
action_gatekeeper();

// Restriction de l'inscription aux profils autorisés
$editor = elgg_get_logged_in_user_entity();
$editor_profile_type = dossierdepreuve_get_user_profile_type($editor);
if (!in_array($editor_profile_type, array('tutor', 'evaluator', 'organisation')) && !elgg_is_admin_logged_in()) {
	register_error(elgg_echo('dossierdepreuve:error:cantedit'));
	forward(REFERER);
}

$editor_guid = $editor->guid;
$editor_name = $editor->name;
$sitename = $CONFIG->site->name;
$siteurl = $CONFIG->url;
$ts = time();

// Get vars
// Types de profils
$profiletype = get_input('profiletype', 'learner');
$profilename = elgg_echo('profile:types:' . $profiletype);
$profile_types_options = array(
		"type" => "object", "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
		"owner_guid" => elgg_get_site_entity()->getGUID(), "limit" => false,
	);
if ($custom_profile_types = elgg_get_entities($profile_types_options)) {
	foreach($custom_profile_types as $type) {
		if ($type->metadata_name == $profiletype) { $profileguid = $type->guid; }
	}
}
// Facultatif : groupe de formation
$group_guid = get_input('group_guid', false);
if ($group_guid) {
	if ($group = get_entity($group_guid)) { $group_name = $group->name; }
}
// Emails à inscrire
$register_emails = get_input('register_emails', false);
$add_contact = get_input('add_contact', false);
// Facultatif : mise en contact automatique
if ($add_contact == 'yes') $contact_guid = get_input('contact_guid', 0);
if ($contact_guid) {
	if ($contact = get_entity($contact_guid)) {}
} else { $contact_guid = 0; }

// Données nécessaires pour continuer : emails et type de profil
if (!$register_emails || !$profiletype) {
  register_error(elgg_echo('dossierdepreuve:error:invaliduser'));
  forward(REFERER);
}


// Email list : basic list
// Note : we could use a | separator to generate usernames, names and other infos as well
$register_emails = preg_replace('/\r\n|\r/', "\n", $register_emails);
// Add csv support - cut also on ";" and ","
$register_emails = str_replace(array(' ', '<p>', '</p>'), '', $register_emails); // Delete paragraphs and white spaces
$register_emails = str_replace(array(';', ','), "\n", $register_emails);
$emails = explode("\n",$register_emails);
$emails = array_unique($emails);

$i = 0;
$report = '';
$error_report = '';
$register_subject = "Votre compte utilisateur a été créé sur " . $sitename;
// Ignore les accès pour pouvoir changer d'username même si c'est réservé aux admins
$ignore_access = elgg_get_ignore_access(); elgg_set_ignore_access(true);
foreach ($emails as $email) {
	$i++;
	$error = false; $guid = false;
	// On nettoie l'adresse email au cas où du html soit passé (normalement non mais bon..)
	if (!is_email_address($email)) { $email = strip_tags($email); }
	
	// Si c'est toujours pas valide, il y a réellement un problème..
	if (!is_email_address($email)) {
		$error = "Adresse email non valide : $email";
	} else {
		// Dernier test : email déjà pris ?
		if ($existing_users = get_user_by_email($email)) $error = "Un compte existe déjà avec cet email, sous l'identifiant: " . $existing_users[0]->username;
	}
	
	// Création du compte
	// Note : on peut changer l'username après : 
	// on va donc nommer chaque compte de manière unique (timestamp puis n° d'ordre), 
	// et les renommer une fois l'entité créée, avec le GUID
	if (!$error) {
		$username = 'user_' . $ts . '_' . $i;
		$password = generate_random_cleartext_password();
		$name = explode('@', $email);
		$name = $profilename . ' ' . $name[0];
		$guid = register_user($username, $password, $name, $email, false, $contact_guid, '');
	}
	// Mise à jour du nouveau compte et rapport
	if ($guid) {
		$new_user = get_entity($guid);
		$username = $profiletype . '_' . $guid;
		// Update username (can't use ->username = $username so do it directly in DB)
		$query = "UPDATE {$CONFIG->dbprefix}users_entity SET username='$username' WHERE guid = $guid";
		$result = update_data($query);
		// Set profile type
		$new_user->custom_profile_type = $profileguid;
		// Add friend
		error_log("Contact : $add_contact $contact_guid - ".print_r($contact));
		if ($contact) {
			$new_user->addFriend($contact_guid);
			$contact->addFriend($guid);
		}
		$register_message = "Bonjour,<br />Votre compte utilisateur a été créé par {$editor_name} sur le site {$sitename}.<br /<br /Vous pouvez vous connecter avec les informations suivantes :<br /> - Adresse de connexion : <strong>{$siteurl}</strong><br /> - identifiant de connexion : votre email <strong>{$email}</strong> (ou votre nom d'utilisateur : <strong>{$username}</strong>)<br /> - mot de passe : <strong>{$password}</strong><br />Merci de conserver précieusement ces informations.<br />";
		// Register to group
		if ($group) {
			if ($profiletype == 'learner') $user->learner_group_b2i = $group->guid;
			if ($group->join($new_user)) {
				$register_message .= "<br />Vous avez été inscrit dans le groupe : <strong>{$group_name}</strong>.<br />";
			}
		}
		notify_user($guid, $editor_guid, $register_subject, $register_message, null, 'email');
		$report[] = "$email : identifiant: $username - mot de passe: $password";
		system_message("Compte crée pour l'email : $email");
	} else {
		$error_report[] = "$email : $error";
	}
}
elgg_set_ignore_access($ignore_access);


// Rapport et messages d'erreur éventuels
if ($report) {
	if (count($report) > 1) system_messages(count($report) . " comptes ont bien été créés.");
	else if (count($report) == 1) system_messages(count($report) . " compte a bien été créé.");
}
if ($error_report) register_error("Erreur lors la création de " . count($error_report) . " comptes. Un rapport par email vous a été envoyé.");

$subject = "Rapport de création des comptes utilisateurs";
$message = "$subject&nbsp;:<br />";
if ($report) $message .= "<br /><strong>Comptes correctement créés&nbsp;:</strong><br />" . implode('<br />', $report) . "<br />";
if ($error_report) $message .= "<br /><strong>Erreurs (compte non créés)&nbsp;:</strong><br />" . implode('<br />', $error_report) . "<br />";
if (notify_user($editor_guid, $editor_guid, $subject, $message, null, 'email')) {
	system_message("Un rapport vous a été envoyé par mail avec le contenu des messages de réussite et d'erreur.");
} else {
	register_error("Une erreur s'est produite lors de l'envoi du rapport.");
}

forward(REFERER);


