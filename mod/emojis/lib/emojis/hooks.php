<?php
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


