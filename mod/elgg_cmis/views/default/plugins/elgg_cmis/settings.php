<?php
/**
 * Elgg CMIS authentication settings
 * Enable user mode / site mode
 * Set CMIS server settings
 * Set credentials for site mode
 * Enable widgets
 */

$plugin = $vars['entity'];
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));
$yn_opt = array_reverse($ny_opt);
$vendors_opt = array('php-cmis-client' => 'PHP CMIS Client (dkd)', 'chemistry-phpclient' => 'CMIS PHP Client (Apache Chemistry)');

// Default required settings
//if (empty($plugin->cmis_url)) $plugin->cmis_url = '';
if (empty($plugin->cmis_soap_url)) { $plugin->cmis_soap_url = 'cmisws/RepositoryService'; }
if (empty($plugin->cmis_atom_url)) { $plugin->cmis_atom_url = 'cmisatom'; }
if (empty($plugin->cmis_1_0_atompub)) { $plugin->cmis_1_0_atompub = 'api/-default-/public/cmis/versions/1.0/atom'; }
if (empty($plugin->cmis_1_0_wsdl)) { $plugin->cmis_1_0_wsdl = 'cmisws/cmis?wsdl'; }
if (empty($plugin->cmis_1_1_atompub)) { $plugin->cmis_1_1_atompub = 'api/-default-/public/cmis/versions/1.1/atom'; }
if (empty($plugin->cmis_1_1_browser_binding)) { $plugin->cmis_1_1_browser_binding = 'api/-default-/public/cmis/versions/1.1/browser'; }



// Select vendor library
echo '<p><label>' . elgg_echo('elgg_cmis:settings:vendor') . elgg_view('input/select', array('name' => 'params[vendor]', 'options_values' => $vendors_opt, 'value' => $plugin->vendor)) . '</label><br /><em>' . elgg_echo('elgg_cmis:settings:vendor:details') . '</em></p>';

// Enable site mode (requires only site settings)
echo '<p><label>' . elgg_echo('elgg_cmis:settings:backend') . elgg_view('input/select', array('name' => 'params[backend]', 'options_values' => $ny_opt, 'value' => $plugin->backend)) . '</label><br /><em>' . elgg_echo('elgg_cmis:settings:backend:details') . '</em></p>';

// Enable user mode (site settings + additional use of user settings for credentials)
echo '<p><label>' . elgg_echo('elgg_cmis:settings:usercmis') . elgg_view('input/select', array('name' => 'params[usercmis]', 'options_values' => $ny_opt, 'value' => $plugin->usercmis)) . '</label><br /><em>' . elgg_echo('elgg_cmis:settings:usercmis:details') . '</em></p>';

// @TODO enable also an object mode (where config is stored in object) ?

// Debug mode
echo '<p><label>' . elgg_echo('elgg_cmis:debugmode') . elgg_view('input/select', array('name' => 'params[debugmode]', 'options_values' => $ny_opt, 'value' => $plugin->debugmode)) . '</label></p>';



// Site settings OR default user settings
if (($plugin->backend == 'yes') || $plugin->usercmis == 'yes') {
	echo '<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">';
		echo '<legend>' . elgg_echo('elgg_cmis:title') . '</legend>';
	
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_url') . elgg_view('input/text', array('name' => 'params[cmis_url]', 'value' => $plugin->cmis_url, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_url:details') . '</em></p>';
		
		// Old settings (for Chemistry lib / user mode only)
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_soap_url') . elgg_view('input/text', array('name' => 'params[cmis_soap_url]', 'value' => $plugin->cmis_soap_url, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_soap_url:details') . '</em></p>';
	
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_atom_url') . elgg_view('input/text', array('name' => 'params[cmis_atom_url]', 'value' => $plugin->cmis_atom_url, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_atom_url:details') . '</em></p>';
		
		// Standard Alfresco endpoints
		/* Not used (yet)
		// CMIS 1.0 AtomPub Service Document - eg. api/-default-/public/cmis/versions/1.0/atom
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_1_0_atompub') . elgg_view('input/text', array('name' => 'params[cmis_1_0_atompub]', 'value' => $plugin->cmis_1_0_atompub, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_1_0_atompub:details') . '</em></p>';
	
		// CMIS 1.0 Web Services WSDL Document - eg. cmisws/cmis?wsdl
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_1_0_wsdl') . elgg_view('input/text', array('name' => 'params[cmis_1_0_wsdl]', 'value' => $plugin->cmis_1_0_wsdl, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_1_0_wsdl:details') . '</em></p>';
	
		// CMIS 1.1 AtomPub Service Document - eg api/-default-/public/cmis/versions/1.1/atom
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_1_1_atompub') . elgg_view('input/text', array('name' => 'params[cmis_1_1_atompub]', 'value' => $plugin->cmis_1_1_atompub, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_1_1_atompub:details') . '</em></p>';
		*/
		
		// CMIS 1.1 Browser Binding URL - api/-default-/public/cmis/versions/1.1/browser
echo '<p><label>' . elgg_echo('elgg_cmis:cmis_1_1_browser_binding') . elgg_view('input/text', array('name' => 'params[cmis_1_1_browser_binding]', 'value' => $plugin->cmis_1_1_browser_binding, 'style ' => 'max-width:30em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:cmis_1_1_browser_binding:details') . '</em></p>';
	
	echo '</fieldset><br />';
}


// Backend mode specific settings
if ($plugin->backend == 'yes') {
	echo '<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">';
		echo '<legend>' . elgg_echo('elgg_cmis:settings:backend:legend') . '</legend>';
		
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_login') . elgg_view('input/text', array('name' => 'params[cmis_username]', 'value' => $plugin->cmis_username, 'style ' => 'max-width:12em;')) . '</label></p>';
		
		echo '<p><label>' . elgg_echo('elgg_cmis:cmis_password') . elgg_view('input/text', array('name' => 'params[cmis_password]', 'value' => $plugin->cmis_password, 'style ' => 'max-width:12em;')) . '</label></p>'; 
		
		echo '<p><label>' . elgg_echo('elgg_cmis:settings:filestore_path') . elgg_view('input/text', array('name' => 'params[filestore_path]', 'value' => $plugin->filestore_path, 'style ' => 'max-width:20em;')) . '</label><br /><em>' . elgg_echo('elgg_cmis:settings:filestore_path:details') . '</em></p>';
		
		echo '<p><label>' . elgg_echo('elgg_cmis:settings:always_use_elggfilestore') . elgg_view('input/select', array('name' => 'params[always_use_elggfilestore]', 'options_values' => $yn_opt, 'value' => $plugin->always_use_elggfilestore)) . '</label></p>';
		
		echo '</fieldset><br />';
}


// User mode specific settings - Enabled widgets
if ($plugin->usercmis == 'yes') {
	?>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cmis:settings:usercmis:legend'); ?></legend>
		<p><strong><?php echo elgg_echo('elgg_cmis:widgets'); ?></strong></p>
	
		<?php
		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_mine');
		echo elgg_view('input/select', array('name' => 'params[widget_mine]', 'options_values' => $ny_opt, 'value' => $plugin->widget_mine )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis');
		echo elgg_view('input/select', array('name' => 'params[widget_cmis]', 'options_values' => $ny_opt, 'value' => $plugin->widget_cmis )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_folder');
		echo elgg_view('input/select', array('name' => 'params[widget_folder]', 'options_values' => $ny_opt, 'value' => $plugin->widget_folder )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_search');
		echo elgg_view('input/select', array('name' => 'params[widget_search]', 'options_values' => $ny_opt, 'value' => $plugin->widget_search )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_insearch');
		echo elgg_view('input/select', array('name' => 'params[widget_insearch]', 'options_values' => $ny_opt, 'value' => $plugin->widget_insearch )) . '</label></p>';
		?>
	
	</fieldset>
	<?php
}


