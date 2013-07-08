<?php
/**
 * French strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Site construit avec Elgg" width="106" height="15" /></a></div>';

$fr = array(
	
	//Theme settings
	'admin:appearance:adf_theme' => "Configuration du thème",
	
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
	'item:object:category' => "Thématiques utilisées",
	'item:object:topicreply' => "Réponse dans un forum",
	
	// Traductions du thème et autres personnalisations
	'adf_platform:groupinvite' => "invitation à rejoindre un groupe à examiner",
 	'adf_platform:groupinvites' => "invitations à rejoindre un groupe à examiner",
	'adf_platform:friendinvite' => "demande de contact à examiner",
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
	'adf_platform:members:online' => "Membres connectés",
	'adf_platform:members:newest' => "Derniers inscrits",
	'adf_platform:groups:featured' => "Groupes à la Une",
	
	// Widgets
	'adf_platform:widget:bookmark:title' => 'Mes Liens web',
	'adf_platform:widget:brainstorm:title' => 'Mes Idées',
	'adf_platform:widget:blog:title' => 'Mes Articles',
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
	// @TODO : Ce texte devrait être adapté à votre site !
	// use $CONFIG->url for site install URL, $CONFIG->email for site email
	'groups:newgroup:disclaimer' => "<blockquote><strong>Extrait de la Charte :</strong> <em>toute personne ou groupe de personnes souhaitant créer un groupe - à la condition de <a href=\"mailto:" . $CONFIG->email . "&subject=Demande%20de%20validation%20de%20groupe&body=Contact%20%depuis%20la%20page%20http%3A%2F%2Fdepartements-en-reseaux.fr%2Fgroups%2Fadd%2F129\" title=\"Ecrire au secrétariat de la plateforme\">se déclarer comme animateur de ce groupe auprès du secrétariat de la plateforme</a>, dispose de droits d’administrateur sur les accès à ce groupe et s’engage à y faire respecter les <a href=\"' . $CONFIG->url . 'pages/view/3792/charte-de-dpartements-en-rseaux\">règles d’utilisation et de création de contenus de « Départements-en-réseaux »</a></em></blockquote>",
	'groups:search:regular' => "Recherche de groupe",
	'groups:regularsearch' => "Nom ou mot-clef",
	'search:group:go' => "Rechercher un groupe",
	'members:search' => "Rechercher un membre",
	
	// 
	'accessibility:allfieldsmandatory' => "<sup class=\"required\">*</sup> Tous les champs sont obligatoires",
	'accessibility:requestnewpassword' => "Demander la réinitialisation du mot de passe",
	'accessibility:revert' => "Supprimer",
	
	
	'adf_platform:homepage' => "Accueil",
	'announcements' => "Annonces",
	'event_calendar' => "Agenda",
	
	'adf_platform:access:public' => "Public (accessible hors connexion)",
	
	'brainstorm:widget:description' => "Affiche la liste de vos idées de remue-méninges.",
	'bookmarks:widget:description' => "Affiche la liste de vos liens web.",
	'pages:widget:description' => "Affiche la liste de vos pages wikis.",
	'event_calendar:widget:description' => "Affiche les événements à venir de votre agenda personnel.",
	'event_calendar:num_display' => "Nombre d'événements à afficher",
	'messages:widget:title' => "Messages non lus",
	'messages:widget:description' => "Affiche les derniers messages non lus de votre boîte de réception.",
	'messages:num_display' => "Nombre de messages à afficher",
	
	
	// Layout settings
	'adf_platform:settings:help' => "Les différentes rubriques de configuration vous permettent de configurer de nombreux éléments du thème (éléments graphiques, d'interface, couleurs, feuilles de styles, etc.), ainsi que certains comportements du site.",
	'adf_platform:settings:layout' => "Pour retrouver la configuration initiale, remplacez le contenu par \"RAZ\" (en mode HTML).",
	'adf_platform:faviconurl' => "URL de la favicon",
	'adf_platform:faviconurl:help' => "Indiquez le chemin de l'icône du site : il s'agit généralement d'un fichier favicon.ico ou .png ou .gif, de format carré et de 64px maxi.",
	'adf_platform:headertitle' => "Titre du site (cliquable, dans le bandeau)",
	'adf_platform:headertitle:help' => "Pour agrandir certains caractères, encadrez-les de balises, et utilisez la classe 'minuscule' pour changer la casse&nbsp;: &lt;span&gt;T&lt;/span&gt;itre.&lt;span class=\"minuscule\"&gt;fr&lt;/span&gt;",
	'adf_platform:header:content' => "Contenu de l'entête (code HTML libre). Pour retrouver la configuration initiale avec une image de logo configurable, remplacez le contenu par \"RAZ\" (en mode HTML).",
	'adf_platform:header:default' => '<div id="easylogo"><a href="/"><img src="' . $vars['url'] . '/mod/adf_public_platform/img/logo.gif" alt="Logo du site"  /></a></div>',
	'adf_platform:header:height' => "Hauteur de l'entête du menu (identique à celle de l'image de fond utilisée - ou inférieure)",
	'adf_platform:header:background' => "URL de l'image de fond de l'entête (apparaît également sous le menu)",
	'adf_platform:footer:color' => "Couleur de fond du footer",
	'adf_platform:footer:content' => "Contenu du footer",
	'adf_platform:footer:default' => $footer_default,
	'adf_platform:home:displaystats' => "Afficher les statistiques en page d'accueil",
	'adf_platform:css' => "Ajoutez ici vos styles CSS personnalisés",
	'adf_platform:css:help' => "Les CSS ajoutés ici surchargent la feuille de style (sans la remplacer), et viennent se charger après tous les autres modules. Ajoutez ici vos styles personnalisés",
	'adf_platform:css:default' => "/* Pour modifier le bandeau */\nheader {  }\n\n/* Les liens */\na, a:visited {  }\na:hover, a:active, a:focus {  }\n\n/* Les titres */\nh1, h2, h3, h4, h5 {  }\n/* etc. */\n",
	'adf_platform:dashboardheader' => "Zone configurable en entête du tableau de bord des membres.",
	'adf_platform:index_wire' => "Ajouter Le Fil sur l'accueil (seulement en mode tableau de bord).",
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
	'adf_platform:color13:color' => "Couleur de fond du sous-menu déroulant",
	'widgets:dashboard:add' => "Personnaliser ma page d'accueil",
	'widgets:profile:add' => "Ajouter des modules à ma page de profil",
	'adf_platform:settings:publicpages' => "Listes des pages publiques (accessibles hors connexion)",
	'adf_platform:settings:publicpages:help' => "Les \"Pages publiques\" sont accessibles à tous, hors connexion. Elles permettent de rendre publics la charte, les mentions légales et autres pages importantes du site.<br />Indiquez une adresse complète de page (URL) par ligne, sans le nom de domaine et le slash initial ('/'), par exemple : pages/view/1234/mentions-legales",
	'adf_platform:home:public_profiles' => "Profil public",
	'adf_platform:home:public_profiles:help' => "Ce réglage permet de donner la possibilité aux membres du site de choisir de rendre leur profil accessible depuis internet, sans compte sur le site. Par défaut leur profil sera réservé aux membres, jusqu'à-ce qu'ils choisissent de le rendre public. Si ce réglage est désactivé, les profils sont publics.<br />A noter : en mode \"intranet\", aucune page n'est visible de l'extérieur, y compris les pages de profil, et ce réglage n'a aucun effet.",
	'adf_platform:usersettings:public_profiles:title' => "Choisir la visibilité de mon profil",
	'adf_platform:usersettings:public_profile' => "Rendre mon profil public",
	'adf_platform:usersettings:public_profile:help' => "Par défaut votre profil n'est visible que des membres du site, afin de ne pas exposer votre profil publiquement sans votre accord volontaire. Ce réglage vous permet de le rendre accessible de l'extérieur.<br />Veuillez noter que tous vos autres réglages de visibilité des champs et des widgets qui composent votre page du profil restent valables : par exemple si vous avez choisi que votre numéro de téléphone ou la liste de contacts sont réservés à vos contacts, rendre votre profil public ne modifiera pas ce réglage, et cette information restera réservée à vos contacts.<br />Il est conseillé de rendre votre profil public si vous souhaitez présenter vos compétences ou partager certaines informations choisies sur internet.",
	'adf_platform:action:public_profile:error' => "Une erreur s'est lors de la modification de vos paramètres.",
	'adf_platform:action:public_profile:saved' => "La visibilité de votre profil a bien été modifiée.",
	'adf_platform:usersettings:public_profile:public' => "Votre profil est maintenant PUBLIC.",
	'adf_platform:usersettings:public_profile:private' => "Votre profil est maintenant RÉSERVÉ AUX MEMBRES.",
	
	
	// Behaviour settings
	'adf_platform:index:url' => "URL du fichier de la page d'accueil (doit pouvoir être inclus)",
	'adf_platform:settings:redirect' => "URL (relative) de redirection après connexion",
	'adf_platform:settings:replace_public_home' => "URL (relative) pour remplacer la page d'accueil publique (par défaut&nbsp;: laisser vide)",
	'adf_platform:settings:replace_home' => "Remplacer la page d'accueil connectée par un tableau de bord personnalisable",
	'adf_platform:settings:firststeps' => "GUID de la page des Premiers Pas (ou page d'aide au démarrage)",
	'adf_platform:settings:firststeps:help' => "Cette page s'affichera dans un bloc de la page d'accueil dépliable qui restera ouvert pendant un mois pour les nouveaux membres. Le GUID de la page est le nombre indiqué dans l'adresse de la page à utiliser : <em>" . elgg_get_site_url() . "/pages/<strong>GUID</strong>/premiers-pas</em>",
	'adf_platform:settings:footer' => "Contenu du pied de page",
	'adf_platform:settings:headerimg' => "Image du bandeau supérieur (85px de haut par défaut)",
	'adf_platform:settings:headerimg:help' => "Indiquez l'URL (relative) de l'image qui sera positionnée au centre du bandeau, sous le menu supérieur, et répétée si nécessaire horizontalement (motif). Utilisez une image de 85px de haut, et suffisamment large pour éviter d'être répétée sur un grand écran (2000px minimum). Pour des dimensions différentes, ajoutez dans les ci-dessous (en modifiant la hauteur) : <em>header { height:115px; }</em>",
	'adf_platform:settings:helplink' => "Page d'aide",
	'adf_platform:settings:helplink:help' => "Indiquez l'adresse de la page d'aide du site, correspondant au lien \"Aide\" du menu supérieur. Cette adresse doit être relative à celle du site (pas de lien externe).",
	'adf_platform:settings:backgroundimg' => "Motif de fond",
	'adf_platform:settings:backgroundimg:help' => "Indiquez l'URL (relative) de l'image qui sera répétée horizontalement et verticalement",
	'adf_platform:settings:backgroundcolor' => "Couleur de fond",
	'adf_platform:settings:backgroundcolor:help' => "La couleur de fond est utilisée si aucune image de fond n'est définie, ou le temps que cette image de fond soit chargée.",
	'adf_platform:settings:groups_disclaimer' => "Configuration du message à l'attention du futur responsable lors de la création d'un nouveau groupe. Pour que le message soit vide, laisser un espace seulement dans le champ.",
	'adf_platform:settings:blog_user_listall' => "Lister de tous les articles de blog (personnels + groupes)",
	'adf_platform:settings:bookmarks_user_listall' => "Listing de tous les liens web (personnels + groupes)",
	'adf_platform:settings:brainstorm_user_listall' => "Listing de toutes les idées (personnelles + groupes)",
	'adf_platform:settings:file_user_listall' => "Listing de tous les fichiers (personnels + groupes)",
	'adf_platform:settings:pages_user_listall' => "Listing de toutes les pages wiki (personnelles + groupes)",
	
	'river:select:all:nofilter' => "Tout (aucun filtre de l'activité)",
	
	
	'adf_platform:settings:widget:blog' => "Activer le widget Blog",
	'adf_platform:settings:widget:bookmarks' => "Activer le widget Liens web",
	'adf_platform:settings:widget:brainstorm' => "Activer le widget Boîte à idées",
	'adf_platform:settings:widget:event_calendar' => "Activer le widget Mon agenda",
	'adf_platform:settings:widget:file' => "Activer le widget Mes fichiers",
	'adf_platform:settings:widget:groups' => "Activer le widget Mes groupes",
	'adf_platform:settings:widget:pages' => "Activer le widget Pages wiki",
	'adf_platform:settings:widget:friends' => "Activer le widget Mes contacts",
	'adf_platform:settings:widget:group_activity' => "Activer le widget Activité du groupe",
	'adf_platform:settings:widget:messages' => "Activer le widget Messages non lus",
	'adf_platform:settings:widget:river_widget' => "Activer le widget Activité globale du site",
	'adf_platform:settings:widget:twitter' => "Activer le widget Twitter",
	'adf_platform:settings:widget:tagcloud' => "Activer le widget Nuage de tags",
	'adf_platform:settings:widget:videos' => "Activer le widget Vidéos",
	'adf_platform:settings:widget:profile_completeness' => "Activer le widget Complétion du profil",
	'adf_platform:settings:widget:profile_completeness:help' => "Ce widget peut être activé/désactivé via la configuration du plugin Profile Manager",
	
	'adf_platform:settings:filters:friends' => "Supprimer l'onglet \"Contacts\" dans les listes de publications personnelles ? (par défaut : Non)",
	'adf_platform:settings:filters:mine' => "Supprimer l'onglet \"Moi\" dans les listes de publications personnelles ? (par défaut : Non)",
	'adf_platform:settings:filters:all' => "Supprimer l'onglet \"Tous\" dans les listes de publications personnelles ? (par défaut : Non)",
	'adf_platform:settings:groups:inviteanyone' => "Permettre d'inviter tout membre dans les groupes ? (par défaut : non = contacts seulement)",
	'adf_platform:settings:members:onesearch' => "Ne garder que la recherche générale de membres ? (par défaut : Non)",
	'adf_platform:settings:members:online' => "Afficher les membres connectés dans la barre latérale (défaut : non)",
	
	//'' => "",
	
	
);

add_translation('fr', $fr);
