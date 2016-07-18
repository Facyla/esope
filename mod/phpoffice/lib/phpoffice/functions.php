<?php
/* Functions that are used by the plugin
 */

define('PHPOFFICE_CLI', (PHP_SAPI == 'cli') ? true : false);
define('PHPOFFICE_EOL', PHPOFFICE_CLI ? PHP_EOL : '<br />');


// Get filepath of the Elgg dataroot for PHPOffice files
function phpoffice_filepath() {
	// Data root path (used for caching results of large requests)
	$phpoffice_dataroot = elgg_get_data_path() . 'phpoffice/';
	if (!is_dir($phpoffice_dataroot)) {
		register_error("File path for PHPOffice not created. Disable and re-enable the plugin again to create the directtory");
		//mkdir($phpoffice_dataroot, 0777);
		//chmod($phpoffice_dataroot, 0777);
	}
	/*
	if (!$key) { return false; }

	$filePath = $phpoffice_dataroot . $key;
	if (fwrite(fopen($filePath, 'w'), $content)) {
		error_log("LEAFLET : wrote new cache for $key");
		return true;
	}
	*/
	return $phpoffice_dataroot;
}


/**
 * Get ending notes
 *
 * @param array $writers
 *
 * @return string
 */
function phpoffice_getEndingNotes($writers) {
	$result = '';

	// Do not show execution time for index
	if (!IS_INDEX) {
		$result .= date('H:i:s') . " Done writing file(s)" . PHPOFFICE_EOL;
		$result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . PHPOFFICE_EOL;
	}

	// Return
	if (PHPOFFICE_CLI) {
		$result .= 'The results are stored in the "results" subdirectory.' . PHPOFFICE_EOL;
	} else {
		if (!IS_INDEX) {
			$types = array_values($writers);
			$result .= '<p>&nbsp;</p>';
			$result .= '<p>Results: ';
			foreach ($types as $type) {
				if (!is_null($type)) {
					$resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
					if (file_exists($resultFile)) {
						$result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
					}
				}
			}
			$result .= '</p>';
		}
	}

	return $result;
}


