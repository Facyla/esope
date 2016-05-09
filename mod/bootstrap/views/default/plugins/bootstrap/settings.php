<?php
/**
 * Bootstrap
 */




// List and select available Bootstrap versions
$versions = array();
// Note : we prefer to use dirname method to avoid false paths caused by symlinks
//$vendors_path = elgg_get_plugins_path() . 'mod/bootstrap/vendors'; // May not work if using symbolic links
$vendors_path = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/vendors'; // Failsafe but depends on plugin structure
$files = scandir($vendors_path);
foreach ($files as $file) {
	if (!in_array($file, array('.', '..')) && is_dir("$vendors_path/$file") && (strpos($file, 'bootstrap') !== false)) {
		$versions_opt[$file] = $file;
	}
}
// Set default to latest version
if ((empty($vars['entity']->bootstrap_version) || !in_array($vars['entity']->bootstrap_version, $versions_opt)) && is_array($versions_opt)) { $vars['entity']->bootstrap_version = end($versions_opt); }
// Select version
echo '<p><label>' . elgg_echo('bootstrap:version:select') . ' ' . elgg_view('input/dropdown', array('name' => 'params[bootstrap_version]', 'options_values' => $versions_opt, 'value' => $vars['entity']->bootstrap_version)) . '</label><br /><em>' . elgg_echo('bootstrap:version:vendors', array($vendors_path)) . '</em></p>';



