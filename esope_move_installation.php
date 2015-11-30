<?php
/* Migration d'Esope
 * Automatise les modifications à apporter à la base de données suite à :
 *  - Changement d'URL
 *  - Changement de BDD
 *  - Changement de version
 * 
 * Ce que ce script ne fait pas :
 *  - Modification du prefix des tables
 *  - Autres opérations liées au déplacement et mises à jour
 */

/* Etapes :
 * 1. Copier les dossier web et data au nouvel emplacement souhaité
 * 2. Configurer le nouveau vhost
 * 3. Configurer engine/settings.php
 * 4. Si nécessaire, mettre à jour .htaccess (RewriteBase)
 * 5. Utiliser ce script pour mettre à jour les chemins et autres informations de la BDD
 */

// CONFIGURATION
// Uncomment to use, comment again once done (always leave uncommented on live site !!)
exit;
// Set to true to fill fields with preset. Set to false to get empty form fields
$example = false;


// Get and clean the requests
function get_input($variable, $default = '', $filter= true) {
	if (!isset($_REQUEST[$variable])) return $default;
	if (is_array($_REQUEST[$variable])) {
		$result = $_REQUEST[$variable];
	} else {
		$result = trim($_REQUEST[$variable]);
	}
	if ($filter) {
		if (is_array($result)) $result = array_map('strip_tags', $result);
		else $result = strip_tags($result);
	}
	return $result;
}

// Get actual values
$vars = array('db_server', 'db_name', 'db_user', 'db_pass', 'prefix', 'old_www', 'new_www', 'old_path', 'new_path', 'old_datapath', 'new_datapath');
// + Check that all fields are OK (not required : prefix and password can be empty)
$required_ok = true;
$required_vars = array('db_server', 'db_name', 'db_user', 'old_www', 'new_www', 'old_path', 'new_path', 'old_datapath', 'new_datapath');
foreach($vars as $varname) {
	$$varname = get_input($varname, '');
	if (in_array($varname, $required_vars) && empty($$varname)) { $required_ok = false; }
}
// Execute query ?
$execute_query = get_input('execute_query', 'no');

if ($example) {
	// DB settings
	$db_server = 'localhost';
	$db_name = 'esope_1.12';
	$db_user = 'root';
	$db_pass = 'root';
	// Custom Elgg DB config
	$prefix = 'elgg_';
	// Web URL without trailing slash
	$old_www = 'http://localhost/public/esope_1.11';
	$new_www = 'http://localhost/public/esope_1.12';
	// Server paths (with trailing slash)
	$old_path = '/var/www/esope_1.11/';
	$new_path = '/var/www/esope_1.12/';
	// Server data paths (with trailing slash)
	$old_datapath = '/var/www/esope_1.11-data/';
	$new_datapath = '/var/www/esope_1.12-data/';
}


// @TODO : use DB config if available
if (include_once(dirname(__FILE__) . '/engine/settings.php')) {
	global $CONFIG;
	if (empty($db_server)) { $db_server = $CONFIG->dbhost; }
	if (empty($db_name)) { $db_name = $CONFIG->dbname; }
	if (empty($db_user)) { $db_user = $CONFIG->dbuser; }
	if (empty($db_pass)) { $db_pass = $CONFIG->dbpass; }

	if (empty($old_www)) { $old_www = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];; }
	if (empty($new_www)) { $new_www = $old_www; }

	if (empty($old_path)) { $old_path = dirname(__FILE__); }
	if (empty($new_path)) { $new_path = dirname(__FILE__); }
	if (empty($old_datapath)) { $old_datapath = dirname(__FILE__) . '-data'; }
	if (empty($new_datapath)) { $new_datapath = dirname(__FILE__) . '-data'; }

	if (empty($prefix)) { $prefix = $CONFIG->dbprefix; }
}

header('Content-Type: text/html; charset=utf-8');
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Elgg move installation MySQL update script</title>
	<style>
	input { min-width:20em; }
	</style>
</head>
<body>
<?php
echo '<h2>Définition des paramètres de configuration</h2>';
echo '<form method="POST">';
echo '<p>Serveur MySQL <label><input type="text" name="db_server" value="' . $db_server . '" required="required" placeholder="localhost, mysql.domain.tld..." /></label></p>';
echo '<p>Nom de la base MySQL <label><input type="text" name="db_name" value="' . $db_name . '" required="required" placeholder="DB name, eg. elggproject" /></label></p>';
echo '<p>Utilisateur MySQL <label><input type="text" name="db_user" value="' . $db_user . '" required="required" placeholder="DB username, eg. elgguser" /></label></p>';
echo '<p>Mot de passe MySQL <label><input type="text" name="db_pass" value="' . $db_pass . '" /></label></p>';
echo '<p><label>Préfixe des tables (généralement "elgg_") <input type="text" name="prefix" value="' . $prefix . '" placeholder="elgg_" /></label></p>';
echo '<p><label>Ancienne URL (sans slash final) <input type="text" name="old_www" value="' . $old_www . '" required="required" placeholder="http://old_domain.tld/elgg" /></label></p>';
echo '<p><label>Nouvelle URL (sans slash final) <input type="text" name="new_www" value="' . $new_www . '" required="required" placeholder="http://new_domain.tld" /></label></p>';
echo '<p><label>Ancien chemin sur le serveur <input type="text" name="old_path" value="' . $old_path . '" required="required" placeholder="/var/www/old_domain.tld/" /></label></p>';
echo '<p><label>Nouveau chemin sur le serveur <input type="text" name="new_path" value="' . $new_path . '" required="required" placeholder="/var/www/new_domain.tld/www/" /></label></p>';
echo '<p><label>Ancien chemin des données sur le serveur <input type="text" name="old_datapath" value="' . $old_datapath . '" required="required" placeholder="/var/www/old_domain.tld-data/" /></label></p>';
echo '<p><label>Nouveau chemin des données sur le serveur <input type="text" name="new_datapath" value="' . $new_datapath . '" required="required" placeholder="/var/www/new_domain.tld/data/" /></label></p>';
echo '<p><label>Exécuter la mise à jour ? <select name="execute_query">';
if ($execute_query == 'yes') {
	echo '<option value="no">Non</option>';
	echo '<option value="yes" selected="selected">Oui !</option>';
} else {
	echo '<option value="no" selected="selected">Non</option>';
	echo '<option value="yes">Oui !</option>';
}
echo '</select></label></p>';
echo '<input type="submit" value="Mettre à jour" />';
echo '</form>';



if ($required_ok) {
	// Generate MySQL update script
	$sql = array();
	$sql[] = "// Mise à jour URL du site";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}sites_entity` SET url=replace(url, \"{$old_www}\", \"{$new_www}\");";
	$sql[] = "# Mise à jour des chemins";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}datalists` SET `value` = '{$new_path}' WHERE `{$prefix}datalists`.`name` = 'path';";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}datalists` SET `value` = '{$new_datapath}' WHERE `{$prefix}datalists`.`name` = 'dataroot';";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}metastrings` SET string=replace(string, \"{$old_datapath}\", \"{$new_datapath}\");";
	$sql[] = "# Mise à jour des URL";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}groups_entity` SET description=replace(description, \"{$old_www}\", \"{$new_www}\");";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}objects_entity` SET description=replace(description, \"{$old_www}\", \"{$new_www}\");";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}private_settings` SET value=replace(value, \"{$old_www}\", \"{$new_www}\");";
	$sql[] = "UPDATE `{$db_name}`.`{$prefix}metastrings` SET string=replace(string, \"{$old_www}\", \"{$new_www}\");";

	echo '<h2>Script MySQL à appliquer</h2>';
	echo '<pre>' . implode("\n", $sql) . '</pre>';


	// Check DB connection
	// @TODO : add optional port and socket ?
	$mysqli = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
	if (!$mysqli) {
		echo "<p>Impossible de se connecter à la base de données !</p>";
	} else {
		echo "<p>Connexion à la base de données réussie</p>";
	}
	
	// Execute actual query
	if ($mysqli && ($execute_query == 'yes')) {
		echo "<p>Exécution de la requête</p>";
		foreach ($sql as $query) {
			mysqli_query($mysqli, $query);
		}
		echo '<p>Succès... ' . mysqli_get_host_info($mysqli) . '</p>';
		mysqli_close($mysqli);
	}

}


