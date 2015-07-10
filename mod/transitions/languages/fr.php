<?php
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
	'transitions:edit' => "Modifier la contribution",
	'transitions:excerpt' => "En 140 caractères...",
	'transitions:body' => "Contenu de votre contribution",
	'transitions:save_status' => "Dernier enregistrement:",
	
	'transitions:revision' => "Révision",
	'transitions:auto_saved_revision' => "Révision automatiquement enregistrée",

	// messages
	'transitions:message:saved' => "Contribution enregistrée.",
	'transitions:error:cannot_save' => "Impossible d\'enregistrer la contribution.",
	'transitions:error:cannot_auto_save' => "Impossible de sauvegarder automatiquement la contribution. ",
	'transitions:error:cannot_write_to_container' => "Droits d\'accès insuffisants pour enregistrer la contribution pour ce groupe.",
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
	'transitions:icon' => "Vignette",
	'transitions:icon:details' => "Vous pouvez charger une image qui sera utilisée pour illustrer votre contribution.",
	'transitions:icon:new' => "Ajouter une vignette",
	'transitions:icon:remove' => "Supprimer la vignette",
	'transitions:attachment' => "Fichier joint",
	'transitions:attachment:details' => "Vous pouvez joindre un fichier à votre contribution. Si vous souhaitez joindre plusieurs fichiers, veuillez en faire un ZIP.",
	'transitions:attachment:new' => "Joindre un fichier",
	'transitions:attachment:remove' => "Supprimer le fichier joint",
	'transitions:category' => "Catégorie",
	'transitions:url' => "Lien web",
	'transitions:url:details' => "Si votre contribution fait référence à une ressource en ligne, veuillez indiquer son adresse.",
	'transitions:lang' => "Langue",
	'transitions:resourcelang' => "Langue de la ressource",
	'transitions:resourcelang:details' => "Si la ressource est disponible dans une autre langue, veuillez indiquer laquelle.",
	'transitions:territory' => "Territoire",
	'transitions:territory:details' => "Si la ressource concerne un territoire, veuillez indiquer lequel. Veuillez indiquer une adresse précise afin de pouvoir afficher la ressource sur une carte, par ex. \"8 passage Brûlon, Paris, France\" ou \"Drôme, France\" ou \"Madagascar\".",
	'transitions:actortype' => "Type d'acteur",
	'transitions:startdate' => "Date de début",
	'transitions:enddate' => "Date de fin",
	'transitions:savedraft' => "Publier ma contribution",
	
	// Other forms
	'transitions:contributed_tags' => "Tags des contributeurs",
	'transitions:form:addtag' => "Ajouter un tag",
	'transitions:addtag' => "Ajouter le tag",
	'transitions:form:addlink' => "Ajouter un lien vers une autre ressource",
	'transitions:addlink' => "Ajouter le lien",
	'transitions:links_supports' => "Ressources en accord",
	'transitions:relation:supports' => "en soutien",
	'transitions:links_invalidates' => "Ressources en opposition",
	'transitions:relation:invalidates' => "en opposition",
	'transitions:index' => "Catalogue des contributions",
	'transitions:search:results' => "%s résultats",
	'transitions:search:result' => "1 seul résultat ! &nbsp; Si vous pensiez à autre chose, n'hésitez pas à en faire part ci-dessous.",
	'transitions:search:noresult' => "Aucun résultat ! &nbsp; Nous attendons votre contribution avec impatience ;-)",
	
	
	
	// Select values
	'transitions:lang:other' => "Autre langue",
	
	'transitions:category:nofilter' => "Toutes",
	'transitions:category:knowledge' => "<i class=\"fa fa-lightbulb-o\"></i> Connaissance",
	'transitions:category:experience' => "<i class=\"fa fa-book\"></i> Récit, expérience",
	'transitions:category:imaginary' => "<i class=\"fa fa-magic\"></i> Imaginaire",
	'transitions:category:tools' => "<i class=\"fa fa-wrench\"></i> Outil ou méthode",
	'transitions:category:actor' => "<i class=\"fa fa-user\"></i> Acteur",
	'transitions:category:project' => "<i class=\"fa fa-cube\"></i> Projet",
	'transitions:category:editorial' => "<i class=\"fa fa-newspaper-o\"></i> Produit éditorial",
	'transitions:category:event' => "<i class=\"fa fa-calendar\"></i> Evénement",
	
	'transitions:actortype:individual' => "Individu",
	'transitions:actortype:collective' => "Collectif",
	'transitions:actortype:association' => "Association",
	'transitions:actortype:enterprise' => "Entreprise",
	'transitions:actortype:education' => "Etablissement d'enseignement ou de recherche",
	'transitions:actortype:collectivity' => "Collectivité locale",
	'transitions:actortype:administration' => "Administration publique",
	'transitions:actortype:plurinational' => "Entité plurinationale",
	'transitions:actortype:other' => "Autre",
	
	
);
