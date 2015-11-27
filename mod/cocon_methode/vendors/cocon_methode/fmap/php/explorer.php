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
	$list = array(
		"error" => '',
		"error_string" => ''
	);

	$cid = '';
	$gid = '';
	$uid = '';

	/**
		Récupère l'ID du cycle
	*/
	if(isset($_POST['cid']) && $_POST['cid'] != '' && $_POST['cid'] != 'undefined'){
		$cid = $_POST['cid'];
	}else{
		$list['error'] = true;
		$list['error_string'] = "ID du cycle manquant";
	}
	/**
		Récupère l'ID du groupe CoCon
	*/
	if(isset($_POST['gid']) && $_POST['gid'] != '' && $_POST['gid'] != 'undefined'){
		$gid = $_POST['gid'];
	}else{
		$list['error'] = true;
		$list['error_string'] = "ID de goupe manquant";
	}

	/**
		Récupère l'ID du membre CoCon
	*/
	if(isset($_POST['uid']) && $_POST['uid'] != '' && $_POST['uid'] != 'undefined'){
		$uid = $_POST['uid'];
	}else{
		$list['error'] = true;
		$list['error_string'] = "ID de membre manquant";
	}
	
	$list = getUserFiches($cid, $gid, $uid);
	if(!$list){
		$list = array(
			"error" => true,
			"error_string" => mysql_error()
		);	
	}
	
	die($list);
?>
