<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/engine/start.php';
	
	//include_once "../inc/config.inc.php";
	//include_once "../inc/utils.inc.php";
	//include_once "../inc/database.inc.php";

	// Type de retour : Texte / UTF-8
	header("content-type: text/plain;charset=utf-8");
	
	// Récupère l'action de générer le document
	$genere = 0;
	if(isset($_POST['genere'])){
		$genere = $_POST['genere'];
	}
	
	// Récupère les données de la feuille de route dans un objet JSON
	$feuille = null;
	if(isset($_POST['json'])){
		$feuille = json_decode($_POST['json']);
		
		// L'ID du groupe CoCon(Collège) n'a pas été indiqué 
		if($feuille->group_id == ''){
			die("error_group");
		}
	}

	// Les données n'ont pas été fournies
	if($feuille == null){
		die("error_datas");
	}
	
	// Connexion à la base de données
	$conn = connectDB();
	
	// Met en historique les anciennes feuilles
	$sql = 'update FEUILLE_ROUTE set ACTIVE=0 where GROUP_ID="'.securiseSQLString($conn, $feuille->group_id).'"';
	$result = executeQuery($conn, $sql);
	
	// Erreur lors de la requête SQL
	if(!$result){
		die("error_sql");
	}
	
	// Création de la feuille de route
	$fid = getUniqueID();
	$sql = "insert into FEUILLE_ROUTE (
		FEUILLE_ID,
		CYCLE_ID,
		GROUP_ID,
		OBJECTIF_1,
		OBJECTIF_2,
		OBJECTIF_3,
		OBJECTIF_4,
		OBJECTIF_5,
		OBJECTIF_6,
		OBJECTIF_7,
		OBJECTIF_8,
		EQUIPE_PROJET,
		RESSOURCES,
		INSTANCE_1,
		COMMENT_1,
		INSTANCE_2,
		COMMENT_2,
		INSTANCE_3,
		COMMENT_3,
		INSTANCE_4,
		COMMENT_4,
		INSTANCE_5,
		COMMENT_5,
		INSTANCE_6,
		COMMENT_6,
		INSTANCE_7,
		COMMENT_7,
		INSTANCE_8,
		COMMENT_8,
		CALENDRIER,
		DT_CREATE,
		ACTIVE) values (
		\"".securiseSQLString($conn, $fid)."\",
		\"".securiseSQLString($conn, $feuille->cycle_id)."\",
		\"".securiseSQLString($conn, $feuille->group_id)."\",
		\"".securiseSQLString($conn, $feuille->objectif_1)."\",
		\"".securiseSQLString($conn, $feuille->objectif_2)."\",
		\"".securiseSQLString($conn, $feuille->objectif_3)."\",
		\"".securiseSQLString($conn, $feuille->objectif_4)."\",
		\"".securiseSQLString($conn, $feuille->objectif_5)."\",
		\"".securiseSQLString($conn, $feuille->objectif_6)."\",
		\"".securiseSQLString($conn, $feuille->objectif_7)."\",
		\"".securiseSQLString($conn, $feuille->objectif_8)."\",
		\"".securiseSQLString($conn, $feuille->equipe_projet)."\",
		\"".securiseSQLString($conn, $feuille->ressources)."\",
		\"".securiseSQLString($conn, $feuille->instance_1->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_1->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_2->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_2->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_3->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_3->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_4->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_4->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_5->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_5->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_6->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_6->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_7->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_7->comment)."\",
		\"".securiseSQLString($conn, $feuille->instance_8->id)."\",
		\"".securiseSQLString($conn, $feuille->instance_8->comment)."\",
		\"".securiseSQLString($conn, $feuille->calendrier)."\",
		\"".microtime(true)."\",
		\"1\"
		)
	";
	$result = executeQuery($conn, $sql);
	// Erreur lors de la requête SQL
	if(!$result){
		die("error_sql");
	}
	
	die($genere);
?>
