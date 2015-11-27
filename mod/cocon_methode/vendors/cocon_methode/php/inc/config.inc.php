<?php
/**
 * Liste des variables pr&eacute;-d&eacute;finies
 */

require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/engine/start.php';
// Return information only to loggedin users
if (!elgg_is_logged_in()) { exit; }

/*
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
*/

// Intégration Cocon Méthode : chemins et BDD
global $CONFIG;
//$root_path = elgg_get_root_path() . 'cocon_methode/vendors/cocon_methode';
$root_path = elgg_get_plugins_path() . 'cocon_methode/vendors/cocon_methode';
$inc_path = $root_path . '/php/inc';
$url_base = elgg_get_site_url() . 'mod/cocon_methode/vendors/cocon_methode';
$dbhost = $CONFIG->dbhost;
$dbuser = $CONFIG->dbuser;
$dbpass = $CONFIG->dbpass;
$dbname = $CONFIG->dbname . '_methode';
$email_sender = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=" . ' <' . $CONFIG->site->email . '>';
// Chemins d'accès
define("ROOT", $root_path);
define("INC", $inc_path);
define("URL_BASE", $url_base);
// Infos base de données
define('TYPE_SGDB','MYSQL'); // Type de base de donn&eacute;es ('MYSQL', 'PGSQL' ou 'ODBC')
define('SGDB_SERVER', $dbhost);// Adresse du serveur de base de données
define('SGDB_PORT', '3306');// port de com du serveur de base de données
define('SGDB_USER', $dbuser);// Utilisateur de connexion au serveur de base de données
define('SGDB_PASSWORD', $dbpass);// Mot de passe de connexion au serveur de base de données
define('SGDB_DATABASE', $dbname);// Nom de la base de données à utiliser
define('EMAIL_SENDER', $email_sender); // Expéditeur de message email


/**
	Retourne un tableau de valeurs contenant la configuration
	$cid est une chaine contenant l'ID du cycle demandé
	$gid est une chaine contenant l'ID du groupe cocon demandé
*/
function getConfiguration($gid){
	$cocon_url = elgg_get_site_url();
	$cocon_url = rtrim($cocon_url, '/');
	$methode_url = $cocon_url . '/mod/cocon_methode/vendors/cocon_methode';
	$user = elgg_get_logged_in_user_entity();
	
	$config = array(
		"error" => false,
		"error_string" => "",
		"cycle_id" => "",
		"group_id" => $gid,
		"group_name" => "", // Nom du groupe CoCon associé au visiteur
		"user_id" => "", // ID du visiteur
		"user_name" => "", // Nom et prénom du visiteur
		"user_role" => -1, // Role du visiteur
		"cocon_url" => $cocon_url, // Base URL for Cocon site
		"methode_url" => $methode_url, // Base URL for Méthode plugin
	);

	// Récupère le cycle en cours du groupe CoCon
	$cid = getCurrentCycleID($gid);
	if (!$cid) {
		$cid = createCycle($gid);
	}
	$config['cycle_id'] = $cid;
	
	// Si toujours pas de cycle => erreur
	if (!$cid) {
		$config['user_role'] = cocon_methode_get_user_role($user); // 0 = principal/direction, 1 = équipe, 2 = autre
		$config['error'] = true;
		$config['error_string'] = 'Cycle introuvable.\n-> '.mysql_error();
		return $config;
	}
	
	// Récupérer toutes ces valeurs depuis CoCon
	/*
	$config['group_name'] = 'Collège de test';
	$config['user_id'] = 'abcd';
	$config['user_name'] = 'Principal de test';
	$config['user_role'] = 0;
	*/
	// Intégration Cocon Méthode
	$group = get_entity($gid);
	if (!elgg_instanceof($group, 'group')) { register_error("Groupe invalide"); forward(); }
	if (!$group->isMember($user->guid)) { register_error("Vous n'êtes pas membre du groupe {$group->name}"); }
	$config['group_name'] = $group->name;
	$config['user_id'] = $user->guid;
	$config['user_name'] = $user->name;
	$config['user_role'] = cocon_methode_get_user_role($user); // 0 = principal/direction, 1 = équipe, 2 = autre
	
	// Update token
	$_SESSION['check_id'] = md5($gid.'_'.$cid);
error_log("Cocon Kit config.inc : Check ID : {$_SESSION['check_id']} = $gid - $cid"); // debug

	
	//error_log("Kit Methode Cocon : ROLE {$user->name} : {$config['user_role']}");
	
	return $config;
}


/**
	Retourne un tableau de valeur contenant les infos de base des enseignants associés au groupe CoCon
	$gid est une chaine contenant l'ID du groupe cocon demandé
*/
function getEnseignantsInfos($gid){
	// Intégration Cocon Méthode
	$group = get_entity($gid);
	if (!elgg_instanceof($group, 'group')) { register_error("Groupe invalide"); forward(); }
	
	$members = $group->getMembers(0);
	$infos = array();
	foreach($members as $ent) {
		$infos[] = array(
				'user_id' => $ent->guid,
				'user_name' => $ent->name,
				'user_email' => $ent->email,
			);
	}
	
	/** POUR TEST : Devra être renseigné par Florian est récupérant les données depuis la base CoCon.
	$infos = array(
		array(
			'user_id' => 'user_id',
			'user_name' => 'User Name',
			'user_email' => 'user_email@domain.tld'
		),
		array(
			'user_id' => 'user2_id',
			'user_name' => 'User2 Name',
			'user_email' => 'user2_email@domain.tld'
		),
	);
	*/
	
	return $infos;
}

