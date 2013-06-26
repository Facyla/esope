<?php
/**
 * Elgg dossierdepreuve inscription candidats
 * 
 * @package Elggdossierdepreuve
 * @author Facyla
 * @copyright Items International 2013
 * @link http://items.fr/
 */

global $CONFIG;

/* Organisations : inscription des formateurs et habilitateurs
 * Formateurs et habilitateurs : inscription des apprenants
 * 
 * Les inscriptions se font via une liste d'adresses emails + type de profil + groupe d'inscription
 * Un rapport est généré pour suivre les inscriptions
 */

$content = '';


// Initialisation data : vars
$editor = elgg_get_logged_in_user_entity();
$editor_guid = elgg_get_logged_in_user_guid();
$editor_profile_type = dossierdepreuve_get_user_profile_type($editor);
$typedossier = 'b2iadultes';

// Liste de valeurs des sélecteurs

// Mise en contact automatique
$add_contact_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

// Type de dossier
$typedossier_values = array(
	  "" => elgg_echo ('dossierdepreuve:choose'),
		'b2iadultes' => "B2i Adultes",
		/*
		'b2i' => "B2i",
		'passnumrra' => "Pass'Numérique",
		*/
	);

/* Type de profil : les options dépendent des profils
 * Les organisations peuvent créer des comptes pour les formateurs, les habilitateurs et les candidats
 * Les formateurs et les habilitateurs peuvent créer les comptes des candidats
 */
$profiletype_opt[elgg_echo('profile:types:learner')] = 'learner';
if (($editor_profile_type == 'organisation') || elgg_is_admin_logged_in()) {
	$profiletype_opt[elgg_echo('profile:types:tutor')] = 'tutor';
	$profiletype_opt[elgg_echo('profile:types:evaluator')] = 'evaluator';
} else if (($editor_profile_type == 'evaluator')) {
	$profiletype_opt[elgg_echo('profile:types:tutor')] = 'tutor';
}
if (elgg_is_admin_logged_in()) $profiletype_opt[elgg_echo('profile:types:organisation')] = 'organisation';

/* Groupes : les groupes dont l'éditeur est membre ou propriétaire seulement */
$all_groups_count = elgg_get_entities(array('types' => 'group', 'count' => true));
$all_groups = elgg_get_entities(array('types' => 'group', 'count' => false, 'limit' => $all_groups_count));
// Liste des groupes B2i
$groups_opt = array('' => elgg_echo('dossierdepreuve:learner_group:none'));
foreach ($all_groups as $ent) {
	if (elgg_instanceof($ent, 'group')) {
		if ($ent->isMember() || elgg_is_admin_logged_in()) {
			$groups_opt[$ent->guid] = $ent->name . ' (groupe ' . $ent->grouptype . ')';
		}
	}
}

// Valeurs par défaut ou passée via URL
// Mise en contact automatique
$profiletype = get_input('profiletype', 'learner');
// Groupe automatique
$group_guid = get_input('group_guid', '');
// Emails à inscrire
$register_emails = get_input('register_emails', '');
// Mise en contact automatique
$add_contact = get_input('add_contact', 'yes');


// Le formulaire proprement dit
echo '<form action="' . $vars['url'] . 'action/dossierdepreuve/inscription" enctype="multipart/form-data" method="post">';
echo elgg_view('input/securitytoken');

// Type de profil : les options dépendent des profils
echo '<p><label for="dossierdepreuve_profiletype">' . elgg_echo('dossierdepreuve:profiletype') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:profiletype:help') . elgg_view('input/radio', array('name' => 'profiletype', 'id' => 'dossierdepreuve_profiletype', 'options' => $profiletype_opt, 'class' => '', 'value' => $profiletype)) . '</p><br />';

// Inscription dans un Groupe
echo '<p><label for="dossierdepreuve_registergroup">' . elgg_echo('dossierdepreuve:registergroup') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:registergroup:help') . elgg_view('input/dropdown', array('value' => $group_guid, 'name' => 'group_guid', 'id' => 'dossierdepreuve_registergroup', 'options_values' => $groups_opt, 'js' => 'style=""')) . '</p><br />';

// Liste des emails à inscrire
echo '<p><label for="dossierdepreuve_register_emails">' . elgg_echo('dossierdepreuve:register_emails') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:register_emails:help') . elgg_view('input/plaintext', array('value' => $register_emails, 'name' => 'register_emails', 'id' => 'dossierdepreuve_register_emails', 'js' => 'style=""')) . '</p>';

// Mise en contact automatique
echo '<input type="hidden" name="contact_guid" value="' . $editor_guid . '" />';
echo '<p><label for="dossierdepreuve_autocontact">' . elgg_echo('dossierdepreuve:add_contact') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:add_contact:help') . elgg_view('input/dropdown', array('value' => $add_contact, 'name' => 'add_contact', 'id' => 'dossierdepreuve_autocontact', 'options_values' => $add_contact_opt, 'js' => 'style=""')) . '</p><br />';

echo '<div class="clearfloat"></div>';


// Hidden fields & submit
echo '<div class="clearfloat"></div><br /><br />';
echo '<p>';
	echo elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:doregister"))) . '<br /><br />';
echo '</p>';

echo '</form>';

