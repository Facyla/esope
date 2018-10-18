<?php
/* Helpers and other Inria specific functions
 * 
 */


// Temporary LOGIN / LOGOUT to enable viewing content as someone else (only a part of a page)
/*
// @TODO : requires new method to work using Elgg 1.12 API - see login as for possible hints

// These functions are used for temporary changing the current user 
// This lets view one's page as someone else
function theme_inria_temp_login($user) {
#	$_SESSION['user'] = $user;
#	$_SESSION['guid'] = $user->guid;
#	$_SESSION['id'] = $user->guid;
#	$_SESSION['username'] = $user->username;
#	$_SESSION['name'] = $user->name;
#	$_SESSION['code'] = $user->code;
#	$_SESSION['user']->save();

	$session = elgg_get_session();
	$session->set('user', $user);
	$session->set('guid', $user->guid);
	$session->set('id', $user->id);
	$session->set('username', $user->username);
	$session->set('name', $user->name);
	$session->set('code', $user->code);
	$session->save();
	session_regenerate_id();
	return true;
}
function theme_inria_temp_logout() {
	$session = elgg_get_session();
	$session->set('code', '');
	$session->save();
	$session->remove('user');
	$session->remove('guid');
	$session->remove('id');
	$session->remove('username');
	$session->remove('name');
	$session->remove('code');

#	$_SESSION['user']->code = "";
#	$_SESSION['user']->save();
#	unset($_SESSION['user']);
#	unset($_SESSION['guid']);
#	unset($_SESSION['id']);
#	unset($_SESSION['username']);
#	unset($_SESSION['name']);
#	unset($_SESSION['code']);

	session_destroy();
	_elgg_session_boot(NULL, NULL, NULL);
	return true;
}
*/


// LDAP
// Conversion des codes de localisation en un nom compréhensible
function theme_inria_ldap_convert_locality($codes) {
	$result = ldap_get_search_infos('objectClass=locality', ldap_auth_settings_info(), array('*'));
	if ($result) {
		// Create localities map
		foreach($result as $num => $locality) {
			$code = $locality['l'][0];
			$locality_table[$code] = $locality['description'][0];
		}
		// Find human-readable localities
		foreach($codes as $code) { $localities[] = $locality_table[strtoupper($code)]; }
		return $localities;
	} else { return false; }
}


// Détermine le niveau d'accès par défaut dans un groupe
function theme_inria_group_default_access($group) {
	if (!elgg_instanceof($group, 'group')) { return false; }
	
	// Determine default access
	// Define default group content access method
	if ($group->membership == 2) {
		$defaultaccess = elgg_get_plugin_setting('opengroups_defaultaccess', 'esope');
		if (empty($defaultaccess)) { $defaultaccess = 'groupvis'; }
	} else {
		$defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'esope');
		if (empty($defaultaccess)) { $defaultaccess = 'group'; }
	}
	// If access policy says group only, always default to group acl (or whatever esope settings says)
	if ($group->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY) {
		$defaultaccess = elgg_get_plugin_setting('closedgroups_defaultaccess', 'esope');
		if (empty($defaultaccess)) { $defaultaccess = 'group'; }
	}
	
	return $defaultaccess;
}

// Détermine la valeur du niveau d'accès par défaut dans un groupe
function theme_inria_group_default_access_value($group) {
	if (!elgg_instanceof($group, 'group')) { return false; }
	
	// Determine default access
	$defaultaccess = theme_inria_group_default_access($group);
	switch($defaultaccess) {
		case 'group': $default_access_value = $group->group_acl; break;
		case 'groupvis': $default_access_value = $group->access_id; break;
		case 'members': $default_access_value = 1; break;
		case 'public': $default_access_value = 2; break;
		case 'default':
			// Do not set (let original check do it) $vars['value'] = get_default_access();
			break;
		default: $default_access_value = $group->group_acl;
	}
	return $default_access_value;
}




// EMOJI SUPPORT
if (!elgg_is_active_plugin('emojis')) {
	// 👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤
	// Input text filter, used to validate text content, extract data, replace strings, etc.
	// Note : Wire input uses a custom getter
	function theme_inria_emoji_input($hook, $type, $input, $params) {
		return theme_inria_emoji_to_html($input);
	}
	/* Unicode Emojis detection and replacement by HTML codepoints
	 * Note : emojis are not detected if they are the last caracter: 
	 *        add a 1 space padding at the end so we can use proper detection
	 * $input (string) Input text to be converted
	 * $strip_nonchars (bool) Remove Unicode Noncharacters - this is required if using a UTF8 MySQL db (full support requires utf8mb4)
	 */
	function theme_inria_emoji_to_html($input, $strip_nonchars = true) {
		$emojis = Emoji\detect_emoji($input);
		$map = Emoji\_load_map();
		if (count($emojis) > 0) {
			error_log("EMOJI detected : " . count($emojis));
			foreach($emojis as $emoji) {
				$replace_map['emojis'][] = $emoji['emoji'];
				$replace_map['shortcodes'][] = ':' . $emoji['short_name'] . ':';
				//$replace_map['html'][] = '&#x' . $emoji['hex_str'];
				$replace_map['html'][] = '&#x' . str_replace('-', ';&#x', $emoji['hex_str']) . ';';
				error_log('&#x' . str_replace('-', ';&#x', $emoji['hex_str']) . ';');
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
		$input = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $input);
	
		return $input;
	}
	// Add colon padding for unicode emoji shortcodes
	function theme_inria_emoji_pad(&$text) { $text = ":$text:"; }
	// Add HTML representation of codepoint
	function theme_inria_emoji_html_codepoint(&$codepoint) { $codepoint = "&#x$codepoint;"; }
	// Get replacement map for text emojis
	function theme_inria_emoji_get_map() {
		static $replace_map = 1;
		if (!is_array($replace_map)) {
			$emojis_map = Emoji\_load_map();
			$emojis = array_keys($emojis_map);
			array_walk($emojis, 'theme_inria_emoji_html_codepoint');
			$text = array_values($emojis_map);
			array_walk($text, 'theme_inria_emoji_pad');
			$replace_map = [
				'emojis' => $emojis,
				'text' => $text,
			];
		}
		return $replace_map;
	}
	/* Prepare emoji for display
	 * replace emoji text value with emoji
	 * or make HTML codepoint viewable
	 */
	function theme_inria_emoji_output($hook, $type, $text, $params) {
		$replace_map = theme_inria_emoji_get_map();
		// Unescape HTML emojis codepoints
		$text = str_replace('&amp;#x', '&#x', $text);
		// Convert :emoji: shortcodes to emojis
		$text = str_replace($replace_map['text'], $replace_map['emojis'], $text);
		return $text;
	}

	/** Modified version for Emojis support
	 * Replace urls, hash tags, and @'s by links
	 *
	 * @param string $text The text of a post
	 * @return string
	 */
	function theme_inria_thewire_filter($text) {
		$url = elgg_get_site_url();
		$text = ' ' . $text;
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
		// Iris : hashtags => avoid &#xXXXX being interpreted as hashtag (as it is a Unicode codepoint)
		$text = preg_replace(
					//'/(^|[^\w])#(\w*[^\s\d!-\/:-@]+\w*)/',
					'/(^|[^\w|\&])#(\w*[^\s\d!-\/:-@]+\w*)/',
					'$1<a href="' . $url . 'thewire/tag/$2">#$2</a>',
					$text);
		$text = trim($text);
		return $text;
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
}





