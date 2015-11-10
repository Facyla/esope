<?php
/**
 * English strings
 */

return array(
	'multilingual' => "Multilingual support",
	'multilingual:prefix:todo' => "[TO BE TRANSLATED INTO %s] ",
	
	// Menus
	'multilingual:menu:currentlang' => "Language : %s",
	'multilingual:menu:versions' => "Versions",
	'multilingual:menu:viewinto' => "Display in %s",
	'multilingual:menu:translateinto' => "Create a new version in %s",
	'multilingual:translate:confirm' => "If you confirm, a new version in %s will be created from the original version. You will then be able to translate it.",
	
	// Settings
	'multilingual:settings:main_lang' => "Site default language code",
	'multilingual:settings:main_lang:details' => "This is the language the original content will be published in, if not otherwise specified. All content without specific language parameter will be considered as written in this language.",
	'multilingual:settings:langs' => "Available language codes",
	'multilingual:settings:langs:details' => "Please use the 2-letters language code, eg. \"en, fr, es, de, it\". If you leave this field empty, content will not be translatable in another language.",
	'multilingual:settings:object_subtypes' => "Eligible content types",
	'multilingual:settings:object_subtypes:details' => "List the content types (<em>subtypes</em>) that can be translated. Note that it doesn't mean much for some content types, especially for the Wire (thewire).<br />The available content types are listed below (theses are the ones that can appear in the search engine).",
	
	// Translation interface
	'multilingual:translate' => "Create a new version in another language",
	'multilingual:translate:instructions:title' => "Instructions",
	'multilingual:translate:instructions' => "To edit the content in the new language, please edit the content displayed below. The original content has been duplicated for you: you can now translate and adapt it to make it available in target language.",
	'multilingual:translate:original' => "Original version",
	'multilingual:translate:version' => "Version in %s",
	'multilingual:translate:otherversions' => "Other versions",
	'multilingual:translate:currentediting' => "(currently editing)",
	'multilingual:translate:nootherversion' => "No version available in an other language.",
	'multilingual:translate:otherlanguages' => "Other languages (not translated)",
	'multilingual:translate:nomissinglanguage' => "A version already exists for all available languages.",
	
	// Notices and errors
	'multilingual:translate:missingentity' => "No entity to translate.",
	'multilingual:translate:newcreated' => "A new version has just been created.",
	'multilingual:translate:alreadyexists' => "A version already exists in this language, and has been loaded below.",
	'multilingual:error:cannotedit' => "You do not have sufficient rights to edit this content.",
	'multilingual:error:cannottranslate' => "Unable to create a new version for this content.",
	'multilingual:error:invalidsubtype' => "This content type cannot be translated.",
	
	
);

