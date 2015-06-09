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
		"error" => '',
		"error_string" => ''
	);

	$fid = '';
	$cid = '';
	$gid = '';
	$uid = '';
	$nom = '';
	
	/**
		Récupère le nom de la nouvelle fiche de mise en pratique
	*/
	if(isset($_POST['nom']) && $_POST['nom'] != '' && $_POST['nom'] != 'undefined'){
		$nom = $_POST['nom'];
	}else{
		$fiche['error'] = true;
		$fiche['error_string'] = "Nom de la fiche manquant";
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
	
	$fid = getUniqueID();
	$fiche = prepareFicheArray($fid, $cid, $gid, $uid, $nom);
	$fid = createFiche($fiche);
	if(!$fid){
		$fiche = array(
			"error" => true,
			"error_string" => mysql_error()
		);	
	}
	
	die(json_encode($fiche));
?>