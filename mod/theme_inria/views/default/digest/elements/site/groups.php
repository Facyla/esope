<?php

	/**
	* Shows the newest groups in the Digest
	*
	*/
	
	$ts_lower = (int) elgg_extract("ts_lower", $vars);
	$ts_upper = (int) elgg_extract("ts_upper", $vars);
	
	$group_options = array(
		"type" => "group",
		"limit" => 0,
		"created_time_lower" => $ts_lower,
		"created_time_upper" => $ts_upper
	);

	if($newest_groups = elgg_get_entities($group_options)){
		$title = elgg_view("output/url", array("text" => elgg_echo("groups"), "href" => "groups/all"));
		
		$group_items = "<div class='digest-groups'>";
		
		foreach($newest_groups as $index => $group){
			$group_items .= '<div class="table-item">';
			$group_items .= elgg_view_entity_icon($group, "medium");
			$group_items .= '<a href="' . $group->getURL() . '">' . $group->name . '</a>';
			$group_items .= '</div>';
		}
			
		$group_items .= "</div>";
		
		echo elgg_view_module("digest", $title, $group_items);
	}
	
