<?php
/**
 * French strings
 */

return [
	'gdpr_consent' => "Consentement RGPD",
	
	// Paramètres
	'gdpr_consent:settings:title' => "Configuration de Consentement RGPD",
	'gdpr_consent:settings:details' => "Plugin de recueil de la validation explicite de documents : permet de recueillir le consentement a posteriori pour les comptes créés précédemment et qui avaient pu être créés sans les valider, ou pour valider une nouvelle version des mentiosn légales, chartes et autres documents contractuels ou nécessitant une preuve d'acceptation volontaire.<br />Le plugin conserve pour chaque utilisateur (via les paramètres personnels du plugin) la date de recueil du consentement, avec la clef et la version indiquée.",
	'gdpr_consent:settings:consent_config' => "Configuration des documents à valider explicitement",
	'gdpr_consent:settings:consent_config:details' => "Indiquez une ligne par document à valider, en séparant chaque argument par une barre verticale : clef | URL | Title | Version<br />
	Chaque élément est obligatoire. Les preuves sont conservées pour chaque couple clef+version : tout changement d'une clef ou d'une version va nécessiter un nouveau recueil du consentement par les utilisateurs.<br />
	Le changement du titre ou de l'URL d'un document n'a aucune incidence sur leur validation.<br />
	Par exemple : privacy | https://mysite.com/privacy | Politique de confidentialité | 0.1",
	
	// Banner
	'gdpr_consent:banner:details' => "L'utilisation de ce site est conditionnée à l'acceptation des documents suivants. Veuillez en prendre connaissance et les accepter pour pouvoir utiliser le site.",
	'gdpr_consent:banner:button' => "Je déclare avoir lu et accepte sans réserve&nbsp;: %s",
	
	// Messages
	'gdpr_consent:error' => "Une erreur est survenue lors de l'acceptation du document %s",
	'gdpr_consent:success' => "Le document %s a bien été accepté.",
	'gdpr_consent:validatedon' => "Acceptation %s",
	
];

