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
	
	'elgg_cmis:document' => "Document",
	'elgg_cmis:folder' => "Dossier",
	'elgg_cmis:foldertype:cmis:folder' => '<i class="fa fa-folder fa-fw"></i>&nbsp;Dossier',
	'elgg_cmis:foldertype:F:st:site' => '<i class="fa fa-sitemap fa-fw"></i>&nbsp;Site',
	'elgg_cmis:unknowtype' => '<i class="fa fa-question fa-fw"></i>&nbsp;Objet de type inconnu', // Unknown Object Type
	/*
	'elgg_cmis:action:view' => "Afficher",
	'elgg_cmis:action:edit' => "Modifier",
	'elgg_cmis:action:page' => "Voir la page",
	'elgg_cmis:action:download' => "Télécharger",
	*/
	'elgg_cmis:action:view' => '<i class="fa fa-desktop fa-fw"></i>&nbsp;Afficher',
	'elgg_cmis:action:edit' => '<i class="fa fa-pencil fa-fw"></i>&nbsp;Modifier',
	'elgg_cmis:action:page' => '<i class="fa fa-external-link fa-fw"></i>&nbsp;Voir la page',
	'elgg_cmis:action:download' => '<i class="fa fa-download fa-fw"></i>&nbsp;Télécharger',
	
	'elgg_cmis:loading' => "Chargement en cours",
	
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

