<?php

/**
 * Functions for the language selector
 */

/**
 * Returns the translations that are allowed to be used
 * 
 * @return array
 */
function language_selector_get_allowed_translations() {
	
	$configured_allowed = elgg_get_plugin_setting("allowed_languages", "language_selector");
	
	if (empty($configured_allowed)) {
		$allowed = array("en");
		
		$installed_languages = get_installed_translations();
	
		$min_completeness = (int) elgg_get_plugin_setting("min_completeness", "language_selector");
		
		if ($min_completeness > 0) {
			if (elgg_is_active_plugin("translation_editor")) {
				$completeness_function = "translation_editor_get_language_completeness";
			} else {
				$completeness_function = "get_language_completeness";
			}
			
			foreach ($installed_languages as $lang_id => $lang_description) {
	
				if ($lang_id != "en") {
					if (($completeness = $completeness_function($lang_id)) >= $min_completeness) {
						$allowed[] = $lang_id;
					}
				}
			}
		}
		
		elgg_set_plugin_setting("allowed_languages", implode(",", $allowed), "language_selector");
		
	} else {
		$allowed = string_to_tag_array($configured_allowed);
	}

	return $allowed;
}

/**
 * Sets the language for the logged out user
 *
 * @return void
 */
function language_selector_set_logged_out_user_language() {
	global $CONFIG;
	
	if (elgg_is_logged_in()) {
		return;
	}

	if (!empty($_COOKIE['client_language'])) {
		// switched with language selector
		$new_lang = $_COOKIE['client_language'];
	} else {

		$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

		if (!empty($browserlang)) {
			// autodetect language

			if (elgg_get_plugin_setting("autodetect", "language_selector") == "yes") {
				$new_lang = $browserlang;
			}
		}
	}

	if (!empty($new_lang) && ($new_lang !== $CONFIG->language)) {
		$allowed = language_selector_get_allowed_translations();
		if (in_array($new_lang, $allowed)) {
			// set new language
			$CONFIG->language = $new_lang;

			// language has been change; reload language keys
			if (elgg_is_active_plugin("translation_editor")) {
				translation_editor_load_translations();
			} else {
				reload_all_translations();
			}
		}
	}
}

/**
 * Unset the plugin setting so it will be reset when used the next time
 *
 * @return void
 */
function language_selector_invalidate_setting() {
	elgg_unset_plugin_setting("allowed_languages", "language_selector");
}
