<?php
namespace Facyla;
/**
 * Class that handles Emojis
 */

class Emojis {
	const LONGEST_EMOJI = 8;
	
	private $map = false;
	private $regexp = false;
	private $emojis_map = false;
	private $cache = false;
	
	// Initialise attributes
	function __construct() {
		$this->map = $this->_load_map();
		$this->regexp = $this->_load_regexp();
		$this->emojis_map = $this->_load_emojis_map();
		$this->cache = $this->_load_cache();
	}
	
	
	// Find all the emoji in the input string
	public function detect_emoji($string) {
		$prevencoding = mb_internal_encoding();
		mb_internal_encoding('UTF-8');
		$data = array();

		//if(!isset($this->map)) $this->map = $this->_load_map();
		//if(!isset($this->regexp)) $this->regexp = $this->_load_regexp();

		if(preg_match_all($this->regexp, $string, $matches)) {
			foreach($matches[0] as $ch) {
				$points = array();
				for($i=0; $i<mb_strlen($ch); $i++) {
					$points[] = strtoupper(dechex($this->uniord(mb_substr($ch, $i, 1))));
				}
				$hexstr = implode('-', $points);

				if(array_key_exists($hexstr, $this->map)) { $short_name = $this->map[$hexstr]; } else { $short_name = null; }

				$skin_tone = null;
				$skin_tones = array(
					'1F3FB' => 'skin-tone-2',
					'1F3FC' => 'skin-tone-3',
					'1F3FD' => 'skin-tone-4',
					'1F3FE' => 'skin-tone-5',
					'1F3FF' => 'skin-tone-6',
				);
				foreach($points as $pt) {
					if(array_key_exists($pt, $skin_tones))
					  $skin_tone = $skin_tones[$pt];
				}

				$data[] = array(
					'emoji' => $ch,
					'short_name' => $short_name,
					'num_points' => mb_strlen($ch),
					'points_hex' => $points,
					'hex_str' => $hexstr,
					'skin_tone' => $skin_tone,
				);
			}
		}

		if($prevencoding) mb_internal_encoding($prevencoding);

		return $data;
	}

	// Detects a single emoji
	public function is_single_emoji($string) {
		$prevencoding = mb_internal_encoding();
		mb_internal_encoding('UTF-8');

		// If the string is longer than the longest emoji, it's not a single emoji
		if(mb_strlen($string) >= LONGEST_EMOJI) return false;
		$all_emoji = $this->detect_emoji($string);
		$emoji = false;

		// If there are more than one or none, return false immediately
		if(count($all_emoji) == 1) {
		  $emoji = $all_emoji[0];
		  // Check if there are any other characters in the string
		  // Remove the emoji found
		  $string = str_replace($emoji['emoji'], '', $string);
		  // If there are any characters left, then the string is not a single emoji
		  if(strlen($string) > 0) $emoji = false;
		}

		if($prevencoding) mb_internal_encoding($prevencoding);

		return $emoji;
	}

	// Load emoojis map
	/* Facyla : add caching
	 * Speed notes
	 * Global : no gain
	 * Gains : input / output / hooks
	 * _load_map : 0.003 / 0.2 / 0.05 with session, 0.05 / 0.2 / 0.05 without => gain 1.6 1 1
	 * _load_regexp : 0.003 / 0.2 / 0.05 with session, 0.05 / 0.2 / 0.05 without => gain 16.6 1 1
	 * None 0.05 / 0.2 / 0.5
	 * Both : 0.003 / 0.2 / 0.05
	 * None + No session in hook : 0.35 / 0.2 / 1.7
	 * Both + No session in hook : 0.05 / 0.2 / 0.05 => gain 7 / 1 / 34
	 */
	private function _load_map() {
		if ($this->map) return $this->map;
		if (isset($_SESSION['emojis_map'])) {
			$this->map = $_SESSION['emojis_map'];
		} else {
			$this->map = json_decode(file_get_contents(dirname(__FILE__).'/map.json'), true);
			$_SESSION['emojis_map'] = $this->map;
		}
		return $this->map;
	}
	
	// Load emojis regular expression
	private function _load_regexp() {
		if ($this->regexp) return $this->regexp;
		if (isset($_SESSION['emojis_regex'])) {
			$this->regexp = $_SESSION['emojis_regex']; 
		} else {
			$this->regexp = '/(?:' . json_decode(file_get_contents(dirname(__FILE__).'/regexp.json')) . ')/u';
			$_SESSION['emojis_regex'] = $this->regexp;
		}
		return $this->regexp;
	}
	
	// Load cache from session, if available
	private function _load_cache() {
		if ($this->cache) return $this->cache;
		if (isset($_SESSION['emojis_known'])) {
			$this->cache = $_SESSION['emojis_known'];
		} else {
			$this->cache = [];
		}
		return $this->cache;
	}

	private function uniord($c) {
		$ord0 = ord($c[0]); if ($ord0>=0   && $ord0<=127) return $ord0;
		$ord1 = ord($c[1]); if ($ord0>=192 && $ord0<=223) return ($ord0-192)*64 + ($ord1-128);
		$ord2 = ord($c[2]); if ($ord0>=224 && $ord0<=239) return ($ord0-224)*4096 + ($ord1-128)*64 + ($ord2-128);
		$ord3 = ord($c[3]); if ($ord0>=240 && $ord0<=247) return ($ord0-240)*262144 + ($ord1-128)*4096 + ($ord2-128)*64 + ($ord3-128);
		return false;
	}
	
	
	
	
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
	public function emojis_to_html($input, $strip_nonchars = true, $skip_cache = false, $use_cache = true) {
		// Empty input does not contain emoji
		if (empty($input)) { return $input; }
	
		// Input can be an array: process it recursively
		if (is_array($input)) {
			// Speed : add session caching (useful only for strings with emojis)
			if ($use_cache) {
				// Nice speedup, but not very safe for scaling ?
				$key = md5(json_encode($input));
				if (isset($this->cache[$key])) {
					//error_log("using cached emojis for $key => $input");
					return $this->cache[$key];
				//} else {
				//	error_log("Creating new emojis cache key for array $key => $input");
				}
			}
			// Alternative optimisation traitement tableaux avec array_walk_recursive 
			// efficace (gain de près de 50%) mais ne traite pas les clefs
			//array_walk_recursive($input, '$this->emojis_to_html_callback');
			//return $input;
			$filtered_input = [];
			foreach($input as $k => $v) {
				// May also keys contain emojis?  why not?  so we need to filter them too
				//$input[$k] = emojis_to_html($v, $strip_nonchars);
				$k = $this->emojis_to_html($k, $strip_nonchars);
				$filtered_input[$k] = $this->emojis_to_html($v, $strip_nonchars, true);
			}
			//error_log("\n\nINPUT hook produced \"$return\" : $hook, $type, $input, $params => INPUT = " . print_r($input, true) . "\n\n --- filtered INPUT = " . print_r($filtered_input, true) . "\n\n");
			//return $input;
		
			// Keep computed value in session cache
			if (!$skip_cache) {
				$this->cache[$key] = $filtered_input;
				$_SESSION['emojis_known'][$key] = $filtered_input;
			}
			return $filtered_input;
		}
	
		// Process any string (plain string or int)
	
		// Detect if string has any emoji before loading class to gain some performance?
		// Detect some standard bypass cases (ts with bypass 1.3, without 2.3)
		if (is_int($input) || is_numeric($input) || !$this->has_unicode_special_chars($input)) { return $input; }
		//if (is_int($input) || is_numeric($input)) { return $input; }
		// Speed gain : from 0.0007 0.2 0.03 to 0.0015 0.2 0.04
	
	
		// Use cache only for strings with emojis
		if ($use_cache) {
			$key = md5(json_encode($input));
			if (isset($this->cache[$key])) {
				//error_log("using cached emojis for $key => $input");
				return $this->cache[$key];
			}
		}
	
		$filtered_input = $input;
	
		// Check string for emojis
		$emojis = $this->detect_emoji($input);
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
	
		// Remaining plain strings
	
		// Remove caracters that won't fit in a UTF-8 MySQL db (use UTF8MB4 to store actual Unicode data)
		// NOTE: you should not just strip, but replace with replacement character U+FFFD to avoid unicode attacks, mostly XSS: http://unicode.org/reports/tr36/#Deletion_of_Noncharacters
		if ($strip_nonchars) {
			$filtered_input = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $filtered_input);
		}
	
		// Keep computed value in session cache
		if (!$skip_cache) {
			//error_log("Creating new emojis cache key for $key => $filtered_input"); // debug
			$this->cache[$key] = $filtered_input;
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
	// @TODO optimize for better perf!
	public function emojis_output_html($text, $replace_shortcodes = false) {
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
	private function emojis_to_html_callback(&$item, $key) {
		$item = $this->emojis_to_html($item);
	}

	// Detect emojis
	public function has_unicode_special_chars($str) {
		//preg_match( '/[\x{1F600}-\x{1F64F}]/u', $str, $matches_emo );
		//return !empty( $matches_emo[0] ) ? true : false;

		$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
		preg_match($regexEmoticons, $str, $matches_emo);
		if (!empty($matches_emo[0])) { return true; }

		// Match Miscellaneous Symbols and Pictographs
		$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
		preg_match($regexSymbols, $str, $matches_sym);
		if (!empty($matches_sym[0])) { return true; }

		// Match Transport And Map Symbols
		$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
		preg_match($regexTransport, $str, $matches_trans);
		if (!empty($matches_trans[0])) {
			return true;
		}

		// Match Miscellaneous Symbols
		$regexMisc = '/[\x{2600}-\x{26FF}]/u';
		preg_match($regexMisc, $str, $matches_misc);
		if (!empty($matches_misc[0])) { return true; }

		// Match Dingbats
		$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
		preg_match($regexDingbats, $str, $matches_bats);
		if (!empty($matches_bats[0])) { return true; }
	
		// Non-characters
		$regexNonChars = '/[\x{10000}-\x{10FFFF}]/u';
		preg_match($regexNonChars, $str, $matches_bats);
		if (!empty($matches_bats[0])) { return true; }
		
		return false;
	}

	// Get replacement map for text emojis
	// Note on output optimisation => session 0.07 vs static 0.17 vs global 0.17 (session faster by approx. 2.5)
	private function _load_emojis_map() {
		if ($this->emojis_map) return $this->emojis_map;
		if (isset($_SESSION['emojis_emojis_map'])) {
			$this->emojis_map = $_SESSION['emojis_emojis_map'];
		} else {
			$emojis = array_keys($this->map);
			$text = array_values($this->map);
			array_walk($emojis, 'emojis_to_html_codepoint');
			array_walk($text, 'emojis_to_text');
			$this->emojis_map = [
				'emojis' => $emojis,
				'text' => $text,
			];
		}
		return $this->emojis_map;
	}
	
	// Add colon padding for unicode emoji shortcodes (by reference)
	public function emojis_to_text(&$text) { $text = ":$text:"; }

	// Add HTML representation of codepoint (by reference)
	public function emojis_to_html_codepoint(&$codepoint) { $codepoint = "&#x$codepoint;"; }
	
	
}

