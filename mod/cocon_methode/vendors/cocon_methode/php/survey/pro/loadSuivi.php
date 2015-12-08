<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))))) . '/engine/start.php';
	
	//include_once "../../inc/config.inc.php";
	//include_once "../../inc/database.inc.php";
	//include_once "../../../php/inc/utils.inc.php";
	//include_once "../../../php/inc/cycle.inc.php";
	include_once "../../../php/inc/survey/pro/session.inc.php";

	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Données JSON
	$suivi = array(
		"error" => '',
		"error_string" => '',
		'invitations' => 0,
		'complets' => 0,
		'en_cours' => 0,
		'en_attente' => 0
	);

	$cid = '';
	$gid = '';
	
	/**
		Récupère l'ID du cycle
	*/
	if(isset($_POST['cid']) && $_POST['cid'] != '' && $_POST['cid'] != 'undefined'){
		$cid = $_POST['cid'];
	}else{
		$suivi['error'] = true;
		$suivi['error_string'] = "ID du cycle";
	}

	/**
		Récupère l'ID du groupe CoCon
	*/
	if(isset($_POST['gid']) && $_POST['gid'] != '' && $_POST['gid'] != 'undefined'){
		$gid = $_POST['gid'];
	}else{
		$suivi['error'] = true;
		$suivi['error_string'] = "ID de goupe manquant";
	}

	// Il y a une erreur, on renvoi au navigateur 
	if($suivi['error'] == true){
		die(json_encode($suivi));
	}

	// On récupère le suivi
	$conn = connectDB();
	$sql = 'SELECT * from SESSION WHERE CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and ACTIVE=1';
	//die($sql);
	$result = executeQuery($conn, $sql);
	if(!$result){
		$suivi['error'] = true;
		$suivi['error_string'] = "Erreur lors du chargement du suivi.\n".mysql_error();
	}else{
		$suivi['invitations'] = mysql_num_rows($result);
		while($row = mysql_fetch_assoc($result)){

		if($row['ETAT'] == 0){
				$suivi['en_attente']++;
			}

			if($row['ETAT'] == 1){
				$suivi['en_cours']++;
			}

			if($row['ETAT'] == 2){
				$suivi['complets']++;
			}
		}
	}
	die(json_encode($suivi));
?>
