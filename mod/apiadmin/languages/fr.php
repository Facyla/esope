<?php
/**
 * Elgg API Admin
 * french text for the API Admin plug-in
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Curverider Ltd and Moodsdesign Ltd
 * @copyright Curverider Ltd 2011 and Moodsdesign Ltd 2012
 * @link http://www.elgg.org
 * @translation French by Florain DANIEL - Facyla
*/

$french = array(
	'admin:administer_utilities:apiadmin' => "API Key Admin",
	'admin:statistics:apilog' => "Journal d'accès à l'API",

	'apiadmin:refrenamed' => "Intitulé de l'API modifiée",
	'apiadmin:refnotrenamed' => "L'intitulé de l'API n'a pas pu être modifié",
	'apiadmin:keyrevoked' => "Clef d'API révoquée",
	'apiadmin:keynotrevoked' => "Le clef d'API n'a pas pu être révoquée",
	'apiadmin:generated' => "Une nouvelle paire de clef d'API a été créée",
	'apiadmin:generationfail' => "Il y a eu un problème lors de la génération d'une nouvelle paire de clefs",
	'apiadmin:regenerated' => "La clef d'API a été régénérée",
	'apiadmin:regenerationfail' => "Il y a eu un problème lors de la régénération des clefs",
	'apiadmin:noreference' => "Vous devez fournir un intitulé pour votre nouvelle clef.",

	'apiadmin:yourref' => "Intitulé de la clef",
	'apiadmin:generate' => "Générer une nouvelle paire de clefs",
	'apiadmin:rename_prompt' => "Entrez un nouvel intitulé pour la clef :",
	'apiadmin:revoke_prompt' => "Etes-vous sûr de vouloir révoquer ces clefs ?",
	'apiadmin:regenerate_prompt' => "Etes-vous sûr de vouloir régénérer ces clefs ?",
	'apiadmin:log:all' => "Afficher le journal d'accès pour toutes les clefs",
	'apiadmin:nokeys' => "Aucune clef d'API enregistrée actuellement.",
	
	'apiadmin:revoke' => "Révoquer cette paire de clefs",
	'apiadmin:rename' => "Modifier son intitulé",
	'apiadmin:regenerate' => "Régénérer la paire de clefs",
	'apiadmin:log' => "Journal d'accès",

	'apiadmin:public' => "Publique",
	'apiadmin:private' => "Privée",

	'apiadmin:settings:enable_stats' => "Activer la collecte de statistiques sur l'utilisation des clefs d'API",
	'apiadmin:settings:keep_tables' => "Ne pas supprimer les tables des statistques de la base de données lors de la désactivation du plugin",

	'item:object:api_key' => "Clefs d'API",

	'apiadmin:record:date' => "Date",
	'apiadmin:record:key' => "Clef d'API",
	'apiadmin:record:handler' => "Gestionnaire",
	'apiadmin:record:request' => "Requête",
	'apiadmin:record:method' => "Méthode HTTP",
	'apiadmin:record:ip_address' => "Adresse IP",
	'apiadmin:record:user_agent' => "User Agent",

	'apiadmin:no_result' => "Il n'y a actuellement aucune entrée dans le journal d'accès de l'API",
	'apiadmin:no_version_check' => "Le plugin Version Check n'est pas installé ou inactif. Vous ne recevrez pas de notification lors de la publication de nouvelles versions d'API Admin.",
);
add_translation('fr', $french);
