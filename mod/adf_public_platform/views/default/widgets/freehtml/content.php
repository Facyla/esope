<?php 
	$widget = $vars["entity"];
	
	if(!empty($widget->html_content)){
		echo "<div class='elgg-output'>" . $widget->html_content . "</div>";
	} else {
		echo elgg_echo("esope:widgets:freehtml:no_content");
	}
	
