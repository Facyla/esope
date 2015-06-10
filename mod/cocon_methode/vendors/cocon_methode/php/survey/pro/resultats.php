<?php
	include "../../inc/survey/pro/report.inc.php";
	
	$cid = '';
	$gid = '';
	$type = '';
	$format = '';
	
	if(isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}else{
		header('HTTP/1.0 403 Permission denied');
		die();
	}
	
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}else{
		header('HTTP/1.0 403 Permission denied');
		die();
	}

	if(isset($_GET['type'])){
		$type = $_GET['type'];
	}else{
		header('HTTP/1.0 403 Permission denied');
		die();
	}

	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}else{
		header('HTTP/1.0 403 Permission denied');
		die();
	}
	
	// Vérifie si il s'agit d'une extraction globale ou un simple téléchargement
	$forZIP = 0;
	if(isset($_GET['zip'])){
		$forZIP = $_GET['zip'];
		if($forZIP == 1){
			if(!file_exists("../../../_tmp/".$gid) || !is_dir("../../../_tmp/".$gid)){
				mkdir("../../../_tmp/".$gid);
			}
		}		
	}
	
	$restitution = null;
	if($type != 'matrice'){
		$restitution = getRestitutionDatas($cid, $gid, $type);
	}else{
		$restitution = getMatriceDatas($cid, $gid);
	}
	
	if(!$restitution){
		die(mysql_error());
	}
	
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
		header("content-type: json/application;charset=utf-8");
	}
	
	if($format == 'odp'){

		include_once('../../inc/tbs/tbs_class.php');
		include_once('../../inc/tbs/opentbs/tbs_plugin_opentbs.php');	
		
		if($type != 'matrice'){
			$TBS = createDocument("odp", $restitution);
			if($forZIP == 0){
				header('Content-Disposition: attachment; filename="resultats_'.$type.'.odp"');
				$TBS->Show(OPENTBS_DOWNLOAD, "resultats_".$type.".odp");
			}else{
				$TBS->Show(OPENTBS_FILE, "../../../_tmp/".$gid."/resultats_".$type.".odp");
				die(json_encode(array("error" => false)));
			}
		}else{
			$TBS = createMatriceDocument("odp", $restitution);
			if($forZIP == "0"){
				header('Content-Disposition: attachment; filename="matrice.odp"');
				$TBS->Show(OPENTBS_DOWNLOAD, "matrice.odp");
			}else{
				$TBS->Show(OPENTBS_FILE, "../../../_tmp/".$gid."/matrice.odp");
				die(json_encode(array("error" => false)));
			}
		}
		exit();
	}

	if($format == 'pdf'){
		
		include_once('../../pdf/fpdf.php');
		include_once('../../pdf/fpdi/fpdi.php');
		
		if($type != 'matrice'){
			$pdf = createDocument("pdf", $restitution);
			if($forZIP == 0){
				header('Content-Disposition: attachment; filename="resultats_'.$type.'.pdf"');
				$pdf->OutPut("resultats_".$type.".pdf", "D");
			}else{
				$pdf->OutPut("../../../_tmp/".$gid."/resultats_".$type.".pdf", "F");
				die(json_encode(array("error" => false)));
			}
		}else{
			header('Content-Disposition: attachment; filename="matrice.pdf"');
			$pdf = createMatriceDocument("pdf", $restitution);
			if($forZIP == 0){
				$pdf->OutPut("../../../_tmp/".$gid."/matrice.pdf", "D");
			}else{
				$pdf->OutPut("../../../_tmp/".$gid."/matrice.pdf", "F");
				die(json_encode(array("error" => false)));
			}
		}
		exit();
	}

?>