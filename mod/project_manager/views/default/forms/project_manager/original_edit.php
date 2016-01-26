<?php
/**
 * Elgg project_manager browser edit
 * 
 * @package Elggproject_manager
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

global $CONFIG;

if (isset($vars['entity'])) {
  $title = $vars['entity']->title;
  $pagetitle = sprintf(elgg_echo("project_manager:edit"),$title);
  $action = "project_manager/edit";
  $description = $vars['entity']->description;
  $tags = $vars['entity']->tags;
  $access_id = $vars['entity']->access_id;
  $write_access_id = $vars['entity']->write_access_id;
  $date = $vars['entity']->date;
  $enddate = $vars['entity']->enddate;
  $clients = $vars['entity']->clients;
  $clienttype = $vars['entity']->clienttype;
  $budget = $vars['entity']->budget;
  $status = $vars['entity']->status;
  $project_managertype = $vars['entity']->project_managertype;
  $clientcontact = $vars['entity']->clientcontact;
  $projectmanager = $vars['entity']->projectmanager;
  $team = $vars['entity']->team;
  $fullteam = $vars['entity']->fullteam;
  $ispublic = $vars['entity']->ispublic;
  $sector = $vars['entity']->sector;
  $offer_file = $vars['entity']->offer_file;
  $market_file = $vars['entity']->market_file;
  $reports_file = $vars['entity']->reports_file;
  $finalreport_file = $vars['entity']->finalreport_file;
  $geodata = $vars['entity']->geodata;
  $scope = $vars['entity']->scope;

} else {
  $pagetitle = elgg_echo("project_manager:new");
  $action = "project_manager/new";
  $title = ""; $description = ""; $budget = ""; $date = ""; $enddate = "";
  $tags = "";
  if (defined('ACCESS_DEFAULT')) { $access_id = ACCESS_DEFAULT; } else { $access_id = 0; }
  if (defined('ACCESS_LOGGED_IN')) { $write_access_id = ACCESS_LOGGED_IN; } else { $write_access_id = 1; }
  $clients = ""; $clienttype = ""; $clientcontact = "";
  $status = ""; $project_managertype = ""; $sector = "";
  $projectmanager = ""; $team = ""; $fullteam = "";
  $reports_file = ""; $offer_file = ""; $market_file = ""; $finalreport_file = ""; $ispublic = "";
  $geodata = ""; $scope = "";
}

$user_guid = $_SESSION['guid'];

// Liste de valeur des sélecteurs
$status_values =  array(
  "" => elgg_echo ('project_manager:choose'),
  "new" => elgg_echo('project_manager:status:new'),
  "needinfo" => elgg_echo('project_manager:status:needinfo'),
  "needmanager" => elgg_echo('project_manager:status:needmanager'),
  "needteam" => elgg_echo('project_manager:status:needteam'),
  "writing" => elgg_echo('project_manager:status:writing'),
  "sent" => elgg_echo('project_manager:status:sent'),
  );

$project_managertype_values =  array(
  "" => elgg_echo ('project_manager:choose'),
  "prospect" => elgg_echo ('project_manager:project_managertype:prospect'),
  "new" => elgg_echo ('project_manager:project_managertype:new'),
  "current" => elgg_echo ('project_manager:project_managertype:current'),
  "old" => elgg_echo ('project_manager:project_managertype:old'),
  );

$ispublic_values =  array(
  "" => elgg_echo ('project_manager:choose'),
  "public" => elgg_echo ('project_manager:public'),
  "private" => elgg_echo ('project_manager:private'),
  "ask" => elgg_echo ('project_manager:ask'),
  );

$clienttypes_values =  array(
  "" => elgg_echo ('project_manager:choose'),
  "entreprise" => elgg_echo ('project_manager:clienttypes:entreprise'),
//  "public" => elgg_echo ('project_manager:clienttypes:public'),
  "servicecentral" => elgg_echo('project_manager:clienttypes:servicecentral'),
  "ministere" => elgg_echo('project_manager:clienttypes:ministere'),
  "collectivite" => elgg_echo ('project_manager:clienttypes:collectivite'),
  "cr" => elgg_echo('project_manager:clienttypes:cr'),
  "cg" => elgg_echo('project_manager:clienttypes:cg'),
  "interco" => elgg_echo('project_manager:clienttypes:interco'),
//  "mix" => elgg_echo ('project_manager:clienttypes:mix'),
  "pole" => elgg_echo('project_manager:clienttypes:pole'),
  "association" => elgg_echo('project_manager:clienttypes:association'),
  // Autres
  "developpement" => elgg_echo('project_manager:clienttypes:developpement'),
  "self" => elgg_echo ('project_manager:clienttypes:self'),
  "other" => elgg_echo ('project_manager:clienttypes:other'),
  );

$sector_values =  array(
  "" => elgg_echo ('project_manager:choose'),
//  "private" => elgg_echo ('project_manager:sector:private'),
  "transport" => elgg_echo('project_manager:sector:transport'),
  "energie" => elgg_echo('project_manager:sector:energie'),
  "banque" => elgg_echo('project_manager:sector:banque'),
  "education" => elgg_echo('project_manager:sector:education'),
  "tv" => elgg_echo('project_manager:sector:tv'),
  "sante" => elgg_echo('Santé'),
  "service" => elgg_echo('project_manager:sector:service'),
  "informatique" => elgg_echo('project_manager:sector:informatique'),
  "media" => elgg_echo('project_manager:sector:media'),
  "culture" => elgg_echo('project_manager:sector:culture'),
  "other" => elgg_echo ('project_manager:sector:other'),
  );

$scope_values =  array(
  "" => elgg_echo('project_manager:choose'),
  "world" => elgg_echo('project_manager:scope:world'),
//  "continent" => elgg_echo('project_manager:scope:continent'),
  "europe" => elgg_echo('project_manager:scope:europe'),
//  "etat" => elgg_echo('project_manager:scope:etat'),
  "france" => elgg_echo('project_manager:scope:france'),
  "uk" => elgg_echo('project_manager:scope:uk'),
  "japon" => elgg_echo('project_manager:scope:japon'),
  "algerie" => elgg_echo('project_manager:scope:algerie'),
  "region" => elgg_echo('project_manager:scope:region'),
  "departement" => elgg_echo('project_manager:scope:departement'),
  "interco" => elgg_echo('project_manager:scope:interco'),
  "commune" => elgg_echo('project_manager:scope:commune'),
  "local" => elgg_echo('project_manager:scope:local'),
  );

?>

<div class="contentWrapper">
  <?php
  // Le formulaire proprement dit
  echo '<form action="' . $vars['url'] . 'action/' . $action . '" enctype="multipart/form-data" method="post">';
  
  echo elgg_view('input/securitytoken');
//    if ($action == "project_manager/new") {}
    
    echo '<div style="width:46%; padding:8px 5px; float:left; border:1px solid lightgrey; margin:0 8px 5px 0;">';
//    echo '<p style="float:right;"><strong>' . elgg_echo("project_manager:status") . '</strong> ' . elgg_view("input/pulldown", array("internalname" => "status", "value" => $status, "options_values" => $status_values, )) . '</p>';
    echo '<h3>Informations</h3><br class="clearfloat" />';
    echo '<p style="vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:title") . '</strong> <input name="title" value="' . $title . '" class="input-text" type="text" style="width:80%; float:right;"></p>';
    echo '<p style="margin-top:10px; vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:budget") . '</strong> <input name="budget" value="' . $budget . '" class="input-text" type="text" style="width:70%; float:right;"></p>';
    echo '<p style="margin-top:10px; vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:clients") . '</strong> <input name="clients" value="' . implode(", ", $clients) . '" class="input-text" type="text" style="width:75%; float:right;"></p>';
    echo '<pstyle="margin-top:10px; vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:clienttype") . ' ' . elgg_view("input/pulldown", array("internalname" => "clienttype", "value" => $clienttype, "options_values" => $clienttypes_values )) . '</strong></p>';
//    echo '<p><strong>' . elgg_echo("project_manager:clienttype") . ' ' . elgg_view("input/pulldown", array("internalname" => "clienttype", "value" => $clienttype, "options_values" => $clienttypes_values, 'js' => 'multiple="multiple" size="5"' )) . '</strong></p>';
    echo '<p style="margin-top:10px; vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:sector") . ' ' . elgg_view("input/pulldown", array("internalname" => "sector", "value" => $sector, "options_values" => $sector_values, )) . '</strong></p>';
    echo '<p style="margin-top:10px; vertical-align:bottom; line-height:30px;"><strong><a href="#" title="' . elgg_echo("project_manager:clientcontact") . '">Contact</a></strong> <input name="clientcontact" value="' . $clientcontact . '" class="input-text" type="text" style="width:70%; float:right;"></p>';
    echo '<p style="margin-top:10px; vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:projectmanager") . '</strong> <input name="projectmanager" value="' . $projectmanager . '" class="input-text" type="text" style="width:60%; float:right;"></p>';

    echo '<p><strong>' . elgg_echo("project_manager:ispublic") . '</strong> ' . elgg_view("input/pulldown", array("internalname" => "ispublic", "value" => $ispublic, "options_values" => $ispublic_values, )) . '</p>';
    
    echo '</div>';
?>
    <div style="width:46%; padding:8px 5px; float:left; border:1px solid lightgrey; margin:0 8px 5px 0;">
<?php
    echo '<p style="float:right;"><strong>' . elgg_echo("project_manager:project_managertype") . '</strong> ' . elgg_view("input/pulldown", array("internalname" => "project_managertype", "value" => $project_managertype, "options_values" => $project_managertype_values, )) . '</p>';
    echo '<h3>Projet</h3><br class="clearfloat" />';
    echo '<div style="float:left;">';
      echo '<strong>Dates du projet, du ... au ...</strong><br />';
      echo '<div style="float:left; margin-right:10px;">' . elgg_view("input/calendar", array("internalname" => "date", "value" => $date, )) . '</div>';
      echo '<div style="float:left;">' . elgg_view("input/calendar", array("internalname" => "enddate", "value" => $enddate, )) . '</div>';
    echo '</div>';
    echo '<div class="clearfloat"></div><br />';
    echo '<p style="float:right;"><strong>' . elgg_echo("project_manager:scope") . '</strong> ' . elgg_view("input/pulldown", array("internalname" => "scope", "value" => $scope, "options_values" => $scope_values, )) . '</p>';
    echo '<p style="vertical-align:bottom; line-height:30px;"><strong>' . elgg_echo("project_manager:geodata") . '</strong> <input name="geodata" value="' . $geodata . '" type="text" style="width:96%;"></p>';
    echo '<div class="clearfloat"></div>';
    /*
    $categories = elgg_view('categories',$vars);
    if (!empty($categories)) { echo '<p>' . $categories . '</p>'; }
    */
    echo '<p>' . elgg_echo("project_manager:files") . '</p>';

//    echo '<p><strong>' . elgg_echo("project_manager:file:offer") . '</strong> <input name="offer_file" class="input-file" type="file" style="float:right;"><br />';
echo '<p><strong><a href="' . $vars['url'] . 'mod/project_manager/embed.php?internalname=offer_file_picker" title="Cliquez pour ajouter des documents" title="Cliquez pour ajouter des documents" rel="facebox">' . elgg_echo("project_manager:file:offer") . elgg_echo("project_manager:file:clicktoadd") . '</a></strong><input id="offer_file_picker" name="offer_file" size="16" style="float:right;" type="text" value ="' . $offer_file . '" /></p>';

//    echo '<p><strong>' . elgg_echo("project_manager:file:market") . '</strong> <input name="market_file" class="input-file" type="file" style="float:right;"></p>';
echo '<p><strong><a href="' . $vars['url'] . 'mod/project_manager/embed.php?internalname=market_file_picker" title="Cliquez pour ajouter des documents" rel="facebox">' . elgg_echo("project_manager:file:market") . elgg_echo("project_manager:file:clicktoadd") . '</a></strong><input id="market_file_picker" name="market_file" size="16" style="float:right;" type="text" value ="' . $market_file . '" /></p>';

//    echo '<p><strong>' . elgg_echo("project_manager:file:finalreport") . '</strong> <input name="finalreport_file" class="input-file" type="file" style="float:right;"><br />';
echo '<p><strong><a href="' . $vars['url'] . 'mod/project_manager/embed.php?internalname=finalreport_file_picker" title="Cliquez pour ajouter des documents" rel="facebox">' . elgg_echo("project_manager:file:finalreport") . elgg_echo("project_manager:file:clicktoadd") . '</a></strong><input id="finalreport_file_picker" name="finalreport_file" size="16" style="float:right;" type="text" value ="' . $finalreport_file . '" /></p>';

//    echo '<p><strong>' . elgg_echo("project_manager:file:reports") . '</strong> <input name="reports_file" class="input-file" type="file" style="float:right;"></p>';
    //get_user_objects($user_guid, $subtype = "", $limit = 10, $offset = 0, $timelower = 0, $timeupper = 0 )
    // Facyla : Objects and friends picker ;)  TODO : configurer pour passer le types d'objects voulus depuis cet appel de vue
    //$user_files = get_user_objects($user_guid, 'file', 999999);
    //$user_files = get_entities('object', 'file', '', '', 999999, 0, false);
    $user_files = elgg_get_entities(array('types' => 'object', 'subtypes' => 'file', 'limit' => 999999));
    echo elgg_view("project_manager/modal_picker", array('internalname' => "reports_file", 'entities' => $user_files, 'highlight' => 'all', 'entitiestype' => "object/file", 'value' => $reports_file, 'title' => "Pièces jointes", 'description' => "Choisissez un ou plusieurs autres documents à joindre à cette project_manager")) . '<br />';

    echo '</div>';
    
    echo '<div class="clearfloat"></div><br />';
    
    //$count = get_entities('user', '', '', '', 9999, 0, true);
    //$members = get_entities('user', '', '', '', $count, 0, false);
    $count = elgg_get_entities(array('types' => 'user', 'limit' => 9999, 'count' => true));
    $members = elgg_get_entities(array('types' => 'user', 'limit' => $count));
    echo elgg_view("project_manager/modal_picker", array('internalname' => "team", 'entities' => $members, 'highlight' => 'all', 'entitiestype' => "user", 'value' => $team, 'title' => elgg_echo("project_manager:team"), 'description' => "Choisissez une ou plusieurs pièces à joindre à ce dossier")) . '<br />';

    echo '<p><strong>' . elgg_echo("project_manager:fullteam") . '</strong> <input name="fullteam" value="' . $fullteam . '" class="input-text" type="text" style="width:70%;"></p><br />';
    
    echo '<br /><p class="longtext_editarea"><strong>' . elgg_echo("project_manager:description") . '<br />' . elgg_view("input/longtext",array( "internalname" => "description", "value" => $description, )) . '</strong></p>';
    
    echo '<p style="vertical-align:bottom;"><strong>' . elgg_echo("project_manager:tags") . ' </strong><input autocomplete="on" name="tags" value="' . implode(", ", $tags) . '" class="input-tags ac_input" type="text" style="width:80%; float:right;"></p>';
    
    echo '<div class="clearfloat"></div>';
    echo '<p style="float:left; width:40%; margin-right:10%;"><strong>' . elgg_echo('project_manager:readaccess') . '<br />' . elgg_view('input/access', array('internalname' => 'access_id','value' => $access_id)) . '</strong></p>';
    echo '<p style="float:left; width:40%;"><strong>' . elgg_echo('project_manager:writeaccess') . '<br />' . elgg_view('input/access', array('internalname' => 'write_access_id','value' => $write_access_id)) . '</strong></p>';
    
    echo '<div class="clearfloat"></div>';
    echo '<p>';
      if (isset($vars['container_guid']))
        echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
      if (isset($vars['entity']))
        echo "<input type=\"hidden\" name=\"project_manager_guid\" value=\"{$vars['entity']->getGUID()}\" />";
      
      echo elgg_view('input/submit', array('value' => elgg_echo("project_manager:save")));
    echo '</p>';
    
    echo '</form>';
    ?>
</div>
