<?php
$content ='';

if (!isset($vars["entities"])) {
  $projects_count = elgg_get_entities(array('types' => 'project_manager', 'limit' => 10, 'count' => true));
  $projects = elgg_get_entities(array('types' => 'project_manager', 'limit' => $projects_count));
} else $projects = $vars["entities"];

// Compose select
$content .= '<select name="' . $vars['name'] . '" id="' . $vars['name'] . '" class="elgg-input-dropdown elgg-input-projects_select ' . $vars['class'] . '" ' . $vars['js'] . '>';
// Inner title
if (isset($vars['value']) && !empty($vars['value'])) {
  $content .= '<option disabled="disabled" value="">' . elgg_echo('project_manager:choose') . '</option>';
} else {
  $content .= '<option disabled="disabled" selected="selected" value="">' . elgg_echo('project_manager:choose') . '</option>';
}
// Empty value option
if ($vars["empty_value"]) {
  if (isset($vars['value']) && !empty($vars['value'])) $content .= '<option value="">Aucun projet</option>';
  else $content .= '<option selected="selected" value="">Aucun projet</option>';
}
// Add current value (= don't change option)
if (isset($vars['value']) && !empty($vars['value'])) {
  if ($current = get_entity($vars['value'])) {
    $content .= '<option selected="selected" value="' . $vars['value'] . '">Ne pas changer (' . $current->name . ')</option>';
  }
}
// Liste des projets
if (is_array($projects)) 
foreach ($projects as $ent) {
	if ($ent instanceof ElggObject) $option = time_tracker_get_projectname($ent);
	else if ($ent instanceof ElggUser) $option = elgg_echo('project_manager:expenses:noproject');
	if ($vars['value'] != $ent->guid) $content .= "<option value='" . $ent->guid . "'>" . $option . "</option>\n";
	else $content .= '<option value="' . $ent->guid . '" selected="selected">' . $option . '</option>';
}

$content .= "</select>";

echo $content;

