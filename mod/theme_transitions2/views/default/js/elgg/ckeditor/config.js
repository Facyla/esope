define(function(require) {
	var elgg = require('elgg');
	var $ = require('jquery');

	return {
		// Use / for row break, - for separator
		toolbar: [
				['Paste', 'PasteFromWord', 'RemoveFormat'], 
				['Undo', 'Redo'], 
				['Image', 'Table', 'Iframe', 'Flash'], 
				['Scayt'], 
				['Source'], 
				['Maximize'], 
				'/', 
				['Format'], 
				['Bold', 'Italic', 'Underline', 'Strike'], 
				['Link', 'Unlink', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'], 
				// source, iframe, flash, table, styles
				// templates
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
		removeButtons: 'Subscript,Superscript', // To have Underline back
		allowedContent: true,
		baseHref: elgg.config.wwwroot,
		removePlugins: 'liststyle,contextmenu,tabletools,resize',
		extraPlugins: 'blockimagepaste',
		defaultLanguage: 'en',
		language: elgg.get_language(),
		skin: 'moono',
		uiColor: '#EEEEEE',
		contentsCss: elgg.get_simplecache_url('css', 'elgg/wysiwyg.css'),
		disableNativeSpellChecker: false,
		disableNativeTableHandles: false,
		removeDialogTabs: 'image:advanced;image:Link;link:advanced;link:target',
		autoGrow_maxHeight: $(window).height() - 100
	};
});
