<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/engine/start.php';
	
	//include "../inc/config.inc.php";
	//include "../inc/database.inc.php";

	/**
		Type de retour : JSON / UTF-8
	*/
	header("content-type: json/application;charset=utf-8");
	
	// Récupère l'ID de cycle
	$cycle_id = "";
	if(isset($_POST['cid'])){
		$cycle_id = $_POST['cid'];
	}

	// Récupère l'ID de goupe CoCon(collège)
	$group_id = "";
	if(isset($_POST['gid'])){
		$group_id = $_POST['gid'];
	}
	
	// Construction de l'objet JSON qui sera retourné
	$feuille = array(
		"error" => false,
		"error_string" => "",
		"feuille_id" => "",
		"cycle_id" => $cycle_id,
		"group_id" => $group_id,
		"objectif_1" => "",
		"objectif_2" => "",
		"objectif_3" => "",
		"objectif_4" => "",
		"objectif_5" => "",
		"objectif_6" => "",
		"objectif_7" => "",
		"objectif_8" => "",
		"equipe_projet" => "",
		"ressources" => "",
		"instance_1" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_2" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_3" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_4" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_5" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_6" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_7" => array(
			"id" => 0,
			"comment" => ""
		),
		"instance_8" => array(
			"id" => 0,
			"comment" => ""
		),	
		"calendrier" => 0
	);
	
	// Erreur si l'ID groupe CoCon(Collège) n'a pas été indiqué
	if ($group_id == ''){
		$feuille['error'] = true;
	}
	
	// Connexion à la base de données
	$conn = connectDB();
	
	// Requête SELECT pour récupérer la dernière feuille de route
	$sql = "select * from FEUILLE_ROUTE where CYCLE_ID=\"".securiseSQLString($conn,$feuille['cycle_id'])."\" AND GROUP_ID=\"".securiseSQLString($conn,$feuille['group_id'])."\" and ACTIVE=1";
	$result = executeQuery($conn, $sql);
	
	// Erreur lors d ela requête
	if(!$result){
		$feuille->error = true;
	}
	
	while($row = mysql_fetch_assoc($result)){
		$feuille['feuille_id'] = $row['FEUILLE_ID'];
		$feuille['objectif_1'] = $row['OBJECTIF_1'];
		$feuille['objectif_2'] = $row['OBJECTIF_2'];
		$feuille['objectif_3'] = $row['OBJECTIF_3'];
		$feuille['objectif_4'] = $row['OBJECTIF_4'];
		$feuille['objectif_5'] = $row['OBJECTIF_5'];
		$feuille['objectif_6'] = $row['OBJECTIF_6'];
		$feuille['objectif_7'] = $row['OBJECTIF_7'];
		$feuille['objectif_8'] = $row['OBJECTIF_8'];

		$feuille['equipe_projet'] = $row['EQUIPE_PROJET'];
		$feuille['ressources'] = $row['RESSOURCES'];

		$feuille['instance_1']['id'] = $row['INSTANCE_1'];
		$feuille['instance_2']['id'] = $row['INSTANCE_2'];
		$feuille['instance_3']['id'] = $row['INSTANCE_3'];
		$feuille['instance_4']['id'] = $row['INSTANCE_4'];
		$feuille['instance_5']['id'] = $row['INSTANCE_5'];
		$feuille['instance_6']['id'] = $row['INSTANCE_6'];
		$feuille['instance_7']['id'] = $row['INSTANCE_7'];
		$feuille['instance_8']['id'] = $row['INSTANCE_8'];

		$feuille['instance_1']['comment'] = $row['COMMENT_1'];
		$feuille['instance_2']['comment'] = $row['COMMENT_2'];
		$feuille['instance_3']['comment'] = $row['COMMENT_3'];
		$feuille['instance_4']['comment'] = $row['COMMENT_4'];
		$feuille['instance_5']['comment'] = $row['COMMENT_5'];
		$feuille['instance_6']['comment'] = $row['COMMENT_6'];
		$feuille['instance_7']['comment'] = $row['COMMENT_7'];
		$feuille['instance_8']['comment'] = $row['COMMENT_8'];

		$feuille['calendrier'] = $row['CALENDRIER'];
	}
	
	// Renvoi l'objet JSON en réponse
	die(json_encode($feuille));
	
?>
