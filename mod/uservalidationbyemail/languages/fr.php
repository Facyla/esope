<?php
/**
 * Email user validation plugin language pack.
 *
 * @package Elgg.Core.Plugin
 * @subpackage ElggUserValidationByEmail
 */

$french = array(
	'admin:users:unvalidated' => "Invalidées",
	
	'email:validate:subject' => "%s veuillez confirmer votre adresse de courriel !",
	'email:validate:body' => "Bonjour %s,

Avant que vous puissiez commencer à utiliser %s, vous devez confirmer que l'adresse email utilisée est bien la vôtre.

Pour confirmer votre adresse et activer votre compte, veuillez cliquer sur le lien suivant:

%s

Si vous ne pouvez pas cliquer sur le lien, copiez et collez-le dans votre navigateur manuellement.

%s
%s
",
	'email:confirm:success' => "Vous avez validé votre adresse de courriel !",
	'email:confirm:fail' => "Votre adresse de courriel n'a pu être vérifiée...",

	'uservalidationbyemail:registerok' => "Pour activer votre compte, veuillez confirmer votre adresse e-mail en cliquant sur le lien qui vient de vous être envoyé (si vous ne recevez rien, veuillez vérifier votre dossier 'Spam' ou 'Indésirables').",
	'uservalidationbyemail:login:fail' => "Votre compte n'est pas validé, par conséquent la tentative de connexion a échoué. Un autre e-mail de validation vient de vous être envoyé.",

	'uservalidationbyemail:admin:no_unvalidated_users' => "Aucun utilisateurs non-validés.",

	'uservalidationbyemail:admin:unvalidated' => "Invalidés",
	'uservalidationbyemail:admin:user_created' => "%s enregistré",
	'uservalidationbyemail:admin:resend_validation' => "Renvoyer la validation",
	'uservalidationbyemail:admin:validate' => "Valider",
	'uservalidationbyemail:admin:delete' => "Supprimer",
	'uservalidationbyemail:confirm_validate_user' => "Valider %s ?",
	'uservalidationbyemail:confirm_resend_validation' => "Renvoyer la validation e-mail à %s ?",
	'uservalidationbyemail:confirm_delete' => "Supprimer %s ?",
	'uservalidationbyemail:confirm_validate_checked' => "Valider les utilisateurs cochés ?",
	'uservalidationbyemail:confirm_resend_validation_checked' => "Renvoyer la validation aux utilisateurs cochés ?",
	'uservalidationbyemail:confirm_delete_checked' => "Supprimer les utilisateurs cochés ?",
	'uservalidationbyemail:check_all' => "Tous",

	'uservalidationbyemail:errors:unknown_users' => "Utilisateurs inconnus",
	'uservalidationbyemail:errors:could_not_validate_user' => "Impossible de valider l'utilisateur.",
	'uservalidationbyemail:errors:could_not_validate_users' => "Impossible de valider tout les utilisateurs cochés.",
	'uservalidationbyemail:errors:could_not_delete_user' => "Impossible de supprimer l'utilisateur.",
	'uservalidationbyemail:errors:could_not_delete_users' => "Impossible de supprimer tout les utilisateurs cochés.",
	'uservalidationbyemail:errors:could_not_resend_validation' => "Impossible de renvoyer la demande de validation.",
	'uservalidationbyemail:errors:could_not_resend_validations' => "Impossible de renvoyer toutes les demandes de validation aux utilisateurs cochés.",

	'uservalidationbyemail:messages:validated_user' => "Utilisateur validé.",
	'uservalidationbyemail:messages:validated_users' => "Tout les utilisateurs cochés ont été validés.",
	'uservalidationbyemail:messages:deleted_user' => "Utilisateur supprimé.",
	'uservalidationbyemail:messages:deleted_users' => "Tout les utilisateurs cochés ont été supprimés.",
	'uservalidationbyemail:messages:resent_validation' => "Demande de validation renvoyée.",
	'uservalidationbyemail:messages:resent_validations' => "Demandes de validation renvoyées à tous les utilisateurs cochés.",

);

add_translation("fr", $french);
