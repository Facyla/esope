<?php
/**
 * French strings
 */

$fr = array(
	'link_preview' => "Prévisualisation de liens web",
	
	'link_preview:details' => "Cette fonctionnalité permet de prévisualiser le contenu d'un lien, en l'ouvrant sous forme réduite dans une fenêtre de prévisualisation.<br />Techniquement, il s'agit d'une iframe dont les dimensions sont réduites, aussi le temps de chargement dépend directement des caractéristiques techniques du site à prévisualiser.",
	
	'link_preview:setting:trigger' => "Déclencheur",
	'link_preview:trigger:hover' => "Survol",
	'link_preview:trigger:click' => "Clic",
	'link_preview:setting:trigger:details' => "Evénement qui déclenche l'affichage de la fenêtre de prévisualisation : Hover = au survol, Click = au premier clic (le 2e déclenche l'ouverture du lien).",
	'link_preview:setting:scale' => "Echelle",
	'link_preview:setting:scale:details' => "Ratio de réduction pour la fenêtre de prévisualisation (dont les dimensions sont calculées automatiquement à partir des dimensions définies ci-après).",
	'link_preview:setting:targetwidth' => "Largeur de l'écran",
	'link_preview:setting:targetwidth:details' => "Largeur de l'écran d'affichage du site à prévisualiser (influe sur le type de rendu, par ex. version mobile ou tablette si trop faible)",
	'link_preview:setting:targetheight' => "Hauteur de l'écran",
	'link_preview:setting:targetheight:details' => "Hauteur de l'écran d'affichage du site à prévisualiser (idem)",
	'link_preview:setting:offset' => "Décalage",
	'link_preview:setting:offset:details' => "Nombre de pixels de décalage par rapport au lien",
	'link_preview:setting:position' => "Position",
	'link_preview:setting:position:details' => "Emplacement de la fenêtre de prévisualisation par rapport au lien.",
	'link_preview:position:right' => "Droite",
	'link_preview:position:left' => "Gauche",
	
);

add_translation('fr', $fr);

