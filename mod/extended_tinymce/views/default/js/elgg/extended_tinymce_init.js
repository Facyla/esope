define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var EXTENDED_TINYMCE = require('extended_tinymce');

	var tinymceLanguage = $('input:hidden[name=extendedtinymcelang]').val();

	$(".elgg-input-longtext").tinymce({
		script_url : elgg.config.wwwroot + '/mod/extended_tinymce/vendor/tinymce/js/tinymce/tinymce.min.js',
		selector: ".elgg-input-longtext",
		theme: "modern",
		skin : "lightgray",
		language : tinymceLanguage,
		relative_urls : false,
		remove_script_host : false,
		document_base_url : elgg.config.wwwroot,
		plugins: "advlist autolink autoresize charmap code colorpicker emoticons fullscreen hr image insertdatetime link lists paste preview print searchreplace table textcolor textpattern wordcount",
		menubar: false,
		toolbar_items_size: "small",
		toolbar: [
			"newdocument preview fullscreen print | searchreplace | styleselect | fontselect | fontsizeselect",
			"undo redo | bullist numlist | outdent indent | bold italic underline | alignleft aligncenter alignright alignjustify | removeformat",
			"pastetext | insertdatetime | charmap | hr | table | forecolor backcolor | link unlink | image | emoticons | blockquote" + (elgg.is_admin_logged_in() ? " | code" : "")
		],
		width : "99%",
		browser_spellcheck : true,
		image_advtab: true,
		paste_data_images: false,
		autoresize_min_height: 200,
		autoresize_max_height: 450,
		insertdate_formats: ["%I:%M:%S %p", "%H:%M:%S", "%Y-%m-%d", "%d.%m.%Y"],
		content_css: elgg.config.wwwroot + 'mod/extended_tinymce/css/elgg_extended_tinymce.css',
		setup : function(e) {
			e.on('change', function(e) { tinyMCE.triggerSave(); });
		}
	});
});
