<?php
$url = elgg_get_site_url();

return array(
	'transitions' => "Contributions",
	'transitions:transitions' => "Contributions",
	'transitions:revisions' => "Révisions",
	'transitions:archives' => "Archives",
	'item:object:transitions' => "Contributions",

	'transitions:title:user_transitions' => "Contributions de %s",
	'transitions:title:all_transitions' => "Tous les contributions du site",
	'transitions:title:friends' => "Contributions des contacts",

	'transitions:group' => "Contributions du groupe",
	'transitions:enabletransitions' => "Activer les contributions du groupe",
	'transitions:write' => "Écrire une contribution",

	// Editing
	'transitions:add' => "Ajouter une contribution",
	'transitions:edit' => "Valorisez votre contribution",
	'catalogue:add' => "Ajoutez une contribution",
	'catalogue:edit' => "Valorisez votre contribution",
	'transitions:edit:details' => "Pour rendre plus lisible cette ressource dans le Catalogue, n’hésitez pas à compléter sa description :",
	'transitions:excerpt' => "En 140 caractères...",
	'transitions:body' => "Contenu de votre contribution",
	'transitions:save_status' => "Dernier enregistrement:",
	
	'transitions:revision' => "Version",
	'transitions:auto_saved_revision' => "Versio automatiquement enregistrée",

	// messages
	'transitions:message:saved' => "Contribution enregistrée.",
	'transitions:error:cannot_save' => "Impossible d'enregistrer la contribution.",
	'transitions:error:cannot_auto_save' => "Impossible de sauvegarder automatiquement la contribution. ",
	'transitions:error:cannot_write_to_container' => "Droits d'accès insuffisants pour enregistrer la contribution pour ce groupe.",
	'transitions:messages:warning:draft' => "Il y a un brouillon non enregistré de cette contribution !",
	'transitions:edit_revision_notice' => "(Ancienne version)",
	'transitions:message:deleted_post' => "Contribution supprimée.",
	'transitions:error:cannot_delete_post' => "Impossible de supprimer la contribution.",
	'transitions:none' => "Aucune contribution",
	'transitions:error:missing:title' => "Vous devez donner un titre à votre contribution !",
	'transitions:error:missing:description' => "Le corps de votre contribution est vide !",
	'transitions:error:cannot_edit_post' => "Cette contribution peut ne pas exister ou vous n\'avez pas les autorisations pour la modifier.",
	'transitions:error:post_not_found' => "Impossible de trouver la contribution spécifiée.",
	'transitions:error:revision_not_found' => "Impossible de trouver cette révision.",
	'transitions:error:actor_not_found' => "Impossible de trouver cet acteur.",
	'transitions:error:not_an_actor' => "Cette contribution n'est pas un acteur.",

	// river
	'river:create:object:transitions' => "%s a publié une contribution %s",
	'river:comment:object:transitions' => "%s a commenté la contribution %s",

	// notifications
	'transitions:notify:summary' => "Nouvelle contribution : %s",
	'transitions:notify:subject' => "Nouvelle contribution : %s",
	'transitions:notify:body' => "
%s a publié une nouvelle contribution : %s

%s

Voir et commenter cette contribution :
%s
",

	// widget
	'transitions:widget:description' => "Ce widget affiche vos dernières contributions",
	'transitions:moretransitions' => "Plus de contributions",
	'transitions:numbertodisplay' => "Nombre de contributions à afficher",
	'transitions:notransitions' => "Aucune contribution",
	
	
	// NEW STRINGS
	'transitions:title:actor' => "Nom",
	'transitions:title:project' => "Nom du projet",
	'transitions:title:event' => "Nom de l\'événement", // Used in JS
	'transitions:icon' => "Illustration de votre contribution",
	'transitions:icon:details' => "Sélectionnez une image pour illustrer votre contribution.",
	'transitions:icon:new' => "Ajouter une illustration",
	'transitions:icon:change' => "Modifier l'illustration",
	'transitions:icon:remove' => "Supprimer l'image actuelle",
	'transitions:attachment' => "Fichier joint",
	'transitions:attachment:details' => "Vous pouvez joindre un fichier à votre contribution. Si vous souhaitez joindre plusieurs fichiers, veuillez en faire un ZIP.",
	'transitions:attachment:new' => "Joindre un fichier",
	'transitions:attachment:remove' => "Supprimer le fichier joint",
	'transitions:category' => "Catégorie",
	'transitions:category:choose' => "Sélectionnez une catégorie",
	'transitions:title' => "Titre de votre contribution",
	'transitions:tags' => "Tags",
	'transitions:tags:placeholder' => "Tags",
	'transitions:tags:details' => "Ajoutez plusieurs tags afin de mieux classer / retrouver votre contribution.<br />Par ex.: théorie, expérimentation, écologie",
	'transitions:excerpt' => "Votre contribution en 140 caractères",
	'transitions:resources' => "Ressources liées",
	'transitions:url' => "Lien vers une ressource en ligne",
	'transitions:url:details' => "Si votre contribution fait référence à une ressource en ligne, veuillez indiquer son adresse.",
	'transitions:lang' => "Langue de votre contribution",
	'transitions:lang:details' => "En quelle langue avez-vous rédigée cette contribution ?",
	'transitions:resourcelang' => "Langue des ressources jointes",
	'transitions:resourcelang:details' => "Indiquez la langue de la ressource jointe (URL ou fichier), si celle-ci est disponible dans une autre langue.",
	'transitions:territory' => "Territoire",
	'transitions:territory:details' => "Si la ressource concerne un territoire, veuillez indiquer lequel. Veuillez indiquer une adresse précise afin de pouvoir afficher la ressource sur une carte, par ex. \"8 passage Brûlon, Paris, France\" ou \"Drôme, France\" ou \"Madagascar\".",
	'transitions:actortype' => "Type d'acteur",
	'transitions:startdate' => "Date de début",
	'transitions:enddate' => "Date de fin",
	'transitions:dateformat' => "M Y",
	'transitions:dateformat:time' => "d M Y à H:i",
	'transitions:date:since' => "Depuis le",
	'transitions:date:until' => "Jusqu'au",
	'transitions:rss_feed' => "Flux RSS",
	'transitions:rss_feed:details' => "URL du fil d'actualité RSS associé à ce défi",
	'transitions:challenge:collection' => "Collection associée au défi",
	'transitions:challenge:collection:details' => "Choisissez une collection de ressources associée au défi.",
	'transitions:savedraft' => "Publier ma contribution",
	'transitions:saveandedit' => "Poursuivre l'édition",
	'transitions:quickform:title' => "Contribution rapide",
	'transitions:quickform:details' => "En cliquant sur le bouton \"Poursuivre l'édition\", votre contribution sera enregistrée en mode \"brouillon\" et vous pourrez la compléter avant de la publier.",
	'transitions:preview' => "Sauvegarder",
	'transitions:save' => "Publier",
	'transitions:owner_username' => "Propriétaire de la contribution",
	'transitions:owner_username:details' => "Pour transférer la contribution à un autre contributeur, indiquez son nom d'utilisateur ci-dessus (saisissez quelques lettres de son nom pour que des choix vous soient proposés).",
	'transitions:featured:title' => "Contributions choisies",
	'transitions:background:title' => "Contributions en retrait",
	'transitions:featured' => "Mettre en avant / en retrait",
	'transitions:featured:details' => "Permet de mettre plus en avant ou plus en retrait une publication. Ceci joue sur la visibilité de la contribution, en l'affichant en Une, ou en la retirant des résultats par défaut.",
	'transitions:featured:no' => "Non (par défaut)",
	'transitions:featured:yes' => "Oui (mis au second plan)",
	'transitions:featured:default' => "Standard",
	'transitions:featured:featured' => "Mis en avant",
	'transitions:featured:background' => "En retrait",
	'transitions:search:rss' => "Flux RSS pour cette recherche",
	'transitions:filter' => "Filtrer les contributions",
	'transitions:filter:featured' => "Choisies",
	'transitions:filter:background' => "En retrait",
	'transitions:filter:recent' => "Récentes",
	'transitions:filter:read' => "Les + lues",
	'transitions:filter:commented' => "Les + commentées",
	'transitions:filter:enriched' => "Les + contribuées",
	
	// Other forms
	'transitions:accountrequired' => "Veuillez vous connecter pour contribuer.<br />Si vous n'avez pas encore de compte,  c'est très rapide ! <a href=\"" . $url . "register\" target=\"_blank\" class=\"elgg-button elgg-button-action\">Créer mon compte de contributeur Transitions²</a>",
	'transitions:tags_contributed' => "Tags des contributeurs",
	'transitions:addtag' => "Tagguer",
	'transitions:addtag:submit' => "Ajouter un tag",
	'transitions:addtag:details' => "Vous pouvez ajouter un ou plusieurs tags pour aider à mieux classer cette ressource.",
	'transitions:addtag:success' => "Tag ajouté",
	'transitions:addtag:emptytag' => "Pas de tag à ajouter",
	'transitions:addtag:alreadyexists' => "Ce tag a déjà été ajouté",
	'transitions:addlink' => "Relier",
	'transitions:addlink:details' => "Vous pouvez relier cette ressource à une autre ressource en ligne, en ajoutant une courte explication sur la raison de ce lien. <br />Pour relier plusieurs ressources, merci d'utiliser le formulaire plusieurs fois.",
	'transitions:addlink:submit' => "Ajouter le lien",
	'transitions:addlink:success' => "Ressource ajoutée",
	'transitions:addlink:emptylink' => "Pas de ressource à ajouter",
	'transitions:addlink:invalidlink' => "URL non valide",
	'transitions:addlink:alreadyexists' => "Cette ressource a déjà été ajoutée",
	'transitions:addlink:url' => "URL",
	'transitions:addlink:url:placeholder' => "URL de la ressource",
	'transitions:addlink:comment' => "Explication",
	'transitions:addlink:comment:placeholder' => "Pourquoi un lien vers cette ressource ?",
	'transitions:addlink:add' => "+ Ajouter un lien",
	'transitions:addlink:remove' => "Supprimer ce lien",
	'transitions:addlink:remove:confirm' => "Confirmez-vous vouloir supprimer ce lien ?",
	'transitions:links_supports' => "Ressources en accord",
	'transitions:relation:supports' => "en soutien",
	'transitions:links_invalidates' => "Ressources en opposition",
	'transitions:relation:invalidates' => "en opposition",
	'transitions:links' => "Liens des contributeurs",
	'transitions:links_comment' => "Commentaire des liens des contributeurs",
	'transitions:links:placeholder' => "URL de la ressource",
	'transitions:links_comment:placeholder' => "Explications en une ligne",
	'transitions:related_actors' => "Acteurs partenaires du projet",
	'transitions:addactor' => "Ajouter un Acteur",
	'transitions:addactor:details' => "Vous pouvez associer un Acteur à ce projet. <br />Pour ajouter plusieurs acteurs, merci d'utiliser le formulaire plusieurs fois.",
	'transitions:addactor:submit' => "Ajouter l'Acteur",
	'transitions:addactor:select' => "Sélectionner l'acteur",
	'transitions:addactor:noneselected' => "Aucun acteur sélectionné",
	'transitions:addactor:success' => "Acteur ajouté",
	'transitions:addactor:error' => "Cet acteur n'a pas pu être ajouté",
	'transitions:addactor:emptyactor' => "Aucun acteur sélectionné",
	'transitions:addactor:alreadyexists' => "Cet acteur a déjà été ajouté",
	'transitions:related_content' => "Contenus liés à ce défi",
	'transitions:form:addrelation' => "Ajouter une relation",
	'transitions:addrelation' => "Ajouter une relation",
	'transitions:addrelation:noneselected' => "Aucune ressource sélectionnée",
	'transitions:addrelation:success' => "Ressource liée ajoutée",
	'transitions:addrelation:error' => "Cette ressource n'a pas pu être ajoutée",
	'transitions:addrelation:emptyactor' => "Aucune ressource sélectionnée",
	'transitions:addrelation:alreadyexists' => "Cette ressource a déjà été ajoutée",
	'transitions:index' => "Catalogue des contributions",
	'transitions:search' => "Rechercher",
	'transitions:search:go' => "Go",
	'transitions:search:placeholder' => "Rechercher une contribution",
	'transitions:search:results' => "%s résultats",
	'transitions:search:result' => "1 seul résultat ! &nbsp; Si vous pensiez à quelque chose en particulier, n'hésitez pas à proposer votre contribution.",
	'transitions:search:noresult' => "Aucun résultat ! &nbsp; Nous attendons votre contribution avec impatience ;-)",
	'transitions:socialshare' => "Mail et réseaux sociaux",
	'transitions:socialshare:details' => "Utilisez les liens de partage suivants pour publier cette contribution sur les médias sociaux.",
	//'transitions:permalink' => "Lien permanent",
	'transitions:permalink' => "Lien",
	'transitions:permalink:details' => "Utilisez le lien permanent suivant pour faire référence à cette contribution.",
	//'transitions:shortlink' => "Lien court",
	'transitions:shortlink' => "Lien",
	'transitions:shortlink:details' => "Utilisez le lien court suivant pour vos partages.",
	//'transitions:embed' => "Code d'embarquement",
	'transitions:embed' => "Intégration",
	'transitions:embed:details' => "Copiez-collez le code HTML suivant pour intégrer cette publication sur un autre site. Vous pouvez modifier les dimensions du bloc en changeant les valeurs après \"width\" (largeur) et \"height\" (hauteur).",
	'transitions:embed:search' => "Sélectionnez une ressource",
	'transitions:embed:search:actor' => "Sélectionnez un acteur",
	'transitions:share' => "Partager",
	'transitions:share:details' => "Vous pouvez partager cette ressource sur d'autres sites via les liens de partage suivants.",
	'transitions:charleft' => "caractères restants",
	'transitions:charleft:warning' => "Les caractères excédentaires ne seront pas affichés",
	'transitions:ical' => "Agenda ICAL de cette page",
	
	// Bookmarklet
	'transitions:bookmarklet' => "Bookmarklet",
	'transitions:bookmarklet:link' => "+Transitions²",
	'transitions:bookmarklet:title' => "Ajoutez ce lien à vos raccourcis pour publier directement sur Transitions²",
	'transitions:bookmarklet:description' => "Le bookmarklet \"+Transitions²\" vous permet de partager ce que vous trouvez sur le web. Pour l'utiliser, glissez simplement le bouton ci-dessus dans la barre de liens de votre navigateur. Si vous utilisez Internet Explorer, faites un clic droit sur le bouton et ajoutez-le dans vos favoris, puis dans votre barre de liens.",
	'transitions:bookmarklet:descriptionie' => "Si vous utilisez Internet Explorer, faites un clic droit sur le bouton et ajoutez-le dans vos favoris, puis dans votre barre de liens.",
	'transitions:bookmarklet:description:conclusion' => "Vous pouvez créer une contribution à partir de n'importe quelle page web en cliquant sur le bookmarklet.",
	
	
	// Select values
	'transitions:lang:other' => "Autre langue",
	
	'transitions:category:nofilter' => "Toutes",
	'transitions:category:knowledge' => "<i class=\"fa fa-lightbulb-o\"></i> Connaissance",
	'transitions:category:knowledge:details' => "Recherches, références, statistiques, indicateurs...",
	'transitions:category:experience' => "<i class=\"fa fa-book\"></i> Récit, expérience",
	'transitions:category:experience:details' => "Témoignages",
	'transitions:category:imaginary' => "<i class=\"fa fa-magic\"></i> Imaginaire",
	'transitions:category:imaginary:details' => "Scénarios prospectifs, utopies et dystopies, modèles, fictions...",
	'transitions:category:tools' => "<i class=\"fa fa-wrench\"></i> Outil ou méthode",
	'transitions:category:tools:details' => "Guides, méthodologies, outils techniques...",
	'transitions:category:actor' => "<i class=\"fa fa-user\"></i> Acteur",
	'transitions:category:actor:details' => "Individus, groupes, organisations, institutions...",
	'transitions:category:project' => "<i class=\"fa fa-cube\"></i> Projet",
	'transitions:category:project:details' => "Réalisations, projets et initiatives ; passés, présents ou à venir ; réussis ou ratés...",
	'transitions:category:event' => "<i class=\"fa fa-calendar\"></i> Evénement",
	'transitions:category:event:details' => "Un temps fort, une date à retenir, un atelier, une rencontre, bref, tout type d'événement à noter dans un calendrier !",
	'transitions:category:editorial' => "<i class=\"fa fa-newspaper-o\"></i> Produit éditorial",
	'transitions:category:editorial:details' => "Référencement d’articles, dossiers, ouvrages, etc. à propos du lien entre les deux transitions, appuyés ou non sur Transitions²",
	'transitions:category:challenge' => "<i class=\"fa fa-trophy\"></i> Défi",
	'transitions:category:challenge:details' => "Un défi adressé aux lecteurs et contributeurs de Transitions².",
	
	'transitions:actortype:individual' => "Individu",
	'transitions:actortype:collective' => "Collectif",
	'transitions:actortype:association' => "Association",
	'transitions:actortype:enterprise' => "Entreprise",
	'transitions:actortype:education' => "Etablissement d'enseignement ou de recherche",
	'transitions:actortype:collectivity' => "Collectivité locale",
	'transitions:actortype:administration' => "Administration publique",
	'transitions:actortype:plurinational' => "Entité plurinationale",
	'transitions:actortype:other' => "Autre",
	'transitions:actortype:choose' => "Sélectionnez un type d'acteur",
	
	
	'transitions:error:missing:category' => "Vous devez spécifier la catégorie de votre contribution !",
	
);
