<?php
$french = array(
	
	'slider' => "Slider",

	/* Settings */
	'slider:settings:description' => "Configuration du slider",
	'slider:settings:defaultslider' => "Contenu par défaut du slider",
	'slider:settings:defaultslider:help' => "Ce plugin vise avant tout à fournir une vue directement utilisable par les développeurs/intégrateurs. Toutefois, pour plus de commodité et dans le cadre de l'intégration avec d'autres plugins (notamment les thèmes), un contenu par défaut peut être configuré ici, et appelé directement via la vue 'slider/slider', sans configuration supplémentaire.<br />",
	
	'slider:settings:content' => "Contenu du slider par défaut",
	'slider:settings:content:help' => "Le contenu du slider affiché est défini par une série de slides qui sont autant d'éléments d'une liste, qui peuvent être une simple image, du texte, une vidéo, ou tout contenu média riche combinant ces éléments.<br />Laisser vide pour récupérer les valeurs par défaut.",
	'slider:settings:css_main' => "Propriétés CSS globales du slider (&lt;ul&gt; principal)",
	'slider:settings:css_main:help' => "n'indiquer que les propriétés, par exemple : width:600px; height:280px;<br />Laisser vide pour récupérer les valeurs par défaut.",
	'slider:settings:jsparams' => "Paramètres (JS) du slider",
	'slider:settings:jsparams:help' => "Ajouter ici les paramètres JS du slider, sous la forme d'une liste de : <strong>parametre : valeur,<br />parametre2 : valeur2,</strong><br />Laisser vide pour récupérer les valeurs par défaut.",
	'slider:settings:css_textslide' => "Propriétés CSS pour les slides contenant du texte",
	'slider:settings:css_textslide:help' => "Propriétés CSS spécifiques aux slides utilisant la classe .textSlide : n'indiquer que les propriétés, par exemple : color:#333;<br />Laisser vide pour récupérer les valeurs par défaut.",
	'slider:settings:css' => "Feuille de style en surcharge pour le slider",
	'slider:settings:css:help' => "Feuille de style en surcharge pour le slider : il s'agit cette fois des CSS complètes à ajouter en surcharge après les styles par défaut.<br />Laisser vide pour récupérer les valeurs par défaut.",
	
	
	// NEW
	'slider:showinstructions' => "Afficher le mode d'emploi",
	'slider:instructions' => "Les sliders peuvent être définis ici, puis insérés dans les articles via un shortcode <q>[slider id=\"12345\"]</q>",
	'slider:add' => "Créer un nouveau slider",
	'slider:edit' => "Edition du slider",
	'slider:edit:title' => "Titre",
	'slider:edit:description' => "Description",
	'slider:edit:content' => "Diapositives",
	'slider:edit:content:details' => "Ajoutez de nouvelles diapositives, et réorganisez-les à votre convenance.",
	'slider:edit:slide' => "Diapositive",
	'slider:edit:addslide' => "Ajouter une diapositive",
	'slider:edit:deleteslide' => "Supprimer cette diapositive",
	'slider:edit:config' => "Configuration JS",
	'slider:edit:css' => "CSS",
	'slider:edit:height' => "Hauteur",
	'slider:edit:height:details' => "Les dimensiosn du slider sont déterminées par le bloc parent. Pour forcer les dimensions de ce bloc parent, précisez ici ses dimensions. Note : toutes les valeurs de la propriété CSS \"height\" sont acceptées, en px, en %, et autres unités, y compris \"auto\".",
	'slider:edit:width' => "Largeur",
	'slider:edit:width' => "Largeur",
	'slider:edit:access' => "Visibilité",
	'slider:edit:submit' => "Enregistrer les modifications",
	'slider:saved' => "Vos modifications ont bien été enregistrées",
	'slider:edit:preview' => "Prévisualisation",
	
);

add_translation("fr",$french);

