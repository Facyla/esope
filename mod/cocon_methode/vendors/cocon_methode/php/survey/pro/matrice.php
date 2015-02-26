<?php
	include "../../inc/survey/pro/report.inc.php";
	
	$cid = '';
	$gid = '';
	$format = '';
	
	if(isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}else{
		header('HTTP/1.0 403 1Permission denied');
		die();
	}
	
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}else{
		header('HTTP/1.0 403 2Permission denied');
		die();
	}

	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}else{
		header('HTTP/1.0 403 4Permission denied');
		die();
	}

	$matrice = getMatriceDatas($cid, $gid);
	if(!$matrice){
		die('erreur -> '.mysql_error());
		
	}

//	var_dump($matrice);
//	die();


	if($format == 'odp'){
		$TBS = createMatriceDocument("odp", $matrice);
		$TBS->Show(OPENTBS_DOWNLOAD, "matrice.odp");
		exit();
	}

	if($format == 'pdf'){
		$pdf = createMatriceDocument("pdf", $matrice);
		$pdf->OutPut("matrice.pdf", "D");
		exit();
	}
	//$matrice['graph']->Stroke();

	//var_dump($restitution);
?>