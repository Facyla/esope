<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/engine/start.php';

	//session_start();
	header("content-type: json/application;charset=utf-8");
	
	if(!isset($_SESSION['check_id'])){
		die(json_encode(array("error" => true)));
	}
	
	// R�cup�re l'ID de goupe CoCon(coll�ge)
	$gid = "";
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}
	
	// Erreur si l'ID groupe CoCon(Coll�ge) n'a pas �t� indiqu�
	if ($gid == ''){
		die(json_encode(array("error" => true)));
	}
	
	// R�cup�re l'ID du cycle
	$cid = "";
	if(isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}
	
	// Erreur si l'ID du cycle n'a pas �t� indiqu�
	if ($cid == ''){
		die(json_encode(array("error" => true)));
	}

	if($_SESSION['check_id'] != md5($gid.'_'.$cid)){
		die(json_encode(array("error" => true)));
	}
	
	// R�cup�re le format du fichier
	$format = "";
	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}
	
	// Erreur si l'ID groupe CoCon(Coll�ge) n'a pas �t� indiqu�
	if ($format == ''){
		die(json_encode(array("error" => true)));
	}

	// R�cup�re le fichier � copier
	$file = "";
	if(isset($_GET['file'])){
		$file = $_GET['file'];
	}
	
	// Erreur si aucun fichier n'a pas �t� indiqu�
	if ($file == ''){
		die(json_encode(array("error" => true)));
	}

	if(!file_exists("../_tmp/".$gid) || !is_dir("../_tmp/".$gid)){
		mkdir("../_tmp/".$gid);
	}
	
	//error_log("../_files/".$file.".".$format);
	$content = file_get_contents("../_files/".$file.".".$format);
	file_put_contents("../_tmp/".$gid."/".$file.".".$format, $content);
	
	die(json_encode(array("error" => false)));
	
?>
