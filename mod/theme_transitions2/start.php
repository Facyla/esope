<?php
/**
 * Aalborg theme plugin
 *
 * @package AalborgTheme
 */

elgg_register_event_handler('init','system','theme_transitions2_init');

function theme_transitions2_init() {

	elgg_register_event_handler('pagesetup', 'system', 'theme_transitions2_pagesetup', 1000);

	// theme specific CSS
	elgg_extend_view('css/elgg', 'theme_transitions2/css');

	elgg_register_plugin_hook_handler('head', 'page', 'theme_transitions2_setup_head');

	// non-members do not get visible links to RSS feeds
	if (!elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}
	
	// Index page
	// Replace the default index page
	elgg_register_page_handler('', 'theme_transitions2_index');
	elgg_register_plugin_hook_handler('index','system','theme_transitions2_index');
	
	// Override default icon sizes
	$icon_sizes = array(
		'topbar' => array('w' => 16, 'h' => 16, 'square' => true, 'upscale' => true),
		'tiny' => array('w' => 25, 'h' => 25, 'square' => true, 'upscale' => true),
		'small' => array('w' => 40, 'h' => 40, 'square' => true, 'upscale' => true),
		'medium' => array('w' => 100, 'h' => 100, 'square' => true, 'upscale' => true),
		'large' => array('w' => 300, 'h' => 300, 'square' => false, 'upscale' => false),
		
		// 800 is a reasonable minimum for main include into article
		'master' => array('w' => 800, 'h' => 800, 'square' => false, 'upscale' => false),
		
		// add uncropped small view for listing (no square)
		'listing' => array('w' => 100, 'h' => 100, 'square' => false, 'upscale' => true),
		// add gallery icon (has to be square)
		'gallery' => array('w' => 300, 'h' => 300, 'square' => true, 'upscale' => true),
		// add high resolution format
		'hres' => array('w' => 2200, 'h' => 1800, 'square' => false, 'upscale' => false),
	);
	elgg_set_config('icon_sizes', $icon_sizes);
	/*
	*/
	
}

/**
 * Serve the front page
 * 
 * @return bool Whether the page was sent.
 */
function theme_transitions2_index() {
	if (elgg_is_logged_in()) {
		if (!include_once(dirname(__FILE__) . "/pages/theme_transitions2/index.php")) { return false; }
	} else {
		if (!include_once(dirname(__FILE__) . "/pages/theme_transitions2/index_public.php")) { return false; }
	}

	return true;
}



/**
 * Rearrange menu items
 */
function theme_transitions2_pagesetup() {

	elgg_unregister_menu_item('footer', 'powered');
	elgg_unregister_menu_item('topbar', 'friends');
	
	if (elgg_is_logged_in()) {

		elgg_register_menu_item('topbar', array(
			'name' => 'account',
			'text' => elgg_echo('account'),
			'href' => "#",
			'priority' => 100,
			'section' => 'alt',
			'link_class' => 'elgg-topbar-dropdown',
		));

		/*
		$item = elgg_get_menu_item('topbar', 'usersettings');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('settings'));
			$item->setPriority(103);
		}
		*/

	}
}

/**
 * Register items for the html head
 *
 * @param string $hook Hook name ('head')
 * @param string $type Hook type ('page')
 * @param array  $data Array of items for head
 * @return array
 */
function theme_transitions2_setup_head($hook, $type, $data) {
	$data['metas']['viewport'] = array(
		'name' => 'viewport',
		'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0',
	);

	$data['links']['apple-touch-icon'] = array(
		'rel' => 'apple-touch-icon',
		'href' => elgg_normalize_url('mod/theme_transitions2/graphics/homescreen.png'),
	);

	return $data;
}



