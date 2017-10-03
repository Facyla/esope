<?php
/**
 * English strings
 */

return array(
	'elgg_cmis:title' => "CMIS Interface",
	
	// Main settings
	'elgg_cmis:cmis_url' => "Alfresco CMIS base URL (ending with alfresco/)",
	'elgg_cmis:user_cmis_url' => "Custom CMIS base URL",
	'elgg_cmis:cmis_soap_url' => "Alfresco CMIS SOAP service (part after alfresco/), eg. cmisws",
	'elgg_cmis:cmis_atom_url' => "Alfresco CMIS ATOMPUB service (part after alfresco/), eg. cmsiatom",
	'elgg_cmis:cmis_1_0_atompub' => "CMIS 1.0 AtomPub Service Document (part after alfresco/), eg. api/-default-/public/cmis/versions/1.0/atom",
	'elgg_cmis:cmis_1_0_wsdl' => "CMIS 1.0 Web Services WSDL Document (part after alfresco/), eg. cmisws/cmis?wsdl",
	'elgg_cmis:cmis_1_1_atompub' => "CMIS 1.1 AtomPub Service Document (part after alfresco/), eg. api/-default-/public/cmis/versions/1.1/atom",
	'elgg_cmis:cmis_1_1_browser_binding' => "CMIS 1.1 Browser Binding URL (part after alfresco/), eg. api/-default-/public/cmis/versions/1.1/browser",
	'elgg_cmis:cmis_login' => "CMIS login",
	'elgg_cmis:cmis_password' => "CMIS password",
	'elgg_cmis:debugmode' => "Debug mode",
	'elgg_cmis:nocontent' => "No content",
	'elgg_cmis:noresult' => "No result",
	'elgg_cmis:noconf' => "Not configured",
	'elgg_cmis:invalidurl' => "Invalid URL",
	'elgg_cmis:settings:usercmis' => "Enable User mode",
	'elgg_cmis:settings:usercmis:disabled' => "User mode disabled",
	'elgg_cmis:settings:usercmis:details' => "Members use their own CMIS credentials to use CMIS",
	'elgg_cmis:settings:usercmis:legend' => "Specific settings for user mode",
	'elgg_cmis:settings:backend' => "Enable Backend mode",
	'elgg_cmis:settings:backend:details' => "CMIS is used as a file storage backend by Elgg. Elgg uses the same credentials for the whole site, and determines access in the usual Elgg way.",
	'elgg_cmis:settings:backend:legend' => "Specific settings for backend mode",
	'elgg_cmis:settings:filestore_path' => "Filestore path on CMIS server (eg. /Applications/elgg/)",
	'elgg_cmis:settings:always_use_elggfilestore' => "Also store latest file version on Elgg Filestore",
	
	
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
	
	
	// File versions
	'elgg_cmis:versions' => "Versions&nbsp;:",
	'elgg_cmis:version:latest' => "Latest version",
	'elgg_cmis:version:latestmajor' => "Latest major version",
	'elgg_cmis:version:notexists' => "Version %s does not exist (latest %s)",
	'elgg_cmis:version:createdon' => "%s",
	'elgg_cmis:version:dateformat' => "m/d/Y at H:i:s",
	
	// File details
	'elgg_cmis:file:details' => "CMIS and filestore information&nbsp;:",
	'elgg_cmis:server:available' => "CMIS server is available and ready for use",
	'elgg_cmis:server:notavailable' => "CMIS server is not available or cannot be used",
	'elgg_cmis:file:metadata' => "Metadata&nbsp;:",
	'elgg_cmis:file:mimetype' => "MIME type&nbsp;: %s",
	'elgg_cmis:file:simpletype' => "File simpletype&nbsp;: %s",
	'elgg_cmis:file:size' => "File size&nbsp;: %s",
	'elgg_cmis:file:createdon' => "created %s",
	'elgg_cmis:file:cmisid' => "CMIS ID&nbsp;: %s",
	'elgg_cmis:file:cmispath' => "CMIS path&nbsp;: %s",
	'elgg_cmis:file:filename' => "Original file name&nbsp;: %s",
	'elgg_cmis:file:filestorename' => "Elgg filestore name&nbsp;: %s",
	'elgg_cmis:file:latest_filestore' => "Latest file version stored in&nbsp;: %s",
	'elgg_cmis:file:download' => "<i class=\"fa fa-download\"></i>&nbsp;Download",
	
	'elgg_cmis:filestore' => "Filestore&nbsp;:",
	'elgg_cmis:filestore:cmis' => "File should be stored in CMIS repository",
	'elgg_cmis:filestore:cmis:stored' => "File is stored in CMIS repository",
	'elgg_cmis:filestore:cmis:notstored' => "File is NOT stored in CMIS repository",
	'elgg_cmis:filestore:elgg' => "File should be stored in Elgg filestore",
	'elgg_cmis:filestore:elgg:stored' => "File is stored in Elgg repository",
	'elgg_cmis:filestore:elgg:notstored' => "File is NOT stored in Elgg repository",
	'elgg_cmis:filestore:elgg:fallback' => "Could not use CMIS filestore, falling back to Elgg filestore.",
	
	
);


