<?php

// Editor-based filtering
$extended_valid_elements = strip_tags(elgg_get_plugin_setting('extended_valid_elements', 'tinymce'));
if (empty($extended_valid_elements)) $extended_valid_elements = "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height|allowfullscreen|allowscriptaccess],object[classid|clsid|codebase|width|height|data|type|id],style[lang|media|title|type],iframe[src|width|height|style],param[name|value],video[src|preload|autoplay|mediagroup|loop|muted|controls|poster|width|height],audio[src|preload|autoplay|mediagroup|loop|muted|controls],source[src|type|media],track[kind|src|srclang|label|default]";

?>

elgg.provide('elgg.tinymce_simple');

/**
 * Toggles the tinymce editor
 *
 * @param {Object} event
 * @return void
 */
elgg.tinymce_simple.toggleEditor = function(event) {
	event.preventDefault();
	
	var target = $(this).attr('href');
	var id = $(target).attr('id');
	if (!tinyMCE.get(id)) {
		tinyMCE.execCommand('mceAddControl', false, id);
		$(this).html(elgg.echo('tinymce:remove'));
	} else {
		tinyMCE.execCommand('mceRemoveControl', false, id);
		$(this).html(elgg.echo('tinymce:add'));
	}
}

/**
 * TinyMCE initialization script
 *
 * You can find configuration information here:
 * http://tinymce.moxiecode.com/wiki.php/Configuration
 */
elgg.tinymce_simple.init = function() {

	$('.tinymce-toggle-editor').live('click', elgg.tinymce_simple.toggleEditor);

	$('.elgg-input-simpletext').parents('form').submit(function() {
		tinyMCE.triggerSave();
	});
	
	// Regular, advanced configuration editor
	tinyMCE.init({
		theme : "advanced",
		mode : "specific_textareas",
		editor_selector : "elgg-input-simpletext",
		editor_deselector : "elgg-input-rawtext",
		
		language : "<?php echo tinymce_get_site_language(); ?>",
		gecko_spellcheck : true,
		browser_spellcheck : true,
		spellchecker_languages : "+French=fr,English=en",
		
		table_inline_editing : true,
		//document_base_url : elgg.config.wwwroot,
		//relative_urls : false,
		convert_urls : false,
		
		// Doesn't check the HTML at all..
		//verify_html : false,
		// Allow custom elements
		//custom_elements : "",
		// Note extended actually extends the default list http://www.tinymce.com/wiki.php/Configuration3x:extended_valid_elements
		extended_valid_elements : "<?php echo $extended_valid_elements; ?>",
		
		plugins : "<?php echo $plugins; ?>",
		
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,anchor,|,undo,redo,|,cleanup,|,bullist,numlist",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_path : true,
		width : "100%",
		//height: "200px",
		
		setup : function(ed) {
			// show the number of words at startup
			ed.onLoadContent.add(function(ed, o) {
				var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
				var text = elgg.echo('tinymce:word_count') + strip.split(' ').length + ' ';
				tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
			});
			// Update word count
			ed.onKeyUp.add(function(ed, e) {
				var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
				var text = elgg.echo('tinymce:word_count') + strip.split(' ').length + ' ';
				tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
			});
			
			// prevent Firefox from dragging/dropping files into editor
			ed.onInit.add(function(ed) {
				if (tinymce.isGecko) {
					tinymce.dom.Event.add(ed.getBody().parentNode, "drop", function(e) {
						if (e.dataTransfer.files.length > 0) {
							e.preventDefault();
						}
					});
				}
			});
		},
		
		content_css: elgg.config.wwwroot + 'mod/tinymce/css/elgg_tinymce.css',
		
		// Templates
		<?php if ($templates) { ?>
			template_templates : [ <?php echo $templates; ?> ],
		<?php } ?>
	});
	
	
	// work around for IE/TinyMCE bug where TinyMCE loses insert carot
	if ($.browser.msie) {
		$(".embed-control").live('hover', function() {
			var classes = $(this).attr('class');
			var embedClass = classes.split(/[, ]+/).pop();
			var textAreaId = embedClass.substr(embedClass.indexOf('embed-control-') + "embed-control-".length);

			if (window.tinyMCE) {
				var editor = window.tinyMCE.get(textAreaId);
				if (elgg.tinymce_simple.bookmark == null) {
					elgg.tinymce_simple.bookmark = editor.selection.getBookmark(2);
				}
			}
		});
	}
}

elgg.register_hook_handler('init', 'system', elgg.tinymce_simple.init);
