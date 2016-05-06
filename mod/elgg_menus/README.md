# Menu editor

This plugin provides an admin interface to edit system menus or create new menus.

It offers several modes :
- "Merge" : add items to an existing menu, and optionally removes items
- "Replace" : replaces and existing menu with a brand new one
- "Clear" : clears a menu (no menu will appear at all)
- "Disabled" : do not change existing menu (can be used to test menus before going live)


## HOW-TOs

### Insert a menu in one's theme
Use following code :
	echo elgg_view('elgg_menus/menu', array('menu_name' => "MENU_NAME"));

Note : custom menu options can be used *only when using this view*.
Eg. you cannot change class, sort order, action handler, nor show sections with standard elgg_view_menu() function.


### Set up submenus
Set parent_name with the parent item name.

### Set up hidden submenus
Submenus are displayed by default. To hide a specific submenu, and display it on :hover, adapt following CSS selectors (replace MENU_NAME by your menu name) :
	.elgg-menu-MENU_NAME .elgg-child-menu { display: none; }
	.elgg-menu-MENU_NAME li:hover .elgg-child-menu { display: block; }

### Multilingual / translated menus
The plugin will detect alternative versions of menus and use them if they exist.
If the translated menu do not exist, it will default to main language 
When using menu names in theme plugins, always use the canonical menu name (without language extension).

To provide language-aware versions of menus :
1. Edit a menu
2. Add "-LANGAGE_CODE" to its name, eg. "footer-fr"
3. Save the menu (it will be duplicated)
4. Edit the new translated menu strings and links


### Translate section headers
Add translation strings into your theme translation file, using this key model : 
	'menu:MENU_NAME:header:SECTION_NAME' => "Translated section name",


