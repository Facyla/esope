<?php

return array(
	'collection' => "Collections",
	'collections' => "Collections",
	'item:object:collection' => "Collections",

	/* Settings */
	'collections:settings:description' => "Collection settings",
	
	'collections:option:yes' => "Yes",
	'collections:option:no' => "No",
	'collections:error:multiple' => "Several collections match the corresponding name, cannot determine which to choose",
	'collections:error:alreadyexists' => "A collection with this name already existrs, please choose another name.",
	
	
'collections:showinstructions' => "Display instructions",
	'collections:instructions' => "The collections can be created here, and then inserted into articles and other publications through a shortcode <q>[collection id=\"12345\"]</q>",
	'collections:add' => "Create a new collection",
	'collections:edit' => "Collection edit",
	'collections:edit:title' => "Title",
	'collections:edit:title:details' => "The title of your collection.",
	'collections:edit:name' => "Custom URL (slurl)",
	'collections:edit:name:details' => "Unique identifier for this collection, used on the URL. Also allow to call the collection the same way on different sites, eg. for use within a theme. Example: my-article",
	'collections:edit:description' => "Description",
	'collections:edit:description:details' => "The description lets you describe your collection and additionnal information about it.",
	'collections:edit:content' => "Elements",
	'collections:edit:content:details' => "Add new elements, and reorder them to your convenience by drag'n'dropping them.",
	'collections:edit:entity' => "Element",
	'collections:edit:addentity' => "+ Add an element",
	'collections:addentity:notallowed' => "You are not allowed to add an element to this collection.",
	'collections:edit:deleteentity' => "Remove this element",
	'collections:edit:deleteentity:confirm' => "This element will be removed from the collection, do you wish to continue?",
	'collections:edit:access' => "Visibility",
	'collections:edit:access:details' => "Determines who is allowedto view this collection.",
	'collections:edit:submit' => "Save changes",
	'collections:saved' => "Your changes have been saved",
	'collections:edit:preview' => "Preview",
	'collections:edit:preview' => "Preview collection",	
	
	'collections:shortcode:collection' => "Collection (already defined)",
	'collections:embed:instructions' => "How to embed this collection?",
	'collections:shortcode:instructions' => " - with a shortcode, into a publication (blog, page, etc.): <strong>[collection id=\"%s\"]</strong>",
	'collections:cmspages:instructions' => " - with a template code, into a template CMSPage: <strong>{{:collection/view|guid=%s}}</strong>",
	'collections:cmspages:instructions:shortcode' => " - with a template short, alternatively, into a template CMSPage: <strong>{{[collection id=\"%s\"]}}</strong>",
	'collections:cmspages:notice' => "IMPORTANT: only CMS pages of type \"Template\" can display collections! You may need to update page type to display it.",
	'collections:iframe:instructions' => " - with an embed code, on any other sites: <strong>&lt;iframe src=\"" . elgg_get_site_url() . "collection/view/%s?embed=full\"&gt;&lt;/iframe&gt;</strong>",
	
	// NEW STRINGS
	'collections:view' => "See elements",
	'collections:edit:entities' => "Publication",
	'collections:edit:entities_comment' => "Comment",
	'collections:select_entity' => "Choose a publication",
	'collections:change_entity' => "Change publication",
	'collection:add' => "Create a collection",
	
	'collections:access:draft' => "Not published",
	'collections:access:published' => "Published",
	'collections:edit:write_access' => "Allow contributions",
	'collections:edit:write_access:details' => "If Yes, you allow toher contributors to add publications to this collection.",
	'collections:write:closed' => "No",
	'collections:write:open' => "Yes",
	'collections:addentity' => "Add an element",
	'collections:addentity:details' => "You can use the following form to choose and add new elements to this collection.",
	'collections:addentity:submit' => "Add this publication",
	'collections:addentity:alreadyexists' => "This publication is already part of this collection. You can use the comments to discuss with the collection owner.",
	'collections:addentity:success' => "The contribution has been successfully added to this collection.",
	
	//'collections:' => "",
	'collections:publishin' => "Publish in",
	'collections:removefromcollection' => "Remove from",
	'collections:addtocollection' => "Add to a new collection",
	'collections:strapline' => 'Latest update on %s by %s',
	'collections:missingrequired' => "Required field missing",
	'collections:embed:search' => "Search",
	'collections:embed:subtype' => "Publication type",
	'collections:embed:nofilter' => "All (no filter)",
	
	'collections:collectionsthis' => "Add to a collection",
	'collections:share' => "Share",
	'collections:socialshare:details' => "Use the folloowing sharing links to publish this colelction on social sites.",
	'collections:permalink' => "Permalink",
	'collections:permalink:details' => "Use the following permalink to share the collection.",
	'collections:shortlink' => "Short link",
	'collections:shortlink:details' => "Use the short link for your sharings.",
	'collections:embed' => "Embed",
	'collections:embed:details' => "Copy-paste the following HTML code to integrate this publication on another site. You can edit the block dimensions by changing the values after \"width\" and \"height\".",
	'collections:entities:count' => "%s elements",
	'collections:settings:subtypes' => "Subtypes",
	'collections:settings:subtypes:details' => "Available subtypes that can be added to collections",
	
	'collection:icon' => "Image",
	'collection:icon:details' => "Choose an image to illustrate your collection.",
	'collection:icon:new' => "Add an image",
	'collection:icon:remove' => "Remove image",
	
);


