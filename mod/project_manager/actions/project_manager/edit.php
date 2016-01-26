<?php
/**
 * Elgg project_manager action : new or edit project
 * 
 * @package Elggproject_manager
 * @author Facyla @ ITEMS
 * @copyright ITEMS International 2013
 * @link http://items.fr/
 */

global $CONFIG;
gatekeeper();
project_manager_gatekeeper();
// Note : voir aussi protection de l'édition, ssi et une fois le projet connu

$project_guid = get_input("project_manager_guid");
if (!$project_guid) { $action = "create"; }

// Get variables
$title = get_input("title");
$project_code = get_input("project_code");
$description = get_input("description");
$tags = get_input("tags");
$access_id = (int) get_input("access_id");
$write_access_id = (int) get_input("write_access_id");
$container_guid = (int) get_input('container_guid', 0);
if (is_null($container_guid)) { $container_guid == $_SESSION['user']->guid; }
$owner_guid = get_input("owner_guid", false); // On ne passe cette valeur que si un admin édite le projet

$date = get_input("date");
if (strpos($date, '-')) {
	$date = explode('-', $date);
	$date = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
}
$enddate = get_input("enddate");
if (strpos($enddate, '-')) {
	$enddate = explode('-', $enddate);
	$enddate = mktime(0, 0, 0, $enddate[1], $enddate[2], $enddate[0]);
}
$clients = get_input("clients");
$clienttype = get_input("clienttype");
$budget = get_input("budget");
$totaldays = get_input("totaldays");
$globalpercentage = get_input("globalpercentage");
$status = get_input("status");
$projecttype = get_input("project_managertype");
$clientcontact = get_input("clientcontact");
$projectmanager = get_input("projectmanager");
$team = get_input("team");
$fullteam = get_input("fullteam");
$profiles = get_input("profiles");
$other = get_input("other");
$otherhuman = get_input("otherhuman");
$extranet = get_input("extranet");
$ispublic = get_input("ispublic");
$sector = get_input("sector");
$offer_file = get_input("offer_file");
$market_file = get_input("market_file");
$reports_file = get_input("reports_file");
$finalreport_file = get_input("finalreport_file");
$geodata = get_input("geodata");
$scope = get_input("scope");
$notes = get_input("notes");
$startyear = get_input("startyear");
$clientshort = get_input("clientshort");

// On récupère l'objet courant ou on crée un nouvel objet project_manager s'il n'existe pas
if ($action != "create") {
	$project = get_entity($project_guid);	// au lieu de $vars['entity'];
	// Note : La protection de l'édition n'est valable que si le projet existe déjà !
	project_manager_projectdata_gatekeeper($project, elgg_get_logged_in_user_guid(), true, true);
	// Droits supplémentaires pour les admins : accès en modif à l'ensemble des projets
	$is_manager = project_manager_manager_gatekeeper(false, true, false);
	if ($is_manager) {
		// Give access to all users, data, etc.
		$ia = elgg_set_ignore_access(true);
	}
	// L'owner, le chef de projet et les managers/admins peuvent éditer, pas les autres
	if ($project->canEdit() || $is_manager) {
		// OK pour édition
	} else {
		register_error(elgg_echo('project_manager:error:cantedit'));
	}
} else {
	$project = new ElggObject();
	$project->subtype = "project_manager";
}

// L'owner ne peut changer que si un admin a changé l'owner, ou si nouveau projet
if ($owner_guid) {
	$project->owner_guid = $owner_guid;
} else	if ($action == "create") {
	$project->owner_guid = $_SESSION['user']->guid;
}
$project->access_id = $access_id;
$project->write_access_id = $write_access_id;
$project->title = $title;
$project->project_code = $project_code;
$project->description = $description;
if (!is_null($container_guid)) { $project->container_guid = $container_guid; }

$project->date = $date;
$project->enddate = $enddate;
$clientsarray = string_to_tag_array($clients);
$project->clients = $clientsarray;
$project->clienttype = $clienttype;
$project->budget = $budget;
$project->totaldays = $totaldays;
$project->globalpercentage = $globalpercentage;
$project->status = $status;
$project->project_managertype = $projecttype;
$project->clientcontact = $clientcontact;
$project->projectmanager = $projectmanager;
$project->team = $team;
$project->fullteam = $fullteam;
$project->profiles = $profiles;
$project->otherhuman = $otherhuman;
$project->other = $other;
$project->extranet = $extranet;
$project->ispublic = $ispublic;
$project->sector = $sector;
$project->offer_file = $offer_file;
$project->market_file = $market_file;
$project->reports_file = $reports_file;
$project->finalreport_file = $finalreport_file;
$project->geodata = $geodata;
$project->scope = $scope;
$project->notes = $notes;
$project->startyear = $startyear;
$project->clientshort = $clientshort;

$tagarray = string_to_tag_array($tags);
$project->tags = $tagarray;

$result = $project->save();

if ($result) {
	system_message(elgg_echo("project_manager:saved"));
//		add_to_river('river/object/project_manager/create','create',$_SESSION['user']->guid,$project->guid);
} else {
	register_error(elgg_echo("project_manager:savefailed"));
}

if ($is_manager) {
	elgg_set_ignore_access($ia);
}


$container = get_entity($container_guid);
if (elgg_instanceof($container, 'group')) forward($CONFIG->wwwroot . "project_manager/" . $container->username);
else forward($CONFIG->wwwroot . "project_manager");

