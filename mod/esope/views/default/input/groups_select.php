<?php
/* Select a group, or none
 * scope : all|member (loggedin user is member of the group)
 * filter : Allow to filter groups by metadata : array('name' => $metaname, 'value' => $metavalue)
 * empty_value : allow empty value (no group)
 * add_owner : add currently logged in user
 * value : current value
 * entity : container group
 */

$dbprefix = elgg_get_config('dbprefix');
$content ='';

// @TODO should it default to page_owner entity (= container group or user) ?
$entity = elgg_extract('entity', $vars);
$scope = elgg_extract('scope', $vars, 'all'); // default = all, member
// @TODO Why default to all scope if no group is passed ?  we do not need any current container group to select a given group...
//if (!elgg_instanceof($entity, 'group')) { $scope = 'all'; }
$filter = elgg_extract('filter', $vars, false);
// Allow to add other attributes, such as : multiple, required, disable, autofocus, size="5"
// Note : mutiple won't work correctly, as only one selection will appear - so do not use it !
$attributes = elgg_extract('attributes', $vars);
$add_owner = elgg_extract('add_owner', $vars, false);
// Get current value entity, if any
$value = elgg_extract('value', $vars);
if (!empty($value)) { $current = get_entity($value); }


// Determine main groups list by scope
switch($scope) {
	case 'member':
		$group_options = array(
			"type" => "group", "limit" => false,
			"relationship" => "member", "relationship_guid" => elgg_get_logged_in_user_guid(),
			'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"),
			'order_by' => 'ge.name ASC',
		);
		$groups = elgg_get_entities_from_relationship($group_options);
		break;
	case 'all':
	default:
		$groups = elgg_get_entities(array('types' => 'group', 'limit' => 0, 'joins' => array("JOIN {$dbprefix}groups_entity ge ON e.guid = ge.guid"), 'order_by' => 'ge.name ASC'));
}

// Allow to filter by metadata : array('name' => $metaname, 'value' => $metavalue)
// Note : typical use is checking that a group tool is enabled by setting 'filter' => array('name' => 'bookmarks_enable', 'value' => 'yes')
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


// Compose select
$content .= '<select name="' . $vars['name'] . '" id="' . $vars['name'] . '" class="elgg-input-dropdown elgg-input-groups_select ' . $vars['class'] . '" ' . $vars['js'] . ' ' . $attributes . '>';

// Add empty value option
if ($vars["empty_value"] || !isset($vars["empty_value"])) {
	if (!empty($value)) {
		$content .= '<option value="0">' . elgg_echo('esope:input:nogroup') .'</option>';
	} else {
		$content .= '<option selected="selected" value="0">' . elgg_echo('esope:input:nogroup') .'</option>';
	}
}

// Add current value (= don't change option)
if ($current) {
	$content .= '<option selected="selected" value="' . $value . '">' . elgg_echo('esope:input:donotchange', array($current->name)) .'</option>';
/* @TODO add alternative disabled option for the case when value is set but current entity not valid ?
} else if (!empty($value)) {
	$content .= '<option selected="selected" value="' . $value . '">' . elgg_echo('esope:input:donotchange', "disabled entity") .'</option>';
*/
}

// Add currently logged in user value
if ($add_owner) {
	$own = elgg_get_logged_in_user_entity();
	$content .= '<option value="' . $own->guid . '">' .  elgg_echo('esope:container:option:own', array($own->name)) .'</option>';
}

// Add container group option
if (elgg_instanceof($entity, 'group')) {
	$content .= "<optgroup label='" .elgg_echo("groups:container"). "'>\n";
	$content .= "<option value='" . $entity->guid . "'>" . $entity->name . "</option>\n";
	$content .= "</optgroup>\n";
}

// Add groups options
if (!empty($groups)) {
	$add_groups = false;
	$groups_block = "<optgroup label='" . elgg_echo("groups") . "'>\n";
	foreach ($groups as $group) {
		if (!elgg_instanceof($entity, 'group') || ($entity->guid != $group->guid)) {
			$add_groups = true;
			if ($value != $group->guid) { $groups_block .= "<option value='" . $group->guid . "'>" . $group->name . "</option>\n"; }
		}
	}
	$groups_block .= "</optgroup>\n";
	if ($add_groups) { $content .= $groups_block; }
}
$content .= "</select>";

echo $content;

