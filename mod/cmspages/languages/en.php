<?php
return array(

	'cmspages' => "Static pages (CMS)",
	'item:object:cmspage' => '<i class="fa fa-file-code-o fa-fw"></i> CMS page',
	'item:object:cmspages' => '<i class="fa fa-file-code-o fa-fw"></i> CMS pages',
	
	'cmspages:pagetype' => "Page URL name",
	'cmspages:cmspage_url' => "<i class=\"fa fa-link\"></i>Permalink",
	'cmspages:cmspage_view' => "<i class=\"fa fa-plug\"></i>Elgg view",
	'cmspages:cmspage_embed' => "<i class=\"fa fa-code\"></i>HTML embed code",
	'cmspages:cmspage_template' => "<i class=\"fa fa-puzzle-piece\"></i>Use in a tempalte",
	'cmspages:pageselect' => "Edit a page",
	'cmspages:page:new' => "Create a new page",
	'cmspages:page:new:name' => "New page title",
	
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
	'cmspages:edit_mode' => "Edit mode",
	'cmspages:edit_mode:basic' => "Simple",
	'cmspages:edit_mode:full' => "Advanced",
	
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
	'cmspages:settings:editors:help' => "List of GUID, separated by commas.<br />These editors are allowed to read and edit any CMS Page<br />All admins are editors, and you can add more members with full access on cmspages (besides this plugin settings page).<br /><i class=\"fa fa-info-circle\"></i> Développeurs : pour définir les éditeurs selon des critères précis, veuilllez utiliser le hook 'cmspages:edit', 'cmspage'.",
'cmspages:settings:authors' => "Liste des auteurs supplémentaires",
	'cmspages:settings:authors:help' => "Liste des GUID des membres, séparés par des virgules.<br />Les auteurs ont un accès limité à leurs propres articles.<br /><i class=\"fa fa-info-circle\"></i> Développeurs : pour définir les éditeurs selon des critères précis, veuilllez utiliser le hook 'cmspages:edit:authors', 'cmspage'.",
	
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
	'cmspages:content_type:details' => "Les pages CMS peuvent être de divers types : les 2 premiers sont à utiliser pour afficher simplement du contenu. Les \"modules\" permettent de définir des blocs de contenu dynamique. Les \"gabarits\" servent à définir des modèles d'affichage qui peuvent être utilisés pour l'affichage de contenus, et des mises en pages complexes, faisant appels à divers autres pages CMS et éléments de contenu.",
	'cmspages:content_type:editor' => "HTML (with editor)",
	'cmspages:content_type:rawhtml' => "HTML (no editor)",
	'cmspages:content_type:module' => "Configurable Module",
	'cmspages:content_type:template' => "Template",
	'cmspages:content_type:template:details' => "Templates usage:<ul>
		<li>{{cmspages-pagetype}} : inserts the 'cmspages-pagetype' page content</li>
		<li>{{%CONTENT%}} : inserts the content loaded to the cmspage view by an external tool, using param 'content'</li>
		<li>{{[shortcode]}} : inserts the 'shortcode' shortcode (if elgg_shortcode plugin enabled)</li>
		<li>{{:forms/register|username=admin|other_param=XXX}} : inserts the forms/register view with parameter 'username' => 'admin'</li>
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
	'cmspages:layout:use' => "Layout",
	'cmspages:layout:details' => "Full page display only. Enables to choose the internal page layout (number of columns)",
	'cmspages:pageshell:use' => "HTML Pageshell",
	'cmspages:pageshell:details' => "Full page display only. Enables to choose the HTML pageshells (top-level structure of the site).",
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
	'cmspages:' => "Sibling link", 
	'cmspages:' => "<kbd>[&nbsp;Edit%s&nbsp;]</kbd>", 
	'cmspages:' => "To edit static pages, please go to", 
	'cmspages:' => "Not set view.",
	*/
	
	'cmspages:categories' => "Category(ies)",
	'cmspages:slurl' => "Permalink",
	'cmspages:shorturl' => "Short URL",
	'cmspages:featured_image' => "Featured image",
	'cmspages:featured_image:view' => "Display Featured image",
	'cmspages:featured_image:remove' => "Remove featured image",
	'cmspages:downloadfailed:invalidentity' => "Invalid CMS Page",
	'cmspages:downloadfailed:invalidmetadata' => "Invalid metadata name",
	'cmspages:notexist:create' => "This page does not exist. You may have mistyped the URL (care to '_', which are replaced by '-'), or you can click on this link to create a new page.",
	'cmspages:edit' => "[&nbsp;Edit %s&nbsp;]",
	'cmspages:create' => "[&nbsp;Create %s&nbsp;]",
	'cmspages:templates:parameters' => "Content parameters",
	'cmspages:templates:shortcodes' => "Shortcodes",
	'cmspages:templates:views' => "Views",
	'cmspages:editors:list' => "Editors list",
	'cmspages:authors:list' => "Authors list",
	'cmspages:editurl' => "To edit CMS Pages, please go to",
	
	'cmspages:cms_mode' => "CMS mode",
	'cmspages:settings:cms_mode' => "Enable CMS mode",
	'cmspages:settings:cms_mode:details' => "Ce mode permet d'utiliser CMSPages pour gérer les pages d'un site. Il propose des adresses de pages optimisées pour le SEO, et des options plus avancées de gestion du rendu.",
	'cmspages:settings:layout:details' => "Par défaut, les pages CMS s'affichent avec le layout \"one_column\" (1 seule colonne), mais vous pouvez choisir de les afficher en utilisant un autre layout (modèle d'agencement du contenu dans la page), par ex. un layout à 2 ou 3 colonnes, ou définir un gabarit personnalisé pour une personnalisation maximale.",
	'cmspages:settings:pageshell' => "HTML Pageshell",
	'cmspages:settings:pageshell:details' => "Pour un contrôle total sur la structure HTML du site, vous pouvez utiliser d'autres \"pageshells\" (coquille HTML). Par défaut la page sera affichée dans l'interface habituelle du site (avec entête, menu, pied de page), mais vous pouvez également utiliser le pageshell \"iframe\" (qui conserve les styles mais pas l'interface), ou définir un pageshell personnalisé pour un contrôle total sur le rendu.",
	'cmspages:layout:custom:edit' => "Edit custom layout",
	'cmspages:layout:sidebar:edit' => "Edit right sidebar",
	'cmspages:layout:sidebar_alt:edit' => "Edit left sidebar",
	'cmspages:pageshell:edit' => "Edit custom pageshel",
	'cmspages:layout:one_column' => "1 column",
	'cmspages:layout:one_sidebar' => "2 columns (right sidebar)",
	'cmspages:layout:two_sidebar' => "3 columns (2 sidebars)",
	'cmspages:layout:custom' => "Custom (cms-layout)",
	'cmspages:layout:' => "Default (same as main site)",
	'cmspages:pageshell:default' => "Site (default)",
	'cmspages:pageshell:cmspages' => "Full width site (without margin)", 
	'cmspages:pageshell:cmspages_cms' => "Full width site + CMS menu", 
	'cmspages:pageshell:iframe' => "Iframe (without interface)",
	'cmspages:pageshell:inner' => "Raw content (for AJAX)",
	'cmspages:pageshell:custom' => "Custom (cms-pageshell)",
	'cmspages:pageshell:' => "Default (same as main site)",
	'cmspages:fieldset:seo' => "SEO Options",
	'cmspages:seo:title' => "Title",
	'cmspages:seo:title:details' => "Maximum 60 caracters. If empty, will fallback to page title.",
	'cmspages:seo:description' => "META Description",
	'cmspages:seo:description:details' => "Most search engine will take 160 caracters into account.",
	'cmspages:seo:tags' => "META Tags",
	'cmspages:seo:tags:details' => "Veuillez saisir une liste des mots-clefs les plus importants pour décrire cette page dans le champ \"Mots-clefs\". Pour un meilleur référencement, il est utile que ces termes figurent dans le texte de la page.",
	'cmspages:seo:index' => "Robots: index",
	'cmspages:seo:index:details' => "Tells robots to index this page or not",
	'cmspages:seo:follow' => "Robots: follow",
	'cmspages:seo:follow:details' => "Tells robots how to handle page links",
	'cmspages:seo:canonical' => "Canonical link",
	'cmspages:seo:canonical:details' => "If this page has several URLs, tells the \"main\" URL for the page. By default, canonical URL is the permalink.",
	
	'cmspages:edit:title' => "Edit page \"%s\"",
	'cmspages:alreadyexists' => "This address already exists, please choose another one",
	
	'cmspages:fieldset:rendering' => "Rendering modes",
	'cmspages:fieldset:publication' => "Publication",
	'cmspages:fieldset:information' => "Useful information &nbsp; <i class=\"fa fa-toggle-down\"></i>",
	'cmspages:fieldset:categories' => "Categories",
	'cmspages:access:current' => "Visibility",
	
	'cmspages:error:nodisplay' => "You do not have the right to access this page.",
	'cmspages:notice:changedurl' => "The address of this page has changed, please update your bookmarks.",
	
	'cmspages:type:' => "HTML",
	'cmspages:type:editor' => "HTML",
	'cmspages:type:rawhtml' => "HTML",
	'cmspages:type:module' => "Module",
	'cmspages:type:template' => "Template",
	'cmspages:notice:newpage' => "Create a new page.",
	'cmspages:pageselect:filter' => "Search a page",
	'cmspages:search:title' => "Page title",
	'cmspages:search:filter' => "Filters",
	'cmspages:filter:all' => "All",
	'cmspages:access_id:none' => "",
	'cmspages:status:none' => "",
	'cmspages:content_type:none' => "",
	'cmspages:sort:none' => "",
	'cmspages:filter:access_id' => "Visibility",
	'cmspages:filter:status' => "Online",
	'cmspages:filter:content_type' => "Page type",
	'cmspages:filter:sort' => "Sort by",
	'cmspages:sort:latest' => "Date",
	'cmspages:sort:alpha' => "Alphabetical",
	'cmspages:search:nameortitle' => "Page title",
	
	/* Modes d'emploi */
	'cmspages:content_type:template:details' => "<i class=\"fa fa-info-circle\"></i>The templates have 2 main usages&nbsp;:
		<ol>
			<li>define templates which will be used as models for other content: the content can then be \"injected\" into the template, at the specified place {{%CONTENT%}}&nbsp;;</li>
			<li>define a complex content, which uses several other elements or dynamic content: the page content will be generated by recursively calling various content block types (variables, shortcodes, Elgg views), or other CMS Pages (content, source code, module, and of course other templates). When using templates, these can also call other templates, etc.</li>
		</ol>
		Pour cela, les gabarits doivent être édités directement en HTML, dans lequel vous pouvez également intégrer les codes suivants :
		<ul>
			<li>CMS PAGE: {{cmspages-pagetype}} : insère le contenu de la page CMS 'cmspages-pagetype' (contenut, code source, module ou gabarit)</li>
			<li>VARIABLE: {{%CONTENT%}} : insère le contenu chargé dans la vue par un outil tiers via le paramètre 'content'</li>
			<li>SHORTCODE: {{[shortcode]}} : insère le shortcode 'shortcode' (si le plugin elgg_shortcode est activé)</li>
			<li>ELGG VIEW: {{:forms/register|username=admin}} : insère la vue forms/register en lui passant le paramètres 'username' => 'admin'</li>
		</ul>",
	'cmspages:content_type:module:details' => "<i class=\"fa fa-info-circle\"></i>Les modules permettent de sélectionner et d'afficher divers types de contenus, selon des critères précis. Pour cela, chaque module doit être configuré avec des paramètres précis :
		<ol>
			<li>Choisir le module : par exemple une Liste d'entités</li>
			<li>Renseigner les paramètres : par ex. type d'entité 'object', type de contenu 'bookmarks', affichage limité à '5', et 'pagination' activée'</li>
			<li>Choisir éventuellement d'autres réglages généraux : contextes autorisés, niveaux d'accès, etc.</li>
			<li>Une fois le module enregistré, il peut être utilisé sous forme de vue, ou appelé par une page de type 'template'.</li>
		</ol>",
	'cmspages:content_type:rawhtml:details' => "<i class=\"fa fa-info-circle\"></i>Ce type de contenu est recommandé si vous souhaitez utiliser du code HTML \"brut\", sans filtrage ni modification. Il est notamment adapté pour intégrer des codes d'intégration de contenus riches comme un widget Twitter ou une vidéo, ou tout type de contenu dont le code source supporte mal les filtrages et corrections apportés par les éditeurs visuels.<br />
		Il est quasiment identique à \"Contenu (HTML avec éditeur visuel)\", mais permet d'éditer la page sans le filtrage et les modifications du code apportées par l'éditeur visuel, notamment les JavaScript ainsi que divers éléments HTML.",
	'cmspages:content_type:editor:details' => "<i class=\"fa fa-info-circle\"></i>Ce type de contenu est recommandé si vous souhaitez rédiger une page de contenu de manière visuelle, par ex. un texte illustré, travailler la mise en forme de la page, etc.<br />
		Si vous avez besoin d'un contrôle direct sur le code source de la page, veuillez utiliser \"Code source (HTML sans éditeur)\".",
	
	'cmspages:status' => "Status",
	'cmspages:status:published' => "Online",
	'cmspages:status:notpublished' => "Offline",
	
	'cmspages:password' => "Password protection",
	'cmspages:password:details' => "If a password is set, it will be asked prior accessing to this page content. <br />Warning: adding a password does not change the page visibility.",
	'cmspage:password:cleared' => "Logout from pages succeeded.",
	'cmspage:password:cleared:page' => "Logout from page succeeded",
	'cmspages:password:submit' => "Access",
	'cmspages:password:form' => "Password-protected access",
	
	/* Settings */
	'cmspages:settings:yes' => "Yes",
	'cmspages:settings:no' => "No",
	'cmspages:settings:none' => "(none)",
	'cmspages:settings:register_object' => "Enable CMSPages search",
	'cmspages:settings:cms_menu' => "Menu to be displayed",
	'cmspages:settings:cms_menu:cmspages_categories' => "cmspages_categories (CMSPages categories)",
	'cmspages:settings:cms_menu:default' => "[ Default ]",
	'cmspages:settings:cms_menu:no' => "[ No menu ]",
	'cmspages:settings:cms_menu:details' => "Pageshells ou layouts avec le \"menu CMS\" uniquement.<br />Par défaut, le menu des catégories des pages CMS sera affiché. Si vous le souhaitez, vous pouvez remplacer ce menu par un menu personnalisé, défini avec le plugin \"elgg_menus\". Pour rétablir le menu des catégories, choisissez \"cmspages_categories\".",
	'cmspages:settings:categories' => "Categories",
	'cmspages:settings:categories:details' => "Pour définir des rubriques, indiquez un titre de rubrique par ligne.<br />Pour définir une arborescence, vous pouvez indenter la liste en utilisant des tirets (plusieurs sous-niveaux possibles).",
	// Header
	'cmspages:settings:cms_header' => "Header",
	'cmspages:settings:cms_header:details' => "Pageshells ou layouts avec le \"menu CMS\" uniquement.<br />Par défaut aucun entête ne sera affiché. Si vous le souhaitez, vous pouvez utiliser une page CMS pour ajouter un entête personnalisé avant le menu.",
	'cmspages:cms_header:edit' => "Edit custom header",
	'cmspages:cms_header:no' => "[ No header ]",
	'cmspages:cms_header:custom' => "[ Custom ] (cms-header)",
	'cmspages:cms_header:initial' => "[ Same as the main site ]",
	'cmspages:cms_header:default' => "[ Default ]",
	// Footer
	'cmspages:settings:cms_footer' => "Footer",
	'cmspages:settings:cms_footer:details' => "Pageshells ou layouts avec le \"menu CMS\" uniquement.<br />Par défaut le pied de page du site sera affiché. Si vous le souhaitez, vous pouvez le remplacer par une page CMS personalisée.",
	'cmspages:cms_footer:edit' => "Edit custom footer",
	'cmspages:cms_footer:no' => "[ No footer ]",
	'cmspages:cms_footer:default' => "[ Default ]",
	'cmspages:cms_footer:initial' => "[ Same as the main site ]",
	'cmspages:cms_footer:custom' => "[ Custom ] (cms-footer)",
	
	'admin:cms' => "CMS",
	'admin:cms:cmspages' => "CMS Pages",
	'cmspages:configredirect' => "To manage CMS pages, you can use directly the page " . elgg_get_site_url() . "cmspages",
	
	'cmspages:fieldset:access' => "Roles management",
	'cmspages:fieldset:categories' => "Categories",
	'cmspages:fieldset:categories:details' => "Categories",
	'cmspages:fieldset:rendering' => "These categories enable to publish CMS pages into a more structured manner than tags. If the HTML pageshell enables it, they can be used as a menu.",
	'cmspages:fieldset:rendering:details' => "These advanced options let you have finer control over the rendering of your page. These options apply only in specific contexts, and do not apply in all cases.",
	
	'cmspages:error:duplicate' => "Warning, several entries have the same name: please update them so there are only unique names.",
	
	'cmspages:editlink' => "Click to edit page",
	'cmspages:nestedlevel' => "Page de niveau %s (le contenu est généralement au niveau 0).",
	
	'cmspages:fieldset:editor' => "Page content",
	'cmspages:history' => "Previous versions history",
	'cmspages:history:version' => "<i class=\"fa fa-history\"></i>Version saved by %s %s",
	
	'cmspages:none' => "No CMS Page found.",
	'cmspages:created' => "created %s",
	'cmspages:updated' => "updated %s",
	'cmspages:readmore' => "Read more",
	
	
);

