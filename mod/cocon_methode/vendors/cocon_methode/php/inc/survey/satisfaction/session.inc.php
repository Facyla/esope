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
			"profil_theo" => 0,
			"etat" => 0,
			"active" => 1,
			"quest_1" => array(
				"l1" => 0
			),
			"quest_2" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_3" => array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_4" => array(
				"l1" => 0
			),
			"quest_5" =>  array(
				"l1" => 0,
				"l2" => 0
			),
			"quest_6" =>  array(
				"l1" => 0
			),
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
		$sql = 'select * from SESSION_SAT where CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and USER_ID="'.securiseSQLString($conn, $uid).'" and ACTIVE=1';
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
		
		// Récupère le profil théorique calculé à partir des réponses du questionnaire enseignant
		$profil_theo = 0;
		$sql = 'select S.*, SC.* from SESSION as S join SESSION_CALCUL as SC on SC.SESSION_ID=S.SESSION_ID WHERE CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and USER_ID="'.securiseSQLString($conn, $uid).'"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$profil_theo = $row['PROFIL_THEO'];
		}
		
		$sid = getUniqueID();
		$sql = 'insert into SESSION_SAT(
			SESSION_ID,
			CYCLE_ID,
			GROUP_ID,
			USER_ID,
			PROFIL_THEO,
			DT_START,
			ETAT,
			ACTIVE) values(
			"'.securiseSQLString($conn, $sid).'",
			"'.securiseSQLString($conn, $cid).'",
			"'.securiseSQLString($conn, $gid).'",
			"'.securiseSQLString($conn, $uid).'",
			"'.securiseSQLString($conn, $profil_theo).'",
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
		$sql = 'select S.* from SESSION_SAT as S
			where S.SESSION_ID="'.securiseSQLString($conn, $survey['session_id']).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		while($row = mysql_fetch_assoc($result)){
			$survey['etat'] = $row['ETAT'];
			$survey['active'] = $row['ACTIVE'];
			$survey['profil_theo'] = $row['PROFIL_THEO'];
		}

		// récupère les réponses associées à la session
		$sql = 'select R.* from REPONSE_SAT as R
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
		$sql = 'select S.* from SESSION_SAT as S
			where S.SESSION_ID="'.securiseSQLString($conn, $sid).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		$locked = false;
		while($row = mysql_fetch_assoc($result)){
			if($row['ETAT'] != 0){
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
		$sql = 'update SESSION_SAT set 
			ETAT="'.securiseSQLString($conn, $survey->etat).'" 
			where SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'"';

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
			// Question 1 à 6
			'quest_1_l1',
			'quest_2_l1',
			'quest_2_l2',
			'quest_3_l1',
			'quest_3_l2',
			'quest_4_l1',
			'quest_5_l1',
			'quest_5_l2',
			'quest_6_l1'
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
			$sql = 'delete from REPONSE_SAT where SESSION_ID="'.securiseSQLString($conn, $arr['session_id']).'" and REP_ID="'.securiseSQLString($conn, $ids[$i]).'"';
			$result = executeQuery($conn, $sql);
			if(!$result){
				return false;
			}
			
			if(!$is_comment){
				$sql = 'insert into REPONSE_SAT (
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
				$sql = 'insert into REPONSE_SAT (
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

?>