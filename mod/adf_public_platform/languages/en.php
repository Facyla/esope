<?php
/**
 * English strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Powered by Elgg" width="106" height="15" /></a></div>';

$en = array(
	
	//Theme settings
	'admin:appearance:adf_theme' => "Theme configuration",
	
	// Layout settings
	'adf_platform:settings:help' => "The various configuration panels let you configure numerous elements of your site: graphical elements, interface, couleurs, stylesheets, etc., and also some behaviours.",
	'adf_platform:settings:layout' => "To reset to initial configuration, replace content by \"RAZ\" (in HTML mode).",
	'adf_platform:faviconurl' => "Favicon URL",
	'adf_platform:faviconurl:help' => "Relative URL of website favicon (PNG or ICO image, usually 64x64 pixels).",
	'adf_platform:headertitle' => "Site title (clickable, in header)",
	'adf_platform:headertitle:help' => "To increase size of caracters, wrap them with span. Use span with 'minuscule' class to lowercase&nbsp;: &lt;span&gt;T&lt;/span&gt;itle.&lt;span class=\"minuscule\"&gt;en&lt;/span&gt;",
	'adf_platform:header:content' => "Custom header code (free HTML). Reset to initial configuration by replacing content by \"RAZ\" (in HTML mode).",
	'adf_platform:header:default' => '<div id="easylogo"><a href="/"><img src="' . $vars['url'] . '/mod/adf_public_platform/img/logo.gif" alt="Site logo"  /></a></div>',
	'adf_platform:header:height' => "Height of header banner (use same value as header background image height - or lower)",
	'adf_platform:header:background' => "Background image URL (display under the top level menu)",
	'adf_platform:footer:color' => "Footer background color",
	'adf_platform:footer:content' => "Footer content",
	'adf_platform:footer:default' => $footer_default,
	'adf_platform:home:displaystats' => "Display stats on home page",
	'adf_platform:css' => "Add here your own CSS styles",
	'adf_platform:css:help' => "The CSS you add here are loaded after the main CSS (without overriding it), and after any plugins CSS.",
	'adf_platform:css:default' => "/* Edit headers style */\nheader {  }\n\n/* Links */\na, a:visited {  }\na:hover, a:active, a:focus {  }\n\n/* Titles */\nh1, h2, h3, h4, h5 {  }\n/* etc. */\n",
	'adf_platform:dashboardheader' => "Custom introduction text before the user dashboard.",
	'adf_platform:homeintro' => "Introductio block on public homepage (above register/login forms).",
	'adf_platform:settings:colors' => "Theme colors",
	'adf_platform:title:color' => "Title color",
	'adf_platform:text:color' => "Text color",
	'adf_platform:link:color' => "Link color",
	'adf_platform:link:hovercolor' => "Link color on hover (and color inversions)",
	'adf_platform:color1:color' => "Top shading color for header",
	'adf_platform:color2:color' => "Top shading color for widgets/modules",
	'adf_platform:color3:color' => "Bottom shading color for widgets/modules",
	'adf_platform:color4:color' => "Bottom shading color for header",
	'adf_platform:color5:color' => "Top shading color for buttons",
	'adf_platform:color6:color' => "Bottom shading color for buttons",
	'adf_platform:color7:color' => "Top shading color for buttons (hover)",
	'adf_platform:color8:color' => "Bottom shading color for buttons (hover)",
	'adf_platform:color9:color' => "Custom color 9",
	'adf_platform:color10:color' => "Custom color 10",
	'adf_platform:color11:color' => "Custom color 11",
	'adf_platform:color12:color' => "Custom color 12",
	'adf_platform:color13:color' => "Main submenu background color",
	'widgets:dashboard:add' => "Edit my homepage",
	'widgets:profile:add' => "Add widgets to my homepage",
	'adf_platform:settings:publicpages' => "Public pages (viewable by non-loggedin visitors)",
	'adf_platform:settings:publicpages:help' => "\"Public pages\" are viewable by anyone, without logging to the site. They are usually legal notices, and other important public pages of your website.<br />Add the relative URL of the pages, one per line, without the domaine name (or subdirectory), and without any initial slash ('/'), e.g.: pages/view/1234/legal-notice",
	
	
	// Behaviour settings
	'adf_platform:index:url' => "URL du fichier de la page d'accueil (doit pouvoir être inclus)",
	'adf_platform:settings:redirect' => "URL (relative) de redirection après connexion",
	'adf_platform:settings:replace_public_home' => "URL (relative) pour remplacer la page d'accueil publique (par défaut&nbsp;: laisser vide)",
	'adf_platform:settings:replace_home' => "Remplacer la page d'accueil connectée par un tableau de bord personnalisable",
	'adf_platform:settings:firststeps' => "GUID de la page des Premiers Pas (ou page d'aide au démarrage)",
	'adf_platform:settings:firststeps:help' => "Le GUID de la page est le nombre indiqué dans l'adresse de la page à utiliser : <em>" . elgg_get_site_url() . "/pages/<strong>GUID</strong>/premiers-pas</em>",
	'adf_platform:settings:footer' => "Contenu du pied de page",
	'adf_platform:settings:headerimg' => "Image du bandeau supérieur (85px de haut)",
	'adf_platform:settings:headerimg:help' => "Indiquez l'URL (relative) de l'image qui sera positionnée au centre du bandeau, sous le menu supérieur, et répétée si nécessaire horizontalement (motif). Utilisez une image de 85px de haut, et suffisamment large pour éviter d'être répétée sur un grand écran (2000px minimum). Pour des dimensions différentes, ajoutez dans les ci-dessous (en modifiant la hauteur) : <em>header { height:115px; }</em>",
	'adf_platform:settings:helplink' => "Page d'aide",
	'adf_platform:settings:helplink:help' => "Indiquez l'adresse de la page d'aide du site, correspondant au lien \"Aide\" du menu supérieur. Cette adresse doit être relative à celle du site (pas de lien externe).",
	'adf_platform:settings:backgroundimg' => "Motif de fond",
	'adf_platform:settings:backgroundimg:help' => "Indiquez l'URL (relative) de l'image qui sera répétée horizontalement et verticalement",
	'adf_platform:settings:backgroundcolor' => "Couleur de fond",
	'adf_platform:settings:backgroundcolor:help' => "",
	'adf_platform:settings:groups_disclaimer' => "Configuration du message à l'attention du futur responsable lors de la création d'un nouveau groupe. Pour que le message soit vide, laisser un espace seulement dans le champ.",
	
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
	
	'accessibility:sidebar:title' => "Outils",
	//'breadcrumb' => "Fil d'Ariane",
	'breadcrumbs' => "Revenir à ",
	// Demandes en attente
	'decline' => "Décliner",
	'refuse' => "Refuser",
	/* Pagination */
	'previouspage' => "Page précédente",
	'nextpage' => "Page suivante",
	/* Recherche de membres */
	'searchbytag' => "Recherche par mot-clef",
	'searchbyname' => "Recherche par nom",
	// Actions génériques à "typer"
	'delete:message' => "Supprimer le(s) message(s)",
	'markread:message' => "Marquer le(s) message(s)  comme lu(s)",
	'toggle:messages' => "inverser la sélection des messages",
	'messages:send' => "Envoyer le message",
	'save:newgroup' => "Créer le groupe !",
	'save:group' => "Enregistrer les modifications du groupe",
	'upload:avatar' => "Charger la photo",
	'save:settings' => "Enregistrer la configuration",
	'save:usersettings' => "Enregistrer mes paramètres",
	'save:usernotifications' => "Enregistrer mes paramètres de notification pour les membres",
	'save:groupnotifications' => "Enregistrer mes paramètres de notification pour les groupes",
	'save:widgetsettings' => "Enregistrer les réglages du module",
	// Notifications
	'link:userprofile' => "Page de profil de %s",
	
	// Params widgets
	'onlineusers:numbertodisplay' => "Nombre maximum de membres connectés à afficher",
	'newusers:numbertodisplay' => "Nombre maximum de nouveaux membres à afficher",
	'brainstorm:numbertodisplay' => "Nombre maximum d'idées à afficher",
	'river:numbertodisplay' => "Nombre maximum d'activités à afficher",
	'group:widget:num_display' => "Nombre maximum de groupes à afficher",
	
	'more:friends' => "Plus de contacts", 
	
	// New group
	'groups:newgroup:disclaimer' => "<blockquote><strong>Extrait de la Charte :</strong> <em>toute personne ou groupe de personnes souhaitant créer un groupe - à la condition de <a href=\"mailto:secretariat@departementsenreseaux.fr&subject=Demande%20de%20validation%20de%20groupe&body=Contact%20%depuis%20la%20page%20http%3A%2F%2Fdepartements-en-reseaux.fr%2Fgroups%2Fadd%2F129\" title=\"Ecrire au secrétariat de la plateforme\">se déclarer comme animateur de ce groupe auprès du secrétariat de la plateforme</a>, dispose de droits d’administrateur sur les accès à ce groupe et s’engage à y faire respecter les <a href=\"' . $CONFIG->url . 'pages/view/3792/charte-de-dpartements-en-rseaux\">règles d’utilisation et de création de contenus de « Départements-en-réseaux »</a></em></blockquote>",
	
	// 
	'accessibility:allfieldsmandatory' => "<sup class=\"required\">*</sup> Tous les champs sont obligatoires",
	'accessibility:requestnewpassword' => "Demander la réinitialisation du mot de passe",
	'accessibility:revert' => "Delete",
	
	
	'adf_platform:homepage' => "Homepage",
	'announcements' => "Announcements",
	'event_calendar' => "Calendar",
	
	'adf_platform:access:public' => "Public (accessible to non-loggedin visitors)",
	
	'brainstorm:widget:description' => "Displays your brainstorm ideas.",
	'bookmarks:widget:description' => "Displays your bookmarks list.",
	'pages:widget:description' => "Displays your pages.",
	'event_calendar:widget:description' => "Displays your upcoming events.",
	'event_calendar:num_display' => "Number of events to display",
	'messages:widget:title' => "Unread messages",
	'messages:widget:description' => "Displays your latest unread messages.",
	'messages:num_display' => "Number of messages to display",
	
	//'' => "",
	
	
);

add_translation('en', $en);
