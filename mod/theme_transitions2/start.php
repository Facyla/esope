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
	elgg_unextend_view('page/elements/sidebar', 'search/header');
	
	// Custom user settings
	elgg_extend_view('forms/account/settings', 'theme_transitions2/usersettings', 200);
	elgg_register_plugin_hook_handler('usersettings:save', 'user', 'theme_transitions2_set_usersettings');
	
	// Move QR code lightbox module to a view that is always available
	elgg_unextend_view('page/elements/owner_block', 'qrcode/ownerblock_extend');
	elgg_extend_view('page/elements/navbar', 'qrcode/ownerblock_extend');
	
	// Public notice for comment
	elgg_extend_view('forms/comment/save', 'theme_transitions2/public_comment', 100);
	
	// Some menus updates
	elgg_register_event_handler('pagesetup', 'system', 'theme_transitions2_pagesetup', 1000);
	
	// Rewrite RSS, ICAL and QR code links in owner_block menu (goes to navigation)
	elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	elgg_unregister_plugin_hook_handler('output:before', 'layout', 'transitions_add_ical_link');
	elgg_register_plugin_hook_handler('output:before', 'layout', 'theme_transitions2_add_tools_links');
	
	// Rewrite register action
	elgg_unregister_action('register');
	elgg_register_action("register", dirname(__FILE__) . "/actions/register.php", "public");
	
	// Remove friendship functionnality
	elgg_unregister_plugin_hook_handler('register', 'menu:user_hover', '_elgg_friends_setup_user_hover_menu');
	elgg_unregister_page_handler('friends');
	elgg_unregister_page_handler('friendsof');
	elgg_unregister_page_handler('collections');
	elgg_unregister_action('friends/add');
	elgg_unregister_action('friends/remove');
	elgg_unregister_action('friends/collections/add');
	elgg_unregister_action('friends/collections/delete');
	elgg_unregister_action('friends/collections/edit');
	
	// Add new actions to hover user menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'theme_transitions2_user_hover_menu', 1000);
	elgg_register_action('admin/user/make_content_admin', dirname(__FILE__) . "/actions/theme_transitions2/make_content_admin.php", 'logged_in');
	elgg_register_action('admin/user/remove_content_admin', dirname(__FILE__) . "/actions/theme_transitions2/remove_content_admin.php", 'logged_in');
	elgg_register_action('admin/user/make_platform_admin', dirname(__FILE__) . "/actions/theme_transitions2/make_platform_admin.php", 'admin');
	elgg_register_action('admin/user/remove_platform_admin', dirname(__FILE__) . "/actions/theme_transitions2/remove_platform_admin.php", 'admin');
	
	// Add home management actions
	elgg_register_action('theme_transitions2/select_article', dirname(__FILE__) . "/actions/theme_transitions2/select_article.php", 'logged_in');
	
	
	// Register admin rights plugin hooks
	//elgg_register_plugin_hook_handler('access:collections:read', 'user', 'theme_transitions2_read_access_hook');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'theme_transitions2_permissions_hook');
	elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'theme_transitions2_container_permissions_hook');
	// Override access rights for special user types
	theme_transitions2_override_read_access();
	
	// Modify owner block menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_transitions2_owner_block_menu', 1000);
	
	// Register Font Awesome
	elgg_register_css('font-awesome', 'vendor/fortawesome/font-awesome/css/font-awesome.min.css');
	elgg_load_css('font-awesome');
	
	// Add viewport to head
	elgg_register_plugin_hook_handler('head', 'page', 'theme_transitions2_setup_head');
	
	// Pour changer la manière de filtrer les tags HTMLawed
	if (elgg_is_active_plugin('htmlawed')) {
		elgg_register_plugin_hook_handler('config', 'htmlawed', 'theme_transitions2_htmlawed_filter_tags');
		elgg_register_plugin_hook_handler('allowed_styles', 'htmlawed', 'theme_transitions2_htmlawed_allowed_tags');
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
		'gallery' => array('w' => 400, 'h' => 400, 'square' => true, 'upscale' => true),
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

	elgg_unregister_menu_item('topbar', 'friends');
	elgg_unregister_menu_item('navbar', 'login-dropdown');
	elgg_unregister_menu_item('navbar', 'register');
	elgg_unregister_menu_item('footer', 'powered');
	
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
	} else {
		elgg_register_menu_item('topbar', array(
			'name' => 'register',
			'text' => elgg_echo('register'),
			'href' => "register",
			'priority' => 100,
			'section' => 'alt',
			'link_class' => '',
		));
		elgg_register_menu_item('topbar', array(
			'name' => 'login',
			'text' => elgg_echo('login'),
			'href' => 'login#login-dropdown-box',
			'rel' => 'popup',
			'class' => 'elgg-button elgg-button-dropdown',
			'priority' => 100,
			'section' => 'alt',
			'link_class' => '',
		));
	}
	
	// Remove QR code icon (will be added to navigation)
	elgg_unregister_menu_item('extras', 'qrcode-page');
	
}

// Add RSS, ICAL and QR code links to main navigation
function theme_transitions2_add_tools_links() {
	$theme_menu = elgg_get_plugin_setting('menu_site', 'theme_transitions2');
	if (empty($theme_menu)) { $theme_menu = 'extras'; }
	
	// RSS
	global $autofeed;
	if (isset($autofeed) && $autofeed == true) {
		$url = current_page_url();
		if (substr_count($url, '?')) { $url .= "&view=rss"; } else { $url .= "?view=rss"; }
		$url = elgg_format_url($url);
		elgg_register_menu_item($theme_menu, array(
			'name' => 'rss',
			'text' => '<i class="fa fa-rss"></i>',
			'href' => $url,
			'title' => elgg_echo('feed:rss'),
			'item_class' => "float-alt", 
		));
	}
	
	// ICAL
	$context = elgg_get_context();
	//echo $context; // debug : check eligible context
	if (in_array($context, array('transitions', 'main', 'collections', 'search'))) {
		$url = current_page_url();
		if (substr_count($url, '?')) { $url .= "&view=ical"; } else { $url .= "?view=ical"; }
		$url = elgg_format_url($url);
		elgg_register_menu_item($theme_menu, array(
			"name" => "ical",
			"href" => $url,
			"text" => '<i class="fa fa-calendar-o"></i>',
			'title' => elgg_echo('transitions:ical'),
			'item_class' => "float-alt", 
		));
	}
	
	// QR code
	$qrcode_title = elgg_echo('qrcode:page:title');
	elgg_register_menu_item($theme_menu, array(
			'name' => 'qrcode-page', 
			'text' => '<i class="fa fa-qrcode"></i>', 
			'title' => $qrcode_title,
			'href' => '#elgg-popup-qrcode-page', 
			'rel' => 'popup', 
			'item_class' => "float-alt", 
		));
	
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


// Content admins (greater admin levels also have this role)
function theme_transitions2_user_is_content_admin($user = false) {
	if (!$user) $user = elgg_get_logged_in_user_entity();
	if (!$user) return false; // Not logged in
	if ($user->is_content_admin == 'yes') return true;
	if (theme_transitions2_user_is_platform_admin($user)) return true;
	if ($user->isAdmin()) return true;
	return false;
}
function theme_transitions_get_content_admins() {
	$options = array('types' => 'user', 'metadata_name_value_pairs' => array('name' => 'is_content_admin', 'value' => 'yes'));
	return elgg_get_entities_from_metadata($options);
}

// Platform admins (greater admin level also have this role)
function theme_transitions2_user_is_platform_admin($user = false) {
	if (!$user) $user = elgg_get_logged_in_user_entity();
	if (!$user) return false; // Not logged in
	if ($user->is_platform_admin == 'yes') return true;
	if ($user->isAdmin()) return true;
	return false;
}
function theme_transitions_get_platform_admins() {
	$options = array('types' => 'user', 'metadata_name_value_pairs' => array('name' => 'is_platform_admin', 'value' => 'yes'));
	return elgg_get_entities_from_metadata($options);
}


function theme_transitions2_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	
	// Remove some unwanted entries
	// Note : easier to remove friends menu by unregistering the core hook
	$remove_user_menus = array('add_friend', 'remove_friend', 'activity:owner', 'transitions');
	// @TODO Supprimer lien message si refus d'être contacté
	$block_messages = elgg_get_plugin_user_setting('block_messages', 'theme_transitions2');
	if ($block_messages == 'yes') $remove_user_menus[] = 'send';
	if ($return) foreach ($return as $key => $item) {
		$name = $item->getName();
		if (is_array($remove_user_tools) && in_array($name, $remove_user_tools)) { unset($return[$key]); }
	}
	
	// Add some admin menus
	$actions = array();
	// Platform admin can grant content admins
	if (theme_transitions2_user_is_platform_admin()) {
		if (theme_transitions2_user_is_content_admin($user)) {
			$actions[] = 'remove_content_admin';
		} else {
			$actions[] = 'make_content_admin';
		}
	}
	// Global admin can grant platform admins
	if (elgg_is_admin_logged_in()) {
		if (theme_transitions2_user_is_platform_admin($user)) {
			$actions[] = 'remove_platform_admin';
		} else {
			$actions[] = 'make_platform_admin';
		}
	}
	
	foreach ($actions as $action) {
		$url = "action/admin/user/$action?guid={$user->guid}";
		$url = elgg_add_action_tokens_to_url($url);
		$item = new \ElggMenuItem($action, elgg_echo($action), $url);
		$item->setSection('admin');
		$item->setConfirmText(true);
		$return[] = $item;
	}
	return $return;
}


// Filters an array of access IDs that the user $params['user_id'] can see.
/*
function theme_transitions2_read_access_hook($hook, $entity_type, $returnvalue, $params) {
	error_log("USER : " . $params['user_id'] . " => ENTITY : " . $params['entity']->guid . ' ' . $returnvalue);
	return $returnvalue;
}
*/
function theme_transitions2_override_read_access() {
	if (!elgg_is_logged_in()) return;
	if (theme_transitions2_user_is_content_admin()) {
		elgg_set_ignore_access(true);
	}
}

// Determines if a user can *edit* a given entity
function theme_transitions2_permissions_hook($hook, $entity_type, $returnvalue, $params) {
	if (theme_transitions2_user_is_content_admin($params['user'])) { return true; }
	return $returnvalue;
}

// Determines if a user can can use the entity $params['container'] as a container for a given entity
// This is necessary to 
function theme_transitions2_container_permissions_hook($hook, $entity_type, $returnvalue, $params) {
	//$user = $params['user'];
	//$entity = $params['entity'];
	//error_log("USER : " . $params['user']->guid . ' ' . $params['user']->name . " => ENTITY : " . $params['entity']->guid . ' ' . $params['entity']->title);
	if (elgg_instanceof($params['container'], 'user')) {
		if (theme_transitions2_user_is_content_admin($params['user'])) { return true; };
	}
	return $returnvalue;
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



function theme_transitions2_htmlawed_filter_tags($hook, $type, $return, $params) {
		$htmlawed_config = array(
		// seems to handle about everything we need.
		//'safe' => true,
		'safe' => false, // @TODO : allows most code
		//'elements' => 'iframe, embed', // Custom allowed elements

		// remove comments/CDATA instead of converting to text
		'comment' => 1,
		'cdata' => 1,

		//'deny_attribute' => 'class, htmlawedon*',
		'deny_attribute' => 'on*',
		'hook_tag' => 'htmlawed_tag_post_processor',

		'schemes' => '*:http,https,ftp,news,mailto,rtsp,teamspeak,gopher,mms,callto',
		// apparent this doesn't work.
		// 'style:color,cursor,text-align,font-size,font-weight,font-style,border,margin,padding,float'
	);
	return $htmlawed_config;
}


function theme_transitions2_htmlawed_allowed_tags($hook, $type, $return, $params) {
	// Filtered tag element
	$tag = $params['tag'];
	
	// this list should be coordinated with the WYSIWYG editor used (tinymce, ckeditor, etc.)
	$allowed_styles = array(
		'color', 'cursor', 'text-align', 'vertical-align', 'font-size',
		'font-weight', 'font-style', 'border', 'border-top', 'background-color',
		'border-bottom', 'border-left', 'border-right',
		'margin', 'margin-top', 'margin-bottom', 'margin-left',
		'margin-right','padding', 'float', 'text-decoration',
		'height', 'width', 
	);
	return $allowed_styles;
}


