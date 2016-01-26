<?php
$content ='';
$scope = $vars["scope"]; // default = all, member
if (!($vars["entity"] instanceof ElggGroup)) { $scope = 'all'; }

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
    $groups_count = elgg_get_entities(array('types' => 'group', 'limit' => 10, 'count' => true));
    $groups = elgg_get_entities(array('types' => 'group', 'limit' => $groups_count));
}


// Compose select
$content .= '<select name="' . $vars['name'] . '" id="' . $vars['name'] . '" class="elgg-input-dropdown elgg-input-groups_select ' . $vars['class'] . '" ' . $vars['js'] . '>';
if ($vars["empty_value"]) {
  if (!empty($vars['value'])) $content .= '<option value="0">Aucun groupe</option>';
  else $content .= '<option selected="selected" value="0">Aucun groupe</option>';
}
// Add current value (= don't change option)
if (isset($vars['value'])) {
  if ($current = get_entity($vars['value'])) {
    $content .= '<option selected="selected" value="' . $vars['value'] . '">Ne pas changer (' . $current->name . ')</option>';
  }
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

