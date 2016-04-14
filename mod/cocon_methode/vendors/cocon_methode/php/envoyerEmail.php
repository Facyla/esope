<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/engine/start.php';

/**
	SCRIPT PHP POUR L'ENVOI D'EMAIL
*/
require_once "inc/config.inc.php";
require_once "inc/database.inc.php";
include_once "inc/utils.inc.php";
include_once "inc/mail.inc.php";
include_once "inc/survey/pro/session.inc.php";

header('Content-type: application/json');

$cid = '';
$gid = '';
$type = '';
$json = '';

$rep = array(
	'error' => false,
	'error_string' => ''
);

if(isset($_POST['cid'])){
	$cid = $_POST['cid'];
}else{
	$rep['error'] = true;
	$rep['error_string'] = 'ID du cycle manquant.';
	
	die(json_encode($rep));
}

if(isset($_POST['gid'])){
	$gid = $_POST['gid'];
}else{
	$rep['error'] = true;
	$rep['error_string'] = 'ID du groupe CoCon manquant.';
	
	die(json_encode($rep));
}

if(isset($_POST['type'])){
	$type = $_POST['type'];
}else{
	$rep['error'] = true;
	$rep['error_string'] = 'Type de message manquant.';
	
	die(json_encode($rep));
}

if(isset($_POST['json'])){
	$json = json_decode($_POST['json']);
}else{
	$rep['error'] = true;
	$rep['error_string'] = 'Texte du message manquant.';
	die(json_encode($rep));
}

//error_log("Cocon Methode email data : $cid / $gid / $type / $json"); // debug

/**
	Envoi des emails d'invitation au questionnaire à TOUS les enseignants
*/
if($type == 'pro'){
	
	// Récupère les infos des enseignants du groupe CoCon
	$enseignants = getEnseignantsInfos($gid);
	
	if(!$enseignants){
		$rep['error'] = true;
		$rep['error_string'] = 'Erreur lors de la récupération des enseignants.';
		die(json_encode($rep));
	}
	
	if(count($enseignants) == 0){
		$rep['error'] = true;
		$rep['error_string'] = 'Aucun enseignant trouvé.';
		die(json_encode($rep));
	}
	
	$htmlEmail = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br/>", $json->email);
	$htmlEmail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
					<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<meta http-equiv="X-UA-Compatible" content="IE=Edge">
						<title>Colleges connectes</title>
						<meta content="no-cache" http-equiv="pragma">
						<meta content="tue, 01 Jun 2010 19:45:00 GMT" name="expires">
					</head>
					<body>'.$htmlEmail;
	
	for($i = 0; $i < count($enseignants); $i++){
		$link = URL_BASE."/survey/pro/index.php?cid=".$cid."&gid=".$gid."&uid=".$enseignants[$i]['user_id'];
		//error_log("Cocon Methode pro : Envoi email => $link"); // debug
		if(!sendMail(
			$enseignants[$i]['user_email'],
			'Invitation au questionnaire CoCon',
			$htmlEmail.'<br><br>Lien vers le questionnaire : <a href="'.$link.'" target="_new">'.$link.'</a>'
			)
		){
			$rep['error'] = true;
			$rep['error_string'] = 'Erreur lors de l\'envoi d\'email.';
			die(json_encode($rep));
		}
	}
	die(json_encode($rep));
}

/**
	Envoi des emails d'invitation au questionnaire aux enseignants N'AYANT PAS TERMINE leur questionnaire
*/
if($type == 'pro2'){
	
	// Récupère les infos des enseignants du groupe CoCon
	$enseignants = getEnseignantsInfos($gid);
	
	if(!$enseignants){
		$rep['error'] = true;
		$rep['error_string'] = 'Erreur lors de la récupération des enseignants.';
		die(json_encode($rep));	
	}
	
	if(count($enseignants) == 0){
		$rep['error'] = true;
		$rep['error_string'] = 'Aucun enseignant trouvé.';
		die(json_encode($rep));	
	}
	
	$htmlEmail = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br/>", $json->email);
	$htmlEmail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
					<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<meta http-equiv="X-UA-Compatible" content="IE=Edge">
						<title>Colleges connectes</title>
						<meta content="no-cache" http-equiv="pragma">
						<meta content="tue, 01 Jun 2010 19:45:00 GMT" name="expires">
					</head>
					<body>'.$htmlEmail;
	
	for($i = 0; $i < count($enseignants); $i++){
		$envoi = false;
		$sid = getSessionID($cid, $gid, $enseignants[$i]['user_id']);
		if(!$sid){
			$envoi = true;
		}else{
			$session_etat = getSessionState($sid);
			if($session_state == 'false'){
				$rep['error'] = true;
				$rep['error_string'] = 'Erreur lors de l\'envoi d\'email.';
				die(json_encode($rep));
			}
			
			if($session_etat != 2){
				$envoi = true;
			}
		}
		
		if($envoi){
			$link = URL_BASE."/survey/pro/index.php?cid=".$cid."&gid=".$gid."&uid=".$enseignants[$i]['user_id'];
			//error_log("Cocon Methode pro2 : Envoi email => $link"); // debug
			if(!sendMail(
				$enseignants[$i]['user_email'],
				'Invitation au questionnaire CoCon',
				$htmlEmail.'<br><br>Lien vers le questionnaire : <a href="'.$link.'" target="_new">'.$link.'</a>'
				)
			){
				$rep['error'] = true;
				$rep['error_string'] = 'Erreur lors de l\'envoi d\'email.';
				die(json_encode($rep));
			}
		}
	}
	die(json_encode($rep));
}

/**
	Envoi des emails d'invitation à remplir des fiches de mise en pratique aux enseignants
*/
if($type == 'fmap'){
	
	// Récupère les infos des enseignants du groupe CoCon
	$enseignants = getEnseignantsInfos($gid);
	
	if(!$enseignants){
		$rep['error'] = true;
		$rep['error_string'] = 'Erreur lors de la récupération des enseignants.';
		die(json_encode($rep));	
	}
	
	if(count($enseignants) == 0){
		$rep['error'] = true;
		$rep['error_string'] = 'Aucun enseignant trouvé.';
		die(json_encode($rep));	
	}
	
	$htmlEmail = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br/>", $json->email);
	$htmlEmail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
					<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<meta http-equiv="X-UA-Compatible" content="IE=Edge">
						<title>Colleges connectes</title>
						<meta content="no-cache" http-equiv="pragma">
						<meta content="tue, 01 Jun 2010 19:45:00 GMT" name="expires">
					</head>
					<body>'.$htmlEmail;
	
	for($i = 0; $i < count($enseignants); $i++){
		$link = URL_BASE."/fmap/index.php?cid=".$cid."&gid=".$gid."&uid=".$enseignants[$i]['user_id'];
//			file_put_contents('fmap_'.$enseignants[$i]['user_id'].'.html', $htmlEmail.'<br><br>Lien vers les fiches de mise en pratique : <a href="'.$link.'" target="_new">'.$link.'</a>');

		if(!sendMail(
			$enseignants[$i]['user_email'],
			'Invitation à remplir des fiches de mise en pratique',
			$htmlEmail.'<br><br>Lien vers les fiches de mise en pratique : <a href="'.$link.'" target="_new">'.$link.'</a>'
			)
		){
			$rep['error'] = true;
			$rep['error_string'] = 'Erreur lors de l\'envoi d\'email.';
			die(json_encode($rep));
		}

	}
	die(json_encode($rep));
}

/**
	Envoi des emails d'invitation à remplir le questionnaire de satisfaction aux enseignants
*/
if($type == 'satisfaction'){
	
	// Récupère les infos des enseignants du groupe CoCon
	$enseignants = getEnseignantsInfos($gid);
	
	if(!$enseignants){
		$rep['error'] = true;
		$rep['error_string'] = 'Erreur lors de la récupération des enseignants.';
		die(json_encode($rep));	
	}
	
	if(count($enseignants) == 0){
		$rep['error'] = true;
		$rep['error_string'] = 'Aucun enseignant trouvé.';
		die(json_encode($rep));	
	}
	
	$htmlEmail = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br/>", $json->email);
	$htmlEmail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
					<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<meta http-equiv="X-UA-Compatible" content="IE=Edge">
						<title>Colleges connectes</title>
						<meta content="no-cache" http-equiv="pragma">
						<meta content="tue, 01 Jun 2010 19:45:00 GMT" name="expires">
					</head>
					<body>'.$htmlEmail;
	
	for($i = 0; $i < count($enseignants); $i++){
		$link = URL_BASE."/survey/satisfaction/index.php?cid=".$cid."&gid=".$gid."&uid=".$enseignants[$i]['user_id'];
//			file_put_contents('satisf_'.$enseignants[$i]['user_id'].'.html', $htmlEmail.'<br><br>Lien vers les fiches de mise en pratique : <a href="'.$link.'" target="_new">'.$link.'</a>');

		if(!sendMail(
			$enseignants[$i]['user_email'],
			'Invitation au questionnaire de satisfaction',
			$htmlEmail.'<br><br>Lien vers les fiches de mise en pratique : <a href="'.$link.'" target="_new">'.$link.'</a>'
			)
		){
			$rep['error'] = true;
			$rep['error_string'] = 'Erreur lors de l\'envoi d\'email.';
			die(json_encode($rep));
		}

	}
	die(json_encode($rep));
}

