<?php
/**
 * Extended TinyMCE - a wysiwyg editor
 *
 */

elgg_register_event_handler('init', 'system', 'extended_tinymce_init');

function extended_tinymce_init() {

	elgg_extend_view('css/elgg', 'extended_tinymce/css');
	elgg_extend_view('css/admin', 'extended_tinymce/css');

	elgg_define_js('extended_tinymce', array(
		'src' => 'mod/extended_tinymce/vendor/tinymce/js/tinymce/jquery.tinymce.min.js',
		'deps' => array('jquery', 'elgg'),
	));

	elgg_extend_view('input/longtext', 'extended_tinymce/init');

	elgg_extend_view('js/embed/embed', 'js/elgg/extended_tinymce/insert.js');

	// extend allowed styles for tinymce editor as filtered by htmlawed
	elgg_register_plugin_hook_handler('allowed_styles', 'htmlawed', 'extended_tinymce_allowed_styles');
}

function extended_tinymce_allowed_styles($hook, $type, $items, $vars) {
	$allowed_styles = array(
		'color', 'cursor', 'text-align', 'vertical-align', 'font-size', 'font-family',
		'font-weight', 'font-style', 'border', 'border-top', 'background-color',
		'border-bottom', 'border-left', 'border-right',
		'margin', 'margin-top', 'margin-bottom', 'margin-left',
		'margin-right', 'padding', 'float', 'text-decoration'
	);

	return $allowed_styles;
}

function extended_tinymce_get_site_language() {
	if ($site_language = elgg_get_config('language')) {
		$path = elgg_get_plugins_path() . "extended_tinymce/vendor/tinymce/js/tinymce/langs";
		if (file_exists("$path/$site_language.js")) {
			return $site_language;
		}
	}

	return 'en';
}

function extended_tinymce_get_user_language() {
	$user_language = get_current_language();

	$path = elgg_get_plugins_path() . "extended_tinymce/vendor/tinymce/js/tinymce/langs";

	if (!file_exists("$path/$user_language.js")) {
		return extended_tinymce_get_site_language();
	}

	return $user_language;
}
