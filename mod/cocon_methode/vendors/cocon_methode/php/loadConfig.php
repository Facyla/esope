<?php
/**
	SCRIPT PHP POUR LE CHARGEMENT DE LA CONFIGURATION
*/
require_once "inc/config.inc.php";
require_once "inc/database.inc.php";
require_once "inc/utils.inc.php";
require_once "inc/cycle.inc.php";

header('Content-type: application/json');

$cid = '';
//$gid = 'abcd'; // POUR TEST : A modifier par Florian pour alimenter la variable avec le bon ID de groupe CoCon
// Intégration Cocon Méthode
$gid = cocon_methode_get_user_group();

/*
$config = array(
	"error" => false,
	"error_string" => "",
	"cycle_id" => "",
	"group_id" => $gid,
	"group_name" => "", // Nom du groupe CoCon associé au visiteur
	"user_id" => "", // ID du visiteur
	"user_name" => "", // Nom et prénom du visiteur
	"user_role" => -1 // Role du visiteur
);
*/

$config = getConfiguration($gid);
$_SESSION['check_id'] = md5($gid.'_'.$config['cycle_id']);
error_log("Cocon Kit start : loadConfig : {$_SESSION['check_id']} = $gid - $config['cycle_id']")); // debug

die(json_encode($config));

