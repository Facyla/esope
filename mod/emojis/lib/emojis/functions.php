<?php
// EMOJIS FUNCTIONS AND THEWIRE FUNCTIONS OVERRIDES
// 👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤


/* Unicode Emojis detection and replacement by HTML codepoints
 * Note : emojis are not detected if they are the last caracter: 
 *        add a 1 space padding at the end so we can use proper detection
 * $input (string) Input text to be converted
 * $strip_nonchars (bool) Remove Unicode Noncharacters - this is required if using a UTF8 MySQL db (full support requires utf8mb4)
 * Note : no real gain with global methods, but interesting with session
 */
// no cache : 0.15 0.3 0.08
//function emojis_to_html($input, $strip_nonchars = true, $skip_cache = true, $use_cache = false) {
// cache : 0.005 0.3 0.06 => gain 30 1 1.3
function emojis_to_html($input, $strip_nonchars = true, $skip_cache = false, $use_cache = true) {
	// Empty input does not contain emoji
	if (empty($input)) { return $input; }
	
	// Input can be an array: process it recursively
	if (is_array($input)) {
		// Speed : add session caching (useful only for strings with emojis)
		if ($use_cache) {
			// Nice speedup, but not very safe for scaling ?
			$key = md5(json_encode($input));
			if (isset($_SESSION['emojis_known'][$key])) {
				//error_log("using cached emojis for $key => $input");
				return $_SESSION['emojis_known'][$key];
			//} else {
			//	error_log("Creating new emojis cache key for array $key => $input");
			}
		}
		// Alternative optimisation traitement tableaux avec array_walk_recursive 
		// efficace (gain de près de 50%) mais ne traite pas les clefs
		//array_walk_recursive($input, 'emojis_to_html_callback');
		//return $input;
		$filtered_input = [];
		foreach($input as $k => $v) {
			// May also keys contain emojis?  why not?  so we need to filter them too
			//$input[$k] = emojis_to_html($v, $strip_nonchars);
			$k = emojis_to_html($k, $strip_nonchars);
			$filtered_input[$k] = emojis_to_html($v, $strip_nonchars, true);
		}
		//error_log("\n\nINPUT hook produced \"$return\" : $hook, $type, $input, $params => INPUT = " . print_r($input, true) . "\n\n --- filtered INPUT = " . print_r($filtered_input, true) . "\n\n");
		//return $input;
		
		// Keep computed value in session cache
		if (!$skip_cache) { $_SESSION['emojis_known'][$key] = $filtered_input; }
		return $filtered_input;
	}
	
	// Process any string (plain string or int)
	
	// Detect if string has any emoji before loading class to gain some performance?
	// Detect some standard bypass cases (ts with bypass 1.3, without 2.3)
	//if (is_int($input) || is_numeric($input) || !emojis_has_emojis($input)) { return $input; }
	//if (is_int($input) || is_numeric($input)) { return $input; }
	// Speed gain : from 0.0007 0.2 0.03 to 0.0015 0.2 0.04
	
	// Use cache only for strings with emojis
	if ($use_cache) {
		$key = md5(json_encode($input));
		if (isset($_SESSION['emojis_known'][$key])) {
			//error_log("using cached emojis for $key => $input");
			return $_SESSION['emojis_known'][$key];
		}
	}
	
	$filtered_input = $input;
	// Check string for emojis
	$emojis = Emoji\detect_emoji($input);
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
		//$filtered_input = str_replace($replace_map['emojis'], $replace_map['shortcodes'], $filtered_input);
		// Replace by HTML codepoint text
		$filtered_input = str_replace($replace_map['emojis'], $replace_map['html'], $filtered_input);
	}

	// Remove caracters that won't fit in a UTF-8 MySQL db (use UTF8MB4 to store actual Unicode data)
	// NOTE: you should not just strip, but replace with replacement character U+FFFD to avoid unicode attacks, mostly XSS: http://unicode.org/reports/tr36/#Deletion_of_Noncharacters
	if ($strip_nonchars) {
		$filtered_input = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $filtered_input);
	}
	
	// Keep computed value in session cache
	if (!$skip_cache) {
		//error_log("Creating new emojis cache key for $key => $filtered_input"); // debug
		$_SESSION['emojis_known'][$key] = $filtered_input;
	}
	
	return $filtered_input;
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



// HELPER FUNCTIONS

// Function used by array_walk_recursive
function emojis_to_html_callback(&$item, $key) {
	$item = emojis_to_html($item);
}

// Detect emojis
function emojis_has_emojis($str) {
	//preg_match( '/[\x{1F600}-\x{1F64F}]/u', $str, $matches_emo );
	//return !empty( $matches_emo[0] ) ? true : false;

	$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
	preg_match($regexEmoticons, $str, $matches_emo);
	if (!empty($matches_emo[0])) {
		return true;
	}

	// Match Miscellaneous Symbols and Pictographs
	$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
	preg_match($regexSymbols, $str, $matches_sym);
	if (!empty($matches_sym[0])) {
		return true;
	}

	// Match Transport And Map Symbols
	$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
	preg_match($regexTransport, $str, $matches_trans);
	if (!empty($matches_trans[0])) {
		return true;
	}

	// Match Miscellaneous Symbols
	$regexMisc = '/[\x{2600}-\x{26FF}]/u';
	preg_match($regexMisc, $str, $matches_misc);
	if (!empty($matches_misc[0])) {
		return true;
	}

	// Match Dingbats
	$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
	preg_match($regexDingbats, $str, $matches_bats);
	if (!empty($matches_bats[0])) {
		return true;
	}

	return false;
	
}

// Add colon padding for unicode emoji shortcodes
function emojis_to_text(&$text) { $text = ":$text:"; }

// Add HTML representation of codepoint
function emojis_to_html_codepoint(&$codepoint) { $codepoint = "&#x$codepoint;"; }

// Get replacement map for text emojis
// Note on output optimisation => session 0.07 vs static 0.17 vs global 0.17 (session faster by approx. 2.5)
function emojis_get_map() {
	if (isset($_SESSION['emojis_map'])) {
		return $_SESSION['emojis_map'];
	} else {
			$emojis_map = Emoji\_load_map();
			$emojis = array_keys($emojis_map);
			array_walk($emojis, 'emojis_to_html_codepoint');
			$text = array_values($emojis_map);
			array_walk($text, 'emojis_to_text');
			$_SESSION['emojis_map'] = [
				'emojis' => $emojis,
				'text' => $text,
			];
		return $_SESSION['emojis_map'];
	}
}


// OVERRIDES

/** Modified version for Emojis support
 * Replace urls, hash tags, and @'s by links
 * but not emojis !
 *
 * @param string $text The text of a post
 * @return string
 */
function emojis_thewire_filter($text) {
	$url = elgg_get_site_url();
	
	// Emojis : add padding on both sides
	// and requires space before any text transformation to link
	$text = ' ' . $text . ' ';
	// email addresses
	$text = preg_replace(
				//'/(^|[^\w])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i',
				'/(^|[^\w|\&])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i',
				'$1<a href="mailto:$2@$3">$2@$3</a>',
				$text);
	// links
	$text = parse_urls($text);
	// usernames
	$text = preg_replace(
				//'/(^|[^\w])@([\p{L}\p{Nd}._]+)/u',
				'/(^|[^\w|\&])@([\p{L}\p{Nd}._]+)/u',
				'$1<a href="' . $url . 'thewire/owner/$2">@$2</a>',
				$text);
	// so to avoid &#xXXXX being interpreted as hashtag (as it is a Unicode codepoint)
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


