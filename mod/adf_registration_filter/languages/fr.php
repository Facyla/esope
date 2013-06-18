<?php
/**
 * French strings
 */


$fr = array(
	
	// Overrides default message
	'invitefriends:introduction' => "Pour inviter d'autres personnes à vous rejoindre sur ce réseau, entrez leurs adresses mail ci-dessous (une par ligne).<br />
	Attention : l'inscription est réservée à certains noms de domaines, veillez à n'inviter que des adresses autorisées (cette liste peut être consultée sur la page d'accueil ou d'inscription au site).",
	
	'RegistrationException:InvalidEmail' => "Domaine invalide. Le nom de domaine utilisé ne fait pas partie de la liste des noms de domaines autorisés, et ne vous permet pas de créer un compte sur cette plateforme.",
	'registration_filter:whitelist' => "Liste des noms de domaines acceptés pour la création des comptes. Un nom de domaine par ligne, pas d'espace vide.<br />Vous avez également la possibilité d'utiliser les virgules et points-virgules comme séparateur.",
	'registration_filter:whitelist:default' => "",
	'registration_filter:register:whitelist' => "Pour pouvoir vous inscrire, le nom de domaine de votre adresse email doit faire partie de la liste suivante : ",
	
);

add_translation('fr', $fr);
