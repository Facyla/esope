<?php
/**
 * English strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Powered by Elgg" width="106" height="15" /></a></div>';

$en = array(
	
	//Theme settings
	'admin:appearance:adf_theme' => "Configuration du thème",
	
	// Layout settings
	'adf_platform:settings:layout' => "Pour retrouver la configuration initiale, remplacez le contenu par \"RAZ\" (en mode HTML).",
	'adf_platform:headertitle' => "Titre du site (cliquable, dans le bandeau)",
	'adf_platform:headertitle:help' => "Pour agrandir certains caractères, encadrez-les de balises, et utilisez la classe 'minuscule' pour changer la casse&nbsp;: &lt;span&gt;T&lt;/span&gt;itre.&lt;span class=\"minuscule\"&gt;fr&lt;/span&gt;",
	'adf_platform:header:content' => "Contenu de l'entête (code HTML libre). Pour retrouver la configuration initiale avec une image de logo configurable, remplacez le contenu par \"RAZ\" (en mode HTML).",
	'adf_platform:header:default' => '<div id="easylogo"><a href="/"><img src="' . $vars['url'] . '/mod/adf_public_platform/img/logo.gif" alt="Logo du site"  /></a></div>',
	'adf_platform:header:height' => "Hauteur de l'entête du menu (identique à celle de l'image de fond utilisée)",
	'adf_platform:header:background' => "URL de l'image de fond de l'entête (apparaît également sous le menu)",
	'adf_platform:footer:color' => "Couleur de fond du footer",
	'adf_platform:footer:content' => "Contenu du footer",
	'adf_platform:footer:default' => $footer_default,
	'adf_platform:home:displaystats' => "Afficher les statistiques en page d'accueil",
	'adf_platform:css' => "Ajoutez ici vos styles CSS personnalisés",
	'adf_platform:css:default' => "Les CSS ajoutés ici surchargent la feuille de style principale (sans la remplacer)",
	'adf_platform:dashboardheader' => "Zone configurable en entête du tableau de bord des membres.",
	'adf_platform:homeintro' => "Bloc en introduction de la page de connexion / inscription.",
	'adf_platform:settings:colors' => "Couleurs du thème",
	'adf_platform:title:color' => "Couleur des titres",
	'adf_platform:link:color' => "Couleur des liens",
	'adf_platform:color1:color' => "Couleur configurable 1",
	'adf_platform:color2:color' => "Couleur configurable 2",
	'adf_platform:color3:color' => "Couleur configurable 3",
	'adf_platform:color4:color' => "Couleur configurable 4",
	'adf_platform:color5:color' => "Couleur configurable 5",
	'adf_platform:color6:color' => "Couleur configurable 6",
	'adf_platform:color7:color' => "Couleur configurable 7",
	'adf_platform:color8:color' => "Couleur configurable 8",
	'adf_platform:color9:color' => "Couleur configurable 9",
	'widgets:dashboard:add' => "Personnaliser ma page d'accueil'",
	'widgets:profile:add' => "Ajouter des modules à ma page de profil",
	'adf_platform:settings:publicpages' => "Pages publiques",
	'adf_platform:publicpages' => "Listes des pages publiques (accessibles hors connexion)",
	'adf_platform:publicpages:help' => "Les \"Pages publiques\" sont accessibles à tous, hors connexion. Elles permettent de rendre publics la charte, les mentions légales et autres pages importantes du site.<br />Indiquez une adresse complète de page (URL) par ligne, sans le nom de domaine et le slash initial ('/'), par exemple : pages/view/3819/mentions-lgales",
	
	
	// Behaviour settings
	'adf_platform:index:url' => "URL du fichier de la page d'accueil (doit pouvoir être inclus)",
	'adf_platform:login:redirect' => "URL de redirection après connexion",
	
	'river:select:all:nofilter' => "Tout (aucun filtre de l'activité)",
	
	
	// AJOUTS EN SURCHARGE DES PLUGINS
	// Note : ces ajouts sont faits ici plutôt que dans les plugins concernés de sorte qu'une mise à jour ait le moins d'incidence possible sur ces traductions 
  'river:comment:object:announcement' => "%s a commenté %s",
  'widgets:profile_completeness:view:tips:link' => "<br />%s&raquo;&nbsp;Compléter mon profil !%s",
	
	'widget:toggle' => "Montrer/masquer le module %s",
	'widget:editmodule' => "Configurer le module %s",
	
	// Annonces : manque des clefs de trad
	'announcements:summary' => "Titre de l'annonce",
	'announcements:body' => "Texte de l'annonce",
	'announcements:post' => "Publier l'annonce",
	'announcements:edit' => "Modifier l'annonce",
	'announcements:delete:nopermission' => "Impossible de supprimer l'annonce : vous n'avez pas les permissions suffisantes",
	'announcements:delete:failure' => "Impossible de supprimer l'annonce.",
	'announcements:delete:sucess' => "Annonce publiée",
	'object:announcement:save:permissiondenied' => "Impossible d'enregistrer l'annonce : vous n'avez pas les permissions suffisantes",
	'object:announcement:save:descriptionrequired' => "Impossible d'enregistrer l'annonce : le texte de l'annonce ne peut être vide.",
	'object:announcement:save:success' => "Annonce enregistrée",
	'item:object:category' => "Catégories utilisées",
	'item:object:topicreply' => "Réponse dans un forum",
	
	// Traductions du thème et autres personnalisations
	'adf_platform:groupinvite' => "invitation à rejoindre un groupe à examiner",
 	'adf_platform:groupinvites' => "invitations à rejoindre un groupe à examiner",
	'adf_platform:friendinvite' => "demandes de contact à examiner",
	'adf_platform:friendinvites' => "demandes de contact à examiner",
	'adf_platform:gotohomepage' => "Aller sur la page d'accueil",
	'adf_platform:usersettings' => "Mes paramètres",
	'adf_platform:myprofile' => "Mon profil",
	'adf_platform:help' => "Aide",
	'adf_platform:loginregister' => "Connexion / inscription",
	'adf_platform:joinagroup' => "Rejoindre un groupe",
	'adf_platform:categories' => "Thématiques",
	'adf_platform:directory' => "Annuaire",
	'adf_platform:event_calendar' => "Agenda",
	'adf_platform:search' => "Rechercher",
	'adf_platform:groupicon' => "icône du groupe",
	'adf_platform:categories:all' => "Actualité des thématiques",
	
	// Widgets
	'adf_platform:widget:bookmark:title' => 'Mes Liens web',
	'adf_platform:widget:brainstorm:title' => 'Mes Idées',
	'adf_platform:widget:blog:title' => 'Mes Articles de blog',
	'adf_platform:widget:event_calendar:title' => 'Mon Agenda',
	'adf_platform:widget:file:title' => 'Mes Fichiers',
	'adf_platform:widget:group:title' => 'Mes Groupes',
	'adf_platform:widget:page:title' => 'Mes Wikis',
	
	//'' => "",
	
	
);

add_translation('en', $en);
