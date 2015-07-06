<?php

return array(
	'collection' => "Collection",

	/* Settings */
	'collections:settings:description' => "Configuration de la collection",
	'collections:settings:defaultslider' => "Contenu par défaut de la collection",
	'collections:settings:defaultslider:help' => "Ce plugin vise avant tout à fournir une vue directement utilisable par les développeurs/intégrateurs. Toutefois, pour plus de commodité et dans le cadre de l'intégration avec d'autres plugins (notamment les thèmes), un contenu par défaut peut être configuré ici, et appelé directement via la vue 'collection/slider', sans configuration supplémentaire.<br />",
	
	'collections:settings:content' => "Contenu de la collection par défaut",
	'collections:settings:content:help' => "Le contenu de la collection affiché est défini par une série de slides qui sont autant d'éléments d'une liste, qui peuvent être une simple image, du texte, une vidéo, ou tout contenu média riche combinant ces éléments.<br />Laisser vide pour récupérer les valeurs par défaut.",
	'collections:settings:css_main' => "Propriétés CSS globales de la collection (&lt;ul&gt; principal)",
	'collections:settings:css_main:help' => "n'indiquer que les propriétés, par exemple : width:600px; height:280px;<br />Laisser vide pour récupérer les valeurs par défaut.",
	'collections:settings:jsparams' => "Paramètres (JS) de la collection",
	'collections:settings:jsparams:help' => "Ajouter ici les paramètres JS de la collection, sous la forme d'une liste de : <strong>parametre : valeur,<br />parametre2 : valeur2,</strong><br />Laisser vide pour récupérer les valeurs par défaut.",
	'collections:settings:css_textslide' => "Propriétés CSS pour les slides contenant du texte",
	'collections:settings:css_textslide:help' => "Propriétés CSS spécifiques aux slides utilisant la classe .textSlide : n'indiquer que les propriétés, par exemple : color:#333;<br />Laisser vide pour récupérer les valeurs par défaut.",
	'collections:settings:css' => "Feuille de style en surcharge pour le diaporama",
	'collections:settings:css:help' => "Feuille de style en surcharge pour le diaporama : il s'agit cette fois des CSS complètes à ajouter en surcharge après les styles par défaut.<br />Laisser vide pour récupérer les valeurs par défaut.",
	'collections:settings:slider_access' => "Permettre aux membres d'éditer des diaporamas",
	'collections:settings:slider_access:details' => "Par défaut, l'accès à l'édition des diaporamas est réservée aux administrateurs. Vous pouvez autoriser les membres du site à y accéder en choisissant \"Oui\"",
	'collections:option:yes' => "Oui",
	'collections:option:no' => "Non",
	'collections:error:multiple' => "Plusieurs sliders correspondent au nom demandé, impossible de déterminer lequel afficher",
	'collections:error:alreadyexists' => "Un slider portant ce nom existe déjà, veuillez choisir un autre nom.",
	
	
	'collections:showinstructions' => "Afficher le mode d'emploi",
	'collections:instructions' => "Les collections peuvent être définies ici, puis insérées dans les articles via un shortcode <q>[collection id=\"12345\"]</q>",
	'collections:add' => "Créer une nouvelle collection",
	'collections:edit' => "Edition de la collection",
	'collections:edit:title' => "Titre",
	'collections:edit:title:details' => "Permet d'identifier aisément la collection. Le titre n'est pas affiché.",
	'collections:edit:name' => "Identifiant",
	'collections:edit:name:details' => "Identifiant unique de la collection, permet de l'appeler sous une forme homogène (par ex. pour utilisation dans un thème).",
	'collections:edit:description' => "Description",
	'collections:edit:description:details' => "Permet de décrire à quoi sert le diaporama. La description n'est pas affichée.",
	'collections:edit:content' => "Diapositives",
	'collections:edit:content:details' => "Ajoutez de nouvelles diapositives, et réorganisez-les à votre convenance. <br />Note&nbsp;: les nouvelles diapositives ne disposent pas d'éditeur visuel&nbsp;; pour pouvoir l'utiliser, enregistrez votre diaporama.",
	'collections:edit:slide' => "Diapositive",
	'collections:edit:addslide' => "Ajouter une diapositive",
	'collections:edit:deleteslide' => "Supprimer cette diapositive",
	'collections:edit:deleteslide:confirm' => "ATTENTION, il n'est pas possible de récupérer le contenu d'une diapositive supprimée. La supprimer tout de même ?",
	'collections:edit:config' => "Configuration JS",
	'collections:edit:config:details' => "Paramètres de configuration JavaScript de la collection (AnythingCollection).",
	'collections:edit:config:toggledocumentation' => "<i class=\"fa fa-toggle-down\"></i>Afficher tous les paramètres de configuration disponibles",
	'collections:edit:css' => "CSS",
	'collections:edit:css:details' => "Feuille de style CSS à ajouter lors de l'affichage de ce diaporama.<br /> Note&nbsp;: pour cibler précisément ce diaporama, utilisez le sélecteur suivant (une fois le diaporama créé)&nbsp;: <strong>#collection-%s</strong>",
	'collections:edit:height' => "Hauteur",
	'collections:edit:height:details' => "Les dimensions de la collection sont déterminées par le bloc parent. Pour forcer les dimensions de ce bloc parent, précisez ici ses dimensions.<br /> Note&nbsp;: toutes les valeurs de la propriété CSS \"height\" sont acceptées, en px, en %, et autres unités, y compris \"auto\".",
	'collections:edit:width' => "Largeur",
	'collections:edit:width:details' => "Les dimensions de la collection sont déterminées par le bloc parent. Pour forcer les dimensions de ce bloc parent, précisez ici ses dimensions.<br /> Note&nbsp;: toutes les valeurs de la propriété CSS \"width\" sont acceptées, en px, en %, et autres unités, y compris \"auto\".",
	'collections:edit:access' => "Visibilité",
	'collections:edit:access:details' => "Permet de définir la visibilité de cette collection.",
	'collections:edit:submit' => "Enregistrer les modifications",
	'collections:saved' => "Vos modifications ont bien été enregistrées",
	'collections:edit:preview' => "Prévisualisation",
	'collections:edit:view' => "Afficher le diaporama",
	'collections:edit:editor' => "Toujours activer l'éditeur visuel pour l'édition",
	'collections:edit:editor:details' => "L'éditeur visuel facilite l'édition, mais il filtre également le code HTML utilisé. Cette option permet de choisir si l'éditeur doit être activé par défaut lorsque vous éditez ce diaporama. Il est conseillé de le désactiver si vous utilisez directement du code HTML (vous pourrez toujours l'activer manuellement sur une diapositive en cas de besoin).",
	'collections:editor:yes' => "Oui (filtre HTML)",
	'collections:editor:no' => "Non (activable sur demande)",
	
	'collections:shortcode:collection' => "Collection (déjà configuré)",
	'collections:embed:instructions' => "Comment intégrer cette collection ?",
	'collections:shortcode:instructions' => " - avec un shortcode, dans une publication (blog, page wiki, etc.)&nbsp;: <strong>[collection id=\"%s\"]</strong>",
	'collections:cmspages:instructions' => " - avec un code spécifique, dans un gabarit créé avec CMSPages&nbsp;: <strong>{{:collection/view|guid=%s}}</strong>",
	'collections:cmspages:instructions:shortcode' => " - avec un shortcode spécifique, méthode alternative pour un gabarit créé avec CMSPages&nbsp;: <strong>{{[collection id=\"%s\"]}}</strong>",
	'collections:cmspages:notice' => "IMPORTANT&nbsp;: seules les pages CMS de type \"Gabarit\" permettent d'afficher des collections ! Il vous sera peut-être nécessaire de mettre à jour le type de page.",
	'collections:iframe:instructions' => " - avec ce code d'embarquement, sur d'autres sites&nbsp;: <strong>&lt;iframe src=\"" . elgg_get_site_url() . "collection/view/%s?embed=full\"&gt;&lt;/iframe&gt;</strong>",
	
);


