<?php
/**
 * French strings
 */
global $CONFIG;

$fr = array(
	'elgg_cmis:title' => "Interface CMIS",
	
	'elgg_cmis:cmis_url' => "Base de l'URL CMIS Alfresco (se terminant par alfresco/)",
	'elgg_cmis:user_cmis_url' => "Base de l'URL CMIS",
	'elgg_cmis:cmis_soap_url' => "Service Alfresco CMIS SOAP (partie après alfresco/), par ex: cmisws",
	'elgg_cmis:cmis_atom_url' => "Service Alfresco CMIS ATOMPUB (partie après alfresco/), par ex: cmsiatom",
	'elgg_cmis:cmis_login' => "Identifiant",
	'elgg_cmis:cmis_password' => "Mot de passe",
	'elgg_cmis:debugmode' => "Activer le mode debug",
	
	// Object types
	'elgg_cmis:document' => "Document",
	'elgg_cmis:folder' => "Dossier",
	'elgg_cmis:foldertype:cmis:folder' => 'Dossier',
	'elgg_cmis:foldertype:F:st:site' => 'Site',
	'elgg_cmis:unknowtype' => 'Objet de type inconnu', // Unknown Object Type
	'elgg_cmis:icon:document' => '<i class="file icon"></i>',
	'elgg_cmis:icon:folder' => '<i class="folder icon"></i>',
	'elgg_cmis:icon:foldertype:cmis:folder' => '<i class="folder icon"></i>',
	'elgg_cmis:icon:foldertype:F:st:site' => '<i class="sitemap icon"></i>',
	'elgg_cmis:icon:unknowtype' => '<i class="sitemap icon"></i>',
	
	// Actions
	'elgg_cmis:action:openfolder' => "Ouvrir le dossier",
	'elgg_cmis:action:view' => "Afficher",
	'elgg_cmis:action:edit' => "Modifier",
	'elgg_cmis:action:page' => "Voir la page",
	'elgg_cmis:action:download' => "Télécharger",
	'elgg_cmis:icon:openfolder' => '<i class="folder open icon"></i>',
	'elgg_cmis:icon:download' => '<i class="download disk icon"></i>',
	'elgg_cmis:icon:view' => '<i class="external url icon"></i>',
	'elgg_cmis:icon:page' => '<i class="desktop icon"></i>',
	'elgg_cmis:icon:edit' => '<i class="pencil icon"></i>',
	
	'elgg_cmis:loading' => "Chargement en cours",
	
	// Widgets
	'elgg_cmis:author' => "Identifiant de l'auteur",
	'elgg_cmis:widget:search ' => "Titre à rechercher",
	'elgg_cmis:widget:insearch ' => "Texte à rechercher",
	'elgg_cmis:widget:cmis' => "CMIS",
	'elgg_cmis:widget:cmis:details' => "Widget CMIS générique (multicritères)",
	'elgg_cmis:widget:cmis_mine' => "CMIS : Mes fichiers",
	'elgg_cmis:widget:cmis_mine:details' => "La liste de mes fichiers sur Partage",
	'elgg_cmis:widget:cmis_folder' => "CMIS : Dossier",
	'elgg_cmis:widget:cmis_folder:details' => "Le contenu d'un dossier sur Partage",
	'elgg_cmis:widget:cmis_search' => "CMIS : Recherche par titre",
	'elgg_cmis:widget:cmis_search:details' => "Liste des résultats d'une recherche sur Partage",
	'elgg_cmis:widget:cmis_insearch' => "CMIS : Recherche plein texte",
	'elgg_cmis:widget:cmis_insearch:details' => "Liste des résultats d'une recherche plein texte sur Partage",
	
);

add_translation('fr', $fr);

