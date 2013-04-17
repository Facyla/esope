<?php

/**
* Elgg custom index plugin language pack
* 
* @package ElggCustom_index_INRIA
**/

$french = array (
	'theme_inria:topbar:me' => "Moi",
	'theme_inria:topbar:usergroups' => 'Mes&nbsp;groupes',
	'theme_inria:topbar:userfriends' => "Mes&nbsp;contacts",
	'theme_inria:topbar:dashboard' => "Mes&nbsp;activités",
	'theme_inria:topbar:profil' => "Mon profil",


	
	'theme_inria:topbar:explorer' => "Explorer",
	'theme_inria:topbar:home' => "Accueil",
	'theme_inria:topbar:groups' => "Les&nbsp;groupes",
	'theme_inria:topbar:members' => "Les&nbsp;membres",
	'theme_inria:topbar:activity' => "Les&nbsp;activités",
	'theme_inria:topbar:pages' => "Les&nbsp;pages",

	'theme_inria:topbar:action' => "Agir",
	'theme_inria:topbar:thewire' => "Publier&nbsp;sur&nbsp;le&nbsp;fil",
	'theme_inria:topbar:new_group' => "Créer&nbsp;un&nbsp;groupe",
	'theme_inria:topbar:invite' => 'Inviter',

	'theme_inria:topbar:collaborative' => "Collaboration",
	'theme_inria:topbar:forge' => "Gforge",
	'theme_inria:topbar:etherpad' => "Etherpad",
	'theme_inria:topbar:doodle' => "Doodle",
	'theme_inria:topbar:webinar' => "Webinar",
	'theme_inria:topbar:ftp' => "Transfert",
	'theme_inria:topbar:share' => "Partage",
	'theme_inria:topbar:confcall' => "Audioconf",
	'theme_inria:topbar:mailinglist' => "Sympa",

	'theme_inria:topbar:inria' => "INRIA",
	'theme_inria:topbar:annuaire' => "Annuaire",
	'theme_inria:topbar:mailer' => "Zimbra",
	'theme_inria:topbar:hollydays' => "Casa",
	'theme_inria:topbar:mission' => "IziGFD",
	'theme_inria:topbar:mission2' => "Oreli",
	'theme_inria:topbar:tickets' => "Tickets&nbsp;SUPPORT",

	'theme_inria:event_calendar:groups' => 'Evénements du groupe',
	'theme_inria:groups:discussions' => 'Discussions du groupe',

	'theme_inria:category' => 'catégorie',

	'theme_inria:membershipreq:title' => "Notifier votre refus d'adhésion",
	'theme_inria:membershipreq:accept' => 'Accepter',
	'theme_inria:membershipreq:reject' => 'Refuser',
	'theme_inria:membershipreq:delete' => 'Supprimer',

	'theme_inria:membershiprej:default_subject' => 'Votre adhésion est refusée',
	'theme_inria:membershiprej:default_message' => 'Désolé, mais votre inscription au groupe %s est rejetée par %s.',
	'theme_inria:membershiprej:send' => 'Envoyer',
	'theme_inria:membershiprej:cancel' => 'Annuler',
	'theme_inria:redirect:title' => 'Login requis',
	
	'theme_inria:mail:fromgrouptag' => 'Groupe ',
	
	'theme_inria:topbar:publications' => 'Les&nbsp;publications',
	'theme_inria:topbar:presentation' => 'Les&nbsp;présentations',
	
	'theme_inria:invite:subject' => 'Invitation',
	//$user->name, $group->name, $url
	'theme_inria:invite:body' => 'Je vous invite à rejoindre le groupe "%s"<br /><br />
								  <a href="%s">Cliquez ici</a> pour accepter.<br />',
	'output:mail:hello' => "Bonjour %s,<br />",
	'output:mail:link' => "Voir la version en ligne sur DevNet",
	'link:home' => "Retour à l'accueil",
	'groups:tabs:home' => 'Accueil',
	'groups:tabs:members' => 'Membres',
	'groups:tabs:forum' => 'Forum',
	'groups:tabs:blog' => 'News',
	'groups:tabs:pages' => 'Pages',
	'groups:tabs:files' => 'Fichiers',
	'groups:tabs:bookmarks' => 'Signets',
	'groups:tabs:presentation' => 'Présentations',
	'groups:tabs:photos' => 'Photos',
	
	'blog:none' => 'Aucune news pour le moment',
	'blog:addpost' => "Ajouter une nouvelle news",
	'blog:editpost' => "Editer cette news",
	'blog:delpost' => "Supprimer cette news",
	
	'bookmarks:none' => 'Aucun signet pour le moment',
	'bookmarks:edit' => 'Modifier ce signet',
	'bookmarks:delete' => 'Supprimer ce signet',
	'bookmarks:add' => 'Partager un nouveau signet',
	
	'pages:new' => 'Ajouter une nouvelle page',
	'pages:none' => 'Aucune page pour le moment',
	
	'groups:deltopic' => 'Supprimer la discussion',
	'groups:tabs:river' => 'Les 6 dernières activités',
	'groups:lastactivity' => 'Dernière activité %s',
	'groups:admin' => 'Admin: ',
	'groups:publications' => 'Publications',
	
	'file:edit' => 'Modifier le fichier',
	'file:delete' => 'Supprimer le fichier',
	'file:upload' => 'Partager un nouveau fichier',
	
	'forum:none' => 'Aucune discussion pour le moment',
	
	'entities:owner' => 'par %s',
	'entities:footer:time' => 'Dernière mise à jour %s',

	'adf_platform:directory' => 'Membres',
	
	'inria:mygroups' => "Mes groupes",
	
	// Traductions
	'theme_inria:login' => "Connexion",
	'members:online' => "Membres connectés",
	'members:newest' => "Derniers inscrits",
	'main' => "Tableau de bord personnel",
	'group_profile' => "Accueil du groupe",
	'inria:groups:featured' => "Groupes à la Une",
	
);

add_translation("fr",$french);


