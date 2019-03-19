<?php
/**
 * French strings
 */

return array(
	'recaptcha' => "reCAPTCHA",
	'recaptcha:settings:publickey' => "Clé du site",
	'recaptcha:settings:publickey:details' => "Utilisez cette clé dans le code HTML que vous proposez à vos utilisateurs.",
	'recaptcha:settings:secretkey' => "Clé secrète",
	'recaptcha:settings:secretkey:details' => "Utilisez cette clé pour toute communication entre votre site et Google. Veillez à ne pas la divulguer, car il s'agit d'une clé secrète.",
	'recaptcha:settings:createapikey' => "Créer une clé d'API",
	'recaptcha:settings:theme' => "Thème",
	'recaptcha:settings:theme:details' => "L'aspect visuel du recaptcha : clair ou sombre ('light' | 'dark')",
	'recaptcha:settings:size' => "Taille",
	'recaptcha:settings:size:details' => "La taille du recaptcha ('normal' | 'compact')",
	'recaptcha:settings:challenge_type' => "Type",
	'recaptcha:settings:challenge_type:details' => "Le type de défi à résoudre ('image' | 'audio')",
	'recaptcha:settings:recaptcha_url' => "Source du script reCaptcha",
	'recaptcha:settings:recaptcha_url:details' => "En cas de blocage, notamment pour une utilisation depuis la Chine, veuillez choisir le domaine recaptcha.net au lieu de google.com pour charger le script reCaptcha.",
	
	// Errors
	'recaptcha:error:missingkeys' => "Impossible de vérifier reCAPTCHA car les clefs sont manquantes. Veuillez demander à l'administrateur de configurer le plugin reCAPTCHA.",
	'recaptcha:error:missingsecret' => "Le paramètre secret de reCAPTCHA est manquant.",
	'recaptcha:error:invalidsecret' => "Le paramètre secret de reCAPTCHA est invalide.",
	'recaptcha:error:missingresponse' => "Le paramètre de réponse reCAPTCHA est manquant.",
	'recaptcha:error:invalidresponse' => "Le paramètre de réponse reCAPTCHA est invalide.",
	
);

