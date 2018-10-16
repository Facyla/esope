<?php
/* ESOPE : needed to empty original file js/elgg/ckeditor/init.js to use PHP in this JS view
 */
// ESOPE @TODO see if we should import other changes from tinymce plugin enhancements

?>
//<script>

define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');
	
	return {
		// Use / for row break, - for separator
		toolbar: [
				// templates
				['Templates'], 
				['RemoveFormat'], 
				['Paste', 'PasteFromWord'], 
				['Undo', 'Redo'], 
				['Blockquote'], 
				['Link', 'Unlink'], 
				// source, iframe, flash, table
				['Image'], //['Smiley'], ['SpecialChar'], 
				['Iframe'], 
				['Table'], 
				['Source'], 
				['Scayt'], 
				['Maximize'], 
				'/', 
				// styles
				['Format'], 
				['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'TextColor', 'BGColor'], 
				['NumberedList', 'BulletedList', 'Outdent', 'Indent'], 
				['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
			],
		
		// Add new custom toolbars
		toolbar_basic: [
				['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'], 
				['NumberedList', 'BulletedList'], 
				['Smiley'], ['Blockquote'], 
				['Link', 'Unlink'], 
				['Scayt'], 
				['Maximize'], 
			],
		
		// Auto-enable SCAYT (spell checker)
		scayt_autoStartup: true,
		// Set default language
		/// Available languages : en_US, en_GB, pt_BR, da_DK, nl_NL, en_CA, fi_FI, fr_FR, fr_CA, de_DE, el_GR, it_IT, nb_NO, pt_PT, es_ES, sv_SE
		scayt_sLang: 'fr_FR',
		
		/*
		toolbarGroups: [
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list","blocks"]},
				{"name":"document","groups":["mode"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"about","groups":["about"]}
			],
		*/
		//removeButtons: 'Subscript,Superscript', // To have Underline back
		// Disable content filtering (handled by Elgg)
		allowedContent: true,
		baseHref: elgg.config.wwwroot,
		//removePlugins: 'liststyle,contextmenu,tabletools,resize',
		removePlugins: '',
		extraPlugins: 'blockimagepaste,colorbutton,colordialog', //colorbutton,colordialog
		defaultLanguage: 'en',
		language: elgg.get_language(),
		skin: 'moono',
		uiColor: '#EEEEEE',
		contentsCss: elgg.get_simplecache_url('css', 'elgg/wysiwyg.css'),
		disableNativeSpellChecker: false,
		disableNativeTableHandles: false,
		//removeDialogTabs: 'image:advanced;image:Link;link:advanced;link:target',
		removeDialogTabs: '',
		autoGrow_maxHeight: $(window).height() - 100,
		
		// ESOPE : templates support
		// See http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.templates
		// Do not remove current editor content
		templates_replaceContent: false,
		
		// The templates definition set to use. It accepts a list of names separated by comma. It must match definitions loaded with the templates_files setting
		// Default : 'default'
		// Eg.: templates: 'my_templates',
		templates: 'esope_custom_templates',
		
		// Define custom templates files - The list of templates definition files to load
		// Default: templates_files: [ 'plugins/templates/templates/default.js' ] 
		/* Eg.: templates_files: [
			'/editor_templates/site_default.js',
			'http://www.example.com/user_templates.js
		],
		*/
		// http://localhost/esope_1.12/mod/ckeditor/vendors/ckeditor/plugins/templates/templates/default.js
		//templates_files: [ '<?php echo elgg_get_site_url(); ?>mod/esope/views/default/js/elgg/ckeditor/esope_custom_templates.js.php' ],
		//templates_files: [ '<?php echo elgg_get_site_url(); ?>esope/templates/config/ckeditor' ],
		templates_files: [ '<?php echo elgg_get_simplecache_url('js', 'esope/ckeditor_templates'); ?>' ],
		
	};
});


// Allow empty HTML tags (especially useful for FA icons)
$(document).ready(function(){
	if (typeof CKEDITOR != "undefined") {
		$.each(CKEDITOR.dtd.$removeEmpty, function (i, value) {
			CKEDITOR.dtd.$removeEmpty[i] = false;
		});
	}
});

