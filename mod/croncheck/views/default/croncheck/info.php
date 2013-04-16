<?php 

	global $CONFIG;
	$cronhooks = $CONFIG->hooks["cron"];
	$intervals = array("reboot", "minute", "fiveminute", "fifteenmin", "halfhour", "hourly", "daily", "weekly", "monthly", "yearly");
	
	// Info part
	$info_title = elgg_echo("croncheck:info");
	
	$info_table = "<table class='elgg-table'>";
	
	$info_table .= "<tr>";
	$info_table .= "<th>" . elgg_echo("croncheck:interval") . "</th>";
	$info_table .= "<th>" . elgg_echo("croncheck:timestamp") . "</th>";
	$info_table .= "<th>" . elgg_echo("croncheck:friendly_time") . "</th>";
	$info_table .= "</tr>";
	
	foreach($intervals as $interval){
		$interval_ts = elgg_get_plugin_setting("latest_" . $interval . "_ts", "croncheck");
		
		$info_table .= "<tr>";
		// which interval
		$info_table .= "<td>'" . $interval . "'</td>";
		// when did it last run (UNIX ts) & friendly time
		if(!empty($interval_ts)){
			$info_table .= "<td>" . $interval_ts . "</td>";
			$info_table .= "<td>" . elgg_view_friendly_time($interval_ts) . " @ " . date("r", $interval_ts) . "</td>";
		} else {
			$info_table .= "<td>&nbsp;</td>";
			$info_table .= "<td>" . elgg_echo("croncheck:no_run") . "</td>";
		}
		
		$info_table .= "</tr>";
	}
	
	$info_table .= "</table>";
	
	// show which functions are registerd to every interval
	if(!empty($vars["toggle"])){
		$module = "info";
		$functions_title = "<br />" . elgg_view("output/url", array("text" => elgg_echo("croncheck:registered"), "href" => "#croncheck_functions", "rel" => "toggle"));
		
		$functions_table = "<table id='croncheck_functions' class='elgg-table'>";
	} else {
		$module = "inline";
		$functions_title = elgg_echo("croncheck:registered");
		
		$functions_table = "<table class='elgg-table'>";
	}
	
	$functions_table .= "<tr>";
	$functions_table .= "<th colspan='2'>" . elgg_echo("croncheck:interval") . "</th>";
	$functions_table .= "</tr>";
	
	foreach($intervals as $interval){
		$functions_table .= "<tr>";
		$functions_table .= "<td>'" . $interval . "'</td>";
		
		if(array_key_exists($interval, $cronhooks) && count($cronhooks[$interval]) >= 1){
			$functions_table .= "<td>";
			foreach($cronhooks[$interval] as $function){
				$functions_table .= $function . "<br />";
			}
			$functions_table .= "</td>";
		} else {
			$functions_table .= "<td>" . elgg_echo("croncheck:none_registered") . "</td>";
		}
		
		$functions_table .= "</tr>";
	}
	
	$functions_table .= "</table>";
	
	// @todo remove widget wrapper if Trac #4186 is fixed
	echo "<div id='croncheck_information'>";
	echo elgg_view_module($module, $info_title, $info_table);
	echo elgg_view_module($module, $functions_title, $functions_table);
	echo "</div>";
