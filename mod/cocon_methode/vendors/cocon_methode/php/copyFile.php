<?php
	header("content-type: json/application;charset=utf-8");
	
	// R�cup�re l'ID de goupe CoCon(coll�ge)
	$gid = "";
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}
	
	// Erreur si l'ID groupe CoCon(Coll�ge) n'a pas �t� indiqu�
	if ($gid == ''){
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
	
	$content = file_get_contents("../_files/".$file.".".$format);
	file_put_contents("../_tmp/".$gid."/".$file.".".$format, $content);
	
	die(json_encode(array("error" => false)));
	
?>