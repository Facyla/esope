<?php
/**
* Elgg register form : extend with join groups
*/

// @TODO adapt to Elgg 1.8 and integrate

$groups = get_input('g');
if ($groups) $group_guids = explode(',', $groups);

// Choix des groupes
$groups_array = fing_get_groups('featured', 'open');
$form_body .= '<div id="register_groups_featured">';
  $form_body .= "<p><strong>Rejoindre des groupes</strong></p>";
  foreach ($groups_array as $ent) {
    $form_body .= "<label>";
    $form_body .= '<input type="checkbox" name="groups[]" value="' . $ent->guid . '" />';
    $form_body .= '<img src="' . $ent->getIcon('tiny') . '" /> ';
    $form_body .= $ent->name;
    $form_body .= "</label><br />";
  }
$form_body .= '</div>';
$form_body .= '<div id="register_groups_full" style="display:none;">';
  $groups_array = fing_get_groups('', 'open');
  $form_body .= "<p><label>Rejoindre des groupes<br />";
  $form_body .= elgg_view('friends/picker',array('entities' => $groups_array, 'internalname' => 'groups', 'highlight' => 'all', 'value' => $group_guids));
  $form_body .= "</label></p>";
$form_body .= '</div>';
$form_body .= '<p><a style="font-weight:bold;" href="javascript:void(0);" onclick="$(\'#register_groups_featured\').toggle();$(\'#register_groups_full\').toggle();">Afficher plus de groupes</a></p>';

