<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/engine/start.php';
	
	//include "../inc/config.inc.php";
	//include "../inc/database.inc.php";
	include_once('../inc/bilan/bilan.inc.php');
	
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
	
	// Vérifie si il s'agit d'une extraction globale ou un simple téléchargement
	$forZIP = 0;
	if(isset($_GET['zip'])){
		$forZIP = $_GET['zip'];
		if($forZIP == 1){
			if(!file_exists("../../_tmp/".$gid) || !is_dir("../../_tmp/".$gid)){
				mkdir("../../_tmp/".$gid);
			}
		}		
	}	
	
	$data = array();
	
	$bilan = prepareBilanArray($cid, $gid);
	if(!$bilan){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	$bilan = loadBilan($bilan);
	if(!$bilan){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	$data[] = array(
		"zone1" => $bilan['zone1'],
		"zone2" => $bilan['zone2'],
		"zone3" => $bilan['zone3'],
		"zone4" => $bilan['zone4'],
		"zone5" => $bilan['zone5'],
		"zone6" => $bilan['zone6'],
		"zone7" => $bilan['zone7'],
		"zone8" => $bilan['zone8'],
		"zone9" => $bilan['zone9'],
		"zone10" => $bilan['zone10'],
		"zone11" => $bilan['zone11'],
		"zone12" => $bilan['zone12'],
		"zone13" => $bilan['zone13']
	);

	/**
		Type de retour en fonction du type de format demandé
	*/
	if($forZIP == 0){
		if($format == "odp"){
			header("content-type: application/vnd.oasis.opendocument.presentation");
		}
		
		if($format == "pdf"){
			header("content-type: application/pdf");
		}
	}else{
		header("content-type: json/application; charset=utf-8");
	}
	
	/**
		Construstion du document selon le format
	*/
	if($format == 'odp'){
		header('Content-Disposition: attachment; filename="bilan.odp"');

		include_once('../inc/tbs/tbs_class.php');
		include_once('../inc/tbs/opentbs/tbs_plugin_opentbs.php');
	
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		
		$template = '../../_files/restitution/bilan.odp';
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
		$TBS->MergeBlock('b', $data);
		
		if($forZIP == "0"){
			$TBS->Show(OPENTBS_DOWNLOAD, "bilan.odp");
		}else{
			$TBS->Show(OPENTBS_FILE, "../../_tmp/".$gid."/bilan.odp");
			die(json_encode(array("error" => false)));
		}
	}

	if($format == 'pdf'){
		header('Content-Disposition: attachment; filename="bilan.pdf"');

		include_once('../pdf/fpdf.php');
		include_once('../pdf/fpdi/fpdi.php');
		
		$template = '../../_files/restitution/bilan.pdf';
		
		$pdf = new FPDI();
		$pages = $pdf->setSourceFile($template);
		
		$pdf->SetFont("Helvetica");
		$pdf->SetFontSize(9);
		$pdf->SetTextColor(128, 128, 128);

		$pdf->SetFont("Helvetica");
		$pdf->SetFontSize(9);
		$pdf->SetTextColor(128, 128, 128);
			
		for($i = 1; $i < ($pages + 1); $i++){

			$pgId = $pdf->importPage($i); 
			$size = $pdf->getTemplateSize($pgId);

			if ($size['w'] > $size['h']) {
				$pdf->AddPage('L', array($size['w'], $size['h']));
			} else {
				$pdf->AddPage('P', array($size['w'], $size['h']));
			}			

			$pdf->useTemplate($pgId,0,0,297,210);

			if($i == 1){
				$pdf->SetFont("Helvetica");
				$pdf->SetFontSize(16);
				$pdf->SetTextColor(0, 0, 64);
				
				$pdf->SetXY(28, 22);
				$pdf->MultiCell(200, 5, utf8_decode(date('d/m/Y', microtime(true))));

				$pdf->SetFontSize(12);
				$pdf->SetXY(101, 44.1);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone1']));

				$pdf->SetFont("Helvetica");
				$pdf->SetFontSize(9);
				$pdf->SetTextColor(128, 128, 128);
				$pdf->SetXY(30, 71);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone2']));
				
				$pdf->SetXY(30, 118);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone3']));

				$pdf->SetXY(30, 163);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone4']));

			}

			if($i == 2){
				$pdf->SetXY(30, 51);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone5']));
				
				$pdf->SetXY(30, 148);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone6']));
			}

			if($i == 3){
				$pdf->SetXY(30, 61);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone7']));
				
				$pdf->SetXY(160, 61);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone8']));
				
				$pdf->SetFont("Helvetica");
				$pdf->SetFontSize(14);
				$pdf->SetTextColor(0, 0, 64);				

				$pdf->SetXY(10, 161);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone9']));
				$pdf->SetFont("Helvetica");
				$pdf->SetFontSize(9);
				$pdf->SetTextColor(128, 128, 128);
			}

			if($i == 4){
				$pdf->SetXY(25, 51);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone10']));
				
				$pdf->SetFont("Helvetica");
				$pdf->SetFontSize(12);
				$pdf->SetTextColor(0, 0, 64);				
				$pdf->SetXY(10, 131);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone11']));
				$pdf->SetXY(105, 131);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone12']));
				$pdf->SetXY(206, 131);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['zone13']));
			}
		}
		
		if($forZIP == 0){
			$pdf->OutPut("bilan.pdf", "D");
		}else{
			$pdf->OutPut("../../_tmp/".$gid."/bilan.pdf", "F");
			die(json_encode(array("error" => false)));
		}
	}

	exit();	
?>
