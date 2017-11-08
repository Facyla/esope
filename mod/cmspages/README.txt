CMSPages - Static pages
=======================


== What are Static pages ? ==
- custom pages, similar to Wordpress pages
- are editable by any admin user (localadmin also in multisite context)
- have a specific URL (ex. mainpage)
- can then be linked from site menu..
- don't trigger any notification
- changes take effect immediately, but there's no history : care not to empty field before saving (empty fields are allowed)
- access level can be set for each page
- can be used as templates
- have relations between pages
- can be embedded (iframe or lightbox use)


== USAGES ==
- Edit some static, admin-editable page. This is useful for Terms, and such other pages.

- Enable to let admin edit various parts of a site interface. Used in a theme, static pages allow theme developpers to define blocks that can be edited by admin (or other users - see the editors functionnality). Cmspages can be used to embed various content -particularly when used in conjonction with shortcodes-, including third-party widgets, specific JS scripts, etc. with allows to add slideshows, twitter feeds and other nice features.

- Template engine. Cmspages lets you define multi-level templates that can be used to display other cmspages into a suitable template wrapper, or build whole website interfaces. Using templates, one can build eg. an HTML5 wep-app, out from a standard Elgg install...
	
- Full CMS. Pages defined by cmspages can be used to set up a full website, using custom layouts and content templates.


== PAGE HANDLERS ==
- cmspages/   Main interface and display
- p/   CMS articles
- r/   CMS categories
- t/   CMS tags



== INSTRUCTIONS ==

=== How to create a new page ===
- click on page title ("new page") or click "+" if you're already on a existing page
- type page URL name (can't be changed)
- press Enter (non-Javascript : click button)
- edit form, then click the Create page button
Important notice : URL page name only accepts <strong>alphanum chars, and no space nor other signs except : "-", "_" and ".". Other characters will not be taken into account

=== How to edit an existing page ===
- select a page through the dropdown
- edit it, then save

CMS Pages use 2 views, so that their content can be embedded into a theme and make it customizable
  - cmspages/read is used for fullview cmpages rendering, and may render more content (title, etc.). It can use a custom layout, and may be displayed using a custom cmspages template.
  - cmspages/view view should return only cmspage description (other elements should be hidden), and is designed for inclusion into other views. There's an option (rawcontent) to return only the content, stripping the default inner div that allows to distinguish all cmspages views from each other.

Note : the cmspage "read" page also allows the content to be embedded elsewhere, through a "embed" param : add ?embed=true to use internally (lightbox or popup), or ?embed=full to embed in an external site (the styles will be embedded as well). The embedded content is actually the same as when using "view" mode.

=== How to insert a CMS Page into interface ? ===
- add following code where you want to insert the page content : elgg_view('cmspages/view', array('pagetype' => $pagetype));
- replace $pagetype by the the unique string that is at the end of a CMS Page view URL : pg/cmspages/read/[PAGETYPE]



