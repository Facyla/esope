<?php
/**
 * Aalborg theme plugin
 *
 * @package AalborgTheme
 */

elgg_register_event_handler('init','system','theme_transitions2_init');

function theme_transitions2_init() {

	// theme specific CSS
	elgg_extend_view('css/elgg', 'theme_transitions2/css');
	
	// Custom user settings
	elgg_extend_view('forms/account/settings', 'theme_transitions2/usersettings', 200);
	elgg_register_plugin_hook_handler('usersettings:save', 'user', 'theme_transitions2_set_usersettings');

	
	elgg_register_event_handler('pagesetup', 'system', 'theme_transitions2_pagesetup', 1000);
	
	// Rewrite register action
	elgg_unregister_action('register');
	elgg_register_action("register", dirname(__FILE__) . "/actions/register.php", "public");
	
	// Add new actions to hover user menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'theme_transitions2_user_hover_menu', 1000);
	elgg_register_action('admin/user/makeeditor', dirname(__FILE__) . "/actions/makeeditor.php", 'admin');
	elgg_register_action('admin/user/removeeditor', dirname(__FILE__) . "/actions/removeeditor.php", 'admin');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_transitions2_owner_block_menu', 1000);
	
	// Register Font Awesome
	elgg_register_css('font-awesome', 'vendor/fortawesome/font-awesome/css/font-awesome.min.css');
	elgg_load_css('font-awesome');
	

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
	
}

/**
 * Serve the front page
 * 
 * @return bool Whether the page was sent.
 */
function theme_transitions2_index() {
	/*
	if (elgg_is_logged_in()) {
		if (!include_once(dirname(__FILE__) . "/pages/theme_transitions2/index.php")) { return false; }
	} else {
		if (!include_once(dirname(__FILE__) . "/pages/theme_transitions2/index_public.php")) { return false; }
	}
	*/
	if (!include_once(dirname(__FILE__) . "/pages/theme_transitions2/index.php")) { return false; }
	
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


// Editor role
function theme_transitions2_user_is_editor($user = false) {
	if (!$user) $user = elgg_get_logged_in_user_entity();
	if ($user->is_editor == 'yes') return true;
	return false;
}

function theme_transitions_get_editors() {
	$options = array('types' => 'user', 'metadata_name_value_pairs' => array('name' => 'is_editor', 'value' => 'yes'));
	return elgg_get_entities_from_metadata($options);
}


function theme_transitions2_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	
	// Remove some unwanted entries
	$remove_user_menus = array('add_friend', 'remove_friend', 'activity:owner', 'transitions');
	// @TODO Supprimer lien message si refus d'être contacté
	$block_messages = elgg_get_plugin_user_setting('block_messages', 'theme_transitions2');
	if ($block_messages == 'yes') $remove_user_menus[] = 'send';
	if ($return) foreach ($return as $key => $item) {
		$name = $item->getName();
		if (is_array($remove_user_tools) && in_array($name, $remove_user_tools)) { unset($return[$key]); }
	}
	
	// Add some admin menus
	if (elgg_is_admin_logged_in()) {
		$actions = array();
		if (theme_transitions2_user_is_editor($user)) {
			$actions[] = 'removeeditor';
		} else {
			$actions[] = 'makeeditor';
		}
		
		foreach ($actions as $action) {
			$url = "action/admin/user/$action?guid={$user->guid}";
			$url = elgg_add_action_tokens_to_url($url);
			$item = new \ElggMenuItem($action, elgg_echo($action), $url);
			$item->setSection('admin');
			$item->setConfirmText(true);
			$return[] = $item;
		}
	}
	return $return;
}


function theme_transitions2_owner_block_menu($hook, $type, $return, $params) {
	// Menu user
	$user = $params['entity'];
	if (elgg_instanceof($user, 'user')) {
		$remove_user_tools = array('file', 'transitions');
		if ($return) foreach ($return as $key => $item) {
			$name = $item->getName();
			if (in_array($name, $remove_user_tools)) { unset($return[$key]); }
		}
	}
	return $return;
}

function theme_transitions2_set_usersettings() {
	$user_guid = get_input('guid');
	$public_profile = get_input('public_profile');
	$block_messages = get_input('block_messages');
	if ($user_guid) {
		$user = get_user($user_guid);
	} else {
		$user = elgg_get_logged_in_user_entity();
	}
	if ($user && ($public_profile || $block_messages)) {
		if ($public_profile) $user->setPrivateSetting ('public_profile', $public_profile);
		if ($block_messages) $user->setPrivateSetting ('block_messages', $block_messages);
		return true;
	}
	return false;
}


