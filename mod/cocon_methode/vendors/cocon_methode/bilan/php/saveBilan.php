<?php
	include_once "../../php/inc/config.inc.php";
	include_once "../../php/inc/database.inc.php";
	include_once "../../php/inc/utils.inc.php";
	include_once "../../php/inc/cycle.inc.php";
	include_once "../../php/inc/bilan/bilan.inc.php";
	
	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Données JSON
	$bilan = array(
		"error" => false,
		"error_string" => ''
	);

	$bilan = json_decode(json_encode($bilan));
	
	/**
		Récupère la structure JSON et crée l'objet
	*/
	if(isset($_POST['json'])){
		$bilan = json_decode($_POST['json']);
	}else{
		$bilan->error = true;
		$bilan->error_string = "Les données JSON n'ont pas été transmises.";
		die(json_encode(json_decode(json_encode($bilan),true)));
	}

	/**
		Mise à jour de la fiche
	*/
	if(!updateBilan($bilan)){
		$bilan->error = true;
		$bilan->error_string = "Erreur lors de l'enregistrement de la fiche bilan.\n".mysql_error();
		die(json_encode(json_decode(json_encode($bilan),true)));
	}

	$bilan = json_decode(json_encode($bilan),true);
	die(json_encode($bilan));
?>
