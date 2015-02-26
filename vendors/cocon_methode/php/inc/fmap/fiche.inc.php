<?php

/**
	ENSEMBLE DES FONCTIONS PHP POUR LES FICHES DE MISE EN PRATIQUE
*/

	/**
		Prépare un tableau associatif vide à partir des infos de fiche, cycle, groupe et membre
		$fid est l'ID de la fiche
		$cid est l'ID du cycle
		$gid est l'ID du groupe CoCon
		$uid est l'ID de l'enseignant
		$nom est le nom de la fiche
		Retourne  le tableau
	*/
	function prepareFicheArray($fid, $cid, $gid, $uid, $nom){
		$fiche = array(
			"error" => false,
			"error_string" => "",
			"fiche_id" => $fid,
			"cycle_id" => $cid,
			"group_id" => $gid,
			"user_id" => $uid,
			"active" => 1,
			"nom" => $nom,
			"theme" => "",
			"equipe" => "",
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
			"zone11" => ""
		);
		return $fiche;
	}
	
	/**
		Création d'une nouvelle fiche et retourne l'ID de fiche associée
		$fiche est un tableau de valeurs contenant les données de la fiche
	*/
	function createFiche($fiche){
	
		$conn = connectDB();
		$fid = getUniqueID();
		$sql = 'insert into FICHE(
			FICHE_ID,
			CYCLE_ID,
			GROUP_ID,
			USER_ID,
			NOM,
			ACTIVE) values(
			"'.securiseSQLString($conn, $fiche['fiche_id']).'",
			"'.securiseSQLString($conn, $fiche['cycle_id']).'",
			"'.securiseSQLString($conn, $fiche['group_id']).'",
			"'.securiseSQLString($conn, $fiche['user_id']).'",
			"'.securiseSQLString($conn, $fiche['nom']).'",
			"1")
		';
		
		$result = executeQuery($conn, $sql);
		
		if(!$result){
			return false;
		}else{
			return $fid;
		}
	
	}
	
	/**
		Retourne un tableau associatif contenant les données de la fiche demandée
		$fiche est un tableau associatif contenant les données de la fiche
		Retourne le tableau associatif complèté, ou false s'il y a une erreur lors du chargement
	*/
	function loadFiche($fiche){
		if(!isset($fiche['fiche_id']) || $fiche['fiche_id'] == ''){
			return false;
		}
		
		$conn = connectDB();
		
		// récupère les données d'entête de session
		$sql = 'select F.* from FICHE as F
			where F.FICHE_ID="'.securiseSQLString($conn, $fiche['fiche_id']).'"';

		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}

		while($row = mysql_fetch_assoc($result)){
			$fiche['fiche_id'] = $row['FICHE_ID'];
			$fiche['cycle_id'] = $row['CYCLE_ID'];
			$fiche['group_id'] = $row['GROUP_ID'];
			$fiche['user_id'] = $row['USER_ID'];
			$fiche['active'] = $row['ACTIVE'];
			$fiche['nom'] = $row['NOM'];
			$fiche['theme'] = $row['THEME'];
			$fiche['equipe'] = $row['EQUIPE'];
			$fiche['zone1'] = $row['ZONE1'];
			$fiche['zone2'] = $row['ZONE2'];
			$fiche['zone3'] = $row['ZONE3'];
			$fiche['zone4'] = $row['ZONE4'];
			$fiche['zone5'] = $row['ZONE5'];
			$fiche['zone6'] = $row['ZONE6'];
			$fiche['zone7'] = $row['ZONE7'];
			$fiche['zone8'] = $row['ZONE8'];
			$fiche['zone9'] = $row['ZONE9'];
			$fiche['zone10'] = $row['ZONE10'];
			$fiche['zone11'] = $row['ZONE11'];
		}

		return $fiche;
	}
	
	/**
		Mise à jour de la fiche
		$fiche est un objet JSON
		return true si l'opération a réussie, sinon false
	*/
	function updateFiche($fiche){
		
		$conn = connectDB();
		$sql = 'update FICHE set
			NOM="'.securiseSQLString($conn, $fiche->nom).'",
			THEME="'.securiseSQLString($conn, $fiche->theme).'",
			EQUIPE="'.securiseSQLString($conn, $fiche->equipe).'",
			ZONE1="'.securiseSQLString($conn, $fiche->zone1).'",
			ZONE2="'.securiseSQLString($conn, $fiche->zone2).'",
			ZONE3="'.securiseSQLString($conn, $fiche->zone3).'",
			ZONE4="'.securiseSQLString($conn, $fiche->zone4).'",
			ZONE5="'.securiseSQLString($conn, $fiche->zone5).'",
			ZONE6="'.securiseSQLString($conn, $fiche->zone6).'",
			ZONE7="'.securiseSQLString($conn, $fiche->zone7).'",
			ZONE8="'.securiseSQLString($conn, $fiche->zone8).'",
			ZONE9="'.securiseSQLString($conn, $fiche->zone9).'",
			ZONE10="'.securiseSQLString($conn, $fiche->zone10).'",
			ZONE11="'.securiseSQLString($conn, $fiche->zone11).'"
			where FICHE_ID="'.securiseSQLString($conn, $fiche->fiche_id).'"';
			
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		return true;
	}
	
	/**
		Désactive la fiche
		$fiche est un tableau de variables
		return true si l'opération a réussie, sinon false
	*/
	function removeFiche($fiche){
		
		$conn = connectDB();
		$sql = 'update FICHE set
			ACTIVE="'.securiseSQLString($conn, $fiche['active']).'"
			where FICHE_ID="'.securiseSQLString($conn, $fiche['fiche_id']).'"';
			
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		return true;
	}

	/**
		Récupère les fiches de mise en pratiques associées au cycle et au groupe CoCon fournis
		$cid est l'ID du cycle en cours pour le groupe CoCon
		$gid est l'ID du groupe CoCon

		Retourne un objet JSON contenant les noms et ID des fiches, sinon false si il y a une erreur

	*/
	function getAllFiches($cid, $gid){
		$conn = connectDB();
		$list = array(
			"error" => false,
			"error_string" => "",
			"fiches" => array()
		);
		
		$sql = 'select * from FICHE where CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and ACTIVE=1 ORDER by NOM';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		$n = 0;
		while($row = mysql_fetch_assoc($result)){
			array_push($list['fiches'], array(
					"id" => $row['FICHE_ID'],
					"nom" => $row['NOM']
				)
			);
			$n++;
		}
		
		return json_encode($list);
	}
	
	/**
		Récupère les fiches de mise en pratiques associées à un utilisateur
		$cid est l'ID du cycle en cours pour le groupe CoCon
		$gid est l'ID du groupe CoCon
		$uid  est l'ID de l'utilisateur
		
		Retourne un objet JSON contenant les noms et ID des fiches, sinon false si il y a une erreur

	*/
	function getUserFiches($cid, $gid, $uid){
		$conn = connectDB();
		$list = array(
			"error" => false,
			"error_string" => "",
			"fiches" => array()
		);
		
		$sql = 'select * from FICHE where CYCLE_ID="'.securiseSQLString($conn, $cid).'" and GROUP_ID="'.securiseSQLString($conn, $gid).'" and USER_ID="'.securiseSQLString($conn, $uid).'" and ACTIVE=1 ORDER by NOM';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		$n = 0;
		while($row = mysql_fetch_assoc($result)){
			array_push($list['fiches'], array(
					"id" => $row['FICHE_ID'],
					"nom" => $row['NOM']
				)
			);
			$n++;
		}
		
		return json_encode($list);
	}	
?>