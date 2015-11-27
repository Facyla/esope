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
		"error" => '',
		"error_string" => ''
	);

	$cid = '';
	$gid = '';
	
	/**
		Récupère l'ID du cycle
	*/
	if(isset($_POST['cid']) && $_POST['cid'] != '' && $_POST['cid'] != 'undefined'){
		$cid = $_POST['cid'];
	}else{
		$bilan['error'] = true;
		$bilan['error_string'] = "ID du cycle manquant";
	}
	/**
		Récupère l'ID du groupe CoCon
	*/
	if(isset($_POST['gid']) && $_POST['gid'] != '' && $_POST['gid'] != 'undefined'){
		$gid = $_POST['gid'];
	}else{
		$bilan['error'] = true;
		$bilan['error_string'] = "ID de goupe manquant";
	}

	// Il y a une erreur, on renvoi au navigateur 
	if($bilan['error'] == true){
		die(json_encode($bilan));
	}
	
	/**
		On récupère la fiche
	*/
	// Chargement de la fiche existante
	$bilan['cycle_id'] = $cid;
	$bilan['group_id'] = $gid;
	$datas = loadBilan($bilan);
	if(!$datas){
		$bilan['error'] = true;
		$bilan['error_string'] = mysql_error();//"Erreur lors du chargement de la session.";			
	}else{
		$bilan = $datas;
	}
	
	die(json_encode($bilan));
?>
