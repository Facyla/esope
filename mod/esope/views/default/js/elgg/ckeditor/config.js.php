<?php
/* ESOPE : needed to empty original file js/elgg/ckeditor/init.js to use PHP in this JS view
 */
// ESOPE @TODO import changes from tinymce version

error_log("TEST CKEditor");
?>
//<script>

define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');

	return {
		// Use / for row break, - for separator
		toolbar: [
				['RemoveFormat'], 
				['Paste', 'PasteFromWord'], 
				['Undo', 'Redo'], 
				['Blockquote'], 
				['Link', 'Unlink'], 
				['Image', 'Table', 'Iframe'], 
				['Source'], 
				['Scayt'], 
				['Maximize'], 
				'/', 
				['Format'], 
				['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'], 
				['NumberedList', 'BulletedList', 'Outdent', 'Indent'], 
				[ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
				// source, iframe, flash, table, styles
				// templates
				['Templates'], 
			],
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
		allowedContent: true,
		baseHref: elgg.config.wwwroot,
		//removePlugins: 'liststyle,contextmenu,tabletools,resize',
		removePlugins: '',
		extraPlugins: 'blockimagepaste',
		defaultLanguage: 'en',
		language: elgg.get_language(),
		skin: 'moono',
		uiColor: '#EEEEEE',
		contentsCss: elgg.get_simplecache_url('css', 'elgg/wysiwyg.css'),
		disableNativeSpellChecker: false,
		disableNativeTableHandles: false,
		//removeDialogTabs: 'image:advanced;image:Link;link:advanced;link:target',
		removeDialogTabs: '',
		autoGrow_maxHeight: $(window).height() - 100
	};
});

