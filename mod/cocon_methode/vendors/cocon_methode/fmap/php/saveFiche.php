<?php
	include "../../php/inc/config.inc.php";
	include "../../php/inc/database.inc.php";
	include "../../php/inc/utils.inc.php";
	include "../../php/inc/cycle.inc.php";
	include "../../php/inc/fmap/fiche.inc.php";
	
	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Données JSON
	$fiche = array(
		"error" => false,
		"error_string" => ''
	);

	$fiche = json_decode(json_encode($fiche));
	
	/**
		Récupère la structure JSON et crée l'objet
	*/
	if(isset($_POST['json'])){
		$fiche = json_decode($_POST['json']);
	}else{
		$fiche->error = true;
		$fiche->error_string = "Les données JSON n'ont pas été transmises.";
		die(json_encode(json_decode(json_encode($fiche),true)));
	}

	/**
		Mise à jour de la fiche
	*/
	if(!updateFiche($fiche)){
		$fiche->error = true;
		$fiche->error_string = "Erreur lors de l'enregistrement de la fiche.";
		die(json_encode(json_decode(json_encode($fiche),true)));
	}

	$fiche = json_decode(json_encode($fiche),true);
	die(json_encode($fiche));
?>