<?php

return array(
	'collections' => "Collections",

	/* Settings */
	'collections:settings:description' => "Main collection settings",
	'collections:settings:defaultcollection' => "Collection default content",
	
	'collections:settings:content' => "Default collection content",
	'collections:settings:content:help' => "The collection content is defined by a ordened list, each item defining a publication. A publication can be any existing site publication.<br />Leave empty to get default values back.",
	'collections:option:yes' => "Yes",
	'collections:option:no' => "No",
	
	
'collections:showinstructions' => "Display instructions",
	'collections:instructions' => "The collections can be created here, and then inserted into articles and other publications through a shortcode <q>[collection id=\"12345\"]</q>",
	'collections:add' => "Create a new collection",
	'collections:edit' => "Collection edit",
	'collections:edit:title' => "Title",
	'collections:edit:title:details' => "The title is a readable identification for the collection. It is not otherwise used when displaying it.",
	'collections:edit:name' => "Identifier",
	'collections:edit:name:details' => "Unique identifier for this collection, allows to call it the same way on different sites, eg. for use within a theme.",
	'collections:edit:description' => "Description",
	'collections:edit:description:details' => "The description lets you define some additionnal information about this collection. It is not displayed either.",
	'collections:edit:content' => "Entities",
	'collections:edit:content:details' => "Add new entities, and reorder them to your convenience. <br />Note: you will not be able to use the visual editor on new entities. Please save your collection to enable it.",
	'collections:edit:entity' => "Entity",
	'collections:edit:addentity' => "Add an entity",
	'collections:edit:deleteentity' => "Remove this entity",
	'collections:edit:deleteentity:confirm' => "This entity will be removed from the collection, do you wish to continue?",
	'collections:edit:access' => "Visibility",
	'collections:edit:access:details' => "Determines who will be allowed to view this collection.",
	'collections:edit:submit' => "Save",
	'collections:saved' => "Your changes have been saved",
	'collections:edit:preview' => "Preview",
	'collections:edit:view' => "View collection",
	'collections:error:multiple' => "Multiple collections found for this name, cannot determine which to display.",
	'collections:error:alreadyexists' => "A collection already exists with this name, please choose antoher one.",
	
	
	'collections:shortcode:collection' => "Collection (already defined)",
	'collections:embed:instructions' => "How to embed this collection ?",
	'collections:shortcode:instructions' => " - with a shortcode, into a publication (blog, page, etc.): <strong>[collection id=\"%s\"]</strong>",
	'collections:cmspages:instructions' => " - with a template code, into a template CMSPage: <strong>{{:collection/view|guid=%s}}</strong>",
	'collections:cmspages:instructions:shortcode' => " - with a template short, alternatively, into a template CMSPage: <strong>{{[collection id=\"%s\"]}}</strong>",
	'collections:cmspages:notice' => "IMPORTANT: only CMS pages of type \"Template\" can display collections! You may need to update page type to display it.",
	'collections:iframe:instructions' => " - with an embed code, on any other sites: <strong>&lt;iframe src=\"" . elgg_get_site_url() . "collection/view/%s?embed=full\"&gt;&lt;/iframe&gt;</strong>",
	
);


