<?php
/**
 * Translation file
 *
 * Note: don't change the return array to short notation because Transifex can't handle those during `tx push -s`
 */

return array(
	
	'relationship:friendrequest' => "%s a demandé à être en contact avec %s",
	'relationship:friendrequest:pending' => "%s souhaite faire partie de vos contacts",
	'relationship:friendrequest:sent' => "Vous avez demandé à être en contact avec %s",
	
	// plugin settings
	'friends:settings:request:description' => "Après avoir activé les demandes de contact en tant que fonctionnalité du plugin Friends, lorsque l’utilisateur A veut être en contact avec l’utilisateur B, l’utilisateur B doit approuver la demande. Lors de l’approbation, l’utilisateur A sera en contact avec l’utilisateur B et l’utilisateur B sera en contact avec l’utilisateur A.",
	'friends:settings:request:label' => "Activer les demandes de contacts",
	'friends:settings:request:help' => "Les membres doivent approuver les demandes de contact et les contacts deviennent réciproques",
	
	'friends:owned' => "Contacts de %s",
	'friend:add' => "Ajouter un contact",
	'friend:remove' => "Retirer le contact",
	'friends:menu:request:status:pending' => "Demande de contact en attente",

	'friends:add:successful' => "Vous avez bien ajouté %s comme contact.",
	'friends:add:duplicate' => "Vous êtes déjà en contact avec %s",
	'friends:add:failure' => "%s n'a pas pu être ajouté comme contact.",
	'friends:request:successful' => 'Une demande de contact a été envoyée à %s',
	'friends:request:error' => 'Une erreur s\'est produite lors du traitement de votre demande de contact avec %s',

	'friends:remove:successful' => "Vous avez bien retiré %s de vos contacts.",
	'friends:remove:no_friend' => "Vous et %s n'êtes pas en contact",
	'friends:remove:failure' => "%s n'a pas pu être retiré de vos contacts.",

	'friends:none' => "Aucun contact pour le moment.",
	'friends:of:owned' => "Membres qui ont %s comme contact",

	'friends:of' => "Contact de",
	
	'friends:request:pending' => "Demandes de contact en attente",
	'friends:request:pending:none' => "Aucune demande de contact en attente trouvée.",
	'friends:request:sent' => "Envoyer des demandes de contact",
	'friends:request:sent:none' => "Aucune demande de contact n'a été envoyée.",
	
	'friends:num_display' => "Nombre de contacts à afficher",
	
	'widgets:friends:name' => "Contacts",
	'widgets:friends:description' => "Affiche une partie de vos contacts.",
	
	'friends:notification:request:subject' => "%s souhaite faire partie de vos contacts !",
	'friends:notification:request:message' => "Bonjour %s,

%s a demandé à être en contact avec vous sur %s.

Pour voir cette demande de contact, cliquez ici :
%s",
	
	'friends:notification:request:decline:subject' => "%s a décliné votre demande de contact",
	'friends:notification:request:decline:message' => "Bonjour %s,

%s a décliné votre demande de contact.",
	
	'friends:notification:request:accept:subject' => "%s a accepté votre demande de contact",
	'friends:notification:request:accept:message' => "Bonjour %s,

%s a accepté votre demande de contact.",
	
	'friends:action:friendrequest:revoke:fail' => "Une erreur s'est produite lors de l'annulation de la demande de contact, veuillez réessayer",
	'friends:action:friendrequest:revoke:success' => "La demande de contact a été annulée",
	
	'friends:action:friendrequest:decline:fail' => "Une erreur s'est produite lors du refus de la demande de contact, veuillez réessayer",
	'friends:action:friendrequest:decline:success' => "La demande de contact a été déclinée",
	
	'friends:action:friendrequest:accept:fail' => "Une erreur s'est produite lors de l'acceptation de la demande de contact, veuillez réessayer",
	'friends:action:friendrequest:accept:success' => "La demande de contact a été acceptée",
);
