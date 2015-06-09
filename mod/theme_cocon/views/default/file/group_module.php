<?php
/**
 * Group file module
 */

$group = elgg_get_page_owner_entity();

if ($group->file_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "file/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

$new_link = elgg_view('output/url', array(
	'href' => "file/add/$group->guid",
	'text' => elgg_echo('file:add'),
	'is_trusted' => true,
));


// Change display if folders are enabled
if (elgg_is_active_plugin('file_tools') && (elgg_get_plugin_setting("user_folder_structure", "file_tools") == "yes") ) {
	
	elgg_push_context('widgets');
	if(empty($sort_by)){
		$sort_value = "e.time_created";
		if($group->file_tools_sort){
			$sort_value = $group->file_tools_sort;
		} elseif($site_sort_default = elgg_get_plugin_setting("sort", "file_tools")){
			$sort_value = $site_sort_default;
		}
		$sort_by = $sort_value;
	}
	if(empty($direction)){
		$sort_direction_value = "asc";
		if(!empty($group->file_tools_sort_direction)){
			$sort_direction_value = $group->file_tools_sort_direction;
		} elseif($site_sort_direction_default = elgg_get_plugin_setting("sort_direction", "file_tools")){
			$sort_direction_value = $site_sort_direction_default;
		}
		$direction = $sort_direction_value;
	}
	
	$options = array(
		'type' => 'object', 'subtype' => 'file',
		'container_guid' => $group->guid,
		'limit' => false,
		// Display only files on main folder
		'wheres' => "NOT EXISTS (
			SELECT 1 FROM " . elgg_get_config("dbprefix") . "entity_relationships r 
			WHERE r.guid_two = e.guid AND
			r.relationship = '" . FILE_TOOLS_RELATIONSHIP . "')",
		'joins' => array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON oe.guid = e.guid"),
	);
	if($sort_by == "simpletype") {
		$options["order_by_metadata"] = array("name" => "mimetype", "direction" => $direction);
	} else {
		$options["order_by"] = $sort_by . " " . $direction;
	}
	$files = elgg_get_entities($options);
	
	$content = elgg_view("file_tools/list/files", array("folder" => false, "files" => $files, "sort_by" => $sort_by, "direction" => $direction, 'hide_selectors' => 'yes'));
	elgg_pop_context();

	if (!$content) {
		$content = '<p>' . elgg_echo('file:none') . '</p>';
	}
	
} else {
	
	elgg_push_context('widgets');
	$options = array(
		'type' => 'object',
		'subtype' => 'file',
		'container_guid' => elgg_get_page_owner_guid(),
		'limit' => 6,
		'full_view' => false,
		'pagination' => false,
	);
	$content = elgg_list_entities($options);
	elgg_pop_context();
	
	if (!$content) {
		$content = '<p>' . elgg_echo('file:none') . '</p>';
	}
	
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('file:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
	'class' => 'elgg-module-group-file',
));

