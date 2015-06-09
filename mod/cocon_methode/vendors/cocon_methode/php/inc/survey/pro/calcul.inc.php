<?php

/**
	FONCTION PHP POUR LE CALCUL DES RESULTATS
*/


	/**
		Calcul l'ensemble des résultats suivants :
		
		- Profil théorique
		- Totaux ouverture sur l'écosystème (4 valeurs + la somme)
		- Totaux Niveau utilisation/pratique et usage (4 valeurs + la somme)
		
		$survey est l'objet JSON contenant les données de la session
		Retourne l'objet JSON de la session avec les résulats, sinon false s'il y a une erreur.
	*/
	function calculResultats($survey){
	
		$val_pt = 0.0;
		$eco_1 = 0.0;
		$eco_2 = 0.0;
		$eco_3 = 0.0;
		$eco_4 = 0.0;
		$eco_sum = 0.0;
		$usag_1 = 0.0;
		$usag_2 = 0.0;
		$usag_3 = 0.0;
		$usag_4 = 0.0;
		$usag_sum = 0.0;
		$profil_theo = 0;
		
		$conn = connectDB();
		
		// Calcul le profil théorique
		$sql = 'select R.*, SI.* from REPONSE as R join SESSION_IP as SI on SI.REP_ID=R.REP_ID where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		$val_pt = mysql_num_rows($result) * 1.0;

		/**
			Calcul les totaux de l'écosystème
		*/
		// eco 1
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=1 AND AJOUT_ECO=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="1"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$eco_1 += $row['COEFF'];
		}

		// eco 2
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=2 AND AJOUT_ECO=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="2"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$eco_2 += $row['COEFF'];
		}

		// eco 3
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=3 AND AJOUT_ECO=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="3"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$eco_3 += $row['COEFF'];
		}

		// eco 4
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=4 AND AJOUT_ECO=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="4"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$eco_4 += $row['COEFF'];
		}
		
		// eco_sum
		$eco_sum = ($eco_1 + $eco_2 + $eco_3 + $eco_4) / 70 * 8;
		
		/**
			Calcule Niveau utilisation/pratique et usage
		*/
		// usag 1
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=1 AND AJOUT_USAG=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="1"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$usag_1 += $row['COEFF'];
		}

		// usag 2
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=2 AND AJOUT_USAG=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="2"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$usag_2 += $row['COEFF'];
		}

		// usag 3
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=3 AND AJOUT_USAG=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="3"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$usag_3 += $row['COEFF'];
		}

		// usag 4
		$sql = 'select R.*, SC.* from REPONSE as R join SESSION_COEFF as SC on (SC.REP_ID=R.REP_ID and SC.LID=4 AND AJOUT_USAG=1) where R.SESSION_ID="'.securiseSQLString($conn, $survey->session_id).'" and R.REP_DATA="4"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$usag_4 += $row['COEFF'];
		}
		
		// usag_sum
		$usag_sum = ($usag_1 + $usag_2 + $usag_3 + $usag_4) / 170 * 8;

		// =SI(C196<>0; SI(C199>=4; SI(C200>=4; "Profil 2"; "Profil 1"); SI(C200>=4; "Profil 4"; "Profil 3")); " ")	
		if($val_pt <> 0.0){
			if($eco_sum >= 4.0){
				if($usag_sum >= 4.0){
					$profil_theo = 2;
				}else{
					$profil_theo = 1;
				}
			}else{
				if($usag_sum >= 4.0){
					$profil_theo = 4;
				}else{
					$profil_theo = 3;
				}
			}
		}else{
			$profil_theo = 0;
		}
		
		// Met à jour le JSON
		$survey->val_pt = $val_pt;
		$survey->profil_theo = $profil_theo;
		$survey->eco_1 = $eco_1;
		$survey->eco_2 = $eco_2;
		$survey->eco_3 = $eco_3;
		$survey->eco_4 = $eco_4;
		$survey->eco_sum = $eco_sum;
		$survey->usag_1 = $usag_1;
		$survey->usag_2 = $usag_2;
		$survey->usag_3 = $usag_3;
		$survey->usag_4 = $usag_4;
		$survey->usag_sum = $usag_sum;
		
		return $survey;
	}
?>