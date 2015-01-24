<?php
/**
 * Liste des variables pr&eacute;-d&eacute;finies
 */
session_start();

$_server = 'local';

if($_server == 'local'){

	// Chemins d'accès
	define("ROOT", "C:\Users\FR001918\Documents\mes_projets\www\sgmap");
	define("INC", "C:\Users\FR001918\Documents\mes_projets\www\sgmap\php\inc");
	define("URL_BASE", "http://localhost/sgmap");

	// Infos base de donn&eacute;es
	define('TYPE_SGDB','MYSQL'); // Type de base de donn&eacute;es ('MYSQL', 'PGSQL' ou 'ODBC')
	define('SGDB_SERVER', 'localhost');// Adresse du serveur de base de donn&eacute;es
	define('SGDB_PORT', '3306');// port de com du serveur de base de donn&eacute;es
	define('SGDB_USER', 'root');// Utilisateur de connexion au serveur de base de donn&eacute;es
	define('SGDB_PASSWORD', '');// Mot de passe de connexion au serveur de base de donn&eacute;es
	define('SGDB_DATABASE', 'pwccocon');// Nom de la base de donn&eacute;es &agrave; utiliser
	define('EMAIL_SENDER', 'Equipe CoCon<equipe@concon.fr>'); // Expéditeur de message email
}

if($_server == 'prod'){

	// Chemins d'accès
	define("ROOT", "/var/www/vhosts/globallearning.pwc.fr/httpdocs/sgmap");
	define("INC", "/var/www/vhosts/globallearning.pwc.fr/httpdocs/sgmap/php/inc");
	define("URL_BASE", "https://pwcgloballearning.pwc.fr/sgmap");

	// Infos base de donn&eacute;es
	define('TYPE_SGDB','MYSQL'); // Type de base de donn&eacute;es ('MYSQL', 'PGSQL' ou 'ODBC')
	define('SGDB_SERVER', 'localhost');// Adresse du serveur de base de donn&eacute;es
	define('SGDB_PORT', '3306');// port de com du serveur de base de donn&eacute;es
	define('SGDB_USER', 'pwccocon');// Utilisateur de connexion au serveur de base de donn&eacute;es
	define('SGDB_PASSWORD', 'CdTmp5MAQnwnqy4Bp1kFp');// Mot de passe de connexion au serveur de base de donn&eacute;es
	define('SGDB_DATABASE', 'pwccocon');// Nom de la base de donn&eacute;es &agrave; utiliser
	define('EMAIL_SENDER', 'Equipe CoCon<equipe@concon.fr>'); // Expéditeur de message email
	define("URL_BASE", "https://pwcgloballearning.pwc.fr/sgmap");
}

/**
	Retourne un tableau de valeurs contenant la configuration
	$cid est une chaine contenant l'ID du cycle demandé
	$gid est une chaine contenant l'ID du groupe cocon demandé
*/
function getConfiguration($gid){

	$config = array(
		"error" => false,
		"error_string" => "",
		"cycle_id" => "",
		"group_id" => $gid,
		"group_name" => "", // Nom du groupe CoCon associé au visiteur
		"user_id" => "", // ID du visiteur
		"user_name" => "", // Nom et prénom du visiteur
		"user_role" => -1 // Role du visiteur
	);

	// Récupère le cycle en cours du groupe CoCon
	$cid = getCurrentCycleID($gid);
	if(!$cid){
		$cid = createCycle($gid);
		if(!$cid){
			$config['error'] = true;
			$config['error_string'] = 'Cycle introuvable.\n-> '.mysql_error();
			return $config;
		}
	}
	$config['cycle_id'] = $cid;
	
	//POUR TEST, il faudra que Florian adapte le code lors du branchement pour récupérer toutes ces valeurs depuis CoCon
	$config['group_name'] = 'Collège de test';
	$config['user_id'] = 'abcd';
	$config['user_name'] = 'Principal de test';
	$config['user_role'] = 0;
	
	return $config;
}

/**
	Retourne un tableau de valeur contenant les infos de base des enseignants associés au groupe CoCon
	$gid est une chaine contenant l'ID du groupe cocon demandé
*/
function getEnseignantsInfos($gid){

	/**
		POUR TEST : Devra être renseigné par Florian est récupérant les données depuis la base CoCon.
	*/
	$infos = array(
	
		array(
			'user_id' => 'bbideaux',
			'user_name' => 'Baptiste Bideaux',
			'user_email' => 'baptiste.bideaux@fr.pwc.com'
		),

		array(
			'user_id' => 'obaudry',
			'user_name' => 'Olivier Baudry',
			'user_email' => 'obaudry@bebetterandco.com'
		),

		array(
			'user_id' => 'acrouchette',
			'user_name' => 'Anne-Cécile Rouchette',
			'user_email' => 'anne-cecile.rouchette@alenium.com'
		),
		
		array(
			'user_id' => 'hghariani',
			'user_name' => 'Héla Ghariani',
			'user_email' => 'hela.ghariani@modernisation.gouv.fr'
		),

		array(
			'user_id' => 'mmontaner',
			'user_name' => 'Michael Montaner',
			'user_email' => 'michael.montaner@fr.pwc.com'
		)
	);
	
	return $infos;
}
?>