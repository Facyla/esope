<?php
/**
 * French strings
 */
$url = elgg_get_site_url();

return [
	'registration_filter' => "Filtre d'inscription",
	
	// Plugin settings
	'registration_filter:whitelist_enable' => "Activer le filtrage par liste blanche",
	'registration_filter:whitelist_enable:details' => "Si ce filtre est activé, seuls des comptes avec un email correspondant à la liste des domaines explicitement autorisés pourront s'inscrire sur le site.",
	'registration_filter:blacklist_enable' => "Activer le filtrage par liste noire",
	'registration_filter:blacklist_enable:details' => "Si ce filtre est activé, les comptes avec un email correspondant à la liste des domaines blacklistés ne seront pas autorisé à s'inscrire sur le site.",
	'registration_filter:modes' => "Il est possible d'activer les deux modes de fonctionnement simultanément, cependant il est généralement inutile d'activer le filtrage par liste noire si le filtrage par liste blanche est déjà activé, dans la mesure ou seuls les emails correspondant aux domaines autorisés pourront s'inscrire.",
	
	'registration_filter:extend_registration_form' => "Etendre le formulaire d'inscription ?",
	'registration_filter:extend_registration_form:details' => "<strong>Oui&nbsp;:</strong> ajoute la liste des noms de domaine autorisés au formulaire d'inscription (vue <em>forms/register</em>). Si la liste est trop longue, elle est tronquée (185 car.) avec un lien pour afficher la suite.<br /><strong>Non&nbsp;:</strong> aucune modification du formulaire d'inscription.",
	
	'registration_filter:whitelist' => "Liste des noms de domaines acceptés pour la création des comptes.",
	'registration_filter:whitelist:details' => "Un nom de domaine par ligne, pas d'espace vide.<br />Vous avez également la possibilité d'utiliser les virgules et points-virgules comme séparateur.",
	'registration_filter:whitelist:default' => "",
	'registration_filter:register:whitelist' => "Pour pouvoir vous inscrire, le nom de domaine de votre adresse email doit faire partie de la liste suivante : ",
	
	'registration_filter:blacklist' => "Liste des noms de domaines interdits.",
	'registration_filter:blacklist:details' => "",
	'registration_filter:blacklist:default' => "", // Enables themes defaults
	
	
	// Overrides
	'invitefriends:introduction' => "Pour inviter d'autres personnes à vous rejoindre sur ce réseau, entrez leurs adresses mail ci-dessous (une par ligne).<br />
	Attention : l'inscription est réservée à certains noms de domaines, veuillez en <a href=\"{$url}registration_filter\">consulter sur cette page la liste des noms de domaine autorisés</a>. Les adresses d'autres noms de domaine seront filtrées et ne recevront aucune invitation.",
	
	'RegistrationException:NotAllowedEmail' => "Domaine invalide. Le nom de domaine utilisé ne fait pas partie de la liste des noms de domaines autorisés, et ne vous permet pas de créer un compte sur cette plateforme.",
	
];

