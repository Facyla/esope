<?php
$english = array(

	'cmspages' => "Static pages (CMS)",
	'item:object:cmspage' => 'Static page',
	'item:object:cmspages' => 'Static pages',
	
	'cmspages:pagetype' => "Page URL name",
	'cmspages:cmspage_url' => "Published page URL :",
	'cmspages:pageselect' => "Choose which page to edit",
	
	'cmspages:new' => "OK",
	'cmspages:newpage' => "Create page \"%s\"",
	'cmspages:createmenu' => "Create a new page",
	'cmspages:addnewpage' => "+ New page",
	'cmspages:newtitle' => "Click to choose page title",
	'cmspages:settitle' => "Click to edit title",
	'cmspages:create' => "Create page !",
	'cmspages:save' => "Update page",
	'cmspages:preview' => "Preview",
	'cmspages:delete' => "Delete page",
	'cmspages:deletewarning' => "Warning : you can\'t restore a deleted page. You may prefer to cancel and make this page private instead if you don\t want to lose content.", // Adds backslashes if you use "'" !	(ex.: can\'t)
	'cmspages:showinstructions' => "Display detailed instructions",
	'cmspages:instructions' => "How to use static pages :<ul>
			<li>have a specific URL (ex. mainpage)</li>
			<li>are editable by any admin user (localadmin also in multisite context)</li>
			<li>can then be linked from site menu..</li>
			<li>don't trigger any notification</li>
			<li>changes take effect immediately, but there's no history : care not to empty field before saving (empty fields are allowed)</li>
			<li>access level can be set for each page</li>
			<li>How to create a new page :
				<ol>
					<li>click \"+\"</li>
					<li>type page URL name (can't be changed)</li>
					<li>press Enter (non-Javascript : click button)</li>
					<li>edit form, then click the Create page button</li>
				</ol>
				<strong>Warning :</strong> URL page name only accepts <strong>alphanum chars, and no space nor other signs except : \"-\", \"_\" et \".\"</strong>
			</li>
		</ul>",
	
	/* Status messages */
	'cmspages:posted' => "Page was successfully updated.",
	'cmspages:deleted' => "The static page was successfully deleted.",
	
	/* Error messages */
	'cmspages:nopreview' => "No preview yet",
	'cmspages:notset' => "This page doesn't exist, or you need to log in to view it.",
	'cmspages:delete:fail' => "There was a problem deleting the page",
	'cmspages:error' => "There has been an error, please try again and if the problem persists, contact the administrator",
	'cmspages:unsettooshort' => "Page URL name undefined or too short (minimum 2 )",
	
	'cmspages:pagescreated' => "%s pages created",
	
	/* Settings */
	'cmspages:settings:layout' => "Layout",
	'cmspages:settings:layout:help' => "Use default layout, or externalblog layout parameters ? I you have no idea or do not use externalblog plugin, let default choice.",
	'cmspages:settings:layout:default' => "Default",
	'cmspages:settings:layout:externalblog' => "Use externablog layout config",
	'cmspages:settings:editors' => "Additional editors",
	'cmspages:settings:editors:help' => "List of GUID, separated by commas. These editors are allowed to edit even if they're not admin, in addition to the admins (who have edit access on cmspages anyway).",
	
	'cmspages:chosenentity' => "Chosen entity (GUID)",
	'cmspages:configuredview' => "Configured view",
	'cmspages:module' => "Module %s",
	'cmspages:searchresults' => "Search results",
	'cmspages:error:updatedpagetypes' => "Warning: following a major version change, the internal pages names (pagetype) have been updated ('_' remplaced by '-'). Now it's done, please select again the page to edit.",
	
	'cmspages:or' => "or",
	
	// @TODO : missing translations in other languages
	'cmspages:fieldset:main' => "Main parameters",
	'cmspages:fieldset:advanced' => "Advanced parameters",
	'cmspages:content_type' => "Content type",
	'cmspages:content_type:editor' => "HTML (with editor)",
	'cmspages:content_type:rawhtml' => "HTML (no editor)",
	'cmspages:content_type:module' => "Configurable Module",
	'cmspages:content_type:template' => "Template",
	'cmspages:content_type:template:details' => "Templates usage:<ul>
		<li>{{cmspages-pagetype}} : inserts the 'cmspages-pagetype' page content</li>
		<li>{{%CONTENT%}} : inserts the content loaded by an external tool (e.g. external blogs)</li>
		</ul>",
	'cmspages:content:rawhtml' => "Page or block content (HTML)",
	'cmspages:content:template' => "Template structure or content",
	'cmspages:content:' => "Page or block content",
	'cmspages:templates:list' => "Used templates",
	'cmspages:css' => "Custom CSS",
	'cmspages:css:details' => "This style sheet will be added when dislaying this page.",
	'cmspages:js' => "Custom JS",
	'cmspages:js:details' => "These JS scripts will be added when dislaying this page.",
	'cmspages:module' => "Module", 
	'cmspages:module:infos' => "Notes : for a title, set the text. For a listing, set type, subtype, and optionnally owner_guids, container_guids, limit and sort, full_view=yes for full content include. For a search: type and criteria. For an entity, the guid.",
	'cmspages:module:config' => "Module configuration (param=value&amp;param2=value2...)",
	'cmspages:contexts' => "Context filters (list of allowed contexts, or empty for no filter)",
	'cmspages:contexts:details' => "If defined, the block will displayed only in allowed use contexts (default: no filter)",
	'cmspages:display' => "Autonomous (full page) display", 
	'cmspages:display:details' => "empty = yes (default), 'no' for disabled (can be only displayed as interface element / block), 'noview' exclusif (page only, not as block), or a layout name to use a specific layout",
	'cmspages:template:use' => "Use a template",
	'cmspages:template:details' => "Empty = no (default), or cmspages template name to use a specific template",
	//'cmspages:settings:unused' => "Note : These settings are not used yet (future developments)",
	'cmspages:fieldset:unused' => "Note : the following parameters are not used yet (further developments)",
	'cmspages:container_guid' => "Container GUID", 
	'cmspages:parent_guid' => "Parent GUID", 
	'cmspages:sibling_guid' => "Sibling GUID", 
	'cmspages:container' => "Container", 
	'cmspages:parent' => "Parent", 
	'cmspages:sibling' => "Sibling", 
	'cmspages:module:' => "None (empty block)", 
	'cmspages:module:title' => "Title", 
	'cmspages:module:listing' => "Entities list", 
	'cmspages:module:search' => "Search results", 
	'cmspages:module:entity' => "Entity", 
	'cmspages:module:view' => "Configurable view", 
	/* @TODO : missing translations
	'cmspages:' => "Lien connexe", 
	'cmspages:' => "<kbd>[&nbsp;Modifier%s&nbsp;]</kbd>", 
	'cmspages:' => "Pour éditer les pages CMS, rendez-vous sur", 
	'cmspages:' => "Vue non configurée.",
	*/
	
);

add_translation("en",$english);

