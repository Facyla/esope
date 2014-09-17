<?php
/**
 * togetherjs plugin
 *
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'togetherjs_init');


/**
 * Init togetherjs plugin.
 */
function togetherjs_init() {
	global $CONFIG; // All site useful vars
	
	
	elgg_extend_view('css', 'togetherjs/css');
	
	elgg_register_js('togetherjs', 'https://togetherjs.com/togetherjs.js', 'head');
	
	// @TODO : make it a setting
	if (elgg_is_logged_in()) {
		elgg_load_js('togetherjs');
		// Note : config script MUST be loaded before the togetherjs script, so weight it light in head !
		elgg_extend_view('page/elements/head', 'togetherjs/extend_head', 10);
		elgg_extend_view('page/elements/footer', 'togetherjs/extend_body');
	}
	
	/* TinyMCE integration prototypes
	
	// Sets the HTML contents of the activeEditor editor
	tinyMCE.activeEditor.setContent('<span>some</span> html');

	// Sets the raw contents of the activeEditor editor
	tinyMCE.activeEditor.setContent('<span>some</span> html', {format : 'raw'});

	// Sets the content of a specific editor (my_editor in this example)
	tinyMCE.get('my_editor').setContent(data);

	// Sets the bbcode contents of the activeEditor editor if the bbcode plugin was added
	tinyMCE.activeEditor.setContent('[b]some[/b] html', {format : 'bbcode'});
	
	// get value from tinyMCE
	tinyMCE.get('message').getContent();
	// populate fields and clear fields
	tinymce.get('message').setContent('');
	
	// Get editor content
	content = tinyMCE.get('elgg-input-1').getContent();
	
	// Set editor content
	tinyMCE.get('elgg-input-1').setContent('<span>SOME</span> html', {format : 'raw'});
	*/
	
	/*
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'togetherjs');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'togetherjs');
	}
	
	// Register a page handler on "togetherjs/"
	elgg_register_page_handler('togetherjs', 'togetherjs_page_handler');
	*/
	
	
}

/*
// Page handler
// Loads pages located in togetherjs/pages/togetherjs/
function togetherjs_page_handler($page) {
	$base = elgg_get_plugins_path() . 'togetherjs/pages/togetherjs';
	switch ($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include "$base/example_page.php";
			break;
		default:
			include "$base/example_page.php";
	}
	return true;
}


// Other useful functions
// prefixed by plugin_name_
/*
function togetherjs_function() {
	
}
*/




