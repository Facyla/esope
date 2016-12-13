<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/engine/start.php';
	
	//include_once "../../inc/config.inc.php";
	//include_once "../../inc/database.inc.php";
	include_once "../inc/config.inc.php";
	include_once "../inc/database.inc.php";
	include_once('../inc/fmap/fiche.inc.php');
	
	$format= "odp";
	if(!isset($_SESSION['check_id'])){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	/**
		Récupère le format du fichier demandé
	*/
	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}
	
	// Récupère l'ID de la fiche de mise en pratique
	$fid = "";
	if(isset($_GET['fid'])){
		$fid = $_GET['fid'];
	}
	
	// Erreur si l'ID de la fiche n'a pas été indiqué
	if ($fid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
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

	if($_SESSION['check_id'] != md5($gid.'_'.$cid)){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// Récupère l'ID de l'utilisateur
	$uid = "";
	if(isset($_GET['uid'])){
		$uid = $_GET['uid'];
	}
	
	$data = array();
	
	$fiche = prepareFicheArray($fid, $cid, $gid, $uid, '');
	if(!$fiche){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	$fiche = loadFiche($fiche);
	if(!$fiche){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	$data[] = array(
		"nom" => $fiche['nom'],
		"theme" => $fiche['theme'],
		"equipe" => $fiche['equipe'],
		"zone1" => $fiche['zone1'],
		"zone2" => $fiche['zone2'],
		"zone3" => $fiche['zone3'],
		"zone4" => $fiche['zone4'],
		"zone5" => $fiche['zone5'],
		"zone6" => $fiche['zone6'],
		"zone7" => $fiche['zone7'],
		"zone8" => $fiche['zone8'],
		"zone9" => $fiche['zone9'],
		"zone10" => $fiche['zone10'],
		"zone11" => $fiche['zone11']
	);

	/**
		Type de retour en fonction du type de format demandé
	*/
	if($format == "odp"){
		header("content-type: application/vnd.oasis.opendocument.presentation");
	}
		
	if($format == "pdf"){
		header("content-type: application/pdf");
	}
	
	/**
		Construstion du document selon le format
	*/
	if($format == 'odp'){
		header('Content-Disposition: attachment; filename="'.$fiche['nom'].'.odp"');

		include_once('../inc/tbs/tbs_class.php');
		include_once('../inc/tbs/opentbs/tbs_plugin_opentbs.php');		

		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		
		$template = '../../_files/restitution/mise_en_pratique.odp';
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).
		$TBS->MergeBlock('b', $data);
		$TBS->Show(OPENTBS_DOWNLOAD, $fiche['nom'].".odp"); // Also merges all [onshow] automatic fields.
	}
	
	if($format == 'pdf'){
		header('Content-Disposition: attachment; filename="'.$fiche['nom'].'.pdf"');
		
		include_once('../pdf/fpdf.php');
		include_once('../pdf/fpdi/fpdi.php');
		
		$template = '../../_files/restitution/mise_en_pratique.pdf';
		
		$pdf = new FPDI();
		$pages = $pdf->setSourceFile($template);
		for($i = 1; $i < ($pages + 1); $i++){
			$pgId = $pdf->importPage($i); 
			$size = $pdf->getTemplateSize($pgId);

			if ($size['w'] > $size['h']) {
				$pdf->AddPage('L', array($size['w'], $size['h']));
			} else {
				$pdf->AddPage('P', array($size['w'], $size['h']));
			}			

			$pdf->useTemplate($pgId,0,0, 297,210);
		}
		
		$pdf->OutPut($fiche['nom'].".pdf", "D");
	}
	
	exit();	
?>
