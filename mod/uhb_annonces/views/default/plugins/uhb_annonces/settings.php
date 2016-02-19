<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('uhb_annonces:option:yes'), 'no' => elgg_echo('uhb_annonces:option:no'));
$no_yes_opt = array('no' => elgg_echo('uhb_annonces:option:no'), 'yes' => elgg_echo('uhb_annonces:option:yes'));


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name == 'default'; }


// Example text setting
//echo '<h3><label>Text setting "setting_name2"</label> ' . elgg_view('input/text', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</h3>';

echo '<p><label>' . elgg_echo("uhb_annonces:settings:contact_email") . elgg_view('input/text', array('name' => 'params[contact_email]', 'value' => $vars['entity']->contact_email)) . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:contact_email:help") . '</em></p>';

echo '<p><label>' . elgg_echo("uhb_annonces:settings:adminlist") . elgg_view('input/plaintext', array('name' => 'params[adminlist]', 'value' => $vars['entity']->adminlist)) . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:adminlist:help") . '</em></p>';

echo '<p><label>' . elgg_echo("uhb_annonces:settings:whitelist") . elgg_view('input/text', array('name' => 'params[whitelist]', 'value' => $vars['entity']->whitelist)) . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:whitelist:help") . '</em></p>';

echo '<p><label>' . elgg_echo("uhb_annonces:settings:candidate_whitelist") . elgg_view('input/text', array('name' => 'params[candidate_whitelist]', 'value' => $vars['entity']->candidate_whitelist)) . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:candidate_whitelist:help") . '</em></p>';

echo '<p><label>' . elgg_echo("uhb_annonces:settings:ipallowed") . elgg_view('input/plaintext', array('name' => 'params[ipallowed]', 'value' => $vars['entity']->ipallowed)) . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:ipallowed:help") . '</em></p>';

echo '<p><label>' . elgg_echo("uhb_annonces:settings:maxcount") . '<input type="number" step="10", min="10", maxlength="5" name="params[max_count]" value="' . $vars['entity']->max_count . '" />' . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:maxcount:help") . '</em></p>';
// Set default
if (!isset($vars['entity']->max_count)) $vars['entity']->max_count = 50;

echo '<p><label>' . elgg_echo("uhb_annonces:settings:maxcountadmin") . '<input type="number" step="10", min="10", maxlength="5" name="params[max_count_admin]" value="' . $vars['entity']->max_count_admin . '" />' . '</label><br /><em>' . elgg_echo("uhb_annonces:settings:maxcountadmin:help") . '</em></p>';
// Set default
if (!isset($vars['entity']->max_count_admin)) $vars['entity']->max_count_admin = 100;


echo '<br />';


/*
echo "<h3>Mails de notification ?</h3>";
*/

// Fields values
echo '<fieldset><legend>' . elgg_echo('uhb_annonces:settings:fieldsvalues') . '</legend>';
echo '<p><em>' . elgg_echo("uhb_annonces:settings:fieldsvalues:help") . '</em></p>';
$dropdown_fields = array('typeoffer', 'typework', 'structurelegalstatus', 'structureworkforce', 'worktime', 'profileformation', 'profilelevel');
foreach($dropdown_fields as $name) {
	// Default to plugin default settings
	if (empty($vars['entity']->$name)) { $vars['entity']->$name = elgg_echo("uhb_annonces:$name:values"); }
	echo '<p><label>' . elgg_echo("uhb_annonces:object:$name") . ' (' . $name . ') ' . elgg_view('input/text', array('name' => "params[$name]", 'value' => $vars['entity']->$name)) . '</label></p>';
}
echo '</fieldset>';



// Search fields values
echo '<fieldset><legend>' . elgg_echo('uhb_annonces:settings:searchfieldsvalues') . '</legend>';
echo '<p><em>' . elgg_echo("uhb_annonces:settings:searchfieldsvalues:help") . '</em></p>';
foreach($dropdown_fields as $name) {
	// Default to same as edit
	if (empty($vars['entity']->{'search_'.$name})) { $vars['entity']->{'search_'.$name} = $vars['entity']->$name; }
	echo '<p><label>' . elgg_echo("uhb_annonces:object:$name") . ' (' . $name . ') ' . elgg_view('input/text', array('name' => "params[search_$name]", 'value' => $vars['entity']->{'search_'.$name})) . '</label></p>';
}
echo '</fieldset>';



// Tech settings
// Set manually memory limit for the search script - use only if no access to .htaccess main file
echo '<p><label>' . elgg_echo('uhb_annonces:settings:memorylimit') . '</label> ' . elgg_view('input/text', array('name' => "params[memory_limit]", 'value' => $vars['entity']->memory_limit)) . '<br /><em>' . elgg_echo('uhb_annonces:settings:memorylimit:details') . '</em></p>';
// '<input type="number" step="64", min="0", maxlength="5" name="params[memory_limit]" value="' . $vars['entity']->memory_limit . '" />' . '</label></p>';

// Debug mode - may be useful for testing purposes
echo '<p><label>' . elgg_echo('uhb_annonces:settings:debugmode') . '</label> ' . elgg_view('input/dropdown', array('name' => 'params[debug_mode]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->debug_mode)) . '<br /><em>' . elgg_echo('uhb_annonces:settings:debugmode:details') . '</em></p>';



