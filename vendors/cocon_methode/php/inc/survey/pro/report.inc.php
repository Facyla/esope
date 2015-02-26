<?php
	/**
		SCRIPT PHP POUR LES RESTITUTIONS DU QUESTIONNAIRE ENSEIGNANTS
	*/
	require_once "../../inc/config.inc.php";
	require_once "../../inc/database.inc.php";
	require_once "../../inc/utils.inc.php";
	require_once "../../inc/cycle.inc.php";
	require_once "session.inc.php";
	require_once "calcul.inc.php";
	require_once "../../inc/survey/charts.inc.php";

	/**
		Récupère les données pour la restitution
		$cid est l'ID du cycle en cours
		$gid est l'ID du groupe CoCon
		$type est une chaine qui doit être "bruts" ou "synth"
		Retourne un tableau associatif contenant les données de la restitution ou false s'il y a une erreur
	*/
	function getRestitutionDatas($cid, $gid, $type){
		/**
			Tableau associatif des données de restitution
		*/
		$restitution = array(
			"cid" => $cid,
			"gid" => $gid,
			"type" => $type,
			"dt_start" => 0,
			"dt_end" => 0,
			"num_repondants" => 0,
			"num_complets" => 0,
			"num_enseignants" => 0,
			"taux_complets" => 0.0,
			"taux_reponse" => 0.0,
			"graph_1a_chart" => null,
			"graph_1b_chart" => null,
			"graph_2" => array(0,0,0,0,0,0),
			"graph_2_chart" => null,
			"graph_3" => array(0,0,0,0,0,0,0,0,0,0,0,0),
			"graph_3_chart" => null,
			"graph_4" => array(0,0,0,0,0),
			"graph_4_chart" => null,
			"graph_5" => array(0,0,0,0,0,0),
			"graph_5_chart" => null,
			"graph_6" => array(0,0,0,0,0),
			"graph_6_chart" => null,
			"graph_7" => array(0,0,0,0,0,0,0,0,0,0,0),
			"graph_7_autre" => array(),
			"graph_7_legends" => array(
				"Gérer les différences de rythme et de niveau des élèves",
				"Diversifier les activités et les modalités de travail",
				"Accompagnement les élèves de manière personnalisée",
				"Favoriser l'apprentissage en autonomie",
				"Gérer les contraintes imposées par les programmes",
				"Garder une trace des activités",
				"Favoriser et articuler différentes formes d'interactivité",
				"Trouver, partager et construire des ressources et contenus pédagogiques",
				"Exploiter davantage les possibilités ouvertes par le numérique en dehors la classe",
				"Développer les capacités de rédaction et de raisonnement des élèves",
				"Rapprocher les pratiques pédagogiques de ce que connaissent la plupart des élèves en dehors de l'école."
			),
			"graph_7_layout" => array(
				"width" => 864,
				"height" => 476,
				"chart_left" => 570
			),
			"graph_7_reps" => array(3,4),
			"graph_7_graph" => null,
			"graph_8" => array(0,0,0,0,0,0,0,0,0,0,0),
			"graph_8_autre" => array(),
			"graph_8_legends" => array(
				"Gérer les différences de rythme et de niveau des élèves",
				"Diversifier les activités et les modalités de travail",
				"Accompagnement les élèves de manière personnalisée",
				"Favoriser l'apprentissage en autonomie",
				"Gérer les contraintes imposées par les programmes",
				"Garder une trace des activités",
				"Favoriser et articuler différentes formes d'interactivité",
				"Trouver, partager et construire des ressources et contenus pédagogiques",
				"Exploiter davantage les possibilités ouvertes par le numérique en dehors la classe",
				"Développer les capacités de rédaction et de raisonnement des élèves",
				"Rapprocher les pratiques pédagogiques de ce que connaissent la plupart des élèves en dehors de l'école."
			),
			"graph_8_colors" => array(
				"0"=>array("R"=>255,"G"=>192,"B"=>0)
			),
			"graph_8_layout" => array(
				"width" => 864,
				"height" => 476,
				"chart_left" => 570
			),
			"graph_8_reps" => array(3,4),
			"graph_8_graph" => null,
			"graph_7_vs_8_graph" => null,
			"graph_7_vs_8_layout" => array(
				"width" => 864,
				"height" => 476,
				"chart_left" => 570
			),
			"graph_9" => array(0,0,0,0),
			"graph_9_legends" => array(
				"Au sein de mon établissement, de visu.",
				"Au sein de mon établissement, via internet (réseaux sociaux, blog,...)",
				"En dehors de mon établissement, de visu",
				"En dehors de mon établissement, via internet (réseaux sociaux, blog,...)"
			),
			"graph_9_layout" => array(
				"width" => 864,
				"height" => 219,
				"chart_left" => 470
			),
			"graph_9_reps" => array(3,4),
			"graph_9_graph" => null,
			"graph_10" => array(0,0,0,0),
			"graph_10_legends" => array(
				"Au sein de mon établissement, de visu.",
				"Au sein de mon établissement, via internet (réseaux sociaux, blog,...)",
				"En dehors de mon établissement, de visu",
				"En dehors de mon établissement, via internet (réseaux sociaux, blog,...)"
			),
			"graph_10_colors" => array(
				"0"=>array("R"=>255,"G"=>192,"B"=>0)
			),			
			"graph_10_layout" => array(
				"width" => 864,
				"height" => 219,
				"chart_left" => 470
			),
			"graph_10_reps" => array(3,4),
			"graph_10_graph" => null,
			"graph_9_vs_10_graph" => null,
			"graph_9_vs_10_layout" => array(
				"width" => 864,
				"height" => 476,
				"chart_left" => 570
			),			
			"graph_11" => array(0,0),
			"graph_11_autre" => array(),
			"graph_11_legends" => array(
				"Au sein de mon établissement",
				"En dehors de mon établissement"
			),
			"graph_11_layout" => array(
				"width" => 864,
				"height" => 476,
				"chart_left" => 370
			),
			"graph_11_reps" => array(3,4),
			"graph_11_graph" => null,
			"graph_12" => array(0,0),
			"graph_12_legends" => array(
				"A titre professionnel",
				"A titre personnel"
			),
			"graph_12_layout" => array(
				"width" => 864,
				"height" => 249,
				"chart_left" => 470
			),
			"graph_12_reps" => array(2,3,4),
			"graph_12_graph" => null,
			"graph_13" => array(0),
			"graph_13_legends" => array(
				"Je m'auto-forme au numérique"
			),
			"graph_13_layout" => array(
				"width" => 864,
				"height" => 219,
				"chart_left" => 470
			),
			"graph_13_reps" => array(2,3),
			"graph_13_graph" => null,
			"graph_14" => array(0,0,0),
			"graph_14_legends" => array(
				"Le projet d'établissement de mon collège",
				"Le volet numérique du projet d'établissement",
				"Le projet Collège Connecté (ou projet CoCon)"
			),
			"graph_14_layout" => array(
				"width" => 864,
				"height" => 143,
				"chart_left" => 470
			),
			"graph_14_reps" => array(1),
			"graph_14_graph" => null,
			"graph_15" => array(0,0),
			"graph_15_legends" => array(
				"Le projet d'établissement de mon collège",
				"Le volet numérique du projet d'établissement"
			),
			"graph_15_layout" => array(
				"width" => 864,
				"height" => 128,
				"chart_left" => 470
			),
			"graph_15_reps" => array(1),
			"graph_15_graph" => null,
			"graph_16" => array(0,0),
			"graph_16_legends" => array(
				"Le projet d'établissement de mon collège",
				"Le volet numérique du projet d'établissement"
			),
			"graph_16_layout" => array(
				"width" => 864,
				"height" => 128,
				"chart_left" => 470
			),
			"graph_16_colors" => array(
				"0"=>array("R"=>255,"G"=>192,"B"=>0)
			),				
			"graph_16_reps" => array(1),
			"graph_16_graph" => null,
			"graph_17" => array(0,0,0,0,0),
			"graph_17_legends" => array(
				"Le projet d'établissement de mon collège",
				"Le volet numérique du projet d'établissement de mon collège",
				"La démarche et le projet Collège Connecté",
				"L'idée de développer de nouvelles pratiques pédagogiques intégrant davantage le numérique",
				"L'idée de développer de nouvelles compétences personnelles intégrant davantage le numérique"
			),
			"graph_17_layout" => array(
				"width" => 864,
				"height" => 218,
				"chart_left" => 570
			),
			"graph_17_reps" => array(3,4),
			"graph_17_graph" => null,
			"graph_18" => array(0,0),
			"graph_18_legends" => array(
				"Membre de l'équipe projet (en contribuant à organiser le projet hors de mes heures de cours)",
				"Enseignant participant (en assistant aux ateliers de partage de nouvelles pratiques numériques)"
			),
			"graph_18_layout" => array(
				"width" => 864,
				"height" => 188,
				"chart_left" => 570
			),
			"graph_18_reps" => array(1),
			"graph_18_graph" => null,
			"graph_19" => array(0,0),
			"graph_19_legends" => array(
				"Les équipements numériques",
				"L'utilisation de contenus numériques (logiciels pédagogiques ou éducatifs, livres, présentations,...)"
			),
			"graph_19_layout" => array(
				"width" => 864,
				"height" => 89,
				"chart_left" => 570
			),
			"graph_19_reps" => array(3,4),
			"graph_19_graph" => null,
			"graph_20" => array(0,0),
			"graph_20_legends" => array(
				"Au format numérique (traitement de texte, présentation,...)",
				"Au format papier"
			),
			"graph_20_layout" => array(
				"width" => 864,
				"height" => 90,
				"chart_left" => 570
			),
			"graph_20_reps" => array(1,2),
			"graph_20_graph" => null,
			"graph_21" => array(0,0,0,0,0,0),
			"graph_21_legends" => array(
				"Je fais des recherches en ligne",
				"Je dispose personnellement de contenus numériques adaptées",
				"J'échange ou ai échangé des contenus au format papier avec d'autres enseignants au sein de mon collège",
				"J'échange ou ai échangé des contenus au format papier avec d'autres enseignants au-delà de mon collège",
				"J'échange ou ai échangé des contenus au format numérique avec d'autres enseignants au sein de mon collège",
				"J'échange ou ai échangé des contenus au format numérique avec d'autres enseignants au-delà de mon collège"
			),
			"graph_21_layout" => array(
				"width" => 864,
				"height" => 249,
				"chart_left" => 670
			),
			"graph_21_reps" => array(3,4),
			"graph_21_graph" => null,
			"graph_22" => array(0,0),
			"graph_22_legends" => array(
				"Des contenus numériques",
				"Des équipements numériques"
			),
			"graph_22_layout" => array(
				"width" => 864,
				"height" => 71,
				"chart_left" => 470
			),
			"graph_22_reps" => array(3,4),
			"graph_22_graph" => null,
			"graph_23" => array(0,0,0,0),
			"graph_23_legends" => array(
				"Sont simples d'utilisation",
				"Sont une aide",
				"Sont utiles",
				"Me permettent de développer de nouvelles compétences"
			),
			"graph_23_layout" => array(
				"width" => 864,
				"height" => 131,
				"chart_left" => 570
			),
			"graph_23_reps" => array(1),
			"graph_23_graph" => null,
			"graph_24" => array(0,0,0,0,0,0,0),
			"graph_24_autre" => array(),
			"graph_24_legends" => array(
				"Internet",
				"La vidéoprojection",
				"Un ordinateur",
				"Des tablettes",
				"Le Tableau Numérique Interactif",
				"Le baladodiffusion",
				"Des livres et autres contenus numérique(logiciels pédagogiques ou éducatifs, livres, présentations,...)"
			),
			"graph_24_layout" => array(
				"width" => 864,
				"height" => 219,
				"chart_left" => 570
			),
			"graph_24_reps" => array(3,4),
			"graph_24_graph" => null,
			"graph_25" => array(0),
			"graph_25_legends" => array(
				"Parmi les outils suivants (ordinateur, tablette, TNI, baladodiffusion),\nj'estime avoir une très bonne maîtrise de :"
			),
			"graph_25_layout" => array(
				"width" => 864,
				"height" => 222,
				"chart_left" => 470
			),
			"graph_25_reps" => array(2,3,4),
			"graph_25_graph" => null,
			"graph_26" => array(0,0),
			"graph_26_legends" => array(
				"Avec les élèves",
				"Avec les parents"
			),
			"graph_26_layout" => array(
				"width" => 864,
				"height" => 219,
				"chart_left" => 470
			),
			"graph_26_reps" => array(3,4),
			"graph_26_graph" => null,
			"graph_27" => array(0,0,0,0,0),
			"graph_27_legends" => array(
				"D'un smartphone",
				"D'un ordinateur",
				"D'une tablette",
				"D'un accès internet à domicile",
				"D'un accès internet via mon mobile"
			),
			"graph_27_layout" => array(
				"width" => 864,
				"height" => 151,
				"chart_left" => 470
			),
			"graph_27_reps" => array(1),
			"graph_27_graph" => null,
			"graph_28" => array(0,0,0),
			"graph_28_legends" => array(
				"Par emails",
				"Via les réseaux sociaux",
				"Par visioconférence (exemple : Skype)",				
			),
			"graph_28_layout" => array(
				"width" => 864,
				"height" => 113,
				"chart_left" => 470
			),
			"graph_28_reps" => array(3,4),
			"graph_28_graph" => null,
			"graph_29" => array(0,0,0),
			"graph_29_legends" => array(
				"J'achète en ligne",
				"Je télécharge (musique, film)",
				"J'utilise la VOD / le replay / Le streaming"
			),
			"graph_29_layout" => array(
				"width" => 864,
				"height" => 151,
				"chart_left" => 470
			),
			"graph_29_reps" => array(3,4),
			"graph_29_graph" => null,
			"graph_30" => array(0,0,0),
			"graph_30_legends" => array(
				"Techniques avec l'équipement",
				"Pour faire fonctionner seul les équipements numériques",
				"Pour utiliser les équipements numériques"
			),
			"graph_30_layout" => array(
				"width" => 864,
				"height" => 219,
				"chart_left" => 470
			),
			"graph_30_reps" => array(1,2),
			"graph_30_graph" => null,
			"graph_31" => array(0,0),
			"graph_31_legends" => array(
				"Par les élèves",
				"Par les collègues"
			),
			"graph_31_layout" => array(
				"width" => 864,
				"height" => 226,
				"chart_left" => 470
			),
			"graph_31_reps" => array(1,2),
			"graph_31_graph" => null,
			"graph_32" => array(0,0,0,0,0,0,0,0,0,0,0,0),
			"graph_32_autre" => array(),
			"graph_32_legends" => array(
				"Le temps de préparation associé à l'éloboration de contenus pédagogiques au format numérique",
				"Les difficultés techniques rencontrées",
				"Le manque de reconnaissance associé à une plus grande utilisation des ressources numériquess",
				"Le manque d'accompagnement et de soutien humain et technique",
				"Une formation et des compétences trop limitées",
				"Une faible appétance pour le numérique",
				"Un manque d'expérience et de connaissances du numérique",
				"Le manque de recul et de visibilité sur la plus-value pédagogique et les apports réels du numérique",
				"La crainte de perdre en qualité par rapport aux propositions existantes",
				"Le manque d'information sur les resources existantes",
				"Le manque d'équipements numériques",
				"Le manque de contenus numériques(logiciels pédagogiques ou éducatifs, livres, présentations,...)"
			),
			"graph_32_layout" => array(
				"width" => 864,
				"height" => 453,
				"chart_left" => 570
			),
			"graph_32_reps" => array(3,4),
			"graph_32_graph" => null,
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
		
		$sql = 'select * from SESSION where CYCLE_ID="'.securiseSQLString($conn, $restitution['cid']).'" and GROUP_ID="'.securiseSQLString($conn, $restitution['gid']).'" and ACTIVE=1';
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
			$restitution['num_repondants']++;
			$restitution['num_enseignants']++;
			if($row['ETAT'] == '2'){
				$restitution['num_complets']++;
			}
			
			// Mise à jour des %
			$restitution['taux_complets'] = (100 / $restitution['num_repondants']) * $restitution['num_complets'];
			$restitution['taux_reponse'] = (100 / $restitution['num_enseignants']) * $restitution['num_repondants'];
			if($row['ETAT'] == 2){
				/**
					Répartition par statut
				*/
				$restitution['graph_2'][$row['STATUS']]++;
				
				/**
					Répartition par ancienneté d'enseignement
				*/
				if($row['ANNEES_ENS'] < 5){
					$restitution['graph_5'][0]++;
				}
				
				if($row['ANNEES_ENS'] > 4 && $row['ANNEES_ENS'] < 10){
					$restitution['graph_5'][1]++;
				}
				
				if($row['ANNEES_ENS'] > 9 && $row['ANNEES_ENS'] < 20){
					$restitution['graph_5'][2]++;
				}

				if($row['ANNEES_ENS'] > 19 && $row['ANNEES_ENS'] < 30){
					$restitution['graph_5'][3]++;
				}

				if($row['ANNEES_ENS'] > 29){
					$restitution['graph_5'][4]++;
				}
				
				/**
					Répartition par ancienneté dans le collège
				*/
				if($row['ANCIEN'] < 5){
					$restitution['graph_6'][0]++;
				}
				
				if($row['ANCIEN'] > 4 && $row['ANCIEN'] < 10){
					$restitution['graph_6'][1]++;
				}
				
				if($row['ANCIEN'] > 9 && $row['ANCIEN'] < 20){
					$restitution['graph_6'][2]++;
				}

				if($row['ANCIEN'] > 19 && $row['ANCIEN'] < 30){
					$restitution['graph_6'][3]++;
				}

				/**
					Répartition par matières et niveaux
				*/
				$sql2 = 'select * from SESSION_MATIERE where SESSION_ID="'.securiseSQLString($conn, $row['SESSION_ID']).'" order by MATIERE_POS asc';
				$result2 = executeQuery($conn, $sql2);
				if(!$result2){
					return false;
				}
				
				// Pour éviter les doublons lors de la comptabilisation
				$mat = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
				$niv = array(0,0,0,0);
				
				// matières
				while($row2 = mysql_fetch_assoc($result2)){
					if($mat[$row2['MATIERE_ID']] == 0){
						$restitution['graph_3'][$row2['MATIERE_ID']]++;
						$mat[$row2['MATIERE_ID']] = 1;
					}
					if($niv[$row2['NIVEAU_ID']] == 0){
						$restitution['graph_4'][$row2['NIVEAU_ID']]++;
						$niv[$row2['NIVEAU_ID']] = 1;
					}
				}
				
				/**
					Calculs par questions
				*/
				$q = 7;
				$over = false;
				while(!$over){
					$reps = array();
					if(isset($restitution['graph_'.$q.'_reps'])){
						$reps = $restitution['graph_'.$q.'_reps'];
					}
					
					if($restitution['type'] == 'synth'){
						$rep = tauxReponses($q, $row['SESSION_ID'], $reps);
					}else{
						$rep = tauxReponsesBruts($q, $row['SESSION_ID']);
					}
					
					if(!$rep){
						return false;
					}
					
					if(isset($restitution['graph_'.$q.'_autre'])){
						array_push($restitution['graph_'.$q.'_autre'], $rep['autre']);
					}
					
					if($restitution['type'] == 'bruts'){
						if(!is_array($restitution['graph_'.$q][0])){
							$restitution['graph_'.$q] = array(
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0),
								array(0,0,0,0)
							);
						}	
						
						for($i = 0; $i < count($restitution['graph_'.$q]); $i++){
							for($ii = 0; $ii < 4; $ii++){
								$restitution['graph_'.$q][$i][$ii] += $rep[$i][$ii];
							}
						}
						
					}else{
						for($i = 0; $i < count($restitution['graph_'.$q]); $i++){
							if(isset($rep[$i])){
								$restitution['graph_'.$q][$i] += $rep[$i];
							}
						}
					}
					
					$q++;
					if($q > 32){
						$over = true;
					}
				}
			}
			//var_dump($restitution);
		}
		
		/**
			Génère les graphiques
		*/
		
		/**
			PARTICIPATION
		*/
		$v = array($restitution['num_complets'],$restitution['num_repondants'],$restitution['num_enseignants']);
		$l = array("Nombre de\nquestionnaires complets", "Nombre de répondants\nau questionnaire", "Nombre\nd'enseignants");
		$colors = array(
			"0"=>array("R"=>222,"G"=>235,"B"=>247),
			"1"=>array("R"=>157,"G"=>195,"B"=>230),
			"2"=>array("R"=>255,"G"=>192,"B"=>0)
		);	
		
		$chart = createHorizontalBarChart($v, $l, $colors, array("width" => 380, "height" => 477, "font_size" => 10));
		$restitution['graph_1a_chart'] = $chart;

		/**
			En %
		*/
		$v = array($restitution['taux_complets'],$restitution['taux_reponse']);
		$l = array("Taux de questionnaires\ncomplets", "Taux de réponse\nau questionnaire");
		$colors = array(
			"0"=>array("R"=>222,"G"=>235,"B"=>247),
			"1"=>array("R"=>157,"G"=>195,"B"=>230)
		);	
		
		$chart = createHorizontalBarChart($v, $l, $colors, array("width" => 380, "height" => 477, "font_size" => 10),"%");
		$restitution['graph_1b_chart'] = $chart;
		
		/**
			STATUT
		*/
		$v = array(0,0,0,0,0);
		$v2 = array();
		$l = array("Titulaire", "TZR", "Contractuel", "Stagiaire", "Autre");
		$l2 = array();
		for($i = 1; $i < 6; $i++){
			if($restitution['num_repondants'] > 0){
				$v[$i - 1] = round((100 / $restitution['num_repondants']) * $restitution['graph_2'][$i]);
			}else{
				$v[$i - 1] = 0;
			}
			if($v[$i-1] > 0){
				array_push($v2, $v[$i-1]);
				array_push($l2, $l[$i-1]);
			}
		}
		
		if(count($v2) == 0){
			$v2 = array(100,0,0,0,0);
			$l2 = array("","","","","");
		}

		$chart = createPieChart($v2, $l2,"", array("legend_left" => 240, "width" => 380, "height" => 214, "chart_size" => 70, "font_size" => 9));
		$restitution['graph_2_chart'] = $chart;
		
		/**
			NIVEAU DE RESPONSABILITE
		*/
		$v = array(0,0,0,0,0,0,0,0,0,0,0);
		$v2 = array();
		$l = array(
			"Documentaliste",
			"Education artistique & musicale",
			"EPS",
			"Histoire-Géographique",
			"Langues mortes/anciennes",
			"Langues vivantes",
			"Lettres",
			"Mathématiques",
			"Physique-Chimie",
			"SVT",
			"Technologie",
			"Autre"
		);
		$l2 = array();
		for($i = 0; $i < 11; $i++){
			if($restitution['num_repondants'] > 0){
				$v[$i] = round(100 / $restitution['num_repondants']) * $restitution['graph_3'][$i];
			}else{
				$v[$i] = 0;
			}
			if($v[$i] > 0){
				array_push($v2, $v[$i]);
				array_push($l2, $l[$i]);
			}
		}
		
		if(count($v2) == 0){
			$v2 = array(100);
			$l2 = array("");
		}	
	
		$chart = createPieChart($v2, $l2, "", array("legend_left" => 205, "legend_top" => 70,"width" => 380, "height" => 251, "chart_left" => 105, "chart_size" => 60, "font_size" => 9));
		$restitution['graph_3_chart'] = $chart;
		
		/**
			PRESENCE PAR NIVEAU
		*/
		$v = array(0,0,0,0);
		$v2 = array();
		$l = array("Enseignants présents sur tous\nles niveaux", "Enseignants présents sur\n3 niveaux", "Enseignants présents sur\n2 niveaux", "Enseignants présents sur\n1 niveau");
		$l2 = array();

		for($i = 0; $i < 4; $i++){
			if($restitution['num_repondants'] > 0){
				$v[$i] = round((100 / $restitution['num_repondants']) * $restitution['graph_4'][$i]);
			}else{
				$v[$i] = 0;
			}
			
			if($v[$i] > 0){
				array_push($v2, $v[$i]);
				array_push($l2, $l[$i]);
			}
		}
		
		if(count($v2) == 0){
			$v2 = array(100);
			$l2 = array("");
		}
		
		$chart = createPieChart($v2, $l2, "", array("chart_left" => 90, "chart_top" => 71, "chart_size" => 50, "legend_left" => 200, "width" => 401, "height" => 142));
		$restitution['graph_4_chart'] = $chart;
		/**
			ANCIENNETE D'ENSEIGNEMENT
		*/
		$v = array(0,0,0,0,0);
		$v2 = array();
		$l = array("inférieur à 5 ans", "Entre 5 et 10 ans", "Entre 10 et 20 ans", "Entre 20 et 30 ans", "supérieur à 30 ans");
		$l2 = array();

		for($i = 1; $i < 6; $i++){

			if($restitution['num_repondants'] > 0){
				$v[$i - 1] = round((100 / $restitution['num_repondants']) * $restitution['graph_5'][$i]);
			}else{
				$v[$i - 1] = 0;
			}
			
			if($v[$i-1] > 0){
				array_push($v2, $v[$i-1]);
				array_push($l2, $l[$i-1]);
			}
		}

		if(count($v2) == 0){
			$v2 = array(100);
			$l2 = array("");
		}	
		
		$chart = createPieChart($v2, $l2, "", array("chart_left" => 100, "chart_top" => 75, "chart_size" => 50, "legend_left" => 230, "width" => 401, "height" => 146));
		$restitution['graph_5_chart'] = $chart;
		
		/**
			ANCIENNETE DANS LE COLLEGE
		*/
		$v = array(0,0,0,0);
		$v2 = array();
		$l = array("inférieur à 5 ans", "Entre 5 et 10 ans", "Entre 10 et 20 ans", "supérieur à 20 ans");
		$l2 = array();

		if(count($v2) == 0){
			$v2 = array(100);
			$l2 = array("");
		}	
		
		for($i = 1; $i < 5; $i++){
			if($restitution['num_repondants'] > 0){
				$v[$i - 1] = round((100 / $restitution['num_repondants']) * $restitution['graph_6'][$i]);
			}else{
				$v[$i - 1] = 0;
			}
			
			if($v[$i-1] > 0){
				array_push($v2, $v[$i-1]);
				array_push($l2, $l[$i-1]);
			}
		}
		
		$chart = createPieChart($v2, $l2, "", array("chart_left" => 100, "chart_top" => 75, "chart_size" => 50, "legend_left" => 230, "width" => 401, "height" => 146));
		$restitution['graph_6_chart'] = $chart;

		/**
			Graphiques questions 7 à 32
		*/
		$q = 7;
		while($q < 33){
			$v = $restitution['graph_'.$q];
			$v2 = array();
			
			// Calcul des taux
			if($restitution['type'] == 'synth'){
				for($i = 0; $i < count($v); $i++){
					$tx = round(100 / $restitution['num_repondants']) * $v[$i];
					if($tx > 100){
						$tx = 100;
					}
					array_push($v2, $tx);
				}
			}
			
			if($restitution['type'] == 'bruts'){
				for($i = 0; $i < count($v); $i++){
					$tx = array(0,0,0,0);
					
					for($ii = 0; $ii < 4; $ii++){
						$t = round((100 / $restitution['num_repondants']) * $v[$i][$ii]);
					
						if ($t > 100){
							$t = 100;
						}
						$tx[$ii] = $t;
					}
					array_push($v2, $tx);
				}
			}
			
			$l = array();
			if(isset($restitution['graph_'.$q.'_legends'])){
				$l = $restitution['graph_'.$q.'_legends'];
			}else{
				$l = $restitution['graph_'.$q];
			}

			$colors = array();
			$chart = null;
			
			if($restitution['type'] == 'synth'){
				if(isset($restitution['graph_'.$q.'_colors'])){
					$colors = $restitution['graph_'.$q.'_colors'];
				}else{
					$colors = array(
						"0" =>array("R"=>157,"G"=>195,"B"=>230)
					);	
				}
				$chart = createHorizontalBarChart($v2, $l, $colors, $restitution['graph_'.$q.'_layout'],"%");
			}
			
			if($restitution['type'] == 'bruts'){
				$colors = array(
					"0"=>array("R"=>188,"G"=>224,"B"=>46),
					"1"=>array("R"=>224,"G"=>100,"B"=>46),
					"2"=>array("R"=>224,"G"=>214,"B"=>46),
					"3"=>array("R"=>46,"G"=>151,"B"=>224)
				);	
				$chart = createMultiHorizontalBarChart($v2, $l, $colors, $restitution['graph_'.$q.'_layout'],"%");
			}
			$restitution['graph_'.$q.'_chart'] = $chart;
			$q++;			
		}

		/**
			Graphiques barre doubles
		*/

		if($restitution['type'] == 'synth'){
		
			// Question 7 vs Question 8
			$v7 = $restitution['graph_7'];
			$v72 = array();
			for($i = 0; $i < count($v7); $i++){
				$tx = round(100 / $restitution['num_repondants']) * $v7[$i];
				if($tx > 100){
					$tx = 100;
				}
				array_push($v72, $tx);
			}

			$v8 = $restitution['graph_8'];
			$v82 = array();
			for($i = 0; $i < count($v8); $i++){
				$tx = round(100 / $restitution['num_repondants']) * $v8[$i];
				if($tx > 100){
					$tx = 100;
				}
				array_push($v82, $tx);
			}

			$l = array();
			if(isset($restitution['graph_7_legends'])){
				$l = $restitution['graph_7_legends'];
			}else{
				$l = $restitution['graph_7'];
			}		
			
			$chart = createDoubleHorizontalBarChart($v72, $v82, $l, "", $restitution['graph_7_vs_8_layout'],"%");
			$restitution['graph_7_vs_8_chart'] = $chart;
			
			// Question 9 vs Question 10
			$v9 = $restitution['graph_9'];
			$v92 = array();
			for($i = 0; $i < count($v9); $i++){
				$tx = round(100 / $restitution['num_repondants']) * $v9[$i];
				if($tx > 100){
					$tx = 100;
				}
				array_push($v92, $tx);
			}

			$v10 = $restitution['graph_10'];
			$v102 = array();
			for($i = 0; $i < count($v10); $i++){
				$tx = round(100 / $restitution['num_repondants']) * $v10[$i];
				if($tx > 100){
					$tx = 100;
				}
				array_push($v102, $tx);
			}

			$l = array();
			if(isset($restitution['graph_9_legends'])){
				$l = $restitution['graph_9_legends'];
			}else{
				$l = $restitution['graph_9'];
			}		
			
			$chart = createDoubleHorizontalBarChart($v92, $v102, $l, "", $restitution['graph_7_vs_8_layout'],"%");
			$restitution['graph_9_vs_10_chart'] = $chart;
		}
		
		return $restitution;
	}
	
	/**
		Calcul les taux de réponses à une question
		- $q est le N° de la question
		- $sid est l'ID de la session de reponses
		- reponses est le tableaux des valeurs de réponses à prendre en compte dans les calculs
		
		Retourne un tableau de valeurs ou false si il y a une erreur
	*/
	function tauxReponses($q, $sid, $reponses){
		
		$conn = connectDB();
		$l = 1;
		$over = false;
		$rep = array(0,0,0,0,0,0,0,0,0,0,0,0,"autre" => "");
		while(!$over){
			if($l < 13){
				$sql = 'select * from REPONSE where SESSION_ID="'.securiseSQLString($conn, $sid).'" and REP_ID="'.securiseSQLString($conn, 'quest_'.$q.'_l'.$l).'"';
			}else{
				$sql = 'select * from REPONSE where SESSION_ID="'.securiseSQLString($conn, $sid).'" and REP_ID="'.securiseSQLString($conn, 'quest_'.$q.'_autre').'"';
			}
			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
			
			while($row = mysql_fetch_assoc($result)){
				if($l < 13){
					if(in_array($row['REP_DATA'], $reponses)){
						$rep[$l - 1] = 1;
					}
				}else{
					$rep['autre'] = $row['COMMENT'];
				}
			}
			$l++;
			if($l == 14){
				$over = true;
			}
		}
		
		return $rep;
	}

	/**
		Calcul les taux de réponses bruts à une question
		- $q est le N° de la question
		- $sid est l'ID de la session de reponses
		- reponses est le tableaux des valeurs de réponses à prendre en compte dans les calculs
		
		Retourne un tableau de valeurs ou false si il y a une erreur
	*/
	function tauxReponsesBruts($q, $sid){
		
		$conn = connectDB();
		$l = 1;
		$over = false;
		$rep = array(
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			array(0,0,0,0),
			"autre" => ""
		);
			
		while(!$over){
			if($l < 13){
				$sql = 'select * from REPONSE where SESSION_ID="'.securiseSQLString($conn, $sid).'" and REP_ID="'.securiseSQLString($conn, 'quest_'.$q.'_l'.$l).'"';
			}else{
				$sql = 'select * from REPONSE where SESSION_ID="'.securiseSQLString($conn, $sid).'" and REP_ID="'.securiseSQLString($conn, 'quest_'.$q.'_autre').'"';
			}
			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
			
			while($row = mysql_fetch_assoc($result)){
				if($l < 13){
					$rep[$l - 1][$row['REP_DATA'] - 1] = 1;
				}else{
					$rep['autre'] = $row['COMMENT'];
				}
			}
			$l++;
			if($l == 14){
				$over = true;
			}
		}
		
		return $rep;
	}
	
	/**
		Génère le document à partir des données de restitution
		- $format est une chaine qui doit être "odp" ou "pdf"
		- $restitution est le tableau de valeurs créé à partir de la fonction "getRestitutionDatas"
		
		Retourne soit l'objet TBS, soit l'objet PDF soit false s'il y a une erreur
	*/
	function createDocument($format, $restitution){

		// ID unique pour le document
		$nid = $restitution['gid'];
			
		// Enregistre les images des graphiques
		$restitution['graph_1a_chart']->Render("gfx1_1_".$nid.".png");
		$restitution['graph_1b_chart']->Render("gfx1_2_".$nid.".png");
		$restitution['graph_2_chart']->Render("gfx2_1_".$nid.".png");
		$restitution['graph_3_chart']->Render("gfx3_1_".$nid.".png");
		$restitution['graph_4_chart']->Render("gfx4_1_".$nid.".png");
		$restitution['graph_5_chart']->Render("gfx5_1_".$nid.".png");
		$restitution['graph_6_chart']->Render("gfx6_1_".$nid.".png");
		$restitution['graph_7_chart']->Render("gfx7_1_".$nid.".png");
		$restitution['graph_8_chart']->Render("gfx8_1_".$nid.".png");
		$restitution['graph_9_chart']->Render("gfx9_1_".$nid.".png");
		$restitution['graph_10_chart']->Render("gfx10_1_".$nid.".png");
		if($restitution['type'] == 'synth'){
			$restitution['graph_7_vs_8_chart']->Render("gfx7-8_1_".$nid.".png");
			$restitution['graph_9_vs_10_chart']->Render("gfx9-10_1_".$nid.".png");
		}
		$restitution['graph_11_chart']->Render("gfx11_1_".$nid.".png");
		$restitution['graph_12_chart']->Render("gfx12_1_".$nid.".png");
		$restitution['graph_13_chart']->Render("gfx13_1_".$nid.".png");
		$restitution['graph_14_chart']->Render("gfx14_1_".$nid.".png");
		$restitution['graph_15_chart']->Render("gfx15_1_".$nid.".png");
		$restitution['graph_16_chart']->Render("gfx16_1_".$nid.".png");
		$restitution['graph_17_chart']->Render("gfx17_1_".$nid.".png");
		$restitution['graph_18_chart']->Render("gfx18_1_".$nid.".png");
		$restitution['graph_19_chart']->Render("gfx19_1_".$nid.".png");
		$restitution['graph_20_chart']->Render("gfx20_1_".$nid.".png");
		$restitution['graph_21_chart']->Render("gfx21_1_".$nid.".png");
		$restitution['graph_22_chart']->Render("gfx22_1_".$nid.".png");
		$restitution['graph_23_chart']->Render("gfx23_1_".$nid.".png");
		$restitution['graph_24_chart']->Render("gfx24_1_".$nid.".png");
		$restitution['graph_25_chart']->Render("gfx25_1_".$nid.".png");
		$restitution['graph_26_chart']->Render("gfx26_1_".$nid.".png");
		$restitution['graph_27_chart']->Render("gfx27_1_".$nid.".png");
		$restitution['graph_28_chart']->Render("gfx28_1_".$nid.".png");
		$restitution['graph_29_chart']->Render("gfx29_1_".$nid.".png");
		$restitution['graph_30_chart']->Render("gfx30_1_".$nid.".png");
		$restitution['graph_31_chart']->Render("gfx31_1_".$nid.".png");
		$restitution['graph_32_chart']->Render("gfx32_1_".$nid.".png");

		$data = array();
		$data[] = array(
			'date_start' => date('d/m/Y', $restitution['dt_start']),
			'date_end' =>  date('d/m/Y', $restitution['dt_end']),
			'number' => $nid,
			'autre_7_1' => '',
			'autre_7_2' => '',
			'autre_7_3' => '',
			'autre_7_4' => '',
			'autre_7_5' => '',
			'autre_7_6' => '',
			'autre_7_7' => '',
			'autre_7_8' => '',
			'autre_7_9' => '',
			'autre_7_10' => '',
			'autre_7_11' => '',
			'autre_7_12' => '',
			'autre_7_13' => '',
			'autre_7_14' => '',
			'autre_7_15' => '',
			'autre_7_16' => '',
			'autre_7_17' => '',
			'autre_7_18' => '',
			'autre_7_19' => '',
			'autre_7_20' => '',
			'autre_7_21' => '',
			'autre_7_22' => '',
			'autre_7_23' => '',
			'autre_7_24' => '',
			'autre_7_25' => '',
			'autre_7_26' => '',
			'autre_7_27' => '',
			'autre_7_28' => '',
			'autre_8_1' => '',
			'autre_8_2' => '',
			'autre_8_3' => '',
			'autre_8_4' => '',
			'autre_8_5' => '',
			'autre_8_6' => '',
			'autre_8_7' => '',
			'autre_8_8' => '',
			'autre_8_9' => '',
			'autre_8_10' => '',
			'autre_8_11' => '',
			'autre_8_12' => '',
			'autre_8_13' => '',
			'autre_8_14' => '',
			'autre_8_15' => '',
			'autre_8_16' => '',
			'autre_8_17' => '',
			'autre_8_18' => '',
			'autre_8_19' => '',
			'autre_8_20' => '',
			'autre_8_21' => '',
			'autre_8_22' => '',
			'autre_8_23' => '',
			'autre_8_24' => '',
			'autre_8_25' => '',
			'autre_8_26' => '',
			'autre_8_27' => '',
			'autre_8_28' => '',
			'autre_11_1' => '',
			'autre_11_2' => '',
			'autre_11_3' => '',
			'autre_11_4' => '',
			'autre_11_5' => '',
			'autre_11_6' => '',
			'autre_11_7' => '',
			'autre_11_8' => '',
			'autre_11_9' => '',
			'autre_11_10' => '',
			'autre_11_11' => '',
			'autre_11_12' => '',
			'autre_11_13' => '',
			'autre_11_14' => '',
			'autre_11_15' => '',
			'autre_11_16' => '',
			'autre_11_17' => '',
			'autre_11_18' => '',
			'autre_11_19' => '',
			'autre_11_20' => '',
			'autre_11_21' => '',
			'autre_11_22' => '',
			'autre_11_23' => '',
			'autre_11_24' => '',
			'autre_11_25' => '',
			'autre_11_26' => '',
			'autre_11_27' => '',
			'autre_11_28' => '',
			'autre_24_1' => '',
			'autre_24_2' => '',
			'autre_24_3' => '',
			'autre_24_4' => '',
			'autre_24_5' => '',
			'autre_24_6' => '',
			'autre_24_7' => '',
			'autre_24_8' => '',
			'autre_24_9' => '',
			'autre_24_10' => '',
			'autre_24_11' => '',
			'autre_24_12' => '',
			'autre_24_13' => '',
			'autre_24_14' => '',
			'autre_24_15' => '',
			'autre_24_16' => '',
			'autre_24_17' => '',
			'autre_24_18' => '',
			'autre_24_19' => '',
			'autre_24_20' => '',
			'autre_24_21' => '',
			'autre_24_22' => '',
			'autre_24_23' => '',
			'autre_24_24' => '',
			'autre_24_25' => '',
			'autre_24_26' => '',
			'autre_24_27' => '',
			'autre_24_28' => '',	
			'autre_32_1' => '',
			'autre_32_2' => '',
			'autre_32_3' => '',
			'autre_32_4' => '',
			'autre_32_5' => '',
			'autre_32_6' => '',
			'autre_32_7' => '',
			'autre_32_8' => '',
			'autre_32_9' => '',
			'autre_32_10' => '',
			'autre_32_11' => '',
			'autre_32_12' => '',
			'autre_32_13' => '',
			'autre_32_14' => '',
			'autre_32_15' => '',
			'autre_32_16' => '',
			'autre_32_17' => '',
			'autre_32_18' => '',
			'autre_32_19' => '',
			'autre_32_20' => '',
			'autre_32_21' => '',
			'autre_32_22' => '',
			'autre_32_23' => '',
			'autre_32_24' => '',
			'autre_32_25' => '',
			'autre_32_26' => '',
			'autre_32_27' => '',
			'autre_32_28' => ''
		);	

		$pages = array();
		
		for($i = 1; $i < 29; $i++){

			if(isset($restitution['graph_7_autre'][$i - 1])){
				$data[0]['autre_7_'.$i] = $restitution['graph_7_autre'][$i - 1]; 
				//$data[0]['autre_7_'.$i] = 'graph_7_autre_'.($i - 1); 
			}

			if(isset($restitution['graph_8_autre'][$i])){
				$data[0]['autre_8_'.$i] = $restitution['graph_8_autre'][$i - 1]; 
				//$data[0]['autre_8_'.$i] = 'graph_8_autre_'.($i - 1); 				
			}

			if(isset($restitution['graph_11_autre'][$i])){
				$data[0]['autre_11_'.$i] = $restitution['graph_11_autre'][$i - 1]; 
				//$data[0]['autre_11_'.$i] = 'graph_11_autre_'.($i - 1); 				
			}

			if(isset($restitution['graph_24_autre'][$i])){
				$data[0]['autre_24_'.$i] = $restitution['graph_24_autre'][$i - 1]; 
				//$data[0]['autre_24_'.$i] = 'graph_24_autre_'.($i - 1); 				
			}

			if(isset($restitution['graph_32_autre'][$i])){
				$data[0]['autre_32_'.$i] = $restitution['graph_32_autre'][$i - 1]; 
				//$data[0]['autre_32_'.$i] = 'graph_32_autre_'.($i - 1); 				
			}
			
		}
			
		if($format == "odp"){
			$TBS = null;
			$template = null;			
			
			require_once(INC."/tbs/tbs_class.php");
			require_once(INC."/tbs/opentbs/tbs_plugin_opentbs.php");
			
			// Initialize the TBS instance
			$TBS = new clsTinyButStrong;
			$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
			
			// Chargement du template ODP
			$template = ROOT.'/_files/restitution/resultats_'.$restitution['type'].'.odp';
			$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

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
			$template = ROOT.'/_files/restitution/resultats_'.$restitution['type'].'.pdf';
			
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

				if($i == 3){
					pdfImageAdapter("gfx1_1_".$nid.".png");
					pdfImageAdapter("gfx1_2_".$nid.".png");
					
					$pdf->Image("gfx1_1_".$nid.".png", 40, 50);
					$pdf->Image("gfx1_2_".$nid.".png", 157, 50);
				}
				
				if($i == 4){
					pdfImageAdapter("gfx2_1_".$nid.".png");
					pdfImageAdapter("gfx3_1_".$nid.".png");
					pdfImageAdapter("gfx4_1_".$nid.".png");
					pdfImageAdapter("gfx5_1_".$nid.".png");
					pdfImageAdapter("gfx6_1_".$nid.".png");

					$pdf->Image("gfx2_1_".$nid.".png", 35, 50);
					$pdf->Image("gfx3_1_".$nid.".png", 35, 117);
					$pdf->Image("gfx4_1_".$nid.".png", 155, 50);
					$pdf->Image("gfx5_1_".$nid.".png", 155, 96);
					$pdf->Image("gfx6_1_".$nid.".png", 155, 144);
				}

				if($i == 5){
					pdfImageAdapter("gfx7_1_".$nid.".png");
					$pdf->Image("gfx7_1_".$nid.".png",  35 , 50);
				}

				if($i > 5 && $i < 10){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_7_'.($t + (($i - 6) * 7))]));
						$y += 15;
					}					
					
				}

				if($i == 10){
					pdfImageAdapter("gfx8_1_".$nid.".png");
					$pdf->Image("gfx8_1_".$nid.".png",  35 , 50);
				}
				
				if($i > 10 && $i < 15){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_8_'.($t + (($i - 11) * 7))]));
						$y += 15;
					}					
					
				}	

				if($i == 15){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx9_1_".$nid.".png");
						$pdf->Image("gfx9_1_".$nid.".png",  35 , 50);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx7-8_1_".$nid.".png");
						$pdf->Image("gfx7-8_1_".$nid.".png",  35 , 50);
					}
				}
				
				if($i == 16){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx10_1_".$nid.".png");
						$pdf->Image("gfx10_1_".$nid.".png",  35 , 55);
					}

					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx9_1_".$nid.".png");
						$pdf->Image("gfx9_1_".$nid.".png",  35 , 47);
						pdfImageAdapter("gfx10_1_".$nid.".png");
						$pdf->Image("gfx10_1_".$nid.".png",  35 , 122);
					}
				}
				
				if($i == 17){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx11_1_".$nid.".png");
						$pdf->Image("gfx11_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx9-10_1_".$nid.".png");
						$pdf->Image("gfx9-10_1_".$nid.".png",  35 , 50);
					}					
				}
				
				if($i > 17 && $i < 22 && $restitution['type'] == 'bruts'){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_11_'.($t + (($i - 18) * 7))]));
						$y += 15;
					}					
				}
				
				if($i == 18 && $restitution['type'] == 'synth'){
					pdfImageAdapter("gfx11_1_".$nid.".png");
					$pdf->Image("gfx11_1_".$nid.".png",  35 , 50);
				}
				
				if($i > 18 && $i < 23 && $restitution['type'] == 'synth'){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_11_'.($t + (($i - 19) * 7))]));
						$y += 15;
					}
				}

				if($i == 22){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx12_1_".$nid.".png");
						$pdf->Image("gfx12_1_".$nid.".png",  35 , 55);
					}
				}
				
				if($i == 23){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx13_1_".$nid.".png");
						$pdf->Image("gfx13_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx12_1_".$nid.".png");
						$pdf->Image("gfx12_1_".$nid.".png",  35 , 45);
						pdfImageAdapter("gfx13_1_".$nid.".png");
						$pdf->Image("gfx13_1_".$nid.".png",  35 , 125);
					}					
				}

				if($i == 24){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx14_1_".$nid.".png");
						$pdf->Image("gfx14_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx14_1_".$nid.".png");
						$pdf->Image("gfx14_1_".$nid.".png",  35 , 45);
						pdfImageAdapter("gfx15_1_".$nid.".png");
						$pdf->Image("gfx15_1_".$nid.".png",  35 , 98);
						pdfImageAdapter("gfx16_1_".$nid.".png");
						$pdf->Image("gfx16_1_".$nid.".png",  35 , 145);
					}					
				}

				if($i == 25){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx15_1_".$nid.".png");
						$pdf->Image("gfx15_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx17_1_".$nid.".png");
						$pdf->Image("gfx17_1_".$nid.".png",  35 , 50);
						pdfImageAdapter("gfx18_1_".$nid.".png");
						$pdf->Image("gfx18_1_".$nid.".png",  35 , 125);
					}						
				}
				
				if($i == 26){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx16_1_".$nid.".png");
						$pdf->Image("gfx16_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx19_1_".$nid.".png");
						$pdf->Image("gfx19_1_".$nid.".png",  35 , 44);
						pdfImageAdapter("gfx20_1_".$nid.".png");
						$pdf->Image("gfx20_1_".$nid.".png",  35 , 78);
						pdfImageAdapter("gfx21_1_".$nid.".png");
						$pdf->Image("gfx21_1_".$nid.".png",  35 , 113);
					}					
				}
				
				if($i == 27){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx17_1_".$nid.".png");
						$pdf->Image("gfx17_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx22_1_".$nid.".png");
						$pdf->Image("gfx22_1_".$nid.".png",  35 , 44);
						pdfImageAdapter("gfx23_1_".$nid.".png");
						$pdf->Image("gfx23_1_".$nid.".png",  35 , 78);
						pdfImageAdapter("gfx24_1_".$nid.".png");
						$pdf->Image("gfx24_1_".$nid.".png",  35 , 120);
					}					
				}

				if($i > 27 && $i < 32 && $restitution['type'] == 'synth'){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_24_'.($t + (($i - 28) * 7))]));
						$y += 15;
					}					
				}
				
				if($i == 28){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx18_1_".$nid.".png");
						$pdf->Image("gfx18_1_".$nid.".png",  35 , 55);
					}
				}
				
				if($i == 29){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx19_1_".$nid.".png");
						$pdf->Image("gfx19_1_".$nid.".png",  35 , 55);
					}
				}
				
				if($i == 30){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx20_1_".$nid.".png");
						$pdf->Image("gfx20_1_".$nid.".png",  35 , 55);
					}
				}
				
				if($i == 31){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx21_1_".$nid.".png");
						$pdf->Image("gfx21_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 32){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx22_1_".$nid.".png");
						$pdf->Image("gfx22_1_".$nid.".png",  35 , 55);
					}
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx25_1_".$nid.".png");
						$pdf->Image("gfx25_1_".$nid.".png",  35 , 45);
						pdfImageAdapter("gfx26_1_".$nid.".png");
						$pdf->Image("gfx26_1_".$nid.".png",  35 , 115);
					}					
				}	

				if($i == 33){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx23_1_".$nid.".png");
						$pdf->Image("gfx23_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx27_1_".$nid.".png");
						$pdf->Image("gfx27_1_".$nid.".png",  35 , 44);
						pdfImageAdapter("gfx28_1_".$nid.".png");
						$pdf->Image("gfx28_1_".$nid.".png",  35 , 98);
						pdfImageAdapter("gfx29_1_".$nid.".png");
						$pdf->Image("gfx29_1_".$nid.".png",  35 , 143);
					}						
				}				
				
				if($i == 34){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx24_1_".$nid.".png");
						$pdf->Image("gfx24_1_".$nid.".png",  35 , 55);
					}
					
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx30_1_".$nid.".png");
						$pdf->Image("gfx30_1_".$nid.".png",  35 , 45);
						pdfImageAdapter("gfx31_1_".$nid.".png");
						$pdf->Image("gfx31_1_".$nid.".png",  35 , 115);
					}
				}
				
				if($i > 34 && $i < 39 && $restitution['type'] == 'bruts'){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_24_'.($t + (($i - 35) * 7))]));
						$y += 15;
					}					
				}				

				if($i == 35){
					if($restitution['type'] == 'synth'){
						pdfImageAdapter("gfx32_1_".$nid.".png");
						$pdf->Image("gfx32_1_".$nid.".png",  35 , 55);
					}
				}

				if($i > 35 && $restitution['type'] == 'synth'){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_32_'.($t + (($i - 36) * 7))]));
						$y += 15;
					}					
				}	
				
				if($i == 39){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx25_1_".$nid.".png");
						$pdf->Image("gfx25_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 40){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx26_1_".$nid.".png");
						$pdf->Image("gfx26_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 41){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx27_1_".$nid.".png");
						$pdf->Image("gfx27_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 42){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx28_1_".$nid.".png");
						$pdf->Image("gfx28_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 43){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx29_1_".$nid.".png");
						$pdf->Image("gfx29_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 44){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx30_1_".$nid.".png");
						$pdf->Image("gfx30_1_".$nid.".png",  35 , 55);
					}
				}				

				if($i == 45){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx31_1_".$nid.".png");
						$pdf->Image("gfx31_1_".$nid.".png",  35 , 55);
					}
				}				
				
				if($i == 46){
					if($restitution['type'] == 'bruts'){
						pdfImageAdapter("gfx32_1_".$nid.".png");
						$pdf->Image("gfx32_1_".$nid.".png",  35 , 55);
					}
				}
				
				if($i > 46 && $restitution['type'] == 'bruts'){
					$y = 65;
					$pdf->SetFont("Helvetica");
					$pdf->SetFontSize(10);
					$pdf->SetTextColor(128, 128, 128);
					for($t = 1; $t < 8; $t++){
						$pdf->SetXY(22, $y);
						$pdf->Write(20, utf8_decode($data[0]['autre_32_'.($t + (($i - 47) * 7))]));
						$y += 15;
					}					
				}				
			}
			
			return $pdf;
		}
	
		return false;
	}
	
	/**
		Récupère les données pour la matrice
		$cid est l'ID du cycle en cours
		$gid est l'ID du groupe CoCon
		Retourne un tableau associatif contenant les données de la matrice ou false s'il y a une erreur
	*/
	function getMatriceDatas($cid, $gid){
	
		/**
			Tableau associatif des données de la matrice
		*/
		$matrice = array(
			"cid" => $cid,
			"gid" => $gid,
			"cercles" => array(),
			"graph" => null,
			"grid" => null,
			"scenario" => -1
		);
		
		$conn = connectDb();
		
		/**
			Récupère les sessions en cours
		*/
		$sql = 'select * from SESSION WHERE CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and ACTIVE=1';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		$ecoval = 0;
		$usagval = 0;
		while($row = mysql_fetch_assoc($result)){
			
			$session = prepareSessionArray($row['SESSION_ID'], $row['CYCLE_ID'], $row['GROUP_ID'], $row['USER_ID']);
			if(!$session){
				return false;
			}
			
			$session = loadSession($session);
			if(!$session){
				return false;
			}
			//var_dump($session);
			//die();
		
			$size = 0;
			
			if($session['quest_18']['l1'] == 1 && $session['quest_18']['l2'] == 1){
				$size = 2;
			}
		
			if($session['quest_18']['l1'] == 2 && $session['quest_18']['l2'] == 1){
				$size = 1;
			}

			$v = array(
				"legend" => $session['quest_1']['prenom']." ".$session['quest_1']['nom'],
				"type" => $session['quest_2'],
				"usag" => $session['usag_sum'],
				"eco" => $session['eco_sum'],
				"profil" => $session['profil_rec'],
				"size" => $size
			);
			
			$ecoval += $session['eco_sum'];
			$usagval += $session['usag_sum'];
			
			array_push($matrice['cercles'], $v);
		}

		$ecoval = $ecoval / count($matrice['cercles']);
		$usagval = $usagval / count($matrice['cercles']);
		
		if($ecoval < 5 && $usagval < 5){
			$matrice['scenario'] = 1;
		}
		
		if($ecoval < 5 && $usagval > 4.9){
			$matrice['scenario'] = 2;
		}

		if($ecoval > 4.9 && $usagval < 5){
			$matrice['scenario'] = 3;
		}

		if($ecoval > 4.9 && $usagval > 4.9){
			$matrice['scenario'] = 4;
		}

		$chart = createMatriceChart($matrice, array(
			'width' => 937,
			'height' => 514
		));
		
		if(!$chart){
			return false;
		}
		$matrice['graph'] = $chart;

		$chart = createTableauMatriceChart($matrice, array(
			'width' => 937,
			'height' => 514
		));
		
		if(!$chart){
			return false;
		}
		$matrice['grid'] = $chart;

		return $matrice;
	}	
	
	/**
		Génère le document à partir des données de la matrice
		- $format est une chaine qui doit être "odp" ou "pdf"
		- $matrice est le tableau de valeurs créé à partir de la fonction "getMatriceDatas"
		Retourne soit l'objet TBS, soit l'objet PDF soit false s'il y a une erreur
	*/
	function createMatriceDocument($format, $matrice){
		// ID unique pour le document
		$nid = $matrice['gid'];
			
		// Enregistre les images des graphiques
		$matrice['graph']->Render("matrice_".$nid.".png");	
		$matrice['grid']->Render("grid_".$nid.".png");
			
		if($format == "odp"){
			$TBS = null;
			$template = null;			
			
			require_once(INC."/tbs/tbs_class.php");
			require_once(INC."/tbs/opentbs/tbs_plugin_opentbs.php");
			
			// Initialize the TBS instance
			$TBS = new clsTinyButStrong;
			$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
			
			// Chargement du template ODP
			$template = ROOT.'/_files/restitution/matrice.odp';
			$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).
			
			$data = array();
			$data[] = array(
				'number' => $nid
			);
			
			// Insert les données dans le template
			$TBS->MergeBlock('b', $data);

			if($matrice['scenario'] == 1){
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 5);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 6);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 7);
			}

			if($matrice['scenario'] == 2){
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 4);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 6);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 7);
			}

			if($matrice['scenario'] == 3){
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 4);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 5);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 7);
			}

			if($matrice['scenario'] == 4){
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 4);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 5);
				$TBS->PlugIn(OPENTBS_DELETE_SLIDES, 6);
			}

			return $TBS;			
		}

		if($format == 'pdf'){
			$pdf = null;
			$template = null;
			
			include_once('../../pdf/fpdf.php');
			include_once('../../pdf/fpdi/fpdi.php');
			
			// Chargement du template ODP
			$template = ROOT.'/_files/restitution/matrice.pdf';
			
			$pdf = new FPDI();
			$pages = $pdf->setSourceFile($template);
			for($i = 1; $i < ($pages + 1); $i++){
				$pgId = $pdf->importPage($i); 
				$size = $pdf->getTemplateSize($pgId);

				if($i < 4 || $matrice['scenario'] == $i - 3){
					if ($size['w'] > $size['h']) {
						$pdf->AddPage('L', array($size['w'], $size['h']));
					} else {
						$pdf->AddPage('P', array($size['w'], $size['h']));
					}			
					
					$pdf->useTemplate($pgId,0,0, 297,210);
				}
				
				if($i == 2){
					$pdf->Image("matrice_".$nid.".png", 9 , 23, 278, 146);
				}
				
				if($i == 3){
					$pdf->Image("grid_".$nid.".png", 9 , 23, 278, 146);
				}

			}
			
			return $pdf;
		}
		
		return false;
	}

?>