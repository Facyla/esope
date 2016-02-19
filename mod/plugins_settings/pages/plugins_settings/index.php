<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

admin_gatekeeper();

$title = elgg_echo('plugins_settings:title');

$sidebar = "";

$content = '';
$content .= '';

// All active plugin settings
$all_settings = array();
$all_settings_count = 0;

$mode = get_input('mode');


// START : CHOOSE MODE
$content .= '<h3>' . elgg_echo('plugins_settings:mode') . '</h3>';
$content .= '<p><a href="' . elgg_get_site_url() . 'plugins_settings?mode=export" class="elgg-button elgg-button-action">' . elgg_echo('plugins_settings:export') . '</a></p>';
$content .= '<p><a href="' . elgg_get_site_url() . 'plugins_settings?mode=import" class="elgg-button elgg-button-action">' . elgg_echo('plugins_settings:import') . '</a></p>';


// EXPORT MODE
if ($mode == 'export') {
	$content .= '<h3>' . elgg_echo('plugins_settings:export') . '</h3>';
	// List active plugins
	// Status : active, inactive, or all. 
	//$active_plugins = elgg_get_plugins($status = 'active', $site_guid = null);
	$plugins = elgg_get_plugins('active');
	$content .= '<h4>' . elgg_echo('plugins_settings:activeplugins', array(count($plugins))) . '</h4>';
	//$content .= '<pre>' . print_r($plugins, true) . '</pre>';

	// Get plugins settings
	$content .= '<h4>' . elgg_echo('plugins_settings:currentsettings') . '</h4>';
	$content .= '<ul>';
	foreach($plugins as $plugin) {
		$plugin_name = $plugin->title;
		$content .= '<li>' . $plugin_name . '&nbsp;: ';
		$plugin_settings = $plugin->getAllSettings();
		if (!empty($plugin_settings)) {
			$settings_count = count($plugin_settings);
			$content .= elgg_echo('plugins_settings:settingscount', array($settings_count));
			$all_settings_count += count($plugin_settings);
			// Esope export method
			$plugin_settings = serialize($plugin_settings);
			$plugin_settings = mb_encode_numericentity($plugin_settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
			$plugin_settings = str_replace(';&#','-',$plugin_settings);
			$plugin_settings = htmlentities($plugin_settings, ENT_QUOTES, 'UTF-8');
			//$content .= '<pre>' . print_r($plugin_settings, true) . '</pre>';
			$all_settings[$plugin_name] = $plugin_settings;
		} else {
			$content .= elgg_echo('plugins_settings:nosetting');
		}
		$content .= '</li>';
	}
	$content .= '</ul>';
	$plugins_with_settings = count($all_settings);
	$content .= '<p><strong>' . elgg_echo('plugins_settings:allseettingscount', array($all_settings_count, $plugins_with_settings)) . '</strong></p>';
	
	// Export serialized array
	$content .= '<h3>' . elgg_echo('plugins_settings:exportdata') . '</h3>';
	$content .= '<p>' . elgg_echo('plugins_settings:exportdata:instructions') . '</p>';
	//$content .= '<pre>' . print_r($all_settings, true) . '</pre>';
	$serialized = serialize($all_settings);
	$content .= '<textarea>' . $serialized . '</textarea>';
}


// IMPORT MODE
if ($mode == 'import') {
	$content .= '<h3>' . elgg_echo('plugins_settings:import') . '</h3>';
	$confirm = get_input('confirm');
	$serialized = get_input('import_data');
	
	// Import form
	$content .= '<form method="POST">';
	$content .= '<p><label>' . elgg_echo('plugins_settings:import:data') . '<br />' . elgg_view('input/plaintext', array('name'=> 'import_data', 'value' => $serialized, 'placeholder' => elgg_echo('plugins_settings:import:data:placeholder'))) . '</label></p>';
	$content .= '<p><label>' . elgg_echo('plugins_settings:import:confirm') . ' ' . elgg_view('input/text', array('name' => 'confirm', 'placeholder' => elgg_echo('plugins_settings:import:confirm:placeholder'))) . '</label><br />' . elgg_echo('plugins_settings:import:confirm:instructions') . '</p>';
	$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('plugins_settings:import:proceed'))) . '</p>';
	$content .= '</form>';
	
	// Process import data
	$all_settings = unserialize($serialized);
	foreach ($all_settings as $plugin_name => $settings) {
		$content .= '<li>' . $plugin_name . '&nbsp;: ';
		// Esope import method
		$settings = html_entity_decode($settings, ENT_QUOTES, 'UTF-8');
		$settings = str_replace('-',';&#',$settings);
		$settings = mb_decode_numericentity($settings, array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
		$settings = unserialize($settings);
		if (!empty($settings)) {
			$plugin = elgg_get_plugin_from_id($plugin_name);
			$content .= '<ul>';
			foreach ($settings as $name => $value) {
				$old = htmlentities($plugin->$name, ENT_QUOTES, 'UTF-8');
				$new = htmlentities($value, ENT_QUOTES, 'UTF-8');
				$content .= '<li>' . elgg_echo('plugins_settings:import:settingdetails', array($name, $old, $new)) . '</li>';
				if ($old == $new) {
					$content .= elgg_echo('plugins_settings:import:nochange');
				} else {
						$content .= elgg_echo('plugins_settings:import:canimport');
					// Process real import
					if ($confirm == 'yes') {
						$plugin->setSetting($name, $value);
						$content .= ' <strong style="color:red;">' . elgg_echo('plugins_settings:import:success') . '</strong>';
					}
				}
				$content .= '</li>';
			}
			$content .= '</ul>';
		} else {
			$content .= elgg_echo('plugins_settings:error:novalue');
		}
		$content .= '</li>';
	}
	$content .= '</ul>';
	
}



// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

