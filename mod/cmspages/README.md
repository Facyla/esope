# Elgg CMS Pages plugin


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



=== INSTRUCTIONS ===

== INSTALLATION ==
- Place in mod directory
- Enable plugin
- Go to admin pages
- Check Cmspages in admin menu entry and enjoy (inline help)

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


== DEV NOTES ==
- Admins can allow non-admin users to use that tool (see plugin settings)
- CMS Pages can be used to generate static pages :
  * interface pages with formatted text & images : eg. about, credits, contacts, etc.
  * unfiltered HTML pages to embed multimedia content such as videos, iframes, Twitter widget, etc.
- CMS Pages can also be used to generate dynamic views, which can be used to build a configurable interface :
  * login page information, footer links, header image and text...
  * configurable zones inserted in layout, eg. introduction in group presentation
- CMS Pages supports templating :
  * views can be called recursively from other CMS Pages using {{pagetype}} calls
  * acts as a template & content furnisher for externalblogs
- CMS Pages supports configurable modules :
  * blocks can be generated using custom parameters :
  * available modules = generate group, user, object lists, search results, view a specific entity, etc.
- CMS Pages is aware of context : display can be filtered depending of context (useful to hide a sidebar or specific modules when used in template mode)
- one can also specify if a given cmspage can be rendered in a page, as a view, or both (blocks templating or out-of-context rendering)
- In walled-garden, public CMS Pages are made publicly available (if not wanted : change access rights)


=== Versions History ===

@TODO :
  - import export cmspage(s)
  - presets and models
  - add ids on each cmspage
  - auto adjust editor size to content length

2.3.0 (2018.10.26) - Update for Elgg 2.3

1.12.1 (2018.10.26) - Production version for Elgg 1.12

0.9.9.3 RC1 (2015.08.11) - This version is a release candidate
  - Featured image
  - Activation and desactivation

0.9.9.2 RC0 (2015.04.01) - This version is a release candidate
  - Integration with elgg_menus (allows to override categories menu with a custom menu)
  - Full control over pages header, menu and footer

0.9.9.1 (2015.03.28)
  - admin interface
  - enable password access for any page or view

0.9.9.0 (2015.03.25)
  - new SEO-friendly page handlers for articles (+ categories and tags later)
  - page selection and edit design
  - control over CMS mode layout and pageshell
  - featured image
  - SEO META fields
  - password protected pages
  - better breadcrumbs
  - more infos on existing pages

0.9.8 (2013.11.19)
  - list used templates for a given cmspage
  - templates can also add the visual editor (disabled by default)
  - Allow to define a custom template per cmspages display (using a custom cmspages template). Templates themselves can't use it. Its purpose is to use cmspages in custom layouts, with sidebar, widgets, etc.

0.9.7 (2013.09.18)
  - Allow embedding cmspage content only (same as view, but through an read URL).
  - Usage for "soft" embed (HTML only, no style): add ?embed=true (or any value for param "embed"). This is convenient for lightbox/popup use.
  - Usage for external embed : add ?embed=full to use in an external site, where the CSS are not available (will embed Elgg's CSS together)

0.9.6 (2013.06.30)
  - Auto-update for new pagetype names (replace _ by -)
  - Translations prepared for next release @TODO
  - Add link to pages edition from cmspages settings

0.9.5 (2013.03.02)
  - per-page css support

0.9.4 (2013.02.21)
  - little template debug : filter context should "return" instead of breaking display


0.9.3 (2012.11.30)
  - removed previous POC and make it an independent plugin (export_embed)
  - added public pages support (public cmspages which allow fullview rendering only)
  - fully rewritten menu (doesn't use tabs anymore + more infos in cmspage select)
  - added some documentation above..

0.9.2 (2012.11.29)
  - added proof-of-concept of producing an embeddable content out of an intranet ; currently with a hard-coded group activity widget => make this configurable, and maybe an independant plugin (make_embed) ?

0.9.1 (2012.11.19)
  - added a "template" content type : allows to embed other pages (recursively - this may cause problems if not carefully handled)
  - choose between content types : HTML, template, module
  - some JS in the form to select used fields
  - allowed contexts filter implemented
  - display filter implemented : page only, view only, both, or use a specific layout (only if page rendering)
  - in read mode : custom breadcrumb & context

0.9 (1.8) (2012.11.13):
	- CMS pages adaptation to a flexible cms tool, together with new, non-multisite externalblog plugin
	  * use as a configurable module : listing, search, custom content (default), custom view
	  * display only in custom contexts
	  * use templates ?

0.8 (1.8) (2011.09.25-27):
	- CMS pages ported to 1.8

== Since now, we'll tell (Elgg version)) ==
=== CHANGE VERSIONNING FOR 1.8 VERSIONS ===

0.7.3 (2011.09.25):
	- typo bug + info for using page as a view

0.7.2 (2011.07.04):
	- debug edit link for admins and editors + added on read view

0.7.1 (2011.06.17):
	- add edit link for admins and editors

0.7 (2011.05.06):
	- admin settings : additional editors without any special status can be authorized to edit cmspages (per-plugin edit rights)

0.6.2 (2011.05.02):
	- small bug in cmspages/view

0.6.1 (2011.04.07):
	- better support of externablog layout switcher

0.6 (2011.03.29):
	- cmspages are now searcheable
	- listing view added (object view)
	- url handler added

0.5 (2011.03.17):
	- addded parameter : use externalblog layout parameter instead of default layout

0.4 (2011.02.14):
	- merged feedback from Fing
	- corrected edition bug when using private access level (edit action)
	- corrected delete action
	- modified menu view that didn't pass the GUID for deletion

0.3 (2011.02.11):
	- added 2 new views : cmspages/read (used by read.php), and cmspages/view, which can be used in themes just as any other view
	- rewritten read.php to use read.php view
	- typo fix in menu.php (line 50)

0.2:
	- integrated german language file from Tom http://community.elgg.org/pg/profile/Tombone
	- added a missing translation key
	- corrected minor css syntax bug in menu.php

0.1:
	- original version by Facyla
-->


