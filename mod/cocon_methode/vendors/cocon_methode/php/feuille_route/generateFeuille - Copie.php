<?php
	include "../inc/config.inc.php";
	include "../inc/database.inc.php";
	include_once('../inc/tbs/tbs_class.php');
	include_once('../inc/tbs/opentbs/tbs_plugin_opentbs.php');
	
	$format= "odp";
	
	/**
		Récupère le format du fichier demandé
	*/
	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}

	// Récupère l'ID de goupe CoCon(collège)
	$group_id = "";
	if(isset($_GET['gid'])){
		$group_id = $_GET['gid'];
	}
	
	// Erreur si l'ID groupe CoCon(Collège) n'a pas été indiqué
	if ($group_id == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	$data = array();
	
	// Connexion à la base de données
	$conn = connectDB();
	
	// Requête SELECT pour récupérer la dernière feuille de route
	$sql = "select * from feuille_route where GROUP_ID=\"".securiseSQLString($conn,$group_id)."\" and ACTIVE=1";
	$result = executeQuery($conn, $sql);
	
	// Erreur lors d ela requête
	if(!$result){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	$instances = array(
		"",
		utf8_encode("Conseil pédagogique"),
		utf8_encode("Conseil d’administration"),
		utf8_encode("Commission permanente"),
		utf8_encode("Conseil école-collège"),
		utf8_encode("Commission numérique"),
		utf8_encode("Conseil d’enseignement"),
		utf8_encode("Autre")
	);
	
	while($row = mysql_fetch_assoc($result)){
		$data[] = array(
			'group_id' => 'abdc',
			'group_name' => utf8_encode('Collège Henri Sellier'),
			'date' => date('d/m/Y', $row['DT_CREATE']),
			'objectif_1' => $row['OBJECTIF_1'],
			'objectif_2' => $row['OBJECTIF_2'],
			'objectif_3' => $row['OBJECTIF_3'],
			'objectif_4' => $row['OBJECTIF_4'],
			'objectif_5' => $row['OBJECTIF_5'],
			'objectif_6' => $row['OBJECTIF_6'],
			'objectif_7' => $row['OBJECTIF_7'],
			'objectif_8' => $row['OBJECTIF_8'],

			'equipe_projet' => $row['EQUIPE_PROJET'],
			'ressources' => $row['RESSOURCES'],

			'instance_1' => $instances[$row['INSTANCE_1']],
			'instance_2' => $instances[$row['INSTANCE_2']],
			'instance_3' => $instances[$row['INSTANCE_3']],
			'instance_4' => $instances[$row['INSTANCE_4']],
			'instance_5' => $instances[$row['INSTANCE_5']],
			'instance_6' => $instances[$row['INSTANCE_6']],
			'instance_7' => $instances[$row['INSTANCE_7']],
			'instance_8' => $instances[$row['INSTANCE_8']],

			'comment_1' => $row['COMMENT_1'],
			'comment_2' => $row['COMMENT_2'],
			'comment_3' => $row['COMMENT_3'],
			'comment_4' => $row['COMMENT_4'],
			'comment_5' => $row['COMMENT_5'],
			'comment_6' => $row['COMMENT_6'],
			'comment_7' => $row['COMMENT_7'],
			'comment_8' => $row['COMMENT_8'],

			'calendrier' => $row['CALENDRIER']
		);
	}
/**
	var_dump($data);
	die();
*/

	/**
		Type de retour en fonction du type de format demandé
	*/

	if($format == "odp"){
		header("content-type: application/vnd.oasis.opendocument.presentation");
		header('Content-Disposition: attachment; filename="feuille_de_route.odp"');
	}
	
	if($format == "pdf"){
		header("content-type: application/vnd.oasis.opendocument.presentation");
		header('Content-Disposition: attachment; filename="feuille_de_route.pdf"');
	}

	
	/**
		Construstion du document selon le format
	*/
	if($format == 'odp'){

		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		
		$template = '../../_files/restitution/feuille_de_route.odp';
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).
		$TBS->MergeBlock('b', $data);
		$TBS->Show(OPENTBS_DOWNLOAD, "feuille_de_route.odp"); // Also merges all [onshow] automatic fields.
	}

	exit();	
?>