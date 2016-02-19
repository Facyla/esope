<?php
/**
 * @author Facyla
 * @link http://id.facyla.net/
 */

// Get required data		
elgg_set_context('search');  // display results in search mode, which is list view		
	
// Pas d'exit pour éviter la page blanche, mais rien à afficher si pas loggué..
if (elgg_is_logged_in()) {
  if(isset($vars['entities'])) {
    $project_managers = $vars['entities'];
    $nb_project_managers = count($project_managers);
  } else {
    //$nb_project_managers = get_entities('object', 'project_manager', 0, "", $limit, 0, true);	// Nombre de project_managers
    //$project_managers = get_entities('object', 'project_manager', 0, "", $nb_project_managers, 0, false);	// Toutes les project_managers
    $nb_project_managers = elgg_get_entities(array('type' => 'object', 'subtype' => 'project_manager', 'limit' => $limit, 'count' => true));	// Nombre de project_managers
    $project_managers = elgg_get_entities(array('type' => 'object', 'subtype' => 'project_manager', 'limit' => $nb_project_managers, 'count' => false));	// Toutes les project_managers
  }
  ?>
  <br />
  <h3><?php echo elgg_echo('project_manager:references:description'); ?></h3><br />

  <style>
  table th { font-weight:bold; text-align:center; border: 2px solid #555555; padding:3px; }
  table td { font-weight:normal; border: 1px 1px 2px 2px solid #555555; padding:3px; text-align:left; }
  table td a { font-weight:normal; }
  #references_table { width:100%; border:3px solid #555555; border-collapse:collapse; }
  /*
  table .owner_timestamp { display:none; }
  table .search_listing_icon { display:none; }
  */
  </style>

  
  <table id="references_table" style="max-width:98%; overflow:auto;">
  <thead>
  <tr>
    <th><?php echo $nb_project_managers; ?> project_managers</th>
    <th>Budget</th>
    <th>Type d'acteur</th>
    <th>Secteur</th>
    <th>Client</th>
    <!--
    <th>Contact client</th>
    //-->
    <th>Statut</th>
    <th>Début</th>
    <th>Fin</th>
    <th>Mise à jour</th>
  </tr>
  </thead>
  
  <tbody>
  <?php
  $limit = 99999;
  foreach($project_managers as $project_manager) {
    $date = (empty($project_manager->date)) ? "-" : $project_manager->date;
    $enddate = (empty($project_manager->enddate)) ? $date : $project_manager->enddate;
    // Note : attention en modifiant les colonnes : faut répercuter dans la config des tris JS
    echo '<tr>'
      . '<td><a href="' . $project_manager->getUrl() . '">' . $project_manager->title . '</a></td>'
      . '<td>' . $project_manager->budget . '</td>'
      . '<td>' . elgg_echo('project_manager:clienttypes:' . $project_manager->clienttype) . '</td>'
      . '<td>' . elgg_echo('project_manager:sector:' . $project_manager->sector) . '</td>'
//      . '<td>' . implode(", ", $project_manager->clients) . '</td>'
      . '<td>' . $project_manager->clientcontact . '</td>'
      . '<td>' . elgg_echo('project_manager:project_managertype:' . $project_manager->project_managertype) . '</td>'
      . '<td>' . date("Y/m", $date) . '</td>'
      . '<td>' . date("Y/m", $enddate) . '</td>'
      . '<td>' . elgg_view_friendly_time($project_manager->time_updated) . '</td>'
      . '</tr>';
  }
  ?>
  </tbody>
  </table>

  <script language="javascript" type="text/javascript">  
  var tconfig = {
    // Filtrage en cours de frappe
    on_keyup: true,
    on_keyup_delay: 1200,
    msg_filter: 'Filtrage...',

    // Paramètres généraux
    filters_row_index: 1, // 0 au-dessus, 1 en-dessous
//    loader_html: '<h4 style="color:red;">Chargement en cours...</h4>',
//    remember_grid_values: true,
    
    // Tris
    refresh_filters: true,
    sort: true,  
    sort_config: {
      sort_types:['String','String','String','String','String','ymddate','ymddate','String'],
      //sort_col: [6,true],
      sort_col: [7,true],
      async_sort:true
    },

    // Réglages des filtres
    col_2: "select",
    col_3: "select",
    col_5: "select",
    display_all_text: " [ Tout ] ",
    sort_select: true,
    
    // Dimensions et alternance couleurs
    alternate_rows: true,  
    col_width: ["200px",null,null,null,"70px","70px",null], //prevents column width variations

  };
  var tf1 = setFilterGrid("references_table", tconfig);
  </script>
  
  <?php

} else {
  echo "-";
}

