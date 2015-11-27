<?php
	/**
		SCRIPT PHP POUR LA CREATION D'UN NOUVEAU CYCLE
	*/
	include_once "inc/config.inc.php";
	include_once "inc/database.inc.php";
	include_once "inc/utils.inc.php";
	include_once "inc/cycle.inc.php";

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
	
	error_log("Cocon Kit : {$_SESSION['check_id']} / {$_POST['gid']} / {$_POST['cid']}"); // debug
	if(isset($_POST['gid'])){
		$gid = $_POST['gid'];
	}else{
		$response['error'] = true;
		die(json_encode($response));
	}
error_log("Cocon Kit : gid OK"); // debug
	
	if(isset($_POST['cid'])){
		$cid = $_POST['cid'];
	}else{
		$response['error'] = true;
		die(json_encode($response));
	}
error_log("Cocon Kit : cid OK"); // debug

	if($_SESSION['check_id'] != md5($gid.'_'.$cid)){
		$response['error'] = true;
		die(json_encode($response));
	}
error_log("Cocon Kit : check_id OK"); // debug
	
	$cid = createCycle($gid);
error_log("Cocon Kit : NEW CID OK"); // debug
	
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
