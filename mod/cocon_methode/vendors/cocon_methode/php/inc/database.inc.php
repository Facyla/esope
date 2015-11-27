<?php
require_once 'config.inc.php';

/**
 * Ouvre une connexion &agrave; la base de donn&eacute;es selon le type
 * @return resource
 */
function connectDB(){
	if(TYPE_SGDB == 'MYSQL'){
		$conn = mysql_connect(SGDB_SERVER.':'.SGDB_PORT, SGDB_USER, SGDB_PASSWORD);
		if(!$conn){
			trace('connectDB() : '.getLastSQLError(),2);
			return false;
		}
		mysql_select_db(SGDB_DATABASE, $conn);
		return $conn;
	}
	
	if(TYPE_SGDB == 'PGSQL'){
		$conn = pg_connect('host='.SGDB_SERVER.' port='.SGDB_PORT.' dbname='.SGDB_DATABASE.' user='.SGDB_USER.' password='.SGDB_PASSWORD);
		if(!$conn){
			trace('connectDB() : '.getLastSQLError(),2);
			return false;
		}
		return $conn;
	}	
	
	if(TYPE_SGDB == 'ODBC'){
		$conn = odbc_connect(SGDB_DATABASE, SGDB_USER, SGDB_PASSWORD);
		if(!$conn){
			trace('connectDB() : '.getLastSQLError(),2);
			return false;
		}
		return $conn;
	}
	
}

/**
 * Ferme la connexion &agrave; la base de donn&eacute;es.<br>$conn est la resource retourn&eacute;e par l'appel de la fonction connectDB.
 * @param resource $conn
 */
function closeDB($conn){
	if(TYPE_SGDB == 'MYSQL'){
		mysql_close($conn);
	}
	
	if(TYPE_SGDB == 'PGSQL'){
		pg_close($conn);
	}
	
	if(TYPE_SGDB == 'ODBC'){
		odbc_close($conn);
	}
	return true;	
}

function executeQuery($conn, $sql){
	if(!is_String($sql) || $sql == ''){
		trace('executeQuery(\''.$conn.'\', \''.$sql.'\') : l\'argument $sql n\'est pas de type String ou est une chaine vide.');
		return false;
	}
	$result = true;
	if(TYPE_SGDB == 'MYSQL'){
		$result = mysql_query($sql, $conn);
	}
	
	if(TYPE_SGDB == 'PGSQL'){
		$result = pg_query($conn, $sql);
	}
		
	if(TYPE_SGDB == 'ODBC'){
		$result = odbc_exec($conn, $sql);
	}
	return $result;	
}

/**
 * Retourne le texte de la derni&egrave;re erreur SQL survenue
 * @return String
 */
function getLastSQLError(){
	if(TYPE_SGDB == 'MYSQL'){
		return mysql_error();
	}
	
	if(TYPE_SGDB == 'PGSQL'){
		return pg_errormessage();
	}
		
	if(TYPE_SGDB == 'ODBC'){
		return odbc_errormsg();
	}
}

/**
 * S&eacute;curise une chaine String contre l'injection SQL.
 * @param resource $conn
 * @param String $value
 * @return String
 */
function securiseSQLString($conn, $value){
	if(!is_String($value)){
		return $value;
	}
	
	$_must_close = false;
	if($conn == null){
		$conn = connectDB();
		if(!$conn){
			return $value;
		}
		$_must_close = true;
	}
	
	if(TYPE_SGDB == 'MYSQL'){
//		$value = mysql_escape_string($conn, $value);
//		$value = addslashes($value);
	}

	if(TYPE_SGDB == 'PGSQL'){
		$value = pg_escape_String($conn,$data);
		$value = addslashes($value);
	}
	
	if($_must_close){
		closeDB($conn);
	}
	
	return $value;
}
?>
