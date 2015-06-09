<?php

/**
 * Elgg invite language file
 * 
 * @package ElggInviteFriends
 */

$french = array(

	'friends:invite' => "Proposer de rejoindre le réseau",
	
	'invitefriends:registration_disabled' => "L'enregistrement des nouveaux utilisateurs a été désactivé sur ce site, vous ne pouvez pas inviter de nouveaux utilisateurs.",
	
	'invitefriends:introduction' => "Pour inviter d'autres personnes à vous rejoindre sur ce réseau, entrez leurs adresses mail ci-dessous (une par ligne).",
	'invitefriends:message' => "Personnalisez le message qu'ils vont recevoir avec votre invitation :",
	'invitefriends:subject' => "Invitation à rejoindre %s",

	'invitefriends:success' => "Vos contacts ont été invités.",
	'invitefriends:invitations_sent' => "Invitation envoyé: %s. Il ya eu les problèmes suivants :",
	'invitefriends:email_error' => "Les invitations ont été envoyées, mais l'adresse suivante comporte des erreurs: %s",
	'invitefriends:already_members' => "Les invités suivants sont déja membres: %s",
	'invitefriends:noemails' => "Aucune adresse email n'a été entrée",
	
	'invitefriends:message:default' => "
Bonjour,

Je souhaiterais vous inviter à rejoindre %s.",

	'invitefriends:email' => "
%2\$s vous invite à rejoindre %1\$s :

%3\$s

Pour vous inscrire, cliquez sur le lien suivant :
%4\$s

%2\$s sera automatiquement ajouté à vos contacts quand vous aurez créé votre compte.

Attention : ce réseau est en accès réservé aux Départements, veuillez utiliser votre adresse professionnelle pour vous inscrire. Si cette adresse est rejetée, veuillez contacter le gestionnaire du site.",
	
);
					
add_translation("fr", $french);
