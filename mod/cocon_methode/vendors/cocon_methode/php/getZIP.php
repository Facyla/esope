<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/engine/start.php';

	//session_start();
	include "ziplib/zip.lib.php";

	if(!isset($_SESSION['check_id'])){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// R�cup�re l'ID de goupe CoCon(coll�ge)
	$gid = "";
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}
	
	// Erreur si l'ID groupe CoCon(Coll�ge) n'a pas �t� indiqu�
	if ($gid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}

	// R�cup�re l'ID de cycle
	$cid = "";
	if(isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}
	
	// Erreur si l'ID du cycle n'a pas �t� indiqu�
	if ($cid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}

	if($_SESSION['check_id'] != md5($gid.'_'.$cid)){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// R�cup�re les fichiers � zipper
	$files = "";
	if(isset($_GET['files'])){
		$files = $_GET['files'];
	}
	
	// Erreur si aucun fichier n'a pas �t� indiqu�
	if ($files == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	// R�cup�re les fichiers � zipper
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
