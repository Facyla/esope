<?php
$project = $vars['entity'];
$project_guid = $project->guid;
$show_validated = $vars['show_validated'];
$show_affectated = $vars['show_affectated'];
$year = $vars['year'];
$month = $vars['month'];
$projects = $vars['projects'];
$content = '';

// Saisie valide = projet ou membre (non affecté)
if ($project instanceof ElggUser) $affectated = false;
else if ($project instanceof ElggObject) $affectated = true;
else return;

// Données source récupérées via les données des projets
$project_expenses = unserialize($project->project_expenses);
if (is_array($project_expenses)) {
  $content .= '<table class="project_manager" style="width:100%;">';
  if ($affectated) $content .= '<tr><th scope="colgroup" colspan="12">' . $project->title . '</th></tr>';
  else $content .= '<tr><th scope="colgroup" colspan="12">' . $project->name . ' : Non-affecté / hors-projet</th></tr>';
  // Entête : titre des colonnes
  $content .= '<tr>';
  $content .= '<td scope="col">Date</td><td scope="col">Année</td><td scope="col">Mois (jour)</td><td scope="col">Objet</td><td scope="col">Montant local</td><td scope="col">Devise (si non €)</td><td scope="col">Taux (1€ = ? unités)</td><td scope="col">Montant €</td><td scope="col">TVA déductible € si indiquée et en France</td><td scope="col">Consultant</td><td scope="col">Affectation projets</td><td scope="col">Validation</td>';
  $content .= '</tr>';
  foreach ($project_expenses as $member_guid => $member_expenses) {
    // On ajoute l'entête seulement pour les projets (les membres n'ont pas besoin de séparer les saisies par membre)
    if ($project->guid != $member_guid) {
      // Entête 2 : saisie d'un membre donné
      $content .= '<tr>';
      $content .= '<td scope="colgroup" colspan="12"><strong>' . get_entity($member_guid)->name . ' ('.$member_guid.')</strong></td>';
      $content .= '</tr>';
    }
    
    // Pour chacun des frais du projet de ce membre
    if (is_array($member_expenses)) {
      ksort($member_expenses); // @TODO : Tri par date croissante (revoir structure données ?)
      foreach ($member_expenses as $id => $expenses) {
        if ($show_validated != 'all') {
          if (($show_validated == 'true') && ($expenses['status'] != 'validated')) continue;
          else if (($show_validated == 'false') && ($expenses['status'] == 'validated')) continue;
        }
        $expenses['user_guid'] = $member_guid;
        $expenses['project_guid'] = $project_guid;
        // @TODO : Filtrer par date si $year et/ou $month
        //if ($year && $expenses['']) continue;
        $content .= elgg_view('forms/expenses', array('expenses' => $expenses, 'id' => $id, 'projects' => $projects, 'action' => 'manager'));
      }
    }
    
  }
  $content .= '</table><br />';
} else {
  //$content .= '<tr><td colspan="12">' . elgg_echo('project_manager:nodata') . '</td></tr>';
  //$content .= '<p>' . elgg_echo('project_manager:nodata') . '</p>';
}

echo $content;

