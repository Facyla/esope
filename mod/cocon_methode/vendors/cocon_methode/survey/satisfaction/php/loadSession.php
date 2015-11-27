<?php
	include_once "../../../php/inc/config.inc.php";
	include_once "../../../php/inc/database.inc.php";
	include_once "../../../php/inc/utils.inc.php";
	include_once "../../../php/inc/cycle.inc.php";
	include_once "../../../php/inc/survey/satisfaction/session.inc.php";

	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Données JSON
	$survey = array(
		"error" => '',
		"error_string" => ''
	);

	$sid = '';
	$cid = '';
	$gid = '';
	$uid = '';
	
	/**
		Récupère l'ID du groupe CoCon
	*/
	if(isset($_POST['gid']) && $_POST['gid'] != '' && $_POST['gid'] != 'undefined'){
		$gid = $_POST['gid'];
	}else{
		$survey['error'] = true;
		$survey['error_string'] = "ID de goupe manquant";
	}

	/**
		Récupère l'ID du membre CoCon
	*/
	if(isset($_POST['uid']) && $_POST['uid'] != '' && $_POST['uid'] != 'undefined'){
		$uid = $_POST['uid'];
	}else{
		$survey['error'] = true;
		$survey['error_string'] = "ID de membre manquant";
	}

	// Il y a une erreur, on renvoi au navigateur 
	if($survey['error'] == true){
		die(json_encode($survey));
	}
	
	// Récupère l'ID du cycle
	$cid = getCurrentCycleID($gid);
	
	// Il n'y a pas de cycle pour ce groupe CoCon
	if(!$cid){
		$survey['error'] = true;
		$survey['error_string'] = "Le principal de votre établissement n'a démarré aucun cycle pour la démarche.";
	}
	
	// Il y a une erreur, on renvoi au navigateur 
	if($survey['error'] == true){
		die(json_encode($survey));
	}
	
	/**
		On récupère la session
	*/
	$sid = '';
	$sid = getSessionID($cid, $gid, $uid);
	
	// Il n'y a pas de session
	if(!$sid){
		
		// Prepare l'objet JSON
		$survey = prepareSessionArray('', $cid, $gid, $uid);
		
		// Création d'un nouvelle session
		$sid = createSession($survey['cycle_id'],  $survey['group_id'], $survey['user_id']);
		if(!$sid){
			$survey['error'] = true;
			$survey['error_string'] = "Erreur lors de la création de la session.";			
		}else{
			$survey['session_id'] = $sid;
		}
		
	}else{
		
		// Prepare l'objet JSON
		$survey = prepareSessionArray($sid, $cid, $gid, $uid);

		// Chargement de la session existante
		$survey['session_id'] = $sid;
		$datas = loadSession($survey);
		if(!$datas){
			$survey['error'] = true;
			$survey['error_string'] = mysql_error();//"Erreur lors du chargement de la session.";			
		}else{
			$survey = $datas;
		}
	}
	
	die(json_encode($survey));
?>
