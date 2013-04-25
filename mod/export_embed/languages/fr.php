<?php
/**
 * French strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Site construit avec Elgg" width="106" height="15" /></a></div>';

$fr = array(
	
	'export_embed' => "Widgets embarquables",
	'export_embed:help' => "Ces widgets permettent d'accéder à diverses informations de ce site à partir d'un autre site, et en particulier à partir d'un agrégateur ou d'un tableau de bord personnel.<br />Ils sont accessibles par une URL générique ou personnalisée, et peuvent aussi être intégrés sur votre bureau, ou dans un site web.",
	'export_embed:widget:title' => "Widgets embarquables",
	'export_embed:widget:description' => "Permet d'afficher sur ce site des informations issues d'un autre site Elgg, ou des widgets issus d'autres sites.",
	
	// Embed widget settings
	'export_embed:widget:embedurl' => "URL du widget",
	'export_embed:widget:embedurl:help' => "L'adresse complète du widget à afficher (si renseigné, remplace les 2 paramètres suivants avec le choix du site et du type de widget).",
	'export_embed:widget:site_url' => "Adresse du site",
	'export_embed:widget:site_url:help' => "L'adresse du site à partir duquel récupérer des widget. Cet adresse est celle de votre tableau de bord, se termine par un \"/\" et s'arrête avant le mot \"embed\".",
	'export_embed:widget:embedtype' => "Type de widget",
	'export_embed:widget:embedtype:help' => "Le type de widget à afficher. Selon le type de widget choisi, les réglages suivant auront ou non une utilité.",
	'export_embed:widget:limit' => "Nombre d'éléments à afficher",
	'export_embed:widget:limit:help' => "Pour les listes, permet de limiter le nombre de résultats à afficher.",
	'export_embed:widget:offset' => "Commencer au Nème élément",
	'export_embed:widget:offset:help' => "Pour les listes, permet de choisir à quel numéro commencer (= le nombre résultats à ignorer).",
	'export_embed:widget:group_guid' => "Numéro (GUID) du groupe (le cas échéant)",
	'export_embed:widget:group_guid:help' => "Le \"GUID\" des groupes est le numéro qui est présent dans l'adresse d'un groupe. Par exemple il correspond à XXXXX dans " . elgg_get_site_url() . "<em>groups/profile/<strong>XXXXX</strong>/nom-du-groupe</em>.",
	'export_embed:widget:user_guid' => "Numéro (GUID) du membre (le cas échéant)",
	'export_embed:widget:user_guid:help' => "Ce numéro est plus difficile à trouver, il ne concerne que les cas où l'on souhaite suivre l'activité d'un autre membre que soi-même et ne concerne que les administrateurs.",
	'export_embed:widget:params' => "Paramètres additionnels (param1=valeur1&param2=valeur2... etc.)",
	'export_embed:widget:params:help' => "Divers autres paramètres facultatifs peuvent être ajoutés en utilisant la syntaxe habituelle des paramètres transmis via URL : <strong>param1=valeur1&amp;param2=valeur2</strong> etc.)",
	
	// Embed type
  'export_embed:type:site_activity' => 'Activité du site', 
  'export_embed:type:friends_activity' => 'Activité de mes contacts', 
  'export_embed:type:my_activity' => 'Mon activité', 
  'export_embed:type:group_activity' => "Activité d'un groupe", 
  'export_embed:type:groups_list' => 'Liste des groupes publics', 
  'export_embed:type:agenda' => 'Agenda',
	
	'' => "",
	
);

add_translation('fr', $fr);

