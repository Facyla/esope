<?php
// Select a group, or none

$content ='';
$scope = $vars["scope"]; // default = all, member
if (!elgg_instanceof($vars["entity"], 'group')) { $scope = 'all'; }

switch($scope) {
	case 'member':
		$group_options = array(
			"type" => "group", "limit" => false,
			"relationship" => "member", "relationship_guid" => $group->guid,
		);
		$groups = elgg_get_entities_from_relationship($group_options);
		break;
	case 'all':
	default:
		$groups = elgg_get_entities(array('types' => 'group', 'limit' => 0));
}

// Allow to filter by metadata : array('name' => $metaname, 'value' => $metavalue)
// Note : typical use is checking that a group tool is enabled by setting 'filter' => array('name' => 'bookmarks_enable', 'value' => 'yes')
$filter = $vars["filter"];
if ($filter) {
	$metaname = $filter['name'];
	$metavalue = $filter['value'];
	$filtered_groups = array();
	foreach ($groups as $ent) {
		if ($ent->$metaname == $metavalue) {
			$filtered_groups[] = $ent;
		}
	}
	$groups = $filtered_groups;
}

// Allow to add other attributes, such as : multiple, required, disable, autofocus, size="5"
// Note : mutiple won't work correctly, as only one selection will appear - so do not use it !
$attributes = $vars["attributes"];

// Compose select
$content .= '<select name="' . $vars['name'] . '" id="' . $vars['name'] . '" class="elgg-input-dropdown elgg-input-groups_select ' . $vars['class'] . '" ' . $vars['js'] . ' ' . $attributes . '>';

// Add empty value option
if ($vars["empty_value"] || !isset($vars["empty_value"])) {
	if (!empty($vars['value'])) $content .= '<option value="0">' . elgg_echo('esope:input:nogroup') .'</option>';
	else $content .= '<option selected="selected" value="0">' . elgg_echo('esope:input:nogroup') .'</option>';
}
// Add current value (= don't change option)
if (isset($vars['value'])) {
	if ($current = get_entity($vars['value'])) {
		$content .= '<option selected="selected" value="' . $vars['value'] . '">' . elgg_echo('esope:input:donotchange', array($current->name)) .'</option>';
	}
}
// Add currently logged in user value
if ($vars['add_owner']) {
	$own = elgg_get_logged_in_user_entity();
	$content .= '<option value="' . $own->guid . '">' .  elgg_echo('esope:container:option:own', array($own->name)) .'</option>';
}
// Add container group option
if ($vars["entity"] instanceof ElggGroup) {
	$content .= "<optgroup label='" .elgg_echo("groups:container"). "'>\n";
	$content .= "<option value='" . $vars["entity"]->guid . "'>" . $vars["entity"]->name . "</option>\n";
	$content .= "</optgroup>\n";
}
if (!empty($groups)) {
	$add_groups = false;
	$groups_block .= "<optgroup label='" . elgg_echo("groups") . "'>\n";
	foreach ($groups as $group) {
		if ( !($vars["entity"] instanceof ElggGroup) || ($vars['entity']->guid != $group->guid) ) {
			$add_groups = true;
			if ($vars['value'] != $group->guid) $groups_block .= "<option value='" . $group->guid . "'>" . $group->name . "</option>\n";
		}
	}
	$groups_block .= "</optgroup>\n";
	if ($add_groups) { $content .= $groups_block; }
}
$content .= "</select>";

echo $content;

