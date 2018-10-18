<?php
/**
 * emojis plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

/*
 * Store Unicode emojis as HTML &#XXX;
 * Filter Unicode non-characters
 * Convert (display) :emoji: to HTML emoji entity
 * Provide endpoint for emojis search ?
*/


// Init plugin
elgg_register_event_handler('init', 'system', 'emojis_init');


/**
 * Init emojis plugin.
 */
function emojis_init() {
	
	elgg_extend_view('css', 'emojis/css');
	
	// Adds emojis detection support
	require_once('lib/EmojiDetection/Emoji.php');
	
	// Convert emoji to HTML codepoint + filter UTF-8 non-characters
	// Note : &#XXX; is itself stored as HTML entity (as &amp;#XXX;)
	// @TODO Store emojis as HTML entity (not encoded entity) to avoid display headaches
	// @TODO use this only if Database engine does not support UTF-8 (eg. mysql's utf8 does NOT, while utf8mb4 does)
	elgg_register_plugin_hook_handler('validate', 'input', 'emojis_input_hook');
	
	// Convert back encoded HTML entities to HTML codepoints
	// Note: easy when using longtext output, but use in search results, tags extraction and other string manipulations would work beter with emojis not converted to HTML entities in database
	//elgg_register_plugin_hook_handler('view', 'output/longtext', 'emojis_output_hook'); // Handles only longtext output
	elgg_register_plugin_hook_handler('view', 'all', 'emojis_output_hook'); // Intercepts everything
	
	// Override the wire action so we can change the publish function and add emojis support
	elgg_unregister_action('thewire/add');
	$thewire_action_path = elgg_get_plugins_path() . 'emojis/actions/thewire/';
	elgg_register_action("thewire/add", $thewire_action_path . 'add.php');
	
	
	
	/* Some useful elements :
	// Register a PHP library
	elgg_register_library('elgg:emojis', elgg_get_plugins_path() . 'emojis/lib/emojis.php');
	// Load a PHP library (can also be loaded from the page_handler or from specific views)
	elgg_load_library('elgg:emojis');
	
	// Register a view to simplecache
	// Useful for any view that do not change, usually CSS or JS or other static data or content
	elgg_register_simplecache_view('css/emojis');
	$css_url = elgg_get_simplecache_url('css', 'emojis');
	
	// Register JS script - use with : elgg_load_js('emojis');
	$js_url = elgg_get_plugins_path() . 'emojis/vendors/emojis.js';
	elgg_register_js('emojis', $js_url, 'head');
	
	// Register CSS - use with : elgg_load_css('emojis');
	$css_url = elgg_get_plugins_path() . 'emojis/vendors/emojis.css';
	elgg_register_css('emojis', $css_url, 500);
	
	// Get a plugin setting
	$setting = elgg_get_plugin_setting('setting_name', 'emojis');
	
	// Get a user plugin setting (makes sense only if logged in)
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'emojis');
	}
	
	// Register hook - see /admin/develop_tools/inspect?inspect_type=Hooks
	elgg_register_plugin_hook_handler('login', 'user', 'emojis_somehook');
	
	// Register event - see /admin/develop_tools/inspect?inspect_type=Events
	elgg_register_event_handler('create','object','emojis_someevent');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "emojis_icon_hook");
	
	// override the default url to view a emojis object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'emojis_set_url');
	*/
	
	// Register a page handler on "emojis/"
	elgg_register_page_handler('emojis', 'emojis_page_handler');
	
}

/*
// Include page handlers, hooks and events functions
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/hooks.php');
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/events.php');
include_once(elgg_get_plugins_path() . 'emojis/lib/emojis/functions.php');
*/


// Page handler
// Loads pages located in emojis/pages/emojis/
function emojis_page_handler($page) {
	$base = elgg_get_plugins_path() . 'emojis/pages/emojis';
	switch ($page[0]) {
		/*
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		*/
		default:
			include "$base/index.php";
	}
	return true;
}



// EMOJI SUPPORT
// 👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤
// Input text filter, used to validate text content, extract data, replace strings, etc.
// Note : Wire input uses a custom getter
function emojis_input_hook($hook, $type, $input, $params) {
	return emojis_to_html($input, true);
}
/* Unicode Emojis detection and replacement by HTML codepoints
 * Note : emojis are not detected if they are the last caracter: 
 *        add a 1 space padding at the end so we can use proper detection
 * $input (string) Input text to be converted
 * $strip_nonchars (bool) Remove Unicode Noncharacters - this is required if using a UTF8 MySQL db (full support requires utf8mb4)
 */
function emojis_to_html($input, $strip_nonchars = true) {
	$emojis = Emoji\detect_emoji($input);
	if (is_array($input)) error_log("Array input DETECTED");
	$map = Emoji\_load_map();
	if (count($emojis) > 0) {
		//error_log("EMOJI detected : " . count($emojis));
		foreach($emojis as $emoji) {
			$replace_map['emojis'][] = $emoji['emoji'];
			$replace_map['shortcodes'][] = ':' . $emoji['short_name'] . ':';
			//$replace_map['html'][] = '&#x' . $emoji['hex_str'];
			$replace_map['html'][] = '&#x' . str_replace('-', ';&#x', $emoji['hex_str']) . ';';
			//error_log('&#x' . str_replace('-', ';&#x', $emoji['hex_str']) . ';');
			//$replace_map['html'][] = '&#x' . str_replace('-', ';&#x', $emoji['hex_str']) . ';';
			//error_log('&#x' . str_replace('-', ';&#x', $emoji['hex_str']) . ';');
			//$replace_map['html'][] = '&#x' . implode('&#x', $emoji['points_hex']);
			//error_log('&#x' . implode('&#x', $emoji['points_hex']));
			//error_log(" => " . print_r($emoji, true));
		}
		// Replace by shortcodes // Caution in editors - will be displayed as the shortcode
		//$input = str_replace($replace_map['emojis'], $replace_map['shortcodes'], $input);
		// Replace by HTML codepoint text
		$input = str_replace($replace_map['emojis'], $replace_map['html'], $input);
	}
	
	// Remove caracters that won't fit in a UTF-8 MySQL db (use UTF8MB4 to store actual Unicode data)
	// NOTE: you should not just strip, but replace with replacement character U+FFFD to avoid unicode attacks, mostly XSS: http://unicode.org/reports/tr36/#Deletion_of_Noncharacters
	if ($strip_nonchars) {
		$input = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $input);
	}
	
	return $input;
}

// Add colon padding for unicode emoji shortcodes
function emojis_to_text(&$text) { $text = ":$text:"; }

// Add HTML representation of codepoint
function emojis_to_html_codepoint(&$codepoint) { $codepoint = "&#x$codepoint;"; }

// Get replacement map for text emojis
function emojis_get_map() {
	static $replace_map = 1;
	if (!is_array($replace_map)) {
		$emojis_map = Emoji\_load_map();
		$emojis = array_keys($emojis_map);
		array_walk($emojis, 'emojis_to_html_codepoint');
		$text = array_values($emojis_map);
		array_walk($text, 'emojis_to_text');
		$replace_map = [
			'emojis' => $emojis,
			'text' => $text,
		];
	}
	return $replace_map;
}

/* Output hook : prepare emoji for display
 */
function emojis_output_hook($hook, $type, $text, $params) {
	return emojis_output_html($text, true);
}
/* Prepare emoji for display : replaces &amp; with & so emojis become valid HTML entities
 *  - make HTML codepoint viewable
 *  - replace emoji text value with emoji
 * 2 uses : 
 *    * un-htmlentities emojis before saving to DB (do NOT convert shortcodes ! thus default to false)
 *    * for display hooks (unescape & convert)
 */
function emojis_output_html($text, $replace_shortcodes = false) {
	// Unescape HTML emojis codepoints
	$search = ['&amp;#x', '&amp;zwj;'];
	$replace = ['&#x', '&zwj;'];
	$output .= str_replace($search, $replace, $text);
	
	// Convert :emoji: shortcodes to emojis
	if ($replace_shortcodes) {
		$replace_map = emojis_get_map();
		$output = str_replace($replace_map['text'], $replace_map['emojis'], $output);
	}
	
	//error_log("OUTPUT HOOK applied : " . $text . "\n" . $output);
	//error_log("OUTPUT HOOK applied");
	return $output;
}

/** Modified version for Emojis support
 * Replace urls, hash tags, and @'s by links
 *
 * @param string $text The text of a post
 * @return string
 */
function emojis_thewire_filter($text) {
	$url = elgg_get_site_url();
	// Emojis : add padding on both sides
	$text = ' ' . $text . ' ';
	// email addresses
	$text = preg_replace(
				'/(^|[^\w])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i',
				'$1<a href="mailto:$2@$3">$2@$3</a>',
				$text);
	// links
	$text = parse_urls($text);
	// usernames
	$text = preg_replace(
				'/(^|[^\w])@([\p{L}\p{Nd}._]+)/u',
				'$1<a href="' . $url . 'thewire/owner/$2">@$2</a>',
				$text);
	// Emojis support : hashtags => avoid &#xXXXX being interpreted as hashtag (as it is a Unicode codepoint)
	$text = preg_replace(
				//'/(^|[^\w])#(\w*[^\s\d!-\/:-@]+\w*)/',
				'/(^|[^\w|\&])#(\w*[^\s\d!-\/:-@]+\w*)/',
				'$1<a href="' . $url . 'thewire/tag/$2">#$2</a>',
				$text);
	$text = trim($text);
	return $text;
}

// This function MUST be synced with thewire's + do not convert emojis to HTML entities (or convert them back)
function emojis_thewire_save_post($text, $userid, $access_id, $parent_guid = 0, $method = "site") {
	$post = new ElggObject();

	$post->subtype = "thewire";
	$post->owner_guid = $userid;
	$post->access_id = $access_id;

	// Character limit is now from config
	$limit = elgg_get_plugin_setting('limit', 'thewire');
	if ($limit > 0) {
		$text = elgg_substr($text, 0, $limit);
	}

	// no html tags allowed so we escape
	//$post->description = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
	$description = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
	$description = emojis_output_html($description, false);
	$post->description = $description;

	$post->method = $method; //method: site, email, api, ...

	$tags = thewire_get_hashtags($text);
	if ($tags) {
		$post->tags = $tags;
	}

	// must do this before saving so notifications pick up that this is a reply
	if ($parent_guid) {
		$post->reply = true;
	}

	$guid = $post->save();

	// set thread guid
	if ($parent_guid) {
		$post->addRelationship($parent_guid, 'parent');
		
		// name conversation threads by guid of first post (works even if first post deleted)
		$parent_post = get_entity($parent_guid);
		$post->wire_thread = $parent_post->wire_thread;
	} else {
		// first post in this thread
		$post->wire_thread = $guid;
	}

	if ($guid) {
		elgg_create_river_item(array(
			'view' => 'river/object/thewire/create',
			'action_type' => 'create',
			'subject_guid' => $post->owner_guid,
			'object_guid' => $post->guid,
		));

		// let other plugins know we are setting a user status
		$params = array(
			'entity' => $post,
			'user' => $post->getOwnerEntity(),
			'message' => $post->description,
			'url' => $post->getURL(),
			'origin' => 'thewire',
		);
		elgg_trigger_plugin_hook('status', 'user', $params);
	}
	
	return $guid;
}

/* Support Wire posts content
function theme_inria_thewire_handler_event($event, $type, $object) {
//	if (!empty($object) && elgg_instanceof($object, "object", "thewire")) {
		$text = get_input('body', '', false);
		error_log("TEXT : $text");
		$text = theme_inria_emoji_input('', '', $text, []);
		// no html tags allowed so we escape
		$text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
		error_log(" => $text");
		set_input('body', $text);
		//$object->description = $text;
		// Update entity
		//$object->save();
//	}
	// Return false halts the process, true or no return is equivalent
}
 */



/*
// Input text filter, used to validate text content, extract data, replace strings, etc.
// Note : Wire input uses a custom getter
function emojis_emoji_input($hook, $type, $input, $params) {
	$emojis = Emoji\detect_emoji($input);
	$map = Emoji\_load_map();
	if (count($emojis) > 0) {
		foreach($emojis as $emoji) {
			$replace_map['emojis'][] = $emoji['emoji'];
			$replace_map['shortcodes'][] = ':' . $emoji['short_name'] . ':';
			$replace_map['html'][] = '&#x' . $emoji['hex_str'];
		}
		// Replace by shortcodes // Caution in editors - will be displayed as the shortcode
		//$input = str_replace($replace_map['emojis'], $replace_map['shortcodes'], $input);
		// Replace by HTML codepoint text
		$input = str_replace($replace_map['emojis'], $replace_map['html'], $input);
		error_log('INPUT = ' . $input);
		//error_log(print_r($emojis, true));
		//error_log(print_r($replace_map, true));
		error_log(' => ' . $input);
	}
	return $input;
}
// Add colon padding for unicode emoji shortcodes
function emojis_emoji_pad(&$text) { $text = ":$text:"; }
// Add HTML representation of codepoint
function emojis_emoji_html_codepoint(&$codepoint) { $codepoint = "&#x$codepoint"; }
// Get replacement map for text emojis
function emojis_emoji_get_map() {
	static $replace_map = 0;
	if (!is_array($replace_map)) {
		$emojis_map = Emoji\_load_map();
		error_log("EMOJI MAP :");
		//error_log(print_r($emojis_map, true));
		
		$emojis = array_keys($emojis_map);
		array_walk($emojis, 'emojis_emoji_html_codepoint');
		
		$text = array_values($emojis_map);
		array_walk($text, 'emojis_emoji_pad');
		
		$replace_map = [
			'emojis' => $emojis,
			'text' => $text,
		];
		error_log("REPLACE MAP :");
		//error_log(print_r($replace_map, true));
	}
	return $replace_map;
}
*/

/* Prepare emjoi for display
 * replace emoji text value with emoji
 * or make HTML codepoint viewable
 */
/*
function emojis_emoji_output($hook, $type, $text, $params) {
	$replace_map = emojis_emoji_get_map();
	// Convert shortcodes to emojis
	//$output = str_replace($replace_map['text'], $replace_map['emojis'], $text);
	// Make emojis displayable
	$output = str_replace('&amp;#x', '&#x', $text);
	//error_log("OUTPUT HOOK applied : " . $text . "\n" . $output);
	return $output;
}
*/




