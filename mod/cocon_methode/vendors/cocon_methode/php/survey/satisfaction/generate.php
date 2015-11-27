<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))))) . '/engine/start.php';
	
	//include_once "../../inc/config.inc.php";
	//include_once "../../inc/database.inc.php";
	include_once('../../inc/tbs/tbs_class.php');
	include_once('../../inc/tbs/opentbs/tbs_plugin_opentbs.php');
	include_once('../../inc/survey/satisfaction/report.inc.php');
	
	$format= "odp";
	
	/**
		Récupère le format du fichier demandé
	*/
	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}

	// Récupère l'ID de cycle
	$cid = "";
	if(isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}

	// Erreur si l'ID du cycle n'a pas été indiqué
	if ($cid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// Récupère l'ID de goupe CoCon(collège)
	$gid = "";
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}
	
	// Erreur si l'ID groupe CoCon(Collège) n'a pas été indiqué
	if ($gid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}

	// Vérifie si il s'agit d'une extraction globale ou un simple téléchargement
	$forZIP = "0";
	if(isset($_GET['zip'])){
		$forZIP = $_GET['zip'];
		if($forZIP == 1){
			if(!file_exists("../../../_tmp/".$gid) || !is_dir("../../../_tmp/".$gid)){
				mkdir("../../../_tmp/".$gid);
			}
		}
	}

	$data = array();
	
	$restitution = getRestitutionDatas($cid, $gid);
	if(!$restitution){
		header("HTTP/1.0 403 Permission refused");
		die();
	}

	/**
		Type de retour en fonction du type de format demandé
	*/
	if($forZIP == "0"){
		if($format == "odp"){
			header("content-type: application/vnd.oasis.opendocument.presentation");
		}
		
		if($format == "pdf"){
			header("content-type: application/pdf");
		}
	}else{
		header("content-type: json/application;charset=utf-8");
	}
	
	/**
		Construstion du document selon le format
	*/
	if($format == 'odp'){
		header('Content-Disposition: attachment; filename="satisfaction.odp"');
		$TBS = createDocument("odp", $restitution);
		if($forZIP == "0"){
			$TBS->Show(OPENTBS_DOWNLOAD, "satisfaction.odp");
		}else{
			$TBS->Show(OPENTBS_FILE, "../../../_tmp/".$gid."/satisfaction.odp");
			die(json_encode(array("error" => false)));
		}
	}

	if($format == 'pdf'){
		header('Content-Disposition: attachment; filename="satisfaction.pdf"');
		$pdf = createDocument("pdf", $restitution);
		if($forZIP == "0"){		
			$pdf->OutPut("satisfaction.pdf", "D");		
		}else{
			$pdf->OutPut("../../../_tmp/".$gid."/satisfaction.pdf", "F");		
			die(json_encode(array("error" => false)));
		}
	}
	exit();	
?>
