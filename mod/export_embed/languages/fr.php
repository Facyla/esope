<?php
/**
 * French strings
 */

$url = elgg_get_site_url();
$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . $url . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Site construit avec Elgg" width="106" height="15" /></a></div>';

return array(
	
	'export_embed' => "Widgets embarquables",
	'export_embed:help' => "Ces widgets permettent d'accéder à diverses informations de ce site à partir d'un autre site, et en particulier à partir d'un agrégateur ou d'un tableau de bord personnel.<br />Ils sont accessibles par une URL générique ou personnalisée, et peuvent aussi être intégrés sur votre bureau, ou dans un site web.",
	'export_embed:widget:title' => "Widgets embarquables",
	'export_embed:widget:description' => "Permet d'afficher sur ce site des informations issues d'un autre site Elgg, ou des widgets issus d'autres sites.",
	
	// Embed widget settings
	'export_embed:widget:embedurl' => "URL du widget",
	'export_embed:widget:embedurl:help' => "L'adresse complète du widget à afficher (si renseigné, remplace les 2 paramètres suivants avec le choix du site et du type de widget).",
	'export_embed:widget:site_url' => "Adresse du site",
	'export_embed:widget:site_url:help' => "L'adresse du site à partir duquel récupérer des widget. Cet adresse est celle de votre tableau de bord, se termine par un \"/\" et s'arrête avant le mot \"export_embed\".",
	'export_embed:widget:embedtype' => "Type de widget",
	'export_embed:widget:embedtype:help' => "Le type de widget à afficher. Selon le type de widget choisi, les réglages suivant auront ou non une utilité.",
	'export_embed:widget:limit' => "Nombre d'éléments à afficher",
	'export_embed:widget:limit:help' => "Pour les listes, permet de limiter le nombre de résultats à afficher.",
	'export_embed:widget:offset' => "Commencer au Nème élément",
	'export_embed:widget:offset:help' => "Pour les listes, permet de choisir à quel numéro commencer (= le nombre résultats à ignorer).",
	'export_embed:widget:group_guid' => "Numéro (GUID) du groupe (le cas échéant)",
	'export_embed:widget:group_guid:help' => "Le \"GUID\" des groupes est le numéro qui est présent dans l'adresse d'un groupe. Par exemple il correspond à XXXXX dans " . $url . "<em>groups/profile/<strong>XXXXX</strong>/nom-du-groupe</em>.",
	'export_embed:widget:user_guid' => "Numéro (GUID) du membre (le cas échéant)",
	'export_embed:widget:user_guid:help' => "Ce numéro est plus difficile à trouver, il ne concerne que les cas où l'on souhaite suivre l'activité d'un autre membre que soi-même et ne concerne que les administrateurs.",
	'export_embed:widget:params' => "Paramètres additionnels (param1=valeur1&param2=valeur2... etc.)",
	'export_embed:widget:params:help' => "Divers autres paramètres facultatifs peuvent être ajoutés en utilisant la syntaxe habituelle des paramètres transmis via URL : <strong>param1=valeur1&amp;param2=valeur2</strong> etc.)",
	
	// Embed type
	'export_embed:type:site_activity' => 'Activité du site', 
	'export_embed:type:friends_activity' => 'Activité de mes contacts', 
	'export_embed:type:my_activity' => 'Mon activité', 
	'export_embed:type:group_activity' => "Activité d'un groupe", 
	'export_embed:type:groups_list' => 'Liste des groupes', 
	'export_embed:type:groups_featured' => 'Liste des groupes en Une', 
	'export_embed:type:agenda' => 'Agenda',
	'export_embed:type:profile_card' => "Affichage d'une fiche de profil", 
	'export_embed:type:entity' => "Affichage d'une entité'", 
	'export_embed:type:entities' => "Affichage d'une liste d'entités", 
	
	// Exported elements
	'export_embed:notconfigured' => "<p>Ce widget n'est pas encore configuré (ou les paramètres fournis sont invalides).</p>
		<p>
			Pour afficher les widgets de ce site sur un autre site, veuillez utiliser les informations suivantes&nbsp;:
			<ul>
				<li>Adresse du site&nbsp;: <strong>" . $url . "</strong></li>
				<li>Puis choisir le type d'information à afficher via le sélecteur.</li>
				<li>Pour afficher l'activité d'un groupe en particulier, vous devez indiquer le GUID de ce groupe : il s'agit du nombre que vous trouverez dans l'adresse de la page d'accueil du groupe : <em>groups/profile/<strong>GUID</strong>/nom-du-groupe</em></li>
			</ul></p>",
	'export_embed:nocontent' => "Pas de contenu pour le moment.",
	'export_embed:notconnected' => "ATTENTION, vous n'êtes pas connecté sur %s. Veuillez <a href=\"" . $url . "\" target=\"_blank\">vous connecter</a> pour accéder au contenu réservé aux membres",
	'export_embed:openintab' => "Accéder à %s dans une nouvelle fenêtre",
	'export_embed:site_activity' => "Activité de %s", 
	'export_embed:site_activity:viewall' => "Voir toute l'activité du site", 
	'export_embed:friends_activity' => "Activité de mes contacts", 
	'export_embed:friends_activity:viewall' => "Voir toute l'activité du site", 
	'export_embed:my_activity' => "Mon activité", 
	'export_embed:my_activity:viewall' => "Voir toute l'activité du site", 
	'export_embed:group_activity' => "Activité récente du groupe %s de %s", 
	'export_embed:group_activity:viewall' => "Afficher le groupe %s", 
	'export_embed:group_activity:noaccess' => "Pas d'accès au groupe ou GUID du groupe incorrect", 
	'export_embed:groups_list' => "Liste des groupes de %s", 
	'export_embed:groups_list:viewall' => "Afficher la liste des groupes", 
	'export_embed:groups_list' => "'Liste des groupes en Une de %s", 
	'export_embed:groups_list:viewall' => "Afficher la liste des groupes en Une", 
	'export_embed:agenda' => "Agenda de %s",
	'export_embed:agenda:viewall' => "Agenda",
	'export_embed:entity' => "Affichage de %s", 
	'export_embed:entity:noaccess' => "Pas d'accès ou GUID incorrect", 
	'export_embed:entities' => "Affichage de %s", 
	'export_embed:entities:noaccess' => "Pas d'accès ou GUID incorrects", 
	
);

