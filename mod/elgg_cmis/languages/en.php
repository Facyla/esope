<?php
/**
 * English strings
 */
global $CONFIG;

$en = array(
	'elgg_cmis:title' => "CMIS Interface",
	
	'elgg_cmis:cmis_url' => "Alfresco CMIS base URL (ending with alfresco/)",
	'elgg_cmis:user_cmis_url' => "Custom CMIS base URL",
	'elgg_cmis:cmis_soap_url' => "Alfresco CMIS SOAP service (part after alfresco/), eg. cmisws",
	'elgg_cmis:cmis_atom_url' => "Alfresco CMIS ATOMPUB service (part after alfresco/), eg. cmsiatom",
	'elgg_cmis:cmis_login' => "CMIS login",
	'elgg_cmis:cmis_password' => "CMIS password",
	'elgg_cmis:debugmode' => "Debug mode",
	'elgg_cmis:nocontent' => "No content",
	'elgg_cmis:noresult' => "No result",
	'elgg_cmis:noconf' => "Not configured",
	'elgg_cmis:invalidurl' => "Invalid URL",
	
	// Object types
	'elgg_cmis:document' => "Document",
	'elgg_cmis:folder' => "Folder",
	'elgg_cmis:foldertype:cmis:folder' => 'Folder',
	'elgg_cmis:foldertype:F:st:site' => 'Site',
	'elgg_cmis:unknowtype' => "Unknown Object Type",
	'elgg_cmis:icon:document' => '<i class="file icon fa fa-file"></i>',
	'elgg_cmis:icon:folder' => '<i class="folder icon fa fa-folder"></i>',
	'elgg_cmis:icon:foldertype:cmis:folder' => '<i class="folder icon fa fa-folder"></i>',
	'elgg_cmis:icon:foldertype:F:st:site' => '<i class="sitemap icon fa fa-sitemap"></i>',
	'elgg_cmis:icon:unknowtype' => '<i class="sitemap icon fa fa-sitemap"></i>',
	// Actions
	'elgg_cmis:action:openfolder' => 'Open folder',
	'elgg_cmis:action:view' => 'View',
	'elgg_cmis:action:edit' => 'Edit',
	'elgg_cmis:action:page' => 'View page',
	'elgg_cmis:action:download' => 'Download',
	'elgg_cmis:icon:openfolder' => '<i class="folder open icon fa fa-folder-open"></i>',
	'elgg_cmis:icon:download' => '<i class="download disk icon fa fa-download"></i>',
	'elgg_cmis:icon:view' => '<i class="external url icon fa fa-external-link"></i>',
	'elgg_cmis:icon:page' => '<i class="desktop icon fa fa-desktop"></i>',
	'elgg_cmis:icon:edit' => '<i class="pencil icon fa fa-pencil"></i>',
	
	'elgg_cmis:loading' => "Loading...",
	
	// Widgets
	'elgg_cmis:author' => "Author login",
	'elgg_cmis:widgets' => "CMIS widgets",
	'elgg_cmis:widget:folder ' => "Folder URL or ID",
	'elgg_cmis:widget:search ' => "Search title",
	'elgg_cmis:widget:insearch ' => "Search text",
	'elgg_cmis:widget:cmis' => "CMIS",
	'elgg_cmis:widget:cmis:details' => "Generic CMIS widget (custom queries",
	'elgg_cmis:widget:cmis_mine' => "My Files on Partage",
	'elgg_cmis:widget:cmis_mine:details' => "My files on Partage",
	'elgg_cmis:widget:cmis_folder' => "Folder on Partage",
	'elgg_cmis:widget:cmis_folder:details' => "A folder's content on Partage",
	'elgg_cmis:widget:cmis_search' => "Title search on Partage",
	'elgg_cmis:widget:cmis_search:details' => "Search results on Partage",
	'elgg_cmis:widget:cmis_insearch' => "Fulltext search on Partage",
	'elgg_cmis:widget:cmis_insearch:details' => "Fulltext search results on Partage",
	
	/* Usersettings */
	'elgg_cmis:details' => "This settings pane gives you an easy access to Partage by saving your Partage password. This will be useful in two cases :
	 - direct access to your Partage files through the Partage widget on homepage \"My files on Partage\"<br />
 - direct access to a specific folder on Partage through a group, when the Iris group admin has set it up.<br />
Your password will be encrypted.",
	'elgg_cmis:nopassword' => "Password not set.",
	'elgg_cmis:changepassword' => "Your password has been successfully saved (and encrypted).<br />If you wish to update it, please fill then save your new credentials below.<br />To remove your password, please type \"RAZ\" as password: this will remove all your Partage credentials in Iris.",
	'elgg_cmis:deletedpassword' => "Your password has been successfully deleted.",
	
);

add_translation('en', $en);

