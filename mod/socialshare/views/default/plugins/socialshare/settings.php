<?php
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array_reverse($yes_no_opt);

$providers = array('email' => 'Email', 'twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google+', 'pinterest' => 'Pinterest', 'facebook' => 'Facebook');

// Defaults
if (!isset($vars['entity']->extend_entity)) { $vars['entity']->extend_entity = 'yes'; }
if (!isset($vars['entity']->extend_owner_block)) { $vars['entity']->extend_owner_block = 'no'; }

echo '<p><label>' . elgg_echo('socialshare:extend_entity') . ' ' . elgg_view('input/dropdown', array('name' => 'params[extend_entity]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->extend_entity)) . '</label><br /><em>' . elgg_echo('socialshare:extend_entity:details') . '</em></p>';

echo '<p><label>' . elgg_echo('socialshare:extend_owner_block') . ' ' . elgg_view('input/dropdown', array('name' => 'params[extend_owner_block]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->extend_owner_block)) . '</label><br /><em>' . elgg_echo('socialshare:extend_owner_block:details') . '</em></p>';

/*
echo '<p><label>' . elgg_echo('socialshare:extendviews') . '</label><br />';
echo elgg_echo('socialshare:extendviews:help');
echo elgg_view('input/plaintext', array( 'name' => 'params[extendviews]', 'value' => $vars['entity']->extendviews, 'js' => ' style="min-height:300px;"' )) . '</p>';
*/
echo '<fieldset><legend>' . elgg_echo('socialshare:providers'). '</legend>';
	// Select which sharing links we should enable
	foreach ($providers as $key => $name) {
		// Add provider only if activated
		echo '<p><label>' . $name . ' ' . elgg_view('input/dropdown', array( 'name' => 'params['.$key.'_enable]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->{$key.'_enable'} )) . '</label></p>';
	}
echo '</fieldset>';

