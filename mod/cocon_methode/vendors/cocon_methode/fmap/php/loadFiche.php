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
		"error" => '',
		"error_string" => ''
	);

	$fid = '';
	$cid = '';
	$gid = '';
	$uid = '';
	
	/**
		Récupère l'ID de la fiche de mise en pratique
	*/
	if(isset($_POST['fid']) && $_POST['fid'] != '' && $_POST['fid'] != 'undefined'){
		$fid = $_POST['fid'];
	}else{
		$fiche['error'] = true;
		$fiche['error_string'] = "ID de la fiche manquant";
	}

	/**
		Récupère l'ID du cycle
	*/
	if(isset($_POST['cid']) && $_POST['cid'] != '' && $_POST['cid'] != 'undefined'){
		$cid = $_POST['cid'];
	}else{
		$fiche['error'] = true;
		$fiche['error_string'] = "ID du cycle manquant";
	}
	/**
		Récupère l'ID du groupe CoCon
	*/
	if(isset($_POST['gid']) && $_POST['gid'] != '' && $_POST['gid'] != 'undefined'){
		$gid = $_POST['gid'];
	}else{
		$fiche['error'] = true;
		$fiche['error_string'] = "ID de goupe manquant";
	}

	/**
		Récupère l'ID du membre CoCon
	*/
	if(isset($_POST['uid']) && $_POST['uid'] != '' && $_POST['uid'] != 'undefined'){
		$uid = $_POST['uid'];
	}else{
		$fiche['error'] = true;
		$fiche['error_string'] = "ID de membre manquant";
	}

	// Il y a une erreur, on renvoi au navigateur 
	if($fiche['error'] == true){
		die(json_encode($fiche));
	}
	
	/**
		On récupère la fiche
	*/
	// Chargement de la fiche existante
	$fiche['fiche_id'] = $fid;
	$datas = loadFiche($fiche);
	if(!$datas){
		$fiche['error'] = true;
		$fiche['error_string'] = mysql_error();//"Erreur lors du chargement de la session.";			
	}else{
		$fiche = $datas;
	}
	
	die(json_encode($fiche));
?>
