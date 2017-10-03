<?php
/**
 * French strings
 */

return array(
	'elgg_cmis:title' => "Interface CMIS",
	
	// Main settings
	'elgg_cmis:settings:vendor' => "Bibliothèque CMIS",
	'elgg_cmis:settings:vendor:details' => "Apache Chemistry CMIS PHP Client is the most known PHP CMIS library. However it lacks some features that the other library has implemented, such as versionning.<br />PHP CMIS Client is a port of OpenCMIS (Java) to PHP. Interfaces are mostly the same so most OpenCMIS examples should be also usable for this PHP CMIS Library.",
	'elgg_cmis:settings:usercmis' => "Activer le mode Utilisateur",
	'elgg_cmis:settings:usercmis:disabled' => "Mode Utilisateur désactivé",
	'elgg_cmis:settings:usercmis:details' => "Les membres accèdent à CMIS avec leur propre accès. Cela nécessite qu'ils renseignent leur mot de passe dans leurs paramètres personnels - celui-ci est crypté cependant ce n'est pas idéal du point de vue sécurité.",
	'elgg_cmis:settings:usercmis:legend' => "Paramètres spécifiques pour le mode Utilisateur",
	'elgg_cmis:settings:backend' => "Activer le mode Backend",
	'elgg_cmis:settings:backend:details' => "CMIS est utilisé comme backend pourle stockage des fichiers de Elgg. Dans ce cas le site dispose d'un accès unique pour tous les fichiers, Elgg se chargeant de gérer les droits d'accès sur ces fichiers.",
	'elgg_cmis:settings:backend:legend' => "Paramètres spécifiques pour le mode Backend",
	'elgg_cmis:settings:filestore_path' => "Chemin des fichiers sur le serveur",
'elgg_cmis:settings:filestore_path:details' => "Le chemin absolu de la racine pour le stockage des fichiers sur le serveur CMIS. L'utilisateur configuré doit avoir tous les droits d'édition sur ce répertoire. Par ex.&nbsp;: /Applications/elgg/",
	'elgg_cmis:settings:always_use_elggfilestore' => "Conserver également la dernière version dans Elgg Filestore",
	
	'elgg_cmis:cmis_url' => "Base de l'URL CMIS",
	'elgg_cmis:cmis_url:details' => "URL complète avec un slash final. Par ex. pour Alfresco, cette URL se termine par&nbsp;: alfresco/",
	'elgg_cmis:user_cmis_url' => "Base de l'URL CMIS",
	'elgg_cmis:cmis_soap_url' => "Service CMIS SOAP",
	'elgg_cmis:cmis_soap_url:details' => "Fragment d'URL pour SOAP, sans slash final. Par ex. pour Alfresco&nbsp;: cmisws",
	'elgg_cmis:cmis_atom_url' => "Service CMIS ATOMPUB",
	'elgg_cmis:cmis_atom_url:details' => "Fragment d'URL pour ATOMPUB, sans slash final. Par ex. pour Alfresco&nbsp;: cmsiatom",
	'elgg_cmis:cmis_1_0_atompub' => "CMIS 1.0 AtomPub Service Document",
	'elgg_cmis:cmis_1_0_atompub:details' => "Par ex. pour Alfresco&nbsp;: api/-default-/public/cmis/versions/1.0/atom",
	'elgg_cmis:cmis_1_0_wsdl' => "CMIS 1.0 Web Services WSDL Document",
	'elgg_cmis:cmis_1_0_wsdl:details' => "Par ex. pour Alfresco&nbsp;: cmisws/cmis?wsdl",
	'elgg_cmis:cmis_1_1_atompub' => "CMIS 1.1 AtomPub Service Document",
	'elgg_cmis:cmis_1_1_atompub:details' => "Par ex. pour Alfresco&nbsp;: api/-default-/public/cmis/versions/1.1/atom",
	'elgg_cmis:cmis_1_1_browser_binding' => "CMIS 1.1 Browser Binding URL",
	'elgg_cmis:cmis_1_1_browser_binding:details' => "Par ex. pour Alfresco&nbsp;: api/-default-/public/cmis/versions/1.1/browser",
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
	
	
	// File versions
	'elgg_cmis:versions' => "Versions&nbsp;:",
	'elgg_cmis:version:latest' => "Dernière version",
	'elgg_cmis:version:latestmajor' => "Dernière version majeure",
	'elgg_cmis:version:notexists' => "La version %s n'existe pas (dernière %s)",
	'elgg_cmis:version:createdon' => "%s",
	'elgg_cmis:version:dateformat' => "%s",
	'elgg_cmis:version:dateformat' => "d/m/Y à H:i:s",
	
	// File details
	'elgg_cmis:file:details' => "Informations sur CMIS et le Filestore utilisé&nbsp;:",
	'elgg_cmis:server:available' => "Le serveur CMIS est opérationnel",
	'elgg_cmis:server:notavailable' => "Le serveur CMIS n'est pas opérationnel",
	'elgg_cmis:file:metadata' => "Métadonnées&nbsp;:",
	'elgg_cmis:file:mimetype' => "Type MIME&nbsp;: %s",
	'elgg_cmis:file:simpletype' => "Type de fichier&nbsp;: %s",
	'elgg_cmis:file:size' => "Poids du fichier&nbsp;: %s",
	'elgg_cmis:file:createdon' => "créé %s",
	'elgg_cmis:file:cmisid' => "ID CMIS&nbsp;: %s",
	'elgg_cmis:file:cmispath' => "Chemin CMIS&nbsp;: %s",
	'elgg_cmis:file:filename' => "Nom d'origine du fichier&nbsp;: %s",
	'elgg_cmis:file:filestorename' => "Nom dans le filestore d'Elgg&nbsp;: %s",
	'elgg_cmis:file:latest_filestore' => "Dernière version du fichier stockée dans&nbsp;: %s",
	'elgg_cmis:file:download' => "<i class=\"fa fa-download\"></i>&nbsp;Télécharger",
	
	'elgg_cmis:filestore' => "Filestore&nbsp;:",
	'elgg_cmis:filestore:cmis' => "Le fichier devrait être stocké dans le répertoire CMIS",
	'elgg_cmis:filestore:cmis:stored' => "Le fichier est stocké dans le répertoire CMIS",
	'elgg_cmis:filestore:cmis:notstored' => "Le fichier n'est pas stocké dans le répertoire CMIS",
	'elgg_cmis:filestore:elgg' => "Le fichier devrait être stocké dans le filestore d'Elgg",
	'elgg_cmis:filestore:elgg:stored' => "Le fichier est stocké dans le filestore d'Elgg",
	'elgg_cmis:filestore:elgg:notstored' => "Le fichier n'est pas stocké dans le filestore d'Elgg",
	'elgg_cmis:filestore:elgg:fallback' => "Erreur du filestore CMIS, stockage sur la plateforme.",
	
	
);


