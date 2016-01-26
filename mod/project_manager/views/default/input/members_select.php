<?php
$content ='';
$user  = elgg_get_logged_in_user_entity();
$scope = $vars["scope"]; // default = all, internal, external, friends, groupmembers
//if (!($vars["entity"] instanceof ElggGroup)) { $scope = 'all'; }
if (empty($scope)) { $scope = 'all'; }

// Selon qui a modifié les statuts items, la metadata peut ne pas être accessible..
$ia = elgg_set_ignore_access(true);

switch($scope) {
  case 'groupmembers':
    $member_options = array(
	    "type" => "user", "limit" => false,
	    "relationship" => "member", "relationship_guid" => $group->guid, "inverse_relationship" => true,
    );
    $members = elgg_get_entities_from_relationship($member_options);
    break;
  case 'friends':
    $members_options = array(
	    "type" => "user",  "limit" => false,
	    "relationship" => "friend", "relationship_guid" => $user->guid,
    );
    $members = elgg_get_entities_from_relationship($members_options);
    break;
  case 'internal':
  case 'external':
  case 'all':
  default:
    $members_count = elgg_get_entities(array('types' => 'user', 'limit' => 10, 'count' => true));
    $members = elgg_get_entities(array('types' => 'user', 'limit' => $members_count));
    foreach ($members as $ent) {
      if (!empty($ent->items_status)) $int_members[] = $ent;
      else $ext_members[] = $ent;
    }
}
if ($scope == 'internal') $members = $int_members;
if ($scope == 'external') $members = $ext_members;


// Compose select
$content .= '<select name="' . $vars['name'] . '" id="' . $vars['name'] . '" class="elgg-input-dropdown elgg-input-members_select">';
// Add current value (= don't change option)
if (isset($vars['value'])) {
  if ($current = get_entity($vars['value'])) {
    $content .= '<option selected="selected" value="' . $vars['value'] . '">&raquo; ' . $current->name . ' &laquo;</option>';
  }
}
// Add self option
$content .= "<option value='" . $user->guid . "'>" . elgg_echo("tasks:transfer:myself") . " (" . $user->name .")" . "</option>\n";
// Add groupowner option
if ($vars["entity"] instanceof ElggGroup) {
  $content .= "<optgroup label='" .elgg_echo("groups:owner"). "'>\n";
  $content .= "<option value='" . $owner->guid . "'>" . $owner->name . "</option>\n";
  $content .= "</optgroup>\n";
}
if (!empty($members)) {
	$add_members = false;
	usort($members, create_function('$a,$b', 'return strcmp($a->name,$b->name);'));
	$members_block .= "<optgroup label='" . elgg_echo("members") . "'>\n";
	// Construction du sélecteur
	foreach ($members as $member) {
		if ( ($user->guid != $member->guid) 
			&& (!($vars["entity"] instanceof ElggGroup) || ($group->getOwner() != $member->guid)) 
		) {
    	//if (($scope == 'groupmembers') && ($group->getOwner() != $member->guid)) break;
			$add_members = true;
			if ($vars['value'] != $member->guid) $members_block .= "<option value='" . $member->guid . "'>" . $member->name . "</option>\n";
	  }
	}
	$members_block .= "</optgroup>\n";
	if ($add_members) { $content .= $members_block; }
}
$content .= "</select>";

elgg_set_ignore_access($ia);


echo $content;

