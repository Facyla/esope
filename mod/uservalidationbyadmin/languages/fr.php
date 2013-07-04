<?php
/**
 * Email user validation plugin language pack.
 *
 * @package Elgg.Core.Plugin
 * @subpackage Elgguservalidationbyadmin
 */

$fr = array(
	'admin:users:unvalidated' => 'Non validés',
	
	'email:validate:subject' => "%s demande la validation de son compte pour %s!",
	'email:validate:body' => "Bonjour %s,

Un membre nommé %s vous demande la validation de son compte. 

Les informations géographiques de l'utilisateur sont 
Adresse IP : %s
Emplacement probable : %s

Vous pouvez valider son compte en cliquant sur le lien ci-dessous :

%s

Si vous ne pouvez pas cliquer sur le lien, veuillez le copier-coller dans votre navigateur.

%s
%s
",

	'user:validate:subject' => "Bonjour %s ! Votre compte est activé",
	'user:validate:body' => "Bonjour %s,

This is to notify that your account at %s is activated by the admin. 

You can now login to the site with:

Username : %s
Password : the one you provided while registration

%s
%s
",

	'email:confirm:success' => "Ce compte utilisateur est maintenant validé",
	'email:confirm:fail' => "Ce compte utilisateur n'a pas pu être validé...",

	'uservalidationbyadmin:registerok' => "Vous recevrez un mail de confirmation dès que l'administrateur aura confirmé votre demande de création de compte",
	'uservalidationbyadmin:login:fail' => "Votre compte n'est pas validé, c'est pourquoi vous n'avez pas pu vous identifier. Vous devez attendre qu'un administrateur valide votre compte.",

	'uservalidationbyadmin:admin:no_unvalidated_users' => 'No unvalidated users.',

	'uservalidationbyadmin:admin:unvalidated' => 'Non validé',
	'uservalidationbyadmin:admin:user_created' => '%s a été inscrit',
	'uservalidationbyadmin:admin:resend_validation' => 'Renvoyer la validation validation',
	'uservalidationbyadmin:admin:validate' => 'Valider',
	'uservalidationbyadmin:admin:delete' => 'Supprimer',
	'uservalidationbyadmin:confirm_validate_user' => 'Valider %s ?',
	'uservalidationbyadmin:confirm_resend_validation' => 'Resend validation email to %s?',
	'uservalidationbyadmin:confirm_delete' => 'Supprimer %s ?',
	'uservalidationbyadmin:confirm_validate_checked' => 'Valider les comptes utilisateurs sélectionnés ?',
	'uservalidationbyadmin:confirm_resend_validation_checked' => 'Renovyer une validation aux comptes utilisateurs sélectionnés ?',
	'uservalidationbyadmin:confirm_delete_checked' => 'Supprimer les comptes utilisateurs sélectionnés ?',
	'uservalidationbyadmin:check_all' => 'Tous',

	'uservalidationbyadmin:errors:unknown_users' => 'Comptes utilisateurs inconnus',
	'uservalidationbyadmin:errors:could_not_validate_user' => 'Impossible de valider ce compte utilisateur.',
	'uservalidationbyadmin:errors:could_not_validate_users' => 'Impossible de valider tous les comptes utilisateurs sélectionnés.',
	'uservalidationbyadmin:errors:could_not_delete_user' => 'Impossible de supprimer le compte utilisateur.',
	'uservalidationbyadmin:errors:could_not_delete_users' => 'Impossible de supprimer tous les comptes utilisateurs sélectionnés.',
	'uservalidationbyadmin:errors:could_not_resend_validation' => 'Impossible de renvoyer la demande de validation.',
	'uservalidationbyadmin:errors:could_not_resend_validations' => 'Impossible de renvoyer toutes les demandes de validation aux comptes utilisateurs sélectionnés.',

	'uservalidationbyadmin:messages:validated_user' => 'Compte utilisateur validé.',
	'uservalidationbyadmin:messages:validated_users' => 'Tous les comptes utilisateurs sélectionnés ont été validés.',
	'uservalidationbyadmin:messages:deleted_user' => 'Compte utilisateur supprimé.',
	'uservalidationbyadmin:messages:deleted_users' => 'Tous les comptes utilisateurs sélectionnés ont été supprimés.',
	'uservalidationbyadmin:messages:resent_validation' => 'Demande de validation envoyée à nouveau.',
	'uservalidationbyadmin:messages:resent_validations' => 'Demandes de validation envoyées à nouveau à chacun des comptes utilisateurs sélectionnés.'

);

add_translation("fr", $fr);

