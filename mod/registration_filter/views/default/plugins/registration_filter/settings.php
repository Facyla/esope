<?php
// Dropdown values
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));

// Defaults
if (!isset($vars['entity']->extend_registration_form)) { $vars['entity']->extend_registration_form = 'yes'; }
if (!isset($vars['entity']->whitelist_enable)) { $vars['entity']->whitelist_enable = 'yes'; }
if (strlen($vars['entity']->whitelist) == 0) { $vars['entity']->whitelist = elgg_echo('registration_filter:whitelist:default'); } // Default valid domain list
if (!isset($vars['entity']->blacklist_enable)) { $vars['entity']->blacklist_enable = 'no'; }


// Note : only one of the modes should be chosen : if whitelist enable, blacklist is not useful
echo '<p><em>' . elgg_echo('registration_filter:modes') . '</em></p>';

echo '<fieldset>';
	// Enable whitelist : only matching domains are allowed
	echo '<p><label>' . elgg_echo('registration_filter:whitelist_enable') . ' ' . elgg_view('input/select', array('name' => 'params[whitelist_enable]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->whitelist_enable)) . '</label><br /><em>' . elgg_echo('registration_filter:whitelist_enable:details') . '</em></p>';

	// Whitelist options
	if ($vars['entity']->whitelist_enable == 'yes') {
		// Extend registration form ?
		echo '<p><label>' . elgg_echo('registration_filter:extend_registration_form') . ' ' . elgg_view('input/select', array('name' => 'params[extend_registration_form]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->extend_registration_form)) . '</label><br /><em>' . elgg_echo('registration_filter:extend_registration_form:details') . '</em></p>';

		// Whitelist domains
		// un nom de domaine par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
		echo '<p><label>' . elgg_echo('registration_filter:whitelist') . ' ' . elgg_view('input/plaintext', array('name' => 'params[whitelist]', 'value' => $vars['entity']->whitelist )) . '</label><br /><em>' . elgg_echo('registration_filter:whitelist:details') . '</em></p>';
	}
echo '</fieldset>';


echo '<fieldset>';
	// Enable blacklist : matching domains are always forbidden
	echo '<p><label>' . elgg_echo('registration_filter:blacklist_enable') . ' ' . elgg_view('input/select', array('name' => 'params[blacklist_enable]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->blacklist_enable)) . '</label><br /><em>' . elgg_echo('registration_filter:blacklist_enable:details') . '</em></p>';

	// Blacklist domains
	if ($vars['entity']->blacklist_enable == 'yes') {
		// un nom de domaine par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
		echo '<p><label>' . elgg_echo('registration_filter:blacklist') . ' ' . elgg_view('input/plaintext', array('name' => 'params[blacklist]', 'value' => $vars['entity']->blacklist )) . '</label><br /><em>' . elgg_echo('registration_filter:blacklist:details') . '</em></p>';
	}
echo '</fieldset>';


