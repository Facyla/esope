<?php
/**
* Elgg output content as embed block
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

forward();
exit; // It was a test/POC, now better packaged in a specific plugin - contact author for more info

// Load Elgg engine
define('cmspage', true);
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

/* Le principe est de donner accès à un contenu de manière à pouvoir l'embarquer sous forme d'iframe
 * Si le contenu est public, on doit puvoir a minima bypasser le wlledgarden
 * Si le contenu est privé, on devrait pouvoir y accéder 
  - via un clef d'accès exlusive (clef générée à partir du guid, de la clef privée du site, et autre à voir - éléments stables en tous cas)
  - via mot de passe
  - en l'absence de mot de passe ou de clef (ou si vide) => vide ou invite de connexion ou invite à saisir le mot de passe selon les cas
*/

// @TODO : hook pour autoriser l'accès à cette page en walled_garden !

$body = 'Test export widgets';
$body .= '';

// Test group activity
$num = 5;
$guid = 72;
if ($guid) {
	$entity = get_entity($guid);
	$title = $entity->name;
	$title = '<h4><a href="' . $entity->getURL() . '">' . $title . '</a></h4>';
	$body = "<div class=\"embed embed-group-activity\">$title</div>";
	$db_prefix = elgg_get_config('dbprefix');
	$activity = elgg_list_river(array(
		'limit' => $num, 'pagination' => false,
		'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
		'wheres' => array("(e1.container_guid = $guid)"),
	));
	if (!$activity) {
		$activity = '<p>' . elgg_echo('dashboard:widget:group:noactivity') . '</p>';
	}

	$body .= '<div class="embed-group-content">' . $activity . '</div>';
}


// Display page
// Send page headers : tell at least it's UTF-8
header('Content-Type: text/html; charset=utf-8');
echo $body;

