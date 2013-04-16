<?php 

	function croncheck_init(){
		elgg_extend_view("css/admin", "croncheck/css");
		elgg_extend_view("admin/statistics/overview", "croncheck/info");
		
		elgg_register_widget_type("croncheck", elgg_echo("croncheck:widget:title"), elgg_echo("croncheck:widget:description"), "admin");
	}
	
	function croncheck_monitor($hook, $entity_type, $returnvalue, $params){
		$allowed_crons = array("reboot", "minute", "fiveminute", "fifteenmin", "halfhour", "hourly", "daily", "weekly", "monthly", "yearly");
		
		if(in_array($entity_type, $allowed_crons)){
			if(isset($params["time"])){
				$time = $params["time"];
			} else {
				$time = time();
			}
			
			elgg_set_plugin_setting("latest_" . $entity_type . "_ts", $time, "croncheck");
		}
	}
	
	// register default Elgg event
	elgg_register_event_handler("init", "system", "croncheck_init");

	// register hooks
	elgg_register_plugin_hook_handler("cron", "all", "croncheck_monitor");
	