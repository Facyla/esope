<?php
// EMOJI SUPPORT
// 👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤


// HOOKS

// Input text filter, used to validate text content, extract data, replace strings, etc.
// Note : Wire input uses a custom getter
function emojis_input_hook($hook, $type, $input, $params) {
	//$return = emojis_to_html($input, true); // debug
	//error_log("INPUT hook produced \"$return\" : $hook, $type, $input, $params => INPUT = " . print_r($input, true) . "  --- PARAMS = " . print_r($params, true)); // debug
	//return $return; // debug
	return emojis_to_html($input, true);

}

/* Output hook : prepare emoji for display
 */
function emojis_output_hook($hook, $type, $text, $params) {
	return emojis_output_html($text, true);
}


/* Unicode Emojis detection and replacement by HTML codepoints
 * Note : emojis are not detected if they are the last caracter: 
 *        add a 1 space padding at the end so we can use proper detection
 * $input (string) Input text to be converted
 * $strip_nonchars (bool) Remove Unicode Noncharacters - this is required if using a UTF8 MySQL db (full support requires utf8mb4)
 */
function emojis_to_html($input, $strip_nonchars = true) {
	
	// Empty input does not contain emoji
	if (empty($input)) { return $input; }
	
	// Input can be an array: process it recursively
	if (is_array($input)) {
		$filtered_input = [];
		foreach($input as $k => $v) {
			// May also keys be stored with emojis?  why not?  so we need to filter them too
			//$input[$k] = emojis_to_html($v, $strip_nonchars);
			$k = emojis_to_html($k, $strip_nonchars);
			$v = emojis_to_html($v, $strip_nonchars);
			$filtered_input[$k] = $v;
		}
		//error_log("\n\nINPUT hook produced \"$return\" : $hook, $type, $input, $params => INPUT = " . print_r($input, true) . "\n\n --- filtered INPUT = " . print_r($filtered_input, true) . "\n\n");
		return $filtered_input;
	}
	
	// Regular input (plain string)
	$emojis = Emoji\detect_emoji($input);
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


// OVERRIDES

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


