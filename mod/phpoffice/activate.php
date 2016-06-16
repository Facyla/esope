<?php
/**
 * Perform some actions when enabling the plugin
 */

// Data root path (used for caching results of large requests)
$phpoffice_dataroot = elgg_get_data_path() . 'phpoffice/';
if (!is_dir($phpoffice_dataroot)) {
	mkdir($phpoffice_dataroot, 0777);
	chmod($phpoffice_dataroot, 0777);
}

system_message("Data path for PHPOffice created");

