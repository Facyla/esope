<?php
	session_start();
	include "ziplib/zip.lib.php";

	if(!isset($_SESSION['check_id'])){
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

	if($_SESSION['check_id'] != md5($gid.'_'.$cid)){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// Récupère les fichiers à zipper
	$files = "";
	if(isset($_GET['files'])){
		$files = $_GET['files'];
	}
	
	// Erreur si aucun fichier n'a pas été indiqué
	if ($files == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// Récupère les fichiers à zipper
	$zipname = "resultats.zip";
	if(isset($_GET['zip'])){
		$zipname = $_GET['zip'];
	}

	$files = explode(";", $files);
	$flist = "";
	$file = "temp_".microtime(true).".zip";
	$zip = new zipfile();
	for($i = 0; $i < count($files) - 1; $i++){
		$content = file_get_contents("../_tmp/".$gid."/".$files[$i]);
		$zip->addfile($content, $files[$i]);
	}
	
	$azip = $zip->file();
	
	header("Content-type: application/zip");
	header('Content-Disposition: attachment; filename="'.$zipname.'"');
	die($azip);
	
	
?>