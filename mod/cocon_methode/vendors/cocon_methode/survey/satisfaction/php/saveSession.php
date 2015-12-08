<?php
	include_once "../../../php/inc/config.inc.php";
	include_once "../../../php/inc/database.inc.php";
	include_once "../../../php/inc/utils.inc.php";
	include_once "../../../php/inc/cycle.inc.php";
	include_once "../../../php/inc/survey/satisfaction/session.inc.php";
	include_once "../../../php/inc/survey/satisfaction/calcul.inc.php";
	
	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Données JSON
	$survey = array(
		"error" => false,
		"error_string" => ''
	);

	$survey = json_decode(json_encode($survey));
	
	/**
		Récupère la structure JSON et crée l'objet
	*/
	if(isset($_POST['json'])){
		$survey = json_decode($_POST['json']);
	}else{
		$survey->error = true;
		$survey->error_string = "Les données JSON n'ont pas été transmises.";
		die(json_encode(json_decode(json_encode($survey),true)));
	}

	/**
		La session est-elle verrouillée ?
	*/
	if(!sessionLocked($survey->session_id)){
		/**
			Mise à jour des entêtes de la session
		*/
		if(!updateEntetesSession($survey)){
			$survey->error = true;
			$survey->error_string = "Erreur lors de l'enregistrement des informations du répondant.";
			die(json_encode(json_decode(json_encode($survey),true)));
		}

		/**
			Mise à jour des réponses de la session
		*/
		if(!updateReponsesSession($survey)){
			$survey->error = true;
			$survey->error_string = "Erreur lors de l'enregistrement des réponses.";
			die(json_encode(json_decode(json_encode($survey),true)));
		}
	}
	$survey = json_decode(json_encode($survey),true);
	die(json_encode($survey));
?>
