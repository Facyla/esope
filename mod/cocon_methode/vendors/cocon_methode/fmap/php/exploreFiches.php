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
	
	// Donn�es JSON
	$list = array(
		"error" => '',
		"error_string" => ''
	);

	$cid = '';
	$gid = '';

	/**
		R�cup�re l'ID du cycle
	*/
	if(isset($_POST['cid']) && $_POST['cid'] != '' && $_POST['cid'] != 'undefined'){
		$cid = $_POST['cid'];
	}else{
		$list['error'] = true;
		$list['error_string'] = "ID du cycle manquant";
	}
	/**
		R�cup�re l'ID du groupe CoCon
	*/
	if(isset($_POST['gid']) && $_POST['gid'] != '' && $_POST['gid'] != 'undefined'){
		$gid = $_POST['gid'];
	}else{
		$list['error'] = true;
		$list['error_string'] = "ID de goupe manquant";
	}

	$list = getAllFiches($cid, $gid);
	if(!$list){
		$list = array(
			"error" => true,
			"error_string" => mysql_error()
		);	
	}
	
	die($list);
?>