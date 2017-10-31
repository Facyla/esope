<?php


$french = [     // 1.8
//return [      // 1.9+

	// Plugin settings password
	'password_extended' => "profil étendu",
	'password_extended:settings' => "Politique de mot de passe",
	'password_extended:settings:use_symbols' => "Inclure des caractères spéciaux&nbsp;:",
	'password_extended:settings:use_symbols_value' => "Nombre minimum de caractère(s) spécial(aux)&nbsp;:",
	'password_extended:settings:use_numbers' => "Inclure des chiffres&nbsp;:",
	'password_extended:settings:use_numbers_value' => "Nombre minimum de chiffres&nbsp;:",
	'password_extended:settings:use_lowercase' => "Inclure des caractères minuscules&nbsp;:",
	'password_extended:settings:use_lowercase_value' => "Nombre minimum de minuscules&nbsp;:",
	'password_extended:settings:use_uppercase' => "Inclure des caractères majuscules&nbsp;:",
	'password_extended:settings:use_uppercase_value' => "Nombre minimum de majuscules&nbsp;:",
	'password_extended:settings:password_min_lenght' => "Activer la longueur minimale du mot de passe&nbsp;:",
	'password_extended:settings:password_min_lenght_value' => "Valeur par défaut&nbsp;:",
	'password_extended:settings:password_max_lenght' => "Activer la longueur maximale du mot de passe&nbsp;:",
	'password_extended:settings:password_max_lenght_value' => "",
	'password_extended:settings:password_expired' => "Activer le délai d'expiration du mot de passe",

	'password_extended:login:strict' => "Veuillez renouveller votre mot de passe actuel",
	'password_extended:password1:failed' => "Echec sur le nouveau mot de passe&nbsp;: %s",
	'password_extended:password2:failed' => "Echec sur le mot de passe saisi à nouveau&nbsp;: %s",
	'password_extended:password:compare' => "Les mots de passe ne correspondent pas.",

	/* register user */
	'password_extended:register:password' => "[Mot de passe]",
	'password_extended:register:password_retype' => "[Mot de passe (de nouveau, par mesure de sécurité)]",

	/* Requirements */
	'password_extended:requirements' => "Le mot de passe doit correspondre aux critères suivants&nbsp;:",
	'password_extended:require:long' => "Longueur d'au moins %s caractères.",
	'password_extended:require:numbers' => "Au moins %s chiffre(s).",
	'password_extended:require:symbols' => "Au moins %s caractère(s) spécial(aux).",
	'password_extended:require:lowercase' => "Au moins %s caractère(s) minuscule(s).",
	'password_extended:require:uppercase' => "Au moins %s caractère(s) majuscule(s).",

	// Plugin extended view settings/user
	'password_extended:renew_password' => "Renouvellement du mot de passe",
	'password_extended:renew' => "Renouvellement",
	'password_extended:password_header' => "Mot de passe du compte",
	'password_extended:current_password' => "Mot de passe actuel",
	'password_extended:new_password' => "Nouveau mot de passe",
	'password_extended:retype_password' => "Veuillez confirmer votre nouveau mot de passe",
	'password_extended:finished' => "Le mot de passe a bien été changé.",
	'password:finished_message' => "Bonjour %s, vous avez renouvellé votre mot de passe, merci",
	'password_extended:successfully' => "Changement réussi.",
	'password_extended:failed' => "Echec du changement du mot de passe.",
	/* scripts */
	'script:short' => "Très faible&nbsp;! (il doit être composé d'au moins %s caractères)",
	'script:strong:very' => "Très fort&nbsp;! (Félicitations, attention à ne pas l'oublier maintenant&nbsp;!)",
	'script:strong' => "Fort&nbsp;! (ajoutez des caractères spéciaux pour le rendre encore plus fort)",
	'script:good' => "Bon&nbsp;! (ajoutez des majuscules pour le rendre plus fort)",
	'script:weak' => "Encore assez faible&nbsp;! (ajoutez des chiffres pour créer un bon mot de passe)",

	'script:mismatch' => "Les mots de passe ne corrrespondent pas&nbsp;!",
	'script:matched' => "Les mots de passe corrrespondent&nbsp;!",


];

add_translation("fr",$french);   // 1.8

