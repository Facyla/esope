<?php

	/**
	* Shows the latests thewires in the Digest
	*
	*/
	
	$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
	$ts_lower = (int) elgg_extract("ts_lower", $vars);
	$ts_upper = (int) elgg_extract("ts_upper", $vars);

	// only show thewires that are published
	$dbprefix = elgg_get_config("dbprefix");
	
	$thewire_options = array(
		"type" => "object",
		"subtype" => "thewire",
		"limit" => 5,
		"created_time_lower" => $ts_lower,
		"created_time_upper" => $ts_upper,
		"wheres" => "e.owner_guid != " . $user->guid, // filter own content
	);

	if($thewires = elgg_get_entities($thewire_options)){
		$title = elgg_view("output/url", array("text" => elgg_echo("theme_inria:digest:thewire"), "href" => "thewire/all" ));
		
		$latest_thewires = "";
		
		foreach($thewires as $thewire){
			$thewire_url = $thewire->getURL();
			
			$latest_thewires .= "<div class='digest-blog'>";
			$owner = $thewire->getOwnerEntity();
			$latest_thewires .= "<a href='" . $thewire_url. "'><img src='". $owner->getIconURL("small") . "' style='border-radius: 5px; padding: 0; margin: 0 5px 0 0;' /></a>";
			$latest_thewires .= "<span>";
			$latest_thewires .= "<a href='" . $thewire_url. "'>&laquo;&nbsp;" . $thewire->description . "&nbsp;&raquo;</a>";
			$latest_thewires .= "</span>";
			$latest_thewires .= "</div>";
		}
		
		echo elgg_view_module("digest", $title, $latest_thewires);
	}
	
