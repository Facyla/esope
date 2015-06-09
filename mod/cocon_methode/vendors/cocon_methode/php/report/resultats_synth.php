<?php

// Include classes
include_once('../inc/tbs/tbs_class.php'); // Load the TinyButStrong template engine
include_once('../inc/tbs/opentbs/tbs_plugin_opentbs.php'); // Load the OpenTBS plugin
include_once('inc/calculs.php');  
include_once('inc/chart.php');  
 
// Initialize the TBS instance
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

// A recordset for merging tables
$data = array();
$data[] = array(
	'date_start' => '04/12/2014',
	'date_end' => '08/12/2014',
	'number' => '1234',
	'autre_7_1' => '',
	'autre_7_2' => '',
	'autre_7_3' => '',
	'autre_7_4' => '',
	'autre_7_5' => '',
	'autre_7_6' => '',
	'autre_7_7' => '',
	'autre_7_8' => '',
	'autre_7_9' => '',
	'autre_7_10' => '',
	'autre_7_11' => '',
	'autre_7_12' => '',
	'autre_7_13' => '',
	'autre_7_14' => '',
	'autre_7_15' => '',
	'autre_7_16' => '',
	'autre_7_17' => '',
	'autre_7_18' => '',
	'autre_7_19' => '',
	'autre_7_20' => '',
	'autre_7_21' => '',
	'autre_7_22' => '',
	'autre_7_23' => '',
	'autre_7_24' => '',
	'autre_7_25' => '',
	'autre_7_26' => '',
	'autre_7_27' => '',
	'autre_7_28' => '',
	'autre_8_1' => '',
	'autre_8_2' => '',
	'autre_8_3' => '',
	'autre_8_4' => '',
	'autre_8_5' => '',
	'autre_8_6' => '',
	'autre_8_7' => '',
	'autre_8_8' => '',
	'autre_8_9' => '',
	'autre_8_10' => '',
	'autre_8_11' => '',
	'autre_8_12' => '',
	'autre_8_13' => '',
	'autre_8_14' => '',
	'autre_8_15' => '',
	'autre_8_16' => '',
	'autre_8_17' => '',
	'autre_8_18' => '',
	'autre_8_19' => '',
	'autre_8_20' => '',
	'autre_8_21' => '',
	'autre_8_22' => '',
	'autre_8_23' => '',
	'autre_8_24' => '',
	'autre_8_25' => '',
	'autre_8_26' => '',
	'autre_8_27' => '',
	'autre_8_28' => '',
	'autre_11_1' => '',
	'autre_11_2' => '',
	'autre_11_3' => '',
	'autre_11_4' => '',
	'autre_11_5' => '',
	'autre_11_6' => '',
	'autre_11_7' => '',
	'autre_11_8' => '',
	'autre_11_9' => '',
	'autre_11_10' => '',
	'autre_11_11' => '',
	'autre_11_12' => '',
	'autre_11_13' => '',
	'autre_11_14' => '',
	'autre_11_15' => '',
	'autre_11_16' => '',
	'autre_11_17' => '',
	'autre_11_18' => '',
	'autre_11_19' => '',
	'autre_11_20' => '',
	'autre_11_21' => '',
	'autre_11_22' => '',
	'autre_11_23' => '',
	'autre_11_24' => '',
	'autre_11_25' => '',
	'autre_11_26' => '',
	'autre_11_27' => '',
	'autre_11_28' => '',
	'autre_24_1' => '',
	'autre_24_2' => '',
	'autre_24_3' => '',
	'autre_24_4' => '',
	'autre_24_5' => '',
	'autre_24_6' => '',
	'autre_24_7' => '',
	'autre_24_8' => '',
	'autre_24_9' => '',
	'autre_24_10' => '',
	'autre_24_11' => '',
	'autre_24_12' => '',
	'autre_24_13' => '',
	'autre_24_14' => '',
	'autre_24_15' => '',
	'autre_24_16' => '',
	'autre_24_17' => '',
	'autre_24_18' => '',
	'autre_24_19' => '',
	'autre_24_20' => '',
	'autre_24_21' => '',
	'autre_24_22' => '',
	'autre_24_23' => '',
	'autre_24_24' => '',
	'autre_24_25' => '',
	'autre_24_26' => '',
	'autre_24_27' => '',
	'autre_24_28' => '',	
	'autre_32_1' => '',
	'autre_32_2' => '',
	'autre_32_3' => '',
	'autre_32_4' => '',
	'autre_32_5' => '',
	'autre_32_6' => '',
	'autre_32_7' => '',
	'autre_32_8' => '',
	'autre_32_9' => '',
	'autre_32_10' => '',
	'autre_32_11' => '',
	'autre_32_12' => '',
	'autre_32_13' => '',
	'autre_32_14' => '',
	'autre_32_15' => '',
	'autre_32_16' => '',
	'autre_32_17' => '',
	'autre_32_18' => '',
	'autre_32_19' => '',
	'autre_32_20' => '',
	'autre_32_21' => '',
	'autre_32_22' => '',
	'autre_32_23' => '',
	'autre_32_24' => '',
	'autre_32_25' => '',
	'autre_32_26' => '',
	'autre_32_27' => '',
	'autre_32_28' => ''
);

$template = '../../_files/restitution/resultats_synth.odp';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

$TBS->MergeBlock('b', $data);

// -----------------
// Output the result
// -----------------

// Define the name of the output file
$output_file_name = "resultats_bruts.odp";

// Output the result as a downloadable file (only streaming, no data saved in the server)
$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
exit();
?>