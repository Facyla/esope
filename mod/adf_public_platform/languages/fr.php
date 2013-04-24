<?php
/**
 * French strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Powered by Elgg" width="106" height="15" /></a></div>';

$fr = array(
	
	//Theme settings
	'admin:appearance:adf_theme' => "Configuration du thème",
	
	// Layout settings
	'adf_platform:settings:help' => "Les différentes rubriques de configuration vous permettent de configurer de nombreux éléments du thème (éléments graphiques, d'interface, couleurs, feuilles de styles, etc.), ainsi que certains comportements du site.",
	'adf_platform:settings:layout' => "Pour retrouver la configuration initiale, remplacez le contenu par \"RAZ\" (en mode HTML).",
	'adf_platform:faviconurl' => "URL de la favicon",
	'adf_platform:faviconurl:help' => "Indiquez le chemin de l'icône du site : il s'agit généralement d'un fichier favicon.ico ou .png ou .gif, de format carré et de 64px maxi.",
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
	'adf_platform:css:help' => "Les CSS ajoutés ici surchargent la feuille de style (sans la remplacer), et viennent se charger après tous les autres modules. Ajoutez ici vos styles personnalisés",
	'adf_platform:css:default' => "/* Pour modifier le bandeau */\nheader {  }\n\n/* Les liens */\na, a:visited {  }\na:hover, a:active, a:focus {  }\n\n/* Les titres */\nh1, h2, h3, h4, h5 {  }\n/* etc. */\n",
	'adf_platform:dashboardheader' => "Zone configurable en entête du tableau de bord des membres.",
	'adf_platform:homeintro' => "Bloc en introduction de la page de connexion / inscription.",
	'adf_platform:settings:colors' => "Couleurs du thème",
	'adf_platform:title:color' => "Couleur des titres",
	'adf_platform:text:color' => "Couleur du texte",
	'adf_platform:link:color' => "Couleur des liens",
	'adf_platform:link:hovercolor' => "Couleur des liens au survol (et inversions de couleurs)",
	'adf_platform:color1:color' => "Haut du dégradé header",
	'adf_platform:color2:color' => "Haut du dégradé widgets/modules",
	'adf_platform:color3:color' => "Bas du dégradé widgets/modules",
	'adf_platform:color4:color' => "Bas du dégradé header",
	'adf_platform:color5:color' => "Haut du dégradé des boutons",
	'adf_platform:color6:color' => "Bas du dégradé des boutons",
	'adf_platform:color7:color' => "Haut du dégradé des boutons (hover)",
	'adf_platform:color8:color' => "Bas du dégradé des boutons (hover)",
	'adf_platform:color9:color' => "Couleur configurable 9",
	'adf_platform:color10:color' => "Couleur configurable 10",
	'adf_platform:color11:color' => "Couleur configurable 11",
	'adf_platform:color12:color' => "Couleur configurable 12",
	'widgets:dashboard:add' => "Personnaliser ma page d'accueil'",
	'widgets:profile:add' => "Ajouter des modules à ma page de profil",
	'adf_platform:settings:publicpages' => "Listes des pages publiques (accessibles hors connexion)",
	'adf_platform:settings:publicpages:help' => "Les \"Pages publiques\" sont accessibles à tous, hors connexion. Elles permettent de rendre publics la charte, les mentions légales et autres pages importantes du site.<br />Indiquez une adresse complète de page (URL) par ligne, sans le nom de domaine et le slash initial ('/'), par exemple : pages/view/3819/mentions-lgales",
	
	
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
	'accessibility:revert' => "Supprimer",
	
	
	'adf_platform:homepage' => "Accueil",
	'announcements' => "Annonces",
	'event_calendar' => "Agenda",
	
	'adf_platform:access:public' => "Public (accessible hors connexion)",
	//'' => "",
	
	
);

add_translation('fr', $fr);
