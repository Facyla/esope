<?php
/**
 * All helper functions are bundled here
 */

/**
 * Translate some default Elgg icon names to the FontAwesome version
 *
 * @param string $icon_name the Elgg icon name
 *
 * @return string
 */
function fontawesome_translate_icon($icon_name) {
	
	static $translated_icons = array(
		"arrow-two-head" => "arrows-h",
		"attention" => "exclamation-triangle",
		"cell-phone" => "mobile",
		"checkmark" => "check",
		"clip" => "paperclip",
		"cursor-drag-arrow" => "arrows",
		"drag-arrow" => "arrows", // admin sprite
		"delete-alt" => "times-circle",
		"delete" => "times",
		"facebook" => "facebook-square",
		"grid" => "th",
		"hover-menu" => "caret-down",
		"info" => "info-circle",
		"lock-closed" => "lock",
		"lock-open" => "unlock",
		"mail" => "envelope-o",
		"mail-alt" => "envelope",
		"print-alt" => "print fa-hover",
		"push-pin" => "thumb-tack",
		"push-pin-alt" => "thumb-tack fa-hover",
		"redo" => "share",
		"round-arrow-left" => "arrow-circle-left",
		"round-arrow-right" => "arrow-circle-right",
		"round-checkmark" => "check-circle",
		"round-minus" => "minus-circle",
		"round-plus" => "plus-circle",
		"rss" => "rss-square",
		"search-focus" => "search fa-hover",
		"settings" => "wrench",
		"settings-alt" => "cog",
		"share" => "share-alt-square",
		"shop-cart" => "shopping-cart",
		"speech-bubble" => "comment",
		"speech-bubble-alt" => "comments",
		"star-alt" => "star fa-hover",
		"star-empty" => "star-o",
		"thumbs-down-alt" => "thumbs-down fa-hover",
		"thumbs-up-alt" => "thumbs-up fa-hover",
		"trash" => "trash-o",
		"twitter" => "twitter-square",
		"undo" => "reply",
		"video" => "film",
	);
	
	if (isset($translated_icons[$icon_name])) {
		$icon_name = $translated_icons[$icon_name];
	}
	
	return $icon_name;
}

/**
 * Return the url to the FontAwesome CSS
 *
 * @param bool $realpath return the file location
 *
 * @return false|string
 */
function fontawesome_get_css_location($realpath = false) {
	$realpath = (bool) $realpath;

	$externals = elgg_get_config('externals_map');
	if (empty($externals) || !is_array($externals)) {
		return false;
	}
	$css = elgg_extract('css', $externals);
	if (empty($css) || !is_array($css)) {
		return false;
	}
	$fa = elgg_extract('fontawesome', $css);
	if (empty($fa)) {
		return false;
	}

	$result = elgg_normalize_url($fa->url);

	if ($realpath) {
		$result = str_ireplace(elgg_get_site_url(), elgg_get_root_path(), $result);
	}

	return $result;
}

/**
 * Get all the icon from the CSS file
 *
 * @return false|array
 */
function fontawesome_get_icon_array() {

	$path = fontawesome_get_css_location(true);
	if (empty($path)) {
		return false;
	}

	$contents = file_get_contents($path);
	if (empty($contents)) {
		return false;
	}

	$icons = array();
	$hex_codes = array();

	/**
	 * Get all CSS selectors that have a "content:" pseudo-element rule,
	 * as well as all associated hex codes.
	*/
	preg_match_all( '/\.(icon-|fa-)([^,}]*)\s*:before\s*{\s*(content:)\s*"(\\\\[^"]+)"/s', $contents, $matches);
	$icons = $matches[2];
	$hex_codes = $matches[4];

	$icons = array_combine( $hex_codes, $icons );

	// sort array
	natcasesort($icons);

	return $icons;
}
