<?php
/**
 * Add autocomplete support to an existing field
 * This view is meant to be added next to an existing input field, or to extend it
 * ESOPE : we add here 2 autocomplete modes to the default input/autocomplete view
 * - default autocomplete mod (same as default autocomplete view)
 * - direct autocomplete with a defined set of values
 * - custom autocomplete endpoint (because livesearch returns only user/group/site)
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['selector'] The wanted jQuery selector to add the autocomplete to
 * @uses $vars['id'] Alternate value for selector, based on id
 * @uses $vars['name'] Alternate value for selector, based on name (which all input/* views have)
 *
 * @uses $vars['autocomplete-data'] Array Selects mode 1 if defined, and defines the autocomplete list
 * @uses $vars['autocomplete-url'] String I mode 2, defines a custom endpoint
 */

// Define selector based on what we have
if (!empty($vars['selector'])) {
	$selector = $vars['selector'];
} else if (!empty($vars['id'])) {
	$selector = "#" . $vars['id'];
} else if (!empty($vars['name'])) {
	$selector = '"input[name=\'' . $vars['name'] . '\']"';
}

// Main JS lib - used by both main methods
elgg_load_js('jquery.ui.autocomplete.html');

if ($vars['autocomplete-data']) {
	// MODE 1 - Fixed list autocomplete
	// Autocomplete list looks like : [ "Custom", "Tag", "Auto", "Completion" ]
	echo '<script type="text/javascript">
	$(function() {
		var availableTags = [ "' . implode('", "', $vars['autocomplete-data']) . '" ];
		$(' . $selector . ').autocomplete({ source: availableTags });
	});
	</script>';
	
} else {
	// MODE 2 - Elgg's enriched autocomplete
	$params = array();
	if (isset($vars['match_on'])) {
		$params['match_on'] = $vars['match_on'];
		unset($vars['match_on']);
	}
	if (isset($vars['match_owner'])) {
		$params['match_owner'] = $vars['match_owner'];
		unset($vars['match_owner']);
	}
	
	$ac_url_params = http_build_query($params);
	elgg_load_js('elgg.autocomplete');
	
	if (!empty($vars['autocomplete-url'])) {
		// Add optional custom autocomplete endpoint
		$endpoint = $vars['autocomplete-url'];
	} else {
		// Use default endpoint
		$endpoint = 'livesearch';
	}
	
	echo '<script type="text/javascript">
		elgg.provide(\'elgg.autocomplete\');
		elgg.autocomplete.url = "' . elgg_get_site_url() . $endpoint . '?' . $ac_url_params . '";
		</script>';
}


