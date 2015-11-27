<?php

/**
	ENSEMBLE DES FONCTIONS PHP POUR LES CYCLES
*/

	/**
		Retourne l'ID du cycle en cours pour un groupe CoCon
		$gid est l'ID du groupe CoCon
		
		Si le groupe n'a pas de cycle en cours, retourne false;
	*/
	function getCurrentCycleID($gid){
		
		$conn = connectDB();
		$sql = 'select * from CYCLE where GROUP_ID="'.securiseSQLString($conn, $gid).'" and ACTIVE=1';
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		
		//if (is_bool($result)) error_log("Cocon Kit : $result / $gid / $sql / ".mysql_num_rows($result)); // debug
		//if(mysql_num_rows($result) == 0){
		if(mysql_num_rows($result) < 1){
			return false;
		}
		
		$cid = '';
		while($row = mysql_fetch_assoc($result)){
			$cid = $row['CYCLE_ID'];
		}
		
		if($cid != ''){
			return $cid;
		}else{
			return false;
		}
	}
	
	/**
		Création d'un cycle pour un groupe CoCon
		$gid est l'ID du groupe CoCon
		
		Retourne l'ID du cycle, sinon false s'il y a une erreur;
	*/
	function createCycle($gid){
	
		$conn = connectDB();
		$sql = 'update CYCLE set ACTIVE=0 where GROUP_ID="'.securiseSQLString($conn, $gid).'"';
		$result = executeQuery($conn, $sql);
		
		if(!$result){
			return false;
		}
		
		$cid = getUniqueID();
		
		$sql = 'insert into CYCLE(
			CYCLE_ID,
			GROUP_ID,
			ANNEE,
			ACTIVE) values(
				"'.securiseSQLString($conn, $cid).'",
				"'.securiseSQLString($conn, $gid).'",
				"'.securiseSQLString($conn, date('Y', microtime(true))).'",
				"1")';
				
		$result = executeQuery($conn, $sql);
		if(!$result){
			return false;
		}
		return $cid;
	}


