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
	$project_code = $vars['entity']->project_code;
	$pagetitle = sprintf(elgg_echo("project_manager:edit"),$title);
	$action = "project_manager/edit";
	$description = $vars['entity']->description;
	$tags = $vars['entity']->tags;
	$owner_guid = $vars['entity']->owner_guid;
	$access_id = $vars['entity']->access_id;
	$write_access_id = $vars['entity']->write_access_id;
	$container_guid = $vars['entity']->container_guid;
	$date = $vars['entity']->date;
	$enddate = $vars['entity']->enddate;
	$clients = $vars['entity']->clients;
	$clienttype = $vars['entity']->clienttype;
	$budget = $vars['entity']->budget;
	$totaldays = $vars['entity']->totaldays;
	$status = $vars['entity']->status;
	$project_managertype = $vars['entity']->project_managertype;
	$globalpercentage = $vars['entity']->globalpercentage;
	$clientcontact = $vars['entity']->clientcontact;
	$projectmanager = $vars['entity']->projectmanager;
	$team = $vars['entity']->team;
	$fullteam = $vars['entity']->fullteam;
	$profiles = $vars['entity']->profiles;
	$otherhuman = $vars['entity']->otherhuman;
	$other = $vars['entity']->other;
	$ispublic = $vars['entity']->ispublic;
	$sector = $vars['entity']->sector;
	$offer_file = $vars['entity']->offer_file;
	$market_file = $vars['entity']->market_file;
	$reports_file = $vars['entity']->reports_file;
	$finalreport_file = $vars['entity']->finalreport_file;
	$geodata = $vars['entity']->geodata;
	$scope = $vars['entity']->scope;
	$notes = $vars['entity']->notes;
	$startyear = $vars['entity']->startyear;
	$clientshort = $vars['entity']->clientshort;
	

	// Alertes en cas de données manquantes : code projet, taux...
	if (empty($project_code)) register_error('Le code projet devrait être renseigné : renseignez-vous auprès de la compta pour connaître le code projet -ou le définir ensemble.');
	if (empty($budget)) register_error('Le budget devrait être renseigné.');
	//if (empty($totaldays)) register_error('Le nombre de jours devrait être renseigné.');
	if (empty($project_managertype)) register_error('Le statut du projet devrait être renseigné.');
	if (empty($date) || empty($enddate)) register_error('Les dates du projet devraient être renseignées.');
	if (empty($profiles)) register_error('Les profils ne doivent pas être vides pour permettre de calculer les indicateurs du projet.');
	
} else {
	$pagetitle = elgg_echo("project_manager:new");
	$action = "project_manager/new";
	$title = ""; $description = ""; $budget = "";
	$totaldays = 0;
	$date = ""; $enddate = "";
	$tags = "";
	if (defined('ACCESS_DEFAULT')) { $access_id = ACCESS_DEFAULT; } else { $access_id = 0; }
	if (defined('ACCESS_LOGGED_IN')) { $write_access_id = ACCESS_LOGGED_IN; } else { $write_access_id = 1; }
	$container_guid = get_input('container_guid', 0);
	$clients = ""; $clienttype = ""; $clientcontact = "";
	$status = ""; $project_managertype = ""; $sector = "";
	$globalpercentage = 0;
	$projectmanager = ""; $team = ""; $fullteam = "";
	$profiles = "CMN (consultant manager) : 1000 : 0\nC (consultant) : 700 : 0";
	$otherhuman = ''; $other = '';
	$reports_file = ""; $offer_file = ""; $market_file = ""; $finalreport_file = ""; $ispublic = "";
	$geodata = ""; $scope = "";
	$notes = "";
	$startyear = date('Y');
	$clientshort = "";
}

$user_guid = $_SESSION['guid'];

// Liste de valeur des sélecteurs
$status_values =	array(
		"" => elgg_echo ('project_manager:choose'),
		"new" => elgg_echo('project_manager:status:new'),
		"needinfo" => elgg_echo('project_manager:status:needinfo'),
		"needmanager" => elgg_echo('project_manager:status:needmanager'),
		"needteam" => elgg_echo('project_manager:status:needteam'),
		"writing" => elgg_echo('project_manager:status:writing'),
		"sent" => elgg_echo('project_manager:status:sent'),
	);
	
$project_managertype_values =	array(
		"" => elgg_echo ('project_manager:choose'),
		//"prospect" => elgg_echo ('project_manager:project_managertype:prospect'),
		//"new" => elgg_echo ('project_manager:project_managertype:new'),
		"unsigned" => elgg_echo ('project_manager:project_managertype:unsigned'),
		"current" => elgg_echo ('project_manager:project_managertype:current'),
		//"rejected" => elgg_echo ('project_manager:project_managertype:rejected'),
		"closed" => elgg_echo ('project_manager:project_managertype:closed'),
		//"old" => elgg_echo ('project_manager:project_managertype:old'),
	);


echo '<style>' . elgg_view('project_manager/css') . '</style>';
?>

<div class="contentWrapper">
	<?php
	$info_doc = elgg_echo('project_manager:edit:details');
	echo '<br />';
	echo elgg_view('output/show_hide_block', array('title' => "Informations et mode d'emploi", 'linktext' => "cliquer pour afficher", 'content' => $info_doc));
	echo '<br /><br />';
	
	
	// Le formulaire proprement dit
	echo '<form action="' . $vars['url'] . 'action/' . $action . '" enctype="multipart/form-data" method="post">';
		
		// COLONNE GAUCHE
		echo '<div style="width:56%; float:left;">';
			// Titre
			echo '<p><label>' . elgg_echo("project_manager:title") . ' ' . elgg_view("input/text", array("name" => "title", "value" => $title, 'js' => ' style="width:50ex;"')) . '</label></p>';
			
			// Année de début
			echo '<p><label>' . elgg_echo("project_manager:startyear") . ' ' . elgg_view("input/text", array("name" => "startyear", "value" => $startyear, 'js' => ' style="width:8ex;"')) . '</label></p>';
			
			// Code projet
			echo '<p><label>' . elgg_echo("project_manager:project_code") . ' ' . elgg_view("input/text", array("name" => "project_code", "value" => $project_code, 'js' => ' style="width:12ex;"')) . '</label></p>';
			
			// Statut
			echo '<p><label>' . elgg_echo("project_manager:project_managertype") . ' ' . elgg_view("input/dropdown", array("name" => "project_managertype", "value" => $project_managertype, "options_values" => $project_managertype_values)) . '</label><br /><em>' . elgg_echo("project_manager:project_managertype:details") . '</em></p>';
			
			// Avancement
			//echo '<span style="float:right;">' . elgg_view("output/percentagebar", array("value" => $globalpercentage)) . '</span>';
			echo '<p><label>' . elgg_echo("project_manager:globalpercentage") . ' ' . elgg_view("input/percentage", array("name" => "globalpercentage", "value" => $globalpercentage)) . '</label></p>';
			
			// Budget
			echo '<p><label>' . elgg_echo("project_manager:budget") . ' <input name="budget" value="' . $budget . '" class="elgg-input-text" type="text" style="width:16ex;">&nbsp;€ HT</label></p>';
			
			// Nombre de jours
			/*
			echo '<p><label>' . elgg_echo("project_manager:totaldays") . ' <input name="totaldays" value="' . $totaldays . '" class="elgg-input-text" type="text" style="width:8ex;">&nbsp;jours</label></p>';
			*/
			
			// Dates
			echo '<div style="float:left;"><label>' . elgg_echo('project_manager:date') . ' </span>' . elgg_view("input/date", array("name" => "date", "value" => $date, 'js' => ' style="width:12ex;"')) . '<span class="elgg-icon elgg-icon-calendar"></span> </label> </div>';
			echo '<div style="float:left;"> <label>' . elgg_echo('project_manager:enddate') . ' </span>' . elgg_view("input/date", array("name" => "enddate", "value" => $enddate, 'js' => ' style="width:12ex;"')) . '<span class="elgg-icon elgg-icon-calendar"></span> </label></div>';
			echo '<div class="clearfloat"></div><br />';
			
			// Tags
			echo '<p><label>' . elgg_echo("project_manager:tags") . ' ' . elgg_view("input/tags", array("name" => "tags", "value" => $tags, 'js' => 'style="width:80%;"')) . '</label></p>';
			
		echo '</div>';
		
		
		// COLONNE DROITE : infos client
		echo '<div class="infobox_encart" style="width:40%; float:right;">';
			echo '<h3>' . elgg_echo('project_manager:client') . '</h3>';
			
			// Nom court du client
			echo '<p><label>' . elgg_echo("project_manager:clientshort") . ' ' . elgg_view("input/text", array("name" => "clientshort", "value" => $clientshort, 'js' => ' style="width:12ex;"')) . '</label></p>';
			// Client : organisation
			 echo '<p style="margin-top:10px;"><label>' . elgg_echo("project_manager:clients") . ' ' . elgg_view("input/tags", array("name" => "clients", "value" => $clients)) .'</label></p>';
			// Client : coordonnées
			echo '<p style="margin-top:10px;"><label>' . elgg_echo("project_manager:clientcontact") . elgg_view("input/plaintext", array("name" => "clientcontact", "value" => $clientcontact)) . '</label></p>';
			
			/*
			$categories = elgg_view('categories',$vars);
			if (!empty($categories)) { echo '<p>' . $categories . '</p>'; }
			*/
		echo '</div>';
		
		echo '<div class="clearfloat"></div><br />';
		
		// Notes / remarques sur le budget et les infos précédentes
		echo '<br />';
		echo '<h3>' . elgg_echo("project_manager:notes") . '</h3>';
		echo elgg_view("input/longtext",array( "name" => "notes", "value" => $notes)) . '<br />';
		
		
		// Equipe
		echo '<br />';
		echo '<h3>' . elgg_echo('project_manager:productionteam') . '</h3><br />';
		// Give access to all users, data, etc.
		$ia = elgg_set_ignore_access(true);
		$members_count = elgg_get_entities(array('types' => 'user', 'limit' => 10, 'count' => true));
		$members = elgg_get_entities(array('types' => 'user', 'limit' => $members_count));
		foreach ($members as $ent) {
			if ($ent->items_status == 'salarie') $int_members[] = $ent;
			else if ($ent->items_status == 'non-salarie') $ext_members[] = $ent;
			else $extranet_members[] = $ent;
		}
		elgg_set_ignore_access($ia);
		$user_icon = '<span class="elgg-icon elgg-icon-user"></span> ';
		$users_icon = '<span class="elgg-icon elgg-icon-users"></span> ';
		$people_selector_note = '<em>' . elgg_echo('project_manager:memberselect:details') . '</em><br />';
		// Seuls les admins peuvent changer la propriété du projet
		if (elgg_is_admin_logged_in()) {
			echo '<label>' . elgg_echo('project_manager:owner') . ' ';
			echo elgg_view("input/members_select", array('name' => "owner_guid", 'scope' => 'all', 'value' => $owner_guid)) . $user_icon;
			echo '<br />' . elgg_view('output/members_list', array('value' => $owner_guid)) . '</label>';
		}
		// Chef de projet : possibilité de transférer parmi l'équipe du projet / ou de donner des rôles sur le projet
		//echo elgg_view("input/userpicker", array('name' => "team", 'value' => $team)) . '<br />';
		echo '<label>' . elgg_echo('project_manager:projectmanager') . ' ';
		echo elgg_view("input/members_select", array('name' => "projectmanager", 'scope' => 'all', 'value' => $projectmanager)) . $user_icon;
		echo '<br />' . elgg_view('output/members_list', array('value' => $projectmanager)) . '</label>';
		// Equipe salariée ITEMS
		echo '<strong>' . elgg_echo('project_manager:team') . '&nbsp;:</strong> ';
		$team_field = $people_selector_note . elgg_view("input/friendspicker", array('name' => "team", 'entities' => $int_members, 'highlight' => 'all', 'value' => $team));
		echo $users_icon . elgg_view('output/show_hide_block', array('title' => "", 'linktext' => elgg_echo('project_manager:clicktoselect'), 'content' => $team_field));
		echo '<br />' . elgg_view('output/members_list', array('value' => $team));
		// Equipe non-salariée Items
		echo '<strong>' . elgg_echo('project_manager:fullteam') . '&nbsp;:</strong> ';
		$fullteam_field = $people_selector_note . elgg_view("input/friendspicker", array('name' => "fullteam", 'entities' => $ext_members, 'highlight' => 'all', 'value' => $fullteam, 'title' => elgg_echo("project_manager:fullteam")));
		echo elgg_view('output/show_hide_block', array('title' => "", 'linktext' => $users_icon . elgg_echo('project_manager:clicktoselect'), 'content' => $fullteam_field));
		echo '<br />' . elgg_view('output/members_list', array('value' => $fullteam));
		echo '<div style="width:48%; float:left;">';
		// Production : autres postes humains
		echo '<label>' . elgg_echo('project_manager:otherhuman') . ' ';
		echo elgg_view("input/plaintext", array('name' => "otherhuman", 'value' => $otherhuman, 'title' => elgg_echo("project_manager:otherhuman:details"), 'js' => 'style="height:50px;"')) . '</label><br /><br />';
		echo '</div>';
		echo '<div style="width:48%; float:right;">';
		// Production : autres postes
		echo '<label>' . elgg_echo('project_manager:other') . ' ';
		echo elgg_view("input/plaintext", array('name' => "other", 'value' => $other, 'title' => elgg_echo("project_manager:other:details"), 'js' => 'style="height:50px;"')) . '</label><br /><br />';
		echo '</div>';
		
		// Profils, nombre de jours et taux des consultants
		echo '<strong>' . elgg_echo('project_manager:profilesrates') . '&nbsp;:</strong> ' . elgg_echo('project_manager:profilesrates:details');
		echo elgg_view("input/plaintext", array('name' => "profiles", 'value' => $profiles, 'title' => elgg_echo("project_manager:profilesrates:details"), 'js' => 'style="height:70px;"')) . '<br /><br />';
		
		
		// Container : owner or group
		echo '<br /><h3>Intégration avec les outils collaboratifs</h3>';
		echo '<br /><p><label>' . elgg_echo('project_manager:projectgroup') . ' ' . elgg_view('input/groups_select', array('name' => 'container_guid', 'value' => $container_guid, 'empty_value' => true, 'js' => 'style="max-width:30ex;"')) . '</label>';
		echo '<br /><em>' . elgg_echo('project_manager:projectgroup:details') . '</em>';
		echo '</p>';
		//echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$container_guid}\" />";
		
		// Accès extranet (sans accès au projet ni feuille de temps)
		echo '<em style="font-weight:bold;">FONCTIONNALITE EXTRANET (EN TEST) - n\'a aucun impact sur le projet ni les accès au groupe.</em><br />';
		echo '<label>' . elgg_echo('project_manager:extranet') . ' (' . elgg_echo('project_manager:extranet:details') . ')</label>';
		$extranet_field = elgg_view("input/friendspicker", array('name' => "extranet", 'entities' => $members, 'highlight' => 'all', 'value' => $extranet, 'title' => elgg_echo("project_manager:extranet")));
		echo elgg_view('output/show_hide_block', array('title' => "", 'linktext' => elgg_echo('project_manager:clicktoselect'), 'content' => $extranet_field));
		echo '<br />' . elgg_view('output/members_list', array('value' => $extranet));
		
		// Description détaillée
		echo '<br />';
		echo '<h3>' . elgg_echo("project_manager:description") . '</h3>';
		echo elgg_view("input/longtext",array( "name" => "description", "value" => $description)) . '<br />';
		
		// Accès à ce projet : @TODO membres du projet seulement (déduit des droits associés)
		echo '<p style="float:left; width:40%; margin-right:10%;"><label>' . elgg_echo('project_manager:readaccess') . '<br />' . elgg_view('input/access', array('name' => 'access_id','value' => $access_id)) . '</label></p>';
		
		echo '<div class="clearfloat"></div>';
		
		// GUID
		if (isset($vars['entity']))
			echo "<input type=\"hidden\" name=\"project_manager_guid\" value=\"{$vars['entity']->guid}\" />";
		echo elgg_view('input/securitytoken');
		
		// Submit button
		echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo("project_manager:save"))) . '</p>';
		
		echo '</form>';
		?>
</div>

