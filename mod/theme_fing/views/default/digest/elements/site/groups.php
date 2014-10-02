<?php
/**
* Shows the newest groups in the Digest
*
*/

$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);

$group_options = array(
	'type' => 'group',
	'limit' => 10,
	"created_time_lower" => $ts_lower,
	"created_time_upper" => $ts_upper,
	'metadata_name' => 'featured_group',
	'metadata_value' => 'yes',
);

if($newest_groups = elgg_get_entities_from_metadata($group_options)){
	$title = elgg_view("output/url", array("text" => elgg_echo("esope:digest:groups"), "href" => "groups/all"));
	
	$group_items = "<div class='digest-groups'>";
	
	foreach($newest_groups as $index => $group){
		$group_items .= '<div style="padding-bottom:2ex;">';
			$group_items .= '<div style="float:left; width:110px;">';
				$group_items .= elgg_view_entity_icon($group, "medium");
			$group_items .= '</div>';
			$group_items .= '<div style="float:right;  width:420px;">';
				$group_items .= '<h4><a href="' . $group->getURL() . '">' . $group->name . '</a></h4>';
				$group_items .= '<p><em>' . $group->briefdescription . '</em></p>';
				if ($group->interests) $group_items .= '<p>#' . implode(' &nbsp; #', $group->interests) . '</p>';
			$group_items .= '</div>';
			$group_items .= '<div style="clear:both;"></div>';
			$group_items .= '<p>' . elgg_get_excerpt($group->description, 500) . '</p>';
		$group_items .= '</div>';
	}
		
	$group_items .= "</div>";
	
	echo elgg_view_module("digest", $title, $group_items);
}
chahnaiQu2EemaeZ
