<?php
	include_once "../../php/inc/config.inc.php";
	include_once "../../php/inc/database.inc.php";
	include_once "../../php/inc/utils.inc.php";
	include_once "../../php/inc/cycle.inc.php";
	include_once "../../php/inc/fmap/fiche.inc.php";
	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Données JSON
	$fiche = array(
		"error" => false,
		"error_string" => "",
		"fiche_id" => "",
		"cycle_id" => "",
		"group_id" => "",
		"user_id" => "",
		"active" => 1,
		"nom" => "",
		"theme" => "",
		"equipe" => "",
		"zone1" => "",
		"zone2" => "",
		"zone3" => "",
		"zone4" => "",
		"zone5" => "",
		"zone6" => "",
		"zone7" => "",
		"zone8" => "",
		"zone9" => "",
		"zone10" => "",
		"zone11" => ""
	);

	$fid = '';

	/**
		Récupère l'ID de la fiche
	*/
	if(isset($_POST['fid']) && $_POST['fid'] != '' && $_POST['fid'] != 'undefined'){
		$fid = $_POST['fid'];
	}else{
		$fiche['error'] = true;
		$fiche['error_string'] = "ID de la fiche";
	}

	// Il y a une erreur, on renvoi au navigateur 
	if($fiche['error'] == true){
		die(json_encode($fiche));
	}
	
	$fiche['fiche_id'] = $fid;
	$fiche['active'] = 0;
	if(!removeFiche($fiche)){
		$fiche = array(
			"error" => true,
			"error_string" => mysql_error()
		);	
	}
	
	die(json_encode($fiche));
?>
