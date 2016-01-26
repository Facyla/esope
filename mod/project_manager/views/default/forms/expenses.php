<?php
$content ='';

$expenses = $vars['expenses'];
$id = $vars['id'];
$action = $vars['action']; // Plusieurs modes : create, update, delete, et manager pour la gestion
$projects = $vars['projects'];
$months = time_tracker_get_date_table('months');

// STATUTS DE LA SAISIE
// validated : validé par le consultant (ne peut plus modifier)
// closed ? : validé par un manager (personne ne peut plus modifier)

// Données
if (isset($vars['expenses'])) {
  $date = $expenses['date'];
  $objet = $expenses['objet'];
  $frais_local = $expenses['frais_local'];
  $devise = $expenses['devise'];
  $taux = $expenses['taux'];
  $frais = $expenses['frais'];
  $deduc_tva = $expenses['deduc_tva'];
  $project_guid = $expenses['project_guid'];
  $user_guid = $expenses['user_guid'];
  if ($user_guid && ($user = get_entity($user_guid))) {}
  $status = $expenses['status'];
} else {
  $date = time();
  $objet = '';
  $frais_local = 0;
  $devise = 'EUR';
  $taux = 1;
  $frais = 0;
  $deduc_tva = 0;
  $project_guid = '';
  $status = '';
}
$currencies = array('EUR', 'USD', 'JPY', 'BGN', 'CZK', 'DKK', 'GBP', 'HUF', 'LTL', 'LVL', 'PLN', 'RON', 'SEK', 'CHF', 'NOK', 'HRK', 'RUB', 'TRY', 'AUD', 'BRL', 'CAD', 'CNY', 'HKD', 'IDR', 'ILS', 'INR', 'KRW', 'MXN', 'MYR', 'NZD', 'PHP', 'SGD', 'THB', 'ZAR');

$is_manager = project_manager_manager_gatekeeper(false, true, false);
// Modification possible ssi frais non validés, ou si manager ou admin (2e param)
if (($status != 'validated') || $is_manager ) {
  
  // Comme manager, certains champs ne sont plus éditables, et d'autres le deviennent - mais besoin de tous les champs (hidden)
  if ($action == 'manager') {
    // Sélecteurs et saisies
    $dates = explode('-', $date); $y = $dates[0]; $m = $dates[1]; $d = $dates[2];
    $select_date = '<td>' . elgg_view("output/date", array("value" => $date)) . elgg_view("input/hidden", array("name" => "expenses[$id][date]", "value" => $date)) . '</td>';
    $select_date .= '<td>' . $y . '</td>';
    $select_date .= '<td>' . $months[(int)$m] . ' (' . $d . ')' . '</td>';
    $input_objet = $objet . elgg_view("input/hidden", array("name" => "expenses[$id][objet]", "value" => $objet));
    $input_frais_local = $frais_local . elgg_view("input/hidden", array("name" => "expenses[$id][frais_local]", "value" => $frais_local));
    $select_devise = $devise . elgg_view("input/hidden", array("name" => "expenses[$id][devise]", "value" => $devise));
    $input_taux = round($taux, 4) .  elgg_view("input/hidden", array("name" => "expenses[$id][taux]", "value" => $taux));
    $input_frais = round($frais, 2) . elgg_view("input/hidden", array("name" => "expenses[$id][frais]", "value" => $frais));
    $input_deduc_tva = elgg_view("input/text", array("name" => "expenses[$id][deduc_tva]", "value" => $deduc_tva));
    if (!$user) $select_user = elgg_view("input/project_manager/members_select", array("name" => "expenses[$id][user_guid]", "value" => $user_guid, 'scope' => 'internal'));
    else $select_user = elgg_view("input/hidden", array("name" => "expenses[$id][user_guid]", "value" => $user_guid)) . $user->name;
    $select_projet = elgg_view("input/project_manager/projects_select", array("name" => "expenses[$id][project_guid]", "value" => $project_guid, 'entities' => $projects, 'empty_value' => false)) . elgg_view("input/hidden", array("name" => "expenses[$id][prev_project_guid]", "value" => $project_guid));
    $select_validated = elgg_view("input/dropdown", array("name" => "expenses[$id][status]", "value" => $status, 'options_values' => array('' => "Non validé = les saisies peuvent être modifiées", 'validated' => "Validé = aucune modification possible", 'delete' => "Supprimer cette note de frais")));
    
  } else {
    // Sélecteurs et saisies
    $select_date = elgg_view("input/date", array("name" => "expenses[$id][date]", "value" => $date, 'js' => ' style="width:14ex;"'));
    $input_objet = elgg_view("input/text", array("name" => "expenses[$id][objet]", "value" => $objet, 'js' => ' style="width:40ex;"'));
    $input_frais_local = elgg_view("input/text", array("name" => "expenses[$id][frais_local]", "value" => $frais_local, 'js' => ' style="width:10ex;"'));
    $select_devise = elgg_view("input/dropdown", array("name" => "expenses[$id][devise]", "value" => $devise, 'options' => $currencies));
    $input_taux = round($taux, 4) .  elgg_view("input/hidden", array("name" => "expenses[$id][taux]", "value" => $taux));
    $input_frais = round($frais, 2) . elgg_view("input/hidden", array("name" => "expenses[$id][frais]", "value" => $frais));
    $input_deduc_tva = elgg_view("input/text", array("name" => "expenses[$id][deduc_tva]", "value" => $deduc_tva));
    if (!$user && $is_manager) $select_user = elgg_view("input/project_manager/members_select", array("name" => "expenses[$id][user_guid]", "value" => $user_guid, 'scope' => 'internal'));
    else $select_user = elgg_view("input/hidden", array("name" => "expenses[$id][user_guid]", "value" => $user_guid)) . $user->name;
    $select_projet = elgg_view("input/project_manager/projects_select", array("name" => "expenses[$id][project_guid]", "value" => $project_guid, 'entities' => $projects, 'empty_value' => false)) . elgg_view("input/hidden", array("name" => "expenses[$id][prev_project_guid]", "value" => $project_guid));
    if ($action != 'create') $select_validated = elgg_view("input/dropdown", array("name" => "expenses[$id][status]", "value" => $status, 'options_values' => array('' => "Non validé = les saisies peuvent être modifiées", 'validated' => "Validé = aucune modification possible", 'delete' => "Supprimer cette note de frais")));
  }
} else {
  // Sélecteurs et saisies
  $select_date = elgg_view("output/date", array("value" => $date));
  $input_objet = $objet;
  $input_frais_local = $frais_local;
  $select_devise = $devise;
  $input_taux = round($taux, 4);
  $input_frais = round($frais, 2);
  $input_deduc_tva = $deduc_tva;
  $project = get_entity($project_guid);
  $select_projet = $project->name . $project->title;
  $select_validated = "Cette note de frais a été validée et ne peut plus être modifiée";
}


// Ligne du tableau
$content .= elgg_view("input/hidden", array("name" => "expenses[$id][action]", "value" => $action));
$content .= '<tr>';
// Manager : on affiche des champs Date, Année, mois pour meilleure lisibilité + champ caché user_guid concerné
if ($action == 'manager') $content .= $select_date;
else $content .= '<td>' . $select_date . '</td>';
$content .= '<td>' . $input_objet . '</td>';
$content .= '<td>' . $input_frais_local . '</td>';
$content .= '<td>' . $select_devise . '</td>';
if ($action != 'create') {
  $content .= '<td>' . $input_taux . '</td>';
  $content .= '<td>' . $input_frais . '</td>';
}
$content .= '<td>' . $input_deduc_tva . '</td>';
$content .= '<td>' . $select_user . '</td>';
$content .= '<td>' . $select_projet . '</td>';
if ($action != 'create') $content .= '<td>' . $select_validated . '</td>';
$content .= '</tr>';

echo $content;

