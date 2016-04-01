Elgg Extended Tinymce plugin for Elgg 1.9 - 1.12 and Elgg 2.X
=============================================================

Latest Version: 4.3.3  
Released: 2016-01-16  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly 2012-2016, (C) Curverider 2008-2016  

The TinyMCE editor is licensed under  
GNU Lesser General Public License version 2.1  
(c) 2003-2016 Moxiecode Systems AB.  
Website: http://www.tinymce.com/  


Description
-----------

An extended tinymce plugin based on the jquery version 4.3.3 of the TinyMCE editor. This release of the Extended Tinymce plugin is for Elgg 1.9 - 1.12 and for Elgg 2.X.

For backward compatibility with version 3 of the editor the folder mod/extended_tinymce/vendor/tinymce/jscripts/tiny_mce/plugins/emotions/img contains the emoticons images at the location where they were available before.


Install instructions
--------------------

1. If you have a previous version of the Extended Tinymce plugin installed, disable it and then remove the extended_tinymce folder from your mod directory before copying the new version on the server,
2. Copy/extract the extended_tinymce archive into the mod folder,
3. Disable the Elgg core ckeditor plugin (or any other similar plugin used),
4. Enable the Extended Tinymce plugin.


Creating your own custom skin
-----------------------------

IMPORTANT: Tinymce uses a z-index of 100 for its fullscreen mode. This conflicts with the z-index values used by Elgg (e.g. Topbar). To get it fully working you need to adjust the z-index of ".mce-fullscreen" to 9001 within the files skin.min.css and skin.ie7.min.css of your customized skin.

1. Configure your custom skin at http://skin.tinymce.com/ and download it,
2. Copy your skin folder into the mod/extended_tinymce/vendor/tinymce/js/tinymce/skins directory,
3. Change the skin name of the skin option in mod/extended_tinymce/views/default/js/elgg/extended_tinymce_init.js and mod/extended_tinymce/views/default/extended_tinymce/init.php to the name of your skin.


Adding a language for the tinymce editor
----------------------------------------

This is not to be mixed up with adding an Elgg language file for the plugin. It's about adding the translations for the text output of the Tinymce editor itself.

IMPORTANT: starting with version 4.1.10 of the Extended Tinymce plugin the user's language is used automatically. Unfortunately, it's not possible to check the existence of the corresponding editor's language file sufficiently. The translation files for Tinymce corresponding to the languages available in Elgg core are included in the release of this plugin. But if you support additional translations on your site you need to add the corresponding language file of Tinymce or the editor will not work. If you would like one of the available translations to be added, please tell me and I will do so for the next release of Extended Tinymce.

1. Download the language pack from http://www.tinymce.com/i18n/index.php,
2. Extract the language files from the zip file,
3. Copy the language files into the mod/extended_tinymce/vendor/tinymce/js/tinymce/langs/ directory,
4. Flush the Elgg caches via the admin dashboard on your site.
