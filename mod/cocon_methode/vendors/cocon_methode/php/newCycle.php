<?php
	/**
		SCRIPT PHP POUR LA CREATION D'UN NOUVEAU CYCLE
	*/
	include "inc/config.inc.php";
	include "inc/database.inc.php";
	include "inc/utils.inc.php";
	include "inc/cycle.inc.php";

	header('Content-type: application/json');	

	$response = array(
		"error" => false,
		"cycle_id" => ""
	);

	if(!isset($_SESSION['check_id'])){
		$response['error'] = true;
		die(json_encode($response));
	}
	
	$cid = '';
	$gid = '';
	
	if(isset($_POST['gid'])){
		$gid = $_POST['gid'];
	}else{
		$response['error'] = true;
		die(json_encode($response));
	}
	
	if(isset($_POST['cid'])){
		$cid = $_POST['cid'];
	}else{
		$response['error'] = true;
		die(json_encode($response));
	}

	if($_SESSION['check_id'] != md5($gid.'_'.$cid)){
		$response['error'] = true;
		die(json_encode($response));
	}
	
	$cid = createCycle($gid);
	
	if(!$cid){
		die(mysql_error());
		$response['error'] = true;
		die(json_encode($response));
	}else{
		$response['error'] = false;
		$response['cycle_id'] = $cid;
		$_SESSION['check_id'] = md5($gid.'_'.$cid);
		die(json_encode($response));
	}
?>