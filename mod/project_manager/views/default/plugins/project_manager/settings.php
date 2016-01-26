<?php

$members_count = elgg_get_entities(array('types' => 'user', 'limit' => 10, 'count' => true));
$members = elgg_get_entities(array('types' => 'user', 'limit' => $members_count));
foreach ($members as $ent) {
  if (!empty($ent->items_status)) $items_members[] = $ent;
  else $extranet_members[] = $ent;
/*
  if ($ent->items_status == 'salarie') $items_members[] = $ent;
  else if ($ent->items_status == 'non-salarie') $ext_members[] = $ent;
  else $extranet_members[] = $ent;
*/
}

echo '<p>' . elgg_echo('project_manager:settings:presentation') . '</p>';

echo '<style>
.friends-picker-navigation, .friends-picker-navigation-l, .friends-picker-navigation-r { display:none; }
.panel .wrapper > h3 { display: none; }

.elgg-avatar-tiny { width: 25px; }
</style>';

$managers = explode(',', $vars['entity']->managers);

echo '<br /><label style="clear:left;">' . elgg_echo('project_manager:settings:managers') . '</label> ';
//echo elgg_view('input/text', array('name' => 'params[managers]', 'value' => $vars['entity']->managers));
$managers_picker = elgg_view("input/friendspicker", array('name' => "managers", 'entities' => $items_members, 'highlight' => 'all', 'value' => $managers));
echo elgg_view('output/show_hide_block', array('title' => "", 'linktext' => "Cliquer pour modifier la liste des managers", 'content' => $managers_picker));
if (is_array($managers)) 
echo '<br />' . elgg_view('output/members_list', array('value' => $managers)) . '<br /><br />';
/*
echo '<p>' . elgg_echo('project_manager:settings:managers:help') . '<br /><strong>Liste des managers :</strong> ';
$users_count = elgg_get_entities(array('types' => 'user', 'count' => true));
$users = elgg_get_entities(array('types' => 'user', 'limit' => $users_count));
foreach ($users as $ent) { echo $ent->name . ' (' . $ent->guid . '), '; }
*/
echo '</p>';


// Données de base pour calculs consultants
echo '<h3>' . elgg_echo('project_manager:settings:consultants:data') . '</h3>';
echo '<p><label>' . elgg_echo('project_manager:settings:coefsalarie') . ' ' . elgg_view('input/text', array('name' => 'params[coefsalarie]', 'value' => $vars['entity']->coefsalarie, 'js' => ' style="width:5ex;"')) . '</p>';
echo '<p><label>' . elgg_echo('project_manager:settings:coefpv') . ' ' . elgg_view('input/text', array('name' => 'params[coefpv]', 'value' => $vars['entity']->coefpv, 'js' => ' style="width:5ex;"')) . '</p>';
echo '<p><label>' . elgg_echo('project_manager:settings:dayspermonth') . ' ' . elgg_view('input/text', array('name' => 'params[dayspermonth]', 'value' => $vars['entity']->dayspermonth, 'js' => ' style="width:5ex;"')) . '</p>';


