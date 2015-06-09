<?php

/**
	FONCTION PHP POUR LE CALCUL DES RESULTATS
*/


	/**
		Calcul l'ensemble des résultats bruts et synthétiques
		$cid est une chaine contenant l'ID du cycle concerné
		$gid est une chaine contenant l'ID du groupe CoCon concerné
		Retourne un tableau de clés associative des valeurs ou false s'il y a eu une erreur
	*/
	function calculResultats($cid, $gid){
	
		// POUR TEST
		$resultats = array(
			"num_rep" => 12,
			"rb1_1" => array(4.0, 2.0, 5.0, 1.0),
			"rb2_1" => array(3.0, 1.0, 7.0, 2.0),
			"rb2_2" => array(5.0, 2.0, 3.0, 2.0),
			"rb3_1" => array(4.0, 8.0),
			"rb3_2" => array(6.0, 6.0),
			"rb4_1" => array(
				array(5.0, 4.0, 1.0, 2.0),
				array(6.0, 5.0, 1.0, 0.0),
				array(3.0, 2.0, 5.0, 2.0),
				array(7.0, 3.0, 1.0, 1.0)
			),
			"rb5_1" => array(
				array(6.0, 6.0, 0.0, 0.0),
				array(5.0, 1.0, 3.0, 3.0),
				array(8.0, 1.0, 1.0, 2.0),
				array(2.0, 9.0, 0.0, 1.0)
			),
			"rb5_2" => array(
				array(9.0, 3.0, 0.0, 0.0),
				array(5.0, 5.0, 1.0, 1.0),
				array(10.0, 1.0, 0.0, 1.0),
				array(4.0, 3.0, 4.0, 1.0)
			),
			"rb6_1" => array(8.0, 1.0, 2.0, 1.0),
			
			"rs1_1" => 0.0,
			"rs2_1" => 0.0,
			"rs2_2" => 0.0,
			"rs3_1" => array(0.0, 0.0),
			"rs3_2" => array(0.0, 0.0),
			"rs4_1" => array(0.0, 0.0, 0.0, 0.0),
			"rs5_1" => array(0.0, 0.0, 0.0, 0.0),
			"rs5_2" => array(0.0, 0.0, 0.0, 0.0),
			"rs6_1" => 0.0
		);		
	/**
		$resultats = array(
			"num_rep" => 0,
			"rb1_1" => array(0.0, 0.0, 0.0, 0.0),
			"rb2_1" => array(0.0, 0.0, 0.0, 0.0),
			"rb2_2" => array(0.0, 0.0, 0.0, 0.0),
			"rb3_1" => array(0.0, 0.0),
			"rb3_2" => array(0.0, 0.0),
			"rb4_1" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb5_1" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb5_2" => array(
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0),
				array(0.0, 0.0, 0.0, 0.0)
			),
			"rb6_1" => array(0.0, 0.0, 0.0, 0.0),
			
			"rs1_1" => 0.0,
			"rs2_1" => 0.0,
			"rs2_2" => 0.0,
			"rs3_1" => array(0.0, 0.0),
			"rs3_2" => array(0.0, 0.0),
			"rs4_1" => array(0.0, 0.0, 0.0, 0.0),
			"rs5_1" => array(0.0, 0.0, 0.0, 0.0),
			"rs5_2" => array(0.0, 0.0, 0.0, 0.0),
			"rs6_1" => 0.0
		);

		$conn = connectDB();
		
		// Récupère le nombre de répondants
		$sql = 'select * from SESSION_SAT where CYCLE_ID="'.securiseSQLString($conn, $cid).'" AND GROUP_ID="'.securiseSQLString($conn, $gid).'" AND ETAT=1 AND ACTIVE=1';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		$resultats['num_rep'] = mysql_num_rows($result);
		
		// RESULTATS BRUTS
		$sql = 'select R.*, S.* from REPONSE_SAT as R join SESSION_SAT as S on S.SESSION_ID=R.SESSION_ID where S.CYCLE_ID="'.securiseSQLString($conn, $cid).'" AND S.GROUP_ID="'.securiseSQLString($conn, $gid).'" ORDER BY R.REP_POS';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}		
		
		while($row = mysql_fetch_assoc($result)){
			
			if($row['REP_POS'] == 0){
				$resultats['rb1_1'][$row['REP_DATA'] - 1]++;
			}

			if($row['REP_POS'] == 1){
				$resultats['rb2_1'][$row['REP_DATA'] - 1]++;
			}

			if($row['REP_POS'] == 2){
				$resultats['rb2_2'][$row['REP_DATA'] - 1]++;
			}

			if($row['REP_POS'] == 3){
				$resultats['rb3_1'][$row['REP_DATA'] - 1]++;
			}
			
			if($row['REP_POS'] == 4){
				$resultats['rb3_2'][$row['REP_DATA'] - 1]++;
			}

			if($row['REP_POS'] == 5){
				$resultats['rb4_1'][$row['PROFIL_THEO']][$row['REP_DATA'] - 1]++;
			}
			
			if($row['REP_POS'] == 6){
				$resultats['rb5_1'][$row['PROFIL_THEO']][$row['REP_DATA'] - 1]++;
			}
			
			if($row['REP_POS'] == 7){
				$resultats['rb5_2'][$row['PROFIL_THEO']][$row['REP_DATA'] - 1]++;
			}
			
			if($row['REP_POS'] == 8){
				$resultats['rb6_1'][$row['REP_DATA'] - 1]++;
			}
			
		}
		*/
		// RESULTATS SYNTHETIQUES
		$resultats['rs1_1'] = $resultats['rb1_1'][2] + $resultats['rb1_1'][3];
		$resultats['rs2_1'] = $resultats['rb2_1'][2] + $resultats['rb2_1'][3];
		$resultats['rs2_2'] = $resultats['rb2_2'][2] + $resultats['rb2_2'][3];
		$resultats['rs3_1'][0] = $resultats['rb3_1'][0];
		$resultats['rs3_1'][1] = $resultats['rb3_1'][1];
		$resultats['rs3_2'][0] = $resultats['rb3_2'][0];
		$resultats['rs3_2'][1] = $resultats['rb3_2'][1];

		$resultats['rs4_1'][0] = $resultats['rb4_1'][0][2] + $resultats['rb4_1'][0][3];
		$resultats['rs4_1'][1] = $resultats['rb4_1'][1][2] + $resultats['rb4_1'][1][3];
		$resultats['rs4_1'][2] = $resultats['rb4_1'][2][2] + $resultats['rb4_1'][2][3];		
		$resultats['rs4_1'][3] = $resultats['rb4_1'][3][2] + $resultats['rb4_1'][3][3];

		$resultats['rs5_1'][0] = $resultats['rb5_1'][0][2] + $resultats['rb5_1'][0][3];
		$resultats['rs5_1'][1] = $resultats['rb5_1'][1][2] + $resultats['rb5_1'][1][3];
		$resultats['rs5_1'][2] = $resultats['rb5_1'][2][2] + $resultats['rb5_1'][2][3];		
		$resultats['rs5_1'][3] = $resultats['rb5_1'][3][2] + $resultats['rb5_1'][3][3];

		$resultats['rs5_2'][0] = $resultats['rb5_2'][0][2] + $resultats['rb5_2'][0][3];
		$resultats['rs5_2'][1] = $resultats['rb5_2'][1][2] + $resultats['rb5_2'][1][3];
		$resultats['rs5_2'][2] = $resultats['rb5_2'][2][2] + $resultats['rb5_2'][2][3];		
		$resultats['rs5_2'][3] = $resultats['rb5_2'][3][2] + $resultats['rb5_2'][3][3];
		
		$resultats['rs6_1'] = $resultats['rb6_1'][2] + $resultats['rb1_1'][3];	

		return $resultats;
	}
?>