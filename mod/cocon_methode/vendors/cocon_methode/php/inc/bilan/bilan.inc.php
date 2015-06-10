<?php

/**
	ENSEMBLE DES FONCTIONS PHP POUR LES FICHES BILAN
*/

	/**
		Prépare un tableau associatif vide à partir des infos de cycle, groupe et membre
		$cid est l'ID du cycle
		$gid est l'ID du groupe CoCon
		Retourne  le tableau
	*/
	function prepareBilanArray($cid, $gid){
		$bilan = array(
			"error" => false,
			"error_string" => "",
			"cycle_id" => $cid,
			"group_id" => $gid,
			"active" => 1,
			"zone1" => "",
			"zone2" => "",
			"zone3" => "",
			"zone4" => "",
			"zone5" => "",
			"zone6" => "",
			"zone7" => "",
			"zone8" => "",
			"zone9" => "",
			"zone10" => "",
			"zone11" => "",
			"zone12" => "",
			"zone13" => ""
		);
		return $bilan;
	}
	
	/**
		Création d'une nouvelle fiche bilan et retourne l'ID de fiche associée
		$bilan est un tableau de valeurs contenant les données de la fiche
	*/
	function createBilan($bilan){
	
		$conn = connectDB();
		$bid = getUniqueID();
		$bilan['bilan_id'] = $bid;
		$sql = 'insert into BILAN(
			BILAN_ID,
			CYCLE_ID,
			GROUP_ID,
			ACTIVE) values(
			"'.securiseSQLString($conn, $bilan['bilan_id']).'",
			"'.securiseSQLString($conn, $bilan['cycle_id']).'",
			"'.securiseSQLString($conn, $bilan['group_id']).'",
			"1")
		';
		
		$result = executeQuery($conn, $sql);
		
		if(!$result){
			return false;
		}else{
			return $bid;
		}
	
	}
	
	/**
		Retourne un tableau associatif contenant les données de la fiche bilan demandée
		$bilan est un tableau associatif contenant les données de la fiche bilan
		Retourne le tableau associatif complèté, ou false s'il y a une erreur lors du chargement
	*/
	function loadBilan($bilan){
		if(!isset($bilan['cycle_id']) || $bilan['cycle_id'] == '' || !isset($bilan['group_id']) || $bilan['group_id'] == ''){
			return false;
		}
		
		$conn = connectDB();
		
		// récupère les données d'entête de session
		$sql = 'select B.* from BILAN as B
			where B.CYCLE_ID="'.securiseSQLString($conn, $bilan['cycle_id']).'"
			AND B.GROUP_ID="'.securiseSQLString($conn, $bilan['group_id']).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		/**
			Création d'une fiche bilan s'il y en a pas
		*/
		if(mysql_num_rows($result) == 0){
			$bilan = prepareBilanArray($bilan['cycle_id'], $bilan['group_id']);
			if(!$bilan){
				return false;
			}
			
			$bid = createBilan($bilan);
			if(!$bid){
				return false;
			}
			$bilan['bilan_id'] = $bid;
			return $bilan;
		}
		
		while($row = mysql_fetch_assoc($result)){
			$bilan['bilan_id'] = $row['BILAN_ID'];
			$bilan['cycle_id'] = $row['CYCLE_ID'];
			$bilan['group_id'] = $row['GROUP_ID'];
			$bilan['active'] = $row['ACTIVE'];
			$bilan['zone1'] = $row['ZONE1'];
			$bilan['zone2'] = $row['ZONE2'];
			$bilan['zone3'] = $row['ZONE3'];
			$bilan['zone4'] = $row['ZONE4'];
			$bilan['zone5'] = $row['ZONE5'];
			$bilan['zone6'] = $row['ZONE6'];
			$bilan['zone7'] = $row['ZONE7'];
			$bilan['zone8'] = $row['ZONE8'];
			$bilan['zone9'] = $row['ZONE9'];
			$bilan['zone10'] = $row['ZONE10'];
			$bilan['zone11'] = $row['ZONE11'];
			$bilan['zone12'] = $row['ZONE12'];
			$bilan['zone13'] = $row['ZONE13'];
		}

		return $bilan;
	}
	
	/**
		Mise à jour de la fiche bilan
		$bilan est un objet JSON
		return true si l'opération a réussie, sinon false
	*/
	function updateBilan($bilan){
		
		$conn = connectDB();
		$sql = 'update BILAN set
			ZONE1="'.securiseSQLString($conn, $bilan->zone1).'",
			ZONE2="'.securiseSQLString($conn, $bilan->zone2).'",
			ZONE3="'.securiseSQLString($conn, $bilan->zone3).'",
			ZONE4="'.securiseSQLString($conn, $bilan->zone4).'",
			ZONE5="'.securiseSQLString($conn, $bilan->zone5).'",
			ZONE6="'.securiseSQLString($conn, $bilan->zone6).'",
			ZONE7="'.securiseSQLString($conn, $bilan->zone7).'",
			ZONE8="'.securiseSQLString($conn, $bilan->zone8).'",
			ZONE9="'.securiseSQLString($conn, $bilan->zone9).'",
			ZONE10="'.securiseSQLString($conn, $bilan->zone10).'",
			ZONE11="'.securiseSQLString($conn, $bilan->zone11).'",
			ZONE12="'.securiseSQLString($conn, $bilan->zone12).'",
			ZONE13="'.securiseSQLString($conn, $bilan->zone13).'" 
			where BILAN_ID="'.securiseSQLString($conn, $bilan->bilan_id).'"';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		return true;
	}
?>