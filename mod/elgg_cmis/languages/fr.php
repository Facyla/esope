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
	'elgg_cmis:nocontent' => "Aucun contenu",
	'elgg_cmis:noresult' => "Aucun résultat",
	'elgg_cmis:noconf' => "Module non configuré",
	'elgg_cmis:invalidurl' => "URL invalide",
	
	// Object types
	'elgg_cmis:document' => "Document",
	'elgg_cmis:folder' => "Dossier",
	'elgg_cmis:foldertype:cmis:folder' => 'Dossier',
	'elgg_cmis:foldertype:F:st:site' => 'Site',
	'elgg_cmis:unknowtype' => 'Objet de type inconnu', // Unknown Object Type
	'elgg_cmis:icon:document' => '<i class="file icon fa fa-file"></i>',
	'elgg_cmis:icon:folder' => '<i class="folder icon fa fa-folder"></i>',
	'elgg_cmis:icon:foldertype:cmis:folder' => '<i class="folder icon fa-folder"></i>',
	'elgg_cmis:icon:foldertype:F:st:site' => '<i class="sitemap icon fa fa-sitemap"></i>',
	'elgg_cmis:icon:unknowtype' => '<i class="sitemap icon fa fa-sitemap"></i>',
	
	// Actions
	'elgg_cmis:action:openfolder' => "Ouvrir le dossier",
	'elgg_cmis:action:view' => "Afficher",
	'elgg_cmis:action:edit' => "Modifier",
	'elgg_cmis:action:page' => "Voir la page",
	'elgg_cmis:action:download' => "Télécharger",
	'elgg_cmis:icon:openfolder' => '<i class="folder open icon fa fa-folder-open"></i>',
	'elgg_cmis:icon:download' => '<i class="download disk icon fa fa-download"></i>',
	'elgg_cmis:icon:view' => '<i class="external url icon fa fa-external-link"></i>',
	'elgg_cmis:icon:page' => '<i class="desktop icon fa fa-desktop"></i>',
	'elgg_cmis:icon:edit' => '<i class="pencil icon fa fa-pencil"></i>',
	
	'elgg_cmis:loading' => "Chargement en cours",
	
	// Widgets
	'elgg_cmis:author' => "Identifiant de l'auteur",
	'elgg_cmis:widgets' => "Widgets CMIS",
	'elgg_cmis:widget:folder ' => "URL ou ID du dossier",
	'elgg_cmis:widget:search ' => "Titre à rechercher",
	'elgg_cmis:widget:insearch ' => "Texte à rechercher",
	'elgg_cmis:widget:cmis' => "CMIS",
	'elgg_cmis:widget:cmis:details' => "Widget CMIS générique (multicritères)",
	'elgg_cmis:widget:cmis_mine' => "Mes fichiers sous Partage",
	'elgg_cmis:widget:cmis_mine:details' => "La liste de mes fichiers sur Partage",
	'elgg_cmis:widget:cmis_folder' => "Dossier sur Partage",
	'elgg_cmis:widget:cmis_folder:details' => "Le contenu d'un dossier sur Partage",
	'elgg_cmis:widget:cmis_search' => "Recherche sur Partage",
	'elgg_cmis:widget:cmis_search:details' => "Liste des résultats d'une recherche sur Partage",
	'elgg_cmis:widget:cmis_insearch' => "Recherche plein texte sur Partage",
	'elgg_cmis:widget:cmis_insearch:details' => "Liste des résultats d'une recherche plein texte sur Partage",
	
	/* Usersettings */
	'elgg_cmis:details' => "Ce panneau de configuration vous permet de  pouvoir accéder facilement à vos données sur Partage en pré-enregistrant votre mot de passe Partage. Il vous sera utile dans deux cas :<br />
 - l'accès direct à vos fichiers  sous Partage via le tableau de bord de la page d'accueil \"Mes fichiers sous Partage\"<br />
 - l'accès direct à un répertoire dédié sous Partage via un groupe, lorsque le responsable du groupe l'a prévu.<br />
Votre mot de passe sera crypté.",
	'elgg_cmis:nopassword' => "Aucun mot de passe défini.",
	'elgg_cmis:changepassword' => "Votre mot de passe est bien enregistré (et crypté).<br />Si vous souhaitez le changer, veuillez saisir et enregistrer votre nouveau mot de passe ci-dessous.<br />Pour le supprimer totalement, saisissez \"RAZ\" comme mot de passe : cela réinitialisera vos informations d'authentification.",
	'elgg_cmis:deletedpassword' => "Votre mot de passe a bien été supprimé.",
	
);

add_translation('fr', $fr);

