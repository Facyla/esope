<?php

return array(
	'collection' => "Collections",
	'collections' => "Collections",
	'item:object:collection' => "Collections",

	/* Settings */
	'collections:settings:description' => "Configuration des collections",
	
	'collections:option:yes' => "Oui",
	'collections:option:no' => "Non",
	'collections:error:multiple' => "Plusieurs collections correspondent au nom demandé, impossible de déterminer laquelle afficher",
	'collections:error:alreadyexists' => "Une collection portant ce nom existe déjà, veuillez choisir un autre nom.",
	
	
	'collections:showinstructions' => "Afficher le mode d'emploi",
	'collections:instructions' => "Les collections peuvent être définies ici, puis insérées dans les articles via un shortcode <q>[collection id=\"12345\"]</q>",
	'collections:add' => "Créer une nouvelle collection",
	'collections:edit' => "Edition de la collection",
	'collections:edit:title' => "Titre",
	'collections:edit:title:details' => "Le titre de votre collection.",
	'collections:edit:name' => "Personnaliser l'URL de la collection",
	'collections:edit:name:details' => "Identifiant unique, sans accent ni caractères spéciaux, en minuscule et tout attaché, par ex.: mon-article-non-acentue.",
	'collections:edit:description' => "Description",
	'collections:edit:description:details' => "Permet d'introduire et de contextualiser cette collection : pourquoi ces ressources, dans quel but, à quoi cela fait référence, etc.",
	'collections:edit:content' => "Eléments",
	'collections:edit:content:details' => "Ajoutez de nouvelles publications à votre collection, et réorganisez-les à votre convenance en faisant un cliquer-déplacer.",
	'collections:edit:entity:none' => "Aucune publication sélectionnée",
	'collections:edit:entity' => "Publication",
	'collections:edit:addentity' => "+ Ajouter une publication",
	'collections:addentity:notallowed' => "Vous n'avez pas l'autorisation d'ajouter d'élément à cette collection.",
	'collections:edit:deleteentity' => "Retirer cette publication",
	'collections:edit:deleteentity:confirm' => "Attention, confirmez-vous vouloir retirer cette publication de la collection ?",
	'collections:edit:access' => "Visibilité",
	'collections:edit:access:details' => "Permet de définir qui peut voir cette collection.",
	'collections:edit:submit' => "Enregistrer les modifications",
	'collections:saved' => "Vos modifications ont bien été enregistrées",
	'collections:edit:preview' => "Prévisualisation",
	'collections:edit:view' => "Afficher la collection",

	'collections:shortcode:collection' => "Collection (déjà configurée)",
	'collections:embed:instructions' => "Comment intégrer cette collection ?",
	'collections:shortcode:instructions' => " - avec un shortcode, dans une publication (blog, page wiki, etc.)&nbsp;: <strong>[collection id=\"%s\"]</strong>",
	'collections:cmspages:instructions' => " - avec un code spécifique, dans un gabarit créé avec CMSPages&nbsp;: <strong>{{:collection/view|guid=%s}}</strong>",
	'collections:cmspages:instructions:shortcode' => " - avec un shortcode spécifique, méthode alternative pour un gabarit créé avec CMSPages&nbsp;: <strong>{{[collection id=\"%s\"]}}</strong>",
	'collections:cmspages:notice' => "IMPORTANT&nbsp;: seules les pages CMS de type \"Gabarit\" permettent d'afficher des collections ! Il vous sera peut-être nécessaire de mettre à jour le type de page.",
	'collections:iframe:instructions' => " - avec ce code d'embarquement, sur d'autres sites&nbsp;: <strong>&lt;iframe src=\"" . elgg_get_site_url() . "collection/view/%s?embed=full\"&gt;&lt;/iframe&gt;</strong>",
	
	
	// NEW STRINGS
	'collections:view' => "Voir les éléments",
	'collections:edit:entities' => "Publication",
	'collections:edit:entities_comment' => "Commentaire",
	'collections:select_entity' => "Choisir une publication",
	'collections:change_entity' => "Changer de publication",
	'collection:add' => "Créer une collection",
	
	'collections:access:draft' => "Non publié",
	'collections:access:published' => "Publié",
	'collections:edit:write_access' => "Autoriser les contributions",
	'collections:edit:write_access:details' => "Si Oui, vous permettez à d'autres contributeurs d'ajouter des publications à cette collection.",
	'collections:write:closed' => "Non",
	'collections:write:open' => "Oui",
	'collections:addentity' => "Ajouter un élément",
	'collections:addentity:details' => "Vous pouvez utiliser le formulaire ci-dessous pour choisir et ajouter d'autres éléments à cette collection.",
	'collections:addentity:submit' => "Ajouter cette publication",
	'collections:addentity:alreadyexists' => "Cette publication fait déjà partie de la collection. Vous pouvez utiliser les commentaires pour échanger avec l'auteur.",
	'collections:addentity:success' => "La contribution a bien été ajoutée à cette collection.",
	
	//'collections:' => "",
	'collections:publishin' => "Publier dans",
	'collections:removefromcollection' => "Retirer de",
	'collections:addtocollection' => "Ajouter dans une nouvelle collection",
	'collections:strapline' => 'Dernière mise à jour le %s par %s',
	'collections:missingrequired' => "Il manque un champs requis",
	'collections:embed:search' => "Recherche",
	'collections:embed:subtype' => "Type de publication",
	'collections:embed:nofilter' => "Toutes (pas de filtre)",
	
	'collections:collectionsthis' => "Ajouter à une collection",
	'collections:share' => "Partager",
	'collections:socialshare:details' => "Utilisez les liens de partage suivants pour publier cette collection sur les médias sociaux.",
	'collections:permalink' => "Permalien",
	'collections:permalink:details' => "Utilisez le lien permanent suivant pour faire référence à cette collection.",
	'collections:shortlink' => "Lien court",
	'collections:shortlink:details' => "Utilisez le lien court suivant pour vos partages.",
	'collections:embed' => "Intégrer",
	'collections:embed:details' => "Copiez-collez le code HTML suivant pour intégrer cette publication sur un autre site. Vous pouvez modifier les dimensions du bloc en changeant les valeurs après \"width\" (largeur) et \"height\" (hauteur).",
	'collections:entities:count' => "%s éléments",
	'collections:settings:subtypes' => "Subtypes",
	'collections:settings:subtypes:details' => "Subtypes pouvant être ajoutés aux collections",
	
	'collection:icon' => "Image",
	'collection:icon:details' => "Choisissez une image pour illustrer votre collection.",
	'collection:icon:new' => "Ajouter une image",
	'collection:icon:remove' => "Supprimer l'image",
	
);


