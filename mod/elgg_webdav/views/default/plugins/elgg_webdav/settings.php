<?php
$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));



/* @TODO 
- enable main server Elgg Files : virtual
- enable main server for Elgg Files : public
- enable pure WebDAV server : public
- enable pure WebDAV server : private (user)
- enable pure WebDAV server : groups
- enable pure WebDAV server : members
- enable pure WebDAV server : ...?

// Set default value
if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name == 'default'; }


// Example yes/no setting
echo '<p><label>Test select setting "setting_name"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->setting_name)) . '</p>';
*/

//echo '<p><label>SETTING... ' . elgg_view('input/text', array('name' => 'params[special_groups]', 'value' => $vars['entity']->special_groups)) . '</label></p>';



