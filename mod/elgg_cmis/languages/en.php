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
	
	'elgg_cmis:document' => "Document",
	'elgg_cmis:folder' => "Folder",
	'elgg_cmis:foldertype:cmis:folder' => '<i class="fa fa-folder fa-fw"></i>&nbsp;Folder',
	'elgg_cmis:foldertype:F:st:site' => '<i class="fa fa-sitemap fa-fw"></i>&nbsp;Site',
	'elgg_cmis:unknowtype' => "Unknown Object Type",
	/*
	'elgg_cmis:action:view' => '<i class="fa fa-desktop"></i>&nbsp;View',
	'elgg_cmis:action:edit' => '<i class="fa fa-pencil"></i>&nbsp;Edit',
	'elgg_cmis:action:page' => '<i class="fa fa-external-link"></i>&nbsp;View page',
	'elgg_cmis:action:download' => '<i class="fa fa-download"></i>&nbsp;Download',
	*/
	'elgg_cmis:action:view' => '<i class="fa fa-desktop fa-fw"></i>&nbsp;View',
	'elgg_cmis:action:edit' => '<i class="fa fa-pencil fa-fw"></i>&nbsp;Edit',
	'elgg_cmis:action:page' => '<i class="fa fa-external-link fa-fw"></i>&nbsp;View page',
	'elgg_cmis:action:download' => '<i class="fa fa-download fa-fw"></i>&nbsp;Download',
	
	'elgg_cmis:loading' => "Loading...",
	
	'elgg_cmis:widget:cmis' => "CMIS",
	'elgg_cmis:widget:cmis:details' => "Generic CMIS widget (custom queries",
	'elgg_cmis:widget:cmis_mine' => "CMIS : My Files",
	'elgg_cmis:widget:cmis_mine:details' => "My files on Partage",
	'elgg_cmis:widget:cmis_folder' => "CMIS : Folder",
	'elgg_cmis:widget:cmis_folder:details' => "A folder's content on Partage",
	'elgg_cmis:widget:cmis_search' => "CMIS : Title search",
	'elgg_cmis:widget:cmis_search:details' => "Search results on Partage",
	'elgg_cmis:widget:cmis_insearch' => "CMIS : Fulltext search",
	'elgg_cmis:widget:cmis_insearch:details' => "Fulltext search results on Partage",
	
);

add_translation('en', $en);

