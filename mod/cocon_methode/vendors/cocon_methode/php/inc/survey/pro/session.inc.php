<?php

/**
	ENSEMBLE DES FONCTIONS PHP POUR LE QUESTIONNAIRE ENSEIGNANTS
*/

	/**
		Prépare un tableau associatif vide à partir des infos de session, cycle, groupe et membre
		$sid est l'ID de la session
		$cid est l'ID du cycle
		$gid est l'ID du groupe CoCon
		$uid est l'ID de l'enseignant
		Retourne  le tableau
	*/
	function prepareSessionArray($sid, $cid, $gid, $uid){
		$survey = array(
			"error" => false,
			"error_string" => "",
			"session_id" => $sid,
			"cycle_id" => $cid,
			"user_id" => $uid,
			"group_id" => $gid,
			"profil_rec" => 0,
			"etat" => 0,
			"active" => 1,
			"val_pt" => 0.0,
			"eco_1" => 0.0,
			"eco_2" => 0.0,
			"eco_3" => 0.0,
			"eco_4" => 0.0,
			"eco_sum" => 0.0,
			"usag_1" => 0.0,
			"usag_2" => 0.0,
			"usag_3" => 0.0,
			"usag_4" => 0.0,
			"usag_sum" => 0.0,
			"profil_theo" => 0,
			"comment_1" => "",
			"comment_2" => "",
			"quest_1" => array(
				"nom" => "",
				"prenom" => ""
			),
			"quest_2" => 0,
			"quest_3" => array(
				"matiere_1" => "-1",
				"matiere_2" => "-1",
				"matiere_3" => "-1",
				"matiere_4" => "-1"
			),
			"quest_4" => array(
				"niveau_1" => "-1",
				"niveau_2" => "-1",
				"niveau_3" => "-1",
				"niveau_4" => "-1"
			),
			"quest_5" => 0,
			"quest_6" => 0,
			"quest_7" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0,
				"l6" => 0,
				"l7" => 0,
				"l8" => 0,
				"l9" => 0,
				"l10" => 0,
				"l11" => 0,
				"autre" => ""
			),
			"quest_8" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0,
				"l6" => 0,
				"l7" => 0,
				"l8" => 0,
				"l9" => 0,
				"l10" => 0,
				"l11" => 0,
				"autre" => ""
			),
			"quest_9" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0
			),
			"quest_10" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0
			),
			"quest_11" => array(
				"l1" => 0,
				"l2" => 0,
				"autre" => ""
			),
			"quest_12" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0
			),	
			"quest_13" => array(
				"l1" => 0
			),
			"quest_14" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0
			),
			"quest_15" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_16" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_17" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0
			),
			"quest_18" => array(
				"l1" => 0,
				"l2" => 0
			),	
			"quest_19" => array(
				"l1" => 0,
				"l2" => 0
			),	
			"quest_20" => array(
				"l1" => 0,
				"l2" => 0
			),	
			"quest_21" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0
			),
			"quest_22" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_23" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0
			),
			"quest_24" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0,
				"l6" => 0,
				"l7" => 0,
				"autre" => ""
			),
			"quest_25" => array(
				"l1" => 0,
				"autre" => ""
			),
			"quest_26" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_27" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0
			),
			"quest_28" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0
			),
			"quest_29" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0
			),
			"quest_30" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0
			),
			"quest_31" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_32" => array(
				"l1" => 0,
				"l2" => 0,
				"l3" => 0,
				"l4" => 0,
				"l5" => 0,
				"l6" => 0,
				"l7" => 0,
				"l8" => 0,
				"l9" => 0,
				"l10" => 0,
				"l11" => 0,
				"l12" => 0,
				"autre" => ""
			)
		);
		return $survey;
	}
	
	/**
		Retourne l'ID de la session de réponse en cours d'un enseignant
		$cid est l'ID du cycle en cours
		$gid est l'ID du groupe CoCon associé
		$uid  est l'ID de l'enseignant
		
		Si aucune session n'est trouvée, retourne false;
	*/
	function getSessionID($cid, $gid, $uid){
		
		$conn = connectDB();
		$sql = 'select * from SESSION where CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and USER_ID="'.securiseSQLString($conn, $uid).'" and ACTIVE=1';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		$sid = '';
		while($row = mysql_fetch_assoc($result)){
			$sid = $row['SESSION_ID'];
		}
		
		if($sid != ''){
			return $sid;
		}else{
			return false;
		}
	}

	/**
		Création d'une nouvelle session et retourne l'ID de session associée
		$cid est l'ID du cycle en cours pour le groupe CoCon
		$gid est l'ID du groupe CoCon
		$uid est l'ID du l'enseignant
	*/
	function createSession($cid, $gid, $uid){
	
		$conn = connectDB();
		$sid = getUniqueID();
		$sql = 'insert into SESSION(
			SESSION_ID,
			CYCLE_ID,
			GROUP_ID,
			USER_ID,
			DT_START,
			ETAT,
			ACTIVE) values(
			"'.securiseSQLString($conn, $sid).'",
			"'.securiseSQLString($conn, $cid).'",
			"'.securiseSQLString($conn, $gid).'",
			"'.securiseSQLString($conn, $uid).'",
			"'.securiseSQLString($conn, microtime(true)).'",
			"0","1")
		';
		
		$result = executeQuery($conn, $sql);
		
		if(!$result){
			return false;
		}else{
			return $sid;
		}
	
	}
	
	/**
		Retourne l'état de la session de réponse ou la chaine "false" si il y a eu une erreur
	*/
	function getSessionState($sid){
		$conn = connectDB();
		$sql = 'select SESSION_ID, ETAT FROM SESSION where SESSION_ID="'.securiseSQLString($conn, $sid).'"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return "false";
		}
		
		while($row = mysql_fetch_assoc($result)){
			$etat = $row['ETAT'];
		}
		
		return $etat;
	}
	
	
	/**
		Retourne un tableau associatif contenant les données de la session demandée
		$sid est l'ID de la session à charger
		retourn false s'il y a une erreur lors du chargement
	*/
	function loadSession($survey){
		if(!isset($survey['session_id']) || $survey['session_id'] == ''){
			return false;
		}
		
		$conn = connectDB();
		
		// récupère les données d'entête de session
		$sql = 'select S.* from SESSION as S
			where S.SESSION_ID="'.securiseSQLString($conn, $survey['session_id']).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		while($row = mysql_fetch_assoc($result)){
			$survey['etat'] = $row['ETAT'];
			$survey['active'] = $row['ACTIVE'];
			$survey['quest_1']['nom'] = $row['NOM'];
			$survey['quest_1']['prenom'] = $row['PRENOM'];
			$survey['quest_2'] = $row['STATUS'];
			$survey['quest_5'] = $row['ANNEES_ENS'];
			$survey['quest_6'] = $row['ANCIEN'];
			$survey['profil_rec'] = $row['PROFIL_REC'];
		}
	
		// récupère les matières et niveau associés à la session
		$sql = 'select SM.* from SESSION_MATIERE as SM
			where SM.SESSION_ID="'.securiseSQLString($conn, $survey['session_id']).'" order by SM.MATIERE_POS asc';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		$n = 1;
		while($row = mysql_fetch_assoc($result)){
			$survey['quest_3']['matiere_'.$n]= $row['MATIERE_ID'];
			$survey['quest_4']['niveau_'.$n] = $row['NIVEAU_ID'];
			$n++;
		}
		
		// récupère le profil théorique calculé et les commentaires associés à la session
		$sql = 'select SC.* from SESSION_CALCUL as SC
			where SC.SESSION_ID="'.securiseSQLString($conn, $survey['session_id']).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		while($row = mysql_fetch_assoc($result)){
			$survey['val_pt'] = $row['VAL_PT'];
			$survey['eco_1'] = $row['ECO_1'];
			$survey['eco_2'] = $row['ECO_2'];
			$survey['eco_3'] = $row['ECO_3'];
			$survey['eco_4'] = $row['ECO_4'];
			$survey['eco_sum'] = $row['ECO_SUM'];
			$survey['usag_1'] = $row['USAG_1'];
			$survey['usag_2'] = $row['USAG_2'];
			$survey['usag_3'] = $row['USAG_3'];
			$survey['usag_4'] = $row['USAG_4'];
			$survey['usag_sum'] = $row['USAG_SUM'];
			$survey['profil_theo'] = $row['PROFIL_THEO'];
			$survey['comment_1'] = $row['COMMENT_1'];
			$survey['comment_2'] = $row['COMMENT_2'];
		}

		// récupère les réponses associées à la session
		$sql = 'select R.* from REPONSE as R
			where R.SESSION_ID="'.securiseSQLString($conn, $survey['session_id']).'" order by R.REP_POS asc';
	
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		$n = 1;
		while($row = mysql_fetch_assoc($result)){
			$rep_id = $row['REP_ID'];
			$ids = explode("_", $rep_id);
			
			if(count($ids) == 2){
				$survey[$ids[0].'_'.$ids[1]] = $row['REP_DATA'];
			}
			
			if(count($ids) == 3){
				if($ids[2] == 'autre'){
					$survey[$ids[0].'_'.$ids[1]][$ids[2]] = $row['COMMENT'];
				}else{
					$survey[$ids[0].'_'.$ids[1]][$ids[2]] = $row['REP_DATA'];
				}
			}
		}

		return $survey;
	}
	
	/**
		Retourne true si la session est vérrouillée, sinon false.
		$sid  est l'ID de la session à tester
	*/
	function sessionLocked($sid){
		$conn = connectDB();
		
		// récupère les données d'entête de session
		$sql = 'select S.* from SESSION as S
			where S.SESSION_ID="'.securiseSQLString($conn, $sid).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		$locked = false;
		while($row = mysql_fetch_assoc($result)){
			if($row['ETAT'] == 2){
				$locked = true;
			}
		}
		return $locked;
	}
	
	/**
		Mise à jour des entêtes de session (Nom, prénom....)
		$survey est un objet JSON
		return true si l'opération a réussie, sinon false
	*/
	function updateEntetesSession($survey){
		
		$conn = connectDB();
		$sql = 'update SESSION set 
			NOM="'.securiseSQLString($conn, $survey->quest_1->nom).'",
			PRENOM="'.securiseSQLString($conn, $survey->quest_1->prenom).'",
			STATUS="'.securiseSQLString($conn, $survey->quest_2).'",
			ANNEES_ENS="'.securiseSQLString($conn, $survey->quest_5).'",
			ANCIEN="'.securiseSQLString($conn, $survey->quest_6).'",
			ETAT="'.securiseSQLString($conn, $survey->etat).'",
			PROFIL_REC="'.securiseSQLString($conn, $survey->profil_rec).'"
			where SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'"';
			
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		return true;

	}
	
	/**
		Mise à jour des matières de session
		$survey est un objet JSON
		return true si l'opération a réussie, sinon false
	*/
	function updateMatieresSession($survey){
		
		$conn = connectDB();
			
		// Nettoie les anciennes matières
		$sql = 'delete from SESSION_MATIERE where SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		// Matière 1
		if($survey->quest_3->matiere_1 != -1){
			$sql = 'insert into SESSION_MATIERE (
				SESSION_ID,
				MATIERE_POS,
				MATIERE_ID,
				NIVEAU_ID
			)values(
				"'.securiseSQLString($conn, $survey->session_id).'",
				"'.securiseSQLString($conn, 1).'",
				"'.securiseSQLString($conn, $survey->quest_3->matiere_1).'",
				"'.securiseSQLString($conn, $survey->quest_4->niveau_1).'"
			)';

			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
		}

		// Matière 2
		if($survey->quest_3->matiere_2 != -1){
			$sql = 'insert into SESSION_MATIERE (
				SESSION_ID,
				MATIERE_POS,
				MATIERE_ID,
				NIVEAU_ID
			)values(
				"'.securiseSQLString($conn, $survey->session_id).'",
				"'.securiseSQLString($conn, 2).'",
				"'.securiseSQLString($conn, $survey->quest_3->matiere_2).'",
				"'.securiseSQLString($conn, $survey->quest_4->niveau_2).'"
			)';

			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
		}

		// Matière 3
		if($survey->quest_3->matiere_3 != -1){
			$sql = 'insert into SESSION_MATIERE (
				SESSION_ID,
				MATIERE_POS,
				MATIERE_ID,
				NIVEAU_ID
			)values(
				"'.securiseSQLString($conn, $survey->session_id).'",
				"'.securiseSQLString($conn, 3).'",
				"'.securiseSQLString($conn, $survey->quest_3->matiere_3).'",
				"'.securiseSQLString($conn, $survey->quest_4->niveau_3).'"
			)';

			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
		}

		// Matière 4
		if($survey->quest_3->matiere_4 != -1){
			$sql = 'insert into SESSION_MATIERE (
				SESSION_ID,
				MATIERE_POS,
				MATIERE_ID,
				NIVEAU_ID
			)values(
				"'.securiseSQLString($conn, $survey->session_id).'",
				"'.securiseSQLString($conn, 4).'",
				"'.securiseSQLString($conn, $surver->quest_3->matiere_4).'",
				"'.securiseSQLString($conn, $surver->quest_4->niveau_4).'"
			)';

			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
		}
		
		return true;
	}
	
	/**
		Mise à jour le profile théorique calculé et les commentaires de session
		$survey est un objet JSON
		return true si l'opération a réussie, sinon false
	*/
	function updateResultatsSession($survey){	
		
		$conn = connectDB();
		
		// Supprime l'ancien enregistrement
		$sql = 'delete from SESSION_CALCUL where SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		// Enregsitrement
		$sql = 'insert into SESSION_CALCUL(
		SESSION_ID,
		VAL_PT,
		ECO_1,
		ECO_2,
		ECO_3,
		ECO_4,
		ECO_SUM,
		USAG_1,
		USAG_2,
		USAG_3,
		USAG_4,
		USAG_SUM,
		PROFIL_THEO,
		COMMENT_1,
		COMMENT_2)values(
		"'.securiseSQLString($conn, $survey->session_id).'",
		"'.securiseSQLString($conn, $survey->val_pt).'",
		"'.securiseSQLString($conn, $survey->eco_1).'",
		"'.securiseSQLString($conn, $survey->eco_2).'",
		"'.securiseSQLString($conn, $survey->eco_3).'",
		"'.securiseSQLString($conn, $survey->eco_4).'",
		"'.securiseSQLString($conn, $survey->eco_sum).'",
		"'.securiseSQLString($conn, $survey->usag_1).'",
		"'.securiseSQLString($conn, $survey->usag_2).'",
		"'.securiseSQLString($conn, $survey->usag_3).'",
		"'.securiseSQLString($conn, $survey->usag_4).'",
		"'.securiseSQLString($conn, $survey->usag_sum).'",
		"'.securiseSQLString($conn, $survey->profil_theo).'",
		"'.securiseSQLString($conn, $survey->comment_1).'",
		"'.securiseSQLString($conn, $survey->comment_2).'"
		)';
		
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		return true;
	}
	
	/**
		Mise à jour des réponses à la session
		$survey est un objet JSON
		return true si l'opération a réussie, sinon false
	*/
	function updateReponsesSession($survey){
		$conn = connectDB();
		
		$arr = json_decode(json_encode($survey), true);

		$ids = array(
			// Question 7
			'quest_7_l1',
			'quest_7_l2',
			'quest_7_l3',
			'quest_7_l4',
			'quest_7_l5',
			'quest_7_l6',
			'quest_7_l7',
			'quest_7_l8',
			'quest_7_l9',
			'quest_7_l10',
			'quest_7_l11',
			'quest_7_autre',
			// Question 8
			'quest_8_l1',
			'quest_8_l2',
			'quest_8_l3',
			'quest_8_l4',
			'quest_8_l5',
			'quest_8_l6',
			'quest_8_l7',
			'quest_8_l8',
			'quest_8_l9',
			'quest_8_l10',
			'quest_8_l11',
			'quest_8_autre',
			// Question 9
			'quest_9_l1',
			'quest_9_l2',
			'quest_9_l3',
			'quest_9_l4',
			//Question 10
			'quest_10_l1',
			'quest_10_l2',
			'quest_10_l3',
			'quest_10_l4',
			//Question11
			'quest_11_l1',
			'quest_11_l2',
			'quest_11_autre',
			//Question 12
			'quest_12_l1',
			'quest_12_l2',
			'quest_12_l3',
			'quest_12_l4',
			//Question 13
			'quest_13_l1',
			//Question 14
			'quest_14_l1',
			'quest_14_l2',
			'quest_14_l3',
			// Question 15
			'quest_15_l1',
			'quest_15_l2',
			//Question 16
			'quest_16_l1',
			'quest_16_l2',
			//Question 17
			'quest_17_l1',
			'quest_17_l2',
			'quest_17_l3',
			'quest_17_l4',
			'quest_17_l5',
			//Question 18
			'quest_18_l1',
			'quest_18_l2',
			//Question 19
			'quest_19_l1',
			'quest_19_l2',
			//Question 20
			'quest_20_l1',
			'quest_20_l2',
			//Question 21
			'quest_21_l1',
			'quest_21_l2',
			'quest_21_l3',
			'quest_21_l4',
			'quest_21_l5',
			'quest_21_l6',
			//Question 22
			'quest_22_l1',
			'quest_22_l2',
			//Question 23
			'quest_23_l1',
			'quest_23_l2',
			'quest_23_l3',
			'quest_23_l4',
			//Question 24
			'quest_24_l1',
			'quest_24_l2',
			'quest_24_l3',
			'quest_24_l4',
			'quest_24_l5',
			'quest_24_l6',
			'quest_24_l7',
			'quest_24_autre',
			//Question 25
			'quest_25_l1',
			'quest_25_autre',
			//Question 26
			'quest_26_l1',
			'quest_26_l2',
			//Question 27
			'quest_27_l1',
			'quest_27_l2',
			'quest_27_l3',
			'quest_27_l4',
			'quest_27_l5',
			//Question 28
			'quest_28_l1',
			'quest_28_l2',
			'quest_28_l3',
			//Question 29
			'quest_29_l1',
			'quest_29_l2',
			'quest_29_l3',
			//Question 30
			'quest_30_l1',
			'quest_30_l2',
			'quest_30_l3',
			//Question 31
			'quest_31_l1',
			'quest_31_l2',
			//Question 32
			'quest_32_l1',
			'quest_32_l2',
			'quest_32_l3',
			'quest_32_l4',
			'quest_32_l5',
			'quest_32_l6',
			'quest_32_l7',
			'quest_32_l8',
			'quest_32_l9',
			'quest_32_l10',
			'quest_32_l11',
			'quest_32_l12',
			'quest_32_autre'
		);

		for($i = 0; $i < count($ids); $i++){
			
			$keys = explode("_", $ids[$i]);
			$value = '';
			$is_comment = false;
			$is_exists = true;
			
			if(count($keys) < 3){
				if(isset($arr[$keys[0].'_'.$keys[1]])){
					$value = $arr[$keys[0].'_'.$keys[1]];
				}else{
					$is_exists = false;
				}
			}else{
				if(isset($arr[$keys[0].'_'.$keys[1]][$keys[2]])){
					$value = $arr[$keys[0].'_'.$keys[1]][$keys[2]];
					if($keys[2] == 'autre'){
						$is_comment = true;
					}
				}else{
					$is_exists = false;
				}
			}
			// Supprime la question existante
			$sql = 'delete from REPONSE where SESSION_ID="'.securiseSQLString($conn, $arr['session_id']).'" and REP_ID="'.securiseSQLString($conn, $ids[$i]).'"';
			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
			
			if(!$is_comment){
				$sql = 'insert into REPONSE (
					SESSION_ID,
					REP_ID,
					REP_DATA,
					REP_POS
				)values(
				"'.securiseSQLString($conn, $arr['session_id']).'",
				"'.securiseSQLString($conn, $ids[$i]).'",
				"'.securiseSQLString($conn, $value).'",
				"'.securiseSQLString($conn, $i).'"
				)';
			}else{
				$sql = 'insert into REPONSE (
					SESSION_ID,
					REP_ID,
					COMMENT,
					REP_POS
				)values(
				"'.securiseSQLString($conn, $arr['session_id']).'",
				"'.securiseSQLString($conn, $ids[$i]).'",
				"'.securiseSQLString($conn, $value).'",
				"'.securiseSQLString($conn, $i).'"
				)';
			}

			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}			
		}
		
		return true;

	}	
	
	/**
		Création d'une session depuis un fichier CSV
		Le fichier CSV doit être crée à partir des colonnes C-D-E-F du fichier de questionnaire Excel transmis par Olivier
		$cid  est l'ID du cycle en cours
		$gid est l'ID du groupe CoCon associé
		
		Retourne l'objet JSON contenant les données de la session, sinon false si il y a une erreur
	*/
	function createSessionFromCSV($cid, $gid, $csv){
		
		$status = array(
			"" => 0,
			"Titulaire" => 1,
			"TZR" => 2,
			"Contractuel" => 3,
			"Stagiaire" => 4,
			"Autre" =>5
		);
		
		$matiere = array(
			"" => -1,
			"Documentaliste" => 0,
			"Education artistique & musicale" => 1,
			"EPS" => 2,
			"Histoire-Géographique" => 3,
			"Langues mortes/anciennes" => 4,
			"Langues vivantes" => 5,
			"Lettres" => 6,
			"Mathématiques" => 7,
			"Physique-Chimie" => 8,
			"SVT" => 9,
			"Technologie" => 10,
			"Autre" => 11
		);

		$niveau = array(
			"" => -1,
			"6ème" => 0,
			"5ème" => 1,
			"4ème" => 2,
			"3ème" => 3
		);

		$rep_data = array(
			";;;" => 0,
			"1;;;" => 1,
			";1;;" => 2,
			";;1;" => 3,
			";;;1" => 4
		);
		
		$sid = getUniqueID();
		$uid = getUniqueID();
		
		$survey = prepareSessionArray($sid, $cid, $gid, $uid);
		if(!$survey){
			return false;
		}
		
		$buffer = file_get_contents($csv);
		$buffer = str_replace("Saisir 1", "", $buffer);
		$lines = explode("\r\n", $buffer);
		$n = 0;
		$q = 7;
		$l = 1;
		
		while($n < count($lines)){
			$data = explode(";", $lines[$n]);
			
			if($n == 4){
				$survey["quest_1"]["nom"] = $data[0];
				$survey["quest_1"]["prenom"] = $data[3];
			}
			
			if($n == 6){
				$survey["quest_2"] = $status[$data[0]];
			}

			if($n == 9){
				$survey["quest_3"]["matiere_1"] = $matiere[$data[0]];
				$survey["quest_3"]["matiere_2"] = $matiere[$data[1]];
				$survey["quest_3"]["matiere_3"] = $matiere[$data[2]];
				$survey["quest_3"]["matiere_4"] = $matiere[$data[3]];
			}

			if($n == 12){
				$survey["quest_4"]["niveau_1"] = $niveau[$data[0]];
				$survey["quest_4"]["niveau_2"] = $niveau[$data[1]];
				$survey["quest_4"]["niveau_3"] = $niveau[$data[2]];
				$survey["quest_4"]["niveau_4"] = $niveau[$data[3]];
			}

			if($n == 14){
				$survey["quest_5"] = $data[0];
			}

			if($n == 16){
				$survey["quest_6"] = $data[0];
			}

			if($n > 20){
				
				if(isset($rep_data[$lines[$n]])){
					if(isset($survey["quest_".$q])){
						if(isset($survey["quest_".$q]["l".$l])){
							$survey["quest_".$q]["l".$l] = $rep_data[$lines[$n]];
							$l++;
						}
					}
				}else{
					$q++;
					$l = 1;
				}
				
			}
			
			$n++;
		}
		return $survey;
	}
?>
