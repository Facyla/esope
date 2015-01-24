<?php
	/**
		SCRIPT PHP POUR LE CHARGEMENT DE LA CONFIGURATION
	*/
	include "inc/config.inc.php";
	include "inc/database.inc.php";
	include "inc/utils.inc.php";
	include "inc/cycle.inc.php";

	header('Content-type: application/json');	
	
	$cid = '';
	$gid = 'abcd'; // POUR TEST : A modifier par Florian pour alimenter la variable avec le bon ID de groupe CoCon
	
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
	
	$config = getConfiguration($gid);
	die(json_encode($config));
?>