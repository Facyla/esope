<?php
	/**
		SCRIPT PHP POUR LES RESTITUTIONS DU QUESTIONNAIRE DE SATISFACTION
	*/
	require_once "../../inc/config.inc.php";
	require_once "../../inc/database.inc.php";
	require_once "../../inc/utils.inc.php";
	require_once "../../inc/cycle.inc.php";
	require_once "../../inc/survey/satisfaction/session.inc.php";
	require_once "../../inc/survey/satisfaction/calcul.inc.php";
	require_once "../../inc/survey/charts.inc.php";

	/**
		Récupère les données pour la restitution
		$cid est l'ID du cycle en cours
		$gid est l'ID du groupe CoCon
		Retourne un tableau associatif contenant les données de la restitution ou false s'il y a une erreur
	*/
	function getRestitutionDatas($cid, $gid){
		/**
			Tableau associatif des données de restitution
		*/
		$restitution = array(
			"cid" => $cid,
			"gid" => $gid,
			"dt_start" => 0,
			"dt_end" => 0,
			"num_rep" => 0,
			"rb1" => array(0.0, 0.0, 0.0, 0.0),
			"rb1_legends" => array(
				"Globalement, je suis satisfait par la démarche CoCon"
			),
			"rb1_layout" => array(
				"width" => 801,
				"height" => 106,
				"chart_left" => 570
			),
			"rb1_chart" => null,
			"rb2" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb2_legends" => array(
				"Le temps dédié à l'échange d'idées et usages",
				"Le temps de mise en pratique"
			),
			"rb2_layout" => array(
				"width" => 801,
				"height" => 151,
				"chart_left" => 570
			),
			"rb3" => array(
				array(0.0, 0.0),
				array(0.0, 0.0)
			),
			"rb3_legends" => array(
				"Membre de l'équipe projet (en contribuant à organiser le projet hors de mes heures de cours)",
				"Enseignant participant (en assistant aux ateliers de partage de nouvelles pratiques numériques)"
			),
			"rb3_layout" => array(
				"width" => 801,
				"height" => 128,
				"chart_left" => 570
			),
			"rb3_chart" => null,
			"rb4" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb4_legends" => array(
				"Profil 1",
				"Profil 2",
				"Profil 3",
				"Profil 4"
			),
			"rb4_layout" => array(
				"width" => 801,
				"height" => 446,
				"chart_left" => 270
			),
			"rb4_chart" => null,
			"rb5_1" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb5_1_legends" => array(
				"Profil 1",
				"Profil 2",
				"Profil 3",
				"Profil 4"
			),
			"rb5_1_layout" => array(
				"width" => 801,
				"height" => 446,
				"chart_left" => 270
			),
			"rb5_1_chart" => null,
			"rb5_2" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb5_2_legends" => array(
				"Profil 1",
				"Profil 2",
				"Profil 3",
				"Profil 4"
			),
			"rb5_2_layout" => array(
				"width" => 801,
				"height" => 446,
				"chart_left" => 270
			),
			"rb5_2_chart" => null,
			"rb6" => array(0.0, 0.0, 0.0, 0.0),
			"rb6_legends" => array(
				"Je souhaite qu'une nouvelle démarche soit lancée le plus rapidement possible"
			),
			"rb6_layout" => array(
				"width" => 801,
				"height" => 121,
				"chart_left" => 570
			),
			"rb6_chart" => null,
			
			"rs1" =>  0.0,
			"rs1_legends" => array(
				"Globalement, je suis satisfait par la démarche CoCon"
			),
			"rs1_layout" => array(
				"width" => 801,
				"height" => 106,
				"chart_left" => 570
			),
			"rs1_chart" => null,
			"rs2" => array(0.0, 0.0),
			"rs2_legends" => array(
				"Le temps dédié à l'échange d'idées et usages",
				"Le temps de mise en pratique"
			),
			"rs2_layout" => array(
				"width" => 801,
				"height" => 151,
				"chart_left" => 570
			),
			"rs2_chart" => null,
			"rs3" => array(0.0, 0.0),
			"rs3_legends" => array(
				"Membre de l'équipe projet (en contribuant à organiser le projet hors de mes heures de cours)",
				"Enseignant participant (en assistant aux ateliers de partage de nouvelles pratiques numériques)"
			),
			"rs3_layout" => array(
				"width" => 801,
				"height" => 128,
				"chart_left" => 570
			),
			"rs3_chart" => null,
			"rs4" => array(0.0, 0.0, 0.0, 0.0),
			"rs4_legends" => array(
				"Profil 1",
				"Profil 2",
				"Profil 3",
				"Profil 4"
			),
			"rs4_layout" => array(
				"width" => 801,
				"height" => 446,
				"chart_left" => 270
			),
			"rs4_chart" => null,
			"rs5_1" => array(0.0, 0.0, 0.0, 0.0),
			"rs5_1_legends" => array(
				"Profil 1",
				"Profil 2",
				"Profil 3",
				"Profil 4"
			),
			"rs5_1_layout" => array(
				"width" => 801,
				"height" => 204,
				"chart_left" => 270
			),
			"rs5_1_chart" => null,
			"rs5_2" => array(0.0, 0.0, 0.0, 0.0),
			"rs5_2_legends" => array(
				"Profil 1",
				"Profil 2",
				"Profil 3",
				"Profil 4"
			),
			"rs5_2_layout" => array(
				"width" => 801,
				"height" => 204,
				"chart_left" => 270
			),
			"rs5_2_chart" => null,
			"rs6" => 0.0,
			"rs6_legends" => array(
				"Je souhaite qu'une nouvelle démarche soit lancée le plus rapidement possible"
			),
			"rs6_layout" => array(
				"width" => 801,
				"height" => 121,
				"chart_left" => 570
			),
			"rs6_chart" => null
		);
		
		$restitution = getRenseignements($restitution);
		if(!$restitution){
			return false;
		}
		
		return $restitution;
	}
	
	/**
		Récupère les données de restitution pour la page Renseignements sur les répondants
		- $restitution est un tableau associatif contenant les clés pour chaque données
		Retourne le tableau associatif contenant les données de la restitution ou false s'il y a une erreur
	*/
	function getRenseignements($restitution){
		$conn = connectDB();
		
		$sql = 'select * from SESSION_SAT where CYCLE_ID="'.securiseSQLString($conn, $restitution['cid']).'" and GROUP_ID="'.securiseSQLString($conn, $restitution['gid']).'" and ACTIVE=1';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){

			/**
				Récupère les dates de départ et de fin
			*/
			
			// Date de départ la plus éloignée
			if($row['DT_START'] < $restitution['dt_start'] && $restitution['dt_start'] > 0){
				$restitution['dt_start'] = $row['DT_START'];
			}else{
				$restitution['dt_start'] = $row['DT_START'];
			}
		
			// date de fin la plus proche
			if($row['DT_END'] > $restitution['dt_end']){
				$restitution['dt_end'] = $row['DT_END'];
			}

			/*
				Participation au questionnaire
			*/
			if($row['ETAT'] == '1'){
				$restitution['num_rep']++;
			}
			
		}
		
		$resultats = calculResultats($restitution['cid'], $restitution['gid']);
		// Pour le test
		$restitution['num_rep'] = $resultats['num_rep'];
		if(!$resultats){
			return false;
		}
		
		/**
			Génère les graphiques
		*/
		$colors = array(
			"0"=>array("R"=>46,"G"=>151,"B"=>224),
			"1"=>array("R"=>224,"G"=>100,"B"=>46),
			"2"=>array("R"=>200,"G"=>200,"B"=>200),
			"3"=>array("R"=>255,"G"=>192,"B"=>0)
		);
		
		// BRUT 1
		$v = array(
			array(0.0, 0.0, 0.0, 0.0)
		);
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb1_1'][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb1_1'][1];
		$v[0][2] = round(100 / $restitution['num_rep']) * $resultats['rb1_1'][2];
		$v[0][3] = round(100 / $restitution['num_rep']) * $resultats['rb1_1'][3];
		$pChart = createMultiHorizontalBarChart($v, $restitution['rb1_legends'], $colors, $restitution['rb1_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rb1_chart'] = $pChart;
		
		// BRUT 2
		$v = array(
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0)
		);
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb2_1'][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb2_1'][1];
		$v[0][2] = round(100 / $restitution['num_rep']) * $resultats['rb2_1'][2];
		$v[0][3] = round(100 / $restitution['num_rep']) * $resultats['rb2_1'][3];
		$v[1][0] = round(100 / $restitution['num_rep']) * $resultats['rb2_2'][0];
		$v[1][1] = round(100 / $restitution['num_rep']) * $resultats['rb2_2'][1];
		$v[1][2] = round(100 / $restitution['num_rep']) * $resultats['rb2_2'][2];
		$v[1][3] = round(100 / $restitution['num_rep']) * $resultats['rb2_2'][3];
		
		$pChart = createMultiHorizontalBarChart($v, $restitution['rb2_legends'], $colors, $restitution['rb2_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rb2_chart'] = $pChart;

		// BRUT 3
		$v = array(
			array(0.0, 0.0),
			array(0.0, 0.0)
		);
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb3_1'][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb3_1'][1];
		$v[1][0] = round(100 / $restitution['num_rep']) * $resultats['rb3_2'][0];
		$v[1][1] = round(100 / $restitution['num_rep']) * $resultats['rb3_2'][1];
		
		$pChart = createMultiHorizontalBarChart($v, $restitution['rb3_legends'],$colors, $restitution['rb3_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rb3_chart'] = $pChart;

		// BRUT 4
		$v = array(
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0)
		);
		
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][0][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][0][1];
		$v[0][2] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][0][2];
		$v[0][3] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][0][3];

		$v[1][0] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][1][0];
		$v[1][1] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][1][1];
		$v[1][2] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][1][2];
		$v[1][3] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][1][3];
		
		$v[2][0] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][2][0];
		$v[2][1] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][2][1];
		$v[2][2] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][2][2];
		$v[2][3] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][2][3];

		$v[3][0] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][3][0];
		$v[3][1] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][3][1];
		$v[3][2] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][3][2];
		$v[3][3] = round(100 / $restitution['num_rep']) * $resultats['rb4_1'][3][3];

		$pChart = createMultiHorizontalBarChart($v, $restitution['rb4_legends'],$colors, $restitution['rb4_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rb4_chart'] = $pChart;

		// BRUT 5
		// 1
		$v = array(
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0)
		);
		
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][0][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][0][1];
		$v[0][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][0][2];
		$v[0][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][0][3];

		$v[1][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][1][0];
		$v[1][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][1][1];
		$v[1][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][1][2];
		$v[1][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][1][3];
		
		$v[2][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][2][0];
		$v[2][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][2][1];
		$v[2][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][2][2];
		$v[2][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][2][3];

		$v[3][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][3][0];
		$v[3][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][3][1];
		$v[3][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][3][2];
		$v[3][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_1'][3][3];

		$pChart = createMultiHorizontalBarChart($v, $restitution['rb5_1_legends'],$colors, $restitution['rb5_1_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rb5_1_chart'] = $pChart;
		
		// 2
		$v = array(
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0),
			array(0.0, 0.0, 0.0, 0.0)
		);
		
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][0][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][0][1];
		$v[0][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][0][2];
		$v[0][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][0][3];

		$v[1][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][1][0];
		$v[1][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][1][1];
		$v[1][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][1][2];
		$v[1][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][1][3];
		
		$v[2][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][2][0];
		$v[2][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][2][1];
		$v[2][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][2][2];
		$v[2][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][2][3];

		$v[3][0] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][3][0];
		$v[3][1] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][3][1];
		$v[3][2] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][3][2];
		$v[3][3] = round(100 / $restitution['num_rep']) * $resultats['rb5_2'][3][3];

		$pChart = createMultiHorizontalBarChart($v, $restitution['rb5_2_legends'],$colors, $restitution['rb5_2_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rb5_2_chart'] = $pChart;
		
		// BRUT 6
		$v = array(
			array(0.0, 0.0, 0.0, 0.0)
		);
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rb6_1'][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rb6_1'][1];
		$v[0][2] = round(100 / $restitution['num_rep']) * $resultats['rb6_1'][2];
		$v[0][3] = round(100 / $restitution['num_rep']) * $resultats['rb6_1'][3];
		$pChart = createMultiHorizontalBarChart($v, $restitution['rb6_legends'],$colors, $restitution['rb6_layout']);
		if(!$pChart){
			return false;
		}
		$restitution['rb6_chart'] = $pChart;		
		
		// SYNTH 1
		$v = array(0.0);
		$v[0] = round(100 / $restitution['num_rep']) * $resultats['rs1_1'];
		$pChart = createHorizontalBarChart($v, $restitution['rs1_legends'],array( "0" => array("R"=>46,"G"=>151,"B"=>224) ), $restitution['rs1_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs1_chart'] = $pChart;		

		// SYNTH 2
		$v = array(0.0, 0.0);
		$v[0] = round(100 / $restitution['num_rep']) * $resultats['rs2_1'];
		$v[1] = round(100 / $restitution['num_rep']) * $resultats['rs2_2'];
		$pChart = createHorizontalBarChart($v, $restitution['rs2_legends'],array( "0" => array("R"=>46,"G"=>151,"B"=>224) ), $restitution['rs2_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs2_chart'] = $pChart;		

		// SYNTH 3
		$v = array(
			array(0.0, 0.0),
			array(0.0, 0.0),
			array(0.0, 0.0),
			array(0.0, 0.0)
		);
		
		$v[0][0] = round(100 / $restitution['num_rep']) * $resultats['rs3_1'][0];
		$v[0][1] = round(100 / $restitution['num_rep']) * $resultats['rs3_1'][1];
		$v[1][0] = round(100 / $restitution['num_rep']) * $resultats['rs3_2'][0];
		$v[1][1] = round(100 / $restitution['num_rep']) * $resultats['rs3_2'][1];
		
		$pChart = createMultiHorizontalBarChart($v, $restitution['rs3_legends'],$colors, $restitution['rs3_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs3_chart'] = $pChart;
		
		// SYNTH 4
		$v = array(0.0, 0.0, 0.0, 0.0);
		$v[0] = round(100 / $restitution['num_rep']) * $resultats['rs4_1'][0];
		$v[1] = round(100 / $restitution['num_rep']) * $resultats['rs4_1'][1];
		$v[2] = round(100 / $restitution['num_rep']) * $resultats['rs4_1'][2];
		$v[3] = round(100 / $restitution['num_rep']) * $resultats['rs4_1'][3];
		$pChart = createHorizontalBarChart($v, $restitution['rs4_legends'],array( "0" => array("R"=>46,"G"=>151,"B"=>224) ), $restitution['rs4_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs4_chart'] = $pChart;
		
		// SYNTH 5
		// 1
		$v = array(0.0, 0.0, 0.0, 0.0);
		$v[0] = round(100 / $restitution['num_rep']) * $resultats['rs5_1'][0];
		$v[1] = round(100 / $restitution['num_rep']) * $resultats['rs5_1'][1];
		$v[2] = round(100 / $restitution['num_rep']) * $resultats['rs5_1'][2];
		$v[3] = round(100 / $restitution['num_rep']) * $resultats['rs5_1'][3];
		$pChart = createHorizontalBarChart($v, $restitution['rs5_1_legends'],array( "0" => array("R"=>46,"G"=>151,"B"=>224) ), $restitution['rs5_1_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs5_1_chart'] = $pChart;
		
		// 2
		$v = array(0.0, 0.0, 0.0, 0.0);
		$v[0] = round(100 / $restitution['num_rep']) * $resultats['rs5_2'][0];
		$v[1] = round(100 / $restitution['num_rep']) * $resultats['rs5_2'][1];
		$v[2] = round(100 / $restitution['num_rep']) * $resultats['rs5_2'][2];
		$v[3] = round(100 / $restitution['num_rep']) * $resultats['rs5_2'][3];
		$pChart = createHorizontalBarChart($v, $restitution['rs5_2_legends'],array( "0" => array("R"=>46,"G"=>151,"B"=>224) ), $restitution['rs5_2_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs5_2_chart'] = $pChart;

		// SYNTH 6
		$v = array(0.0);
		$v[0] = round(100 / $restitution['num_rep']) * $resultats['rs6_1'];
		$pChart = createHorizontalBarChart($v, $restitution['rs6_legends'],array( "0" => array("R"=>46,"G"=>151,"B"=>224) ), $restitution['rs6_layout'],"%");
		if(!$pChart){
			return false;
		}
		$restitution['rs6_chart'] = $pChart;	
		
		return $restitution;
	}
	
	/**
		Génère le document à partir des données de restitution
		- $format est une chaine qui doit être "odp" ou "pdf"
		- $restitution est l'objet JSON créé à partir de la fonction "getRestitutionDatas"
		
		Retourne soit l'objet TBS, soit l'objet PDF soit false s'il y a une erreur
	*/
	function createDocument($format, $restitution){
		$TBS = null;
		$template = null;
		$pdf = null;
			
		// ID unique pour le document
		$nid = getUniqueID();
		
		// Enregistre les images des graphiques
		$restitution['rb1_chart']->Render("gfx1_1_".$nid.".png");
		$restitution['rb2_chart']->Render("gfx2_1_".$nid.".png");
		$restitution['rb3_chart']->Render("gfx3_1_".$nid.".png");
		$restitution['rb4_chart']->Render("gfx4_1_".$nid.".png");
		$restitution['rb5_1_chart']->Render("gfx5_1_".$nid.".png");
		$restitution['rb5_2_chart']->Render("gfx5_2_".$nid.".png");
		$restitution['rb6_chart']->Render("gfx6_1_".$nid.".png");

		$restitution['rs1_chart']->Render("gfx1_2_".$nid.".png");
		$restitution['rs2_chart']->Render("gfx2_2_".$nid.".png");
		$restitution['rs3_chart']->Render("gfx3_2_".$nid.".png");
		$restitution['rs4_chart']->Render("gfx4_2_".$nid.".png");
		$restitution['rs5_1_chart']->Render("gfx5_3_".$nid.".png");
		$restitution['rs5_2_chart']->Render("gfx5_4_".$nid.".png");
		$restitution['rs6_chart']->Render("gfx6_2_".$nid.".png");

		if($format == "odp"){
			
			require_once(INC."/tbs/tbs_class.php");
			require_once(INC."/tbs/opentbs/tbs_plugin_opentbs.php");
			
			// Initialize the TBS instance
			$TBS = new clsTinyButStrong;
			$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
			
			// Chargement du template ODP
			$template = ROOT.'/_files/restitution/satisfaction.odp';
			$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).
			
			$data = array();
			$data[] = array(
				'date_start' => date('d/m/Y', $restitution['dt_start']),
				'date_end' =>  date('d/m/Y', $restitution['dt_end']),
				'number' => $nid,
			);			
			// Insert les données dans le template
			$TBS->MergeBlock('b', $data);
			return $TBS;
		}
		
		if($format == 'pdf'){
			$pdf = null;
			$template = null;
			
			include_once('../../pdf/fpdf.php');
			include_once('../../pdf/fpdi/fpdi.php');
			
			// Chargement du template ODP
			$template = ROOT.'/_files/restitution/satisfaction.pdf';
			
			$pdf = new FPDI();
			$pages = $pdf->setSourceFile($template);
			for($i = 1; $i < ($pages + 1); $i++){
				$pgId = $pdf->importPage($i); 
				$size = $pdf->getTemplateSize($pgId);

				if ($size['w'] > $size['h']) {
					$pdf->AddPage('L', array($size['w'], $size['h']));
				} else {
					$pdf->AddPage('P', array($size['w'], $size['h']));
				}			
				
				$pdf->useTemplate($pgId,0,0, 297,210);

				if($i == 2){
					pdfImageAdapter("gfx1_1_".$nid.".png");
					pdfImageAdapter("gfx2_1_".$nid.".png");
					pdfImageAdapter("gfx3_1_".$nid.".png");
					$pdf->Image("gfx1_1_".$nid.".png", 40, 40);
					$pdf->Image("gfx2_1_".$nid.".png", 40, 90);
					$pdf->Image("gfx3_1_".$nid.".png", 40, 150);
				}
				
				if($i == 3){
					pdfImageAdapter("gfx4_1_".$nid.".png");
					$pdf->Image("gfx4_1_".$nid.".png", 40, 50);
				}				

				if($i == 4){
					pdfImageAdapter("gfx5_1_".$nid.".png");
					$pdf->Image("gfx5_1_".$nid.".png", 40, 60);
				}
				
				if($i == 5){
					pdfImageAdapter("gfx5_2_".$nid.".png");
					$pdf->Image("gfx5_2_".$nid.".png", 40, 60);
				}				

				if($i == 6){
					pdfImageAdapter("gfx6_1_".$nid.".png");
					$pdf->Image("gfx6_1_".$nid.".png", 40, 40);
				}
				
				if($i == 7){
					pdfImageAdapter("gfx1_2_".$nid.".png");
					pdfImageAdapter("gfx2_2_".$nid.".png");
					pdfImageAdapter("gfx3_2_".$nid.".png");
					$pdf->Image("gfx1_2_".$nid.".png", 40, 40);
					$pdf->Image("gfx2_2_".$nid.".png", 40, 90);
					$pdf->Image("gfx3_2_".$nid.".png", 40, 150);
				}
				
				if($i == 8){
					pdfImageAdapter("gfx4_2_".$nid.".png");
					$pdf->Image("gfx4_2_".$nid.".png", 40, 50);
				}				

				if($i == 9){
					pdfImageAdapter("gfx5_3_".$nid.".png");
					pdfImageAdapter("gfx5_4_".$nid.".png");
					$pdf->Image("gfx5_3_".$nid.".png", 40, 55);
					$pdf->Image("gfx5_4_".$nid.".png", 40, 130);					
				}

				if($i == 10){
					pdfImageAdapter("gfx6_2_".$nid.".png");
					$pdf->Image("gfx6_2_".$nid.".png", 40, 40);
				}

			}
			
			return $pdf;
		}			
		return false;
	}
?>