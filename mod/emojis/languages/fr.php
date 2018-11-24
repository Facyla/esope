<?php
/**
 * French strings
 */

return array(
	'emojis' => "Emojis",
	
	'emojis:index' => "Emojis",
	
	// Settings
	'emojis:settings:input_hook' => "Activer le hook validate,input",
	'emojis:settings:input_hook:details' => "Permet de gérer les emojis Unicode, tels que ceux saisis via un téléphone. Filtre et convertit toutes les saisies / valeurs pour les conserver sous forme d'entités HTML (\&xAAAAAA;). Indispensable si la base de données MySQL n'est pas en utf8mb4, afin d''éviter les erreurs fatales si des utilisateurs envoient des emojis dans un champ de saisie.",
	'emojis:settings:output_hook' => "Activer le hook view,all",
	'emojis:settings:output_hook:details' => "Convertit les sorties pour permettre d'afficher les emojis sous forme d'entités HTML. Utile si des emojis sont conservés sous forme de shortcodes (:emoji:), ou ont été doublement encodés en HTML (htmlentities(\$emojis_html_codepoint)).<br /><strong>Inutile si vous n'utilisez pas de shortcodes emojis, et si les emojis ont été correctement encodés&nbsp;: la base de données devrait contenir des chaînes similaires à &amp;xAAAAAA; et non &amp;amp;xAAAAAA;.",
	'emojis:settings:thewire' => "Prendre en charge le Fil",
	'emojis:settings:thewire:details' => "Permet d'utiliser les emojis dans le Fil. Ce réglage devrait être identique à celui du hook validate,input. Il est distinct car TheWire (le Fil) utilise des entrées et sorties qui lui sont spécifiques et nécessitent de surcharger l'action correspondante, et deux de ses fonctions.",
	'emojis:settings:debug' => "Activer le mode débogage",
	'emojis:settings:debug:details' => "Affiche diverses informations dans les journaux d'erreur. A utiliser conjointement avec la page de test / benchmark, en modifiant la source pour jouer sur les divers paramètres.",
	
	//'emojis:sprintf' => "%2\$s %1\$s", // Manuel choice of parameters order
	
);

