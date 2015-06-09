<?php
/**
 * Elgg pin action
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Elgg.fr
 * @copyright Elgg.fr
 * @link http://elgg.fr/
*/

// Start engine
require_once (dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();

$guid = get_input('guid', false);
$callback = get_input('callback', false);
$action = get_input('action', '');
$pin_list = get_input('list', true);

// Works only for valid Elgg entities
if ($guid) { $entity = get_entity($guid); }
if ($entity instanceof ElggEntity) {
	// Si demande d'épinglage ou si pas encore épinglé
	if (($action == 'highlight') || !$entity->highlight) {
		// Si pas mis en avant, action = mise en avant
		// Notes : plusieurs valeurs possibles pour différencier différents types de mise en valeur
		// @TODO : gérer une liste de valeurs plutôt qu'une seule pour le moment ?
		switch($action) {
			case 'highlight':
			default:
				$entity->highlight = $pin_list;
		}
		$message = elgg_echo('pin:highlighted:true');
	
	} else {
		// Si demande de désépinglage ou si déjà mis en avant
		// @todo voir si on annule la mise en avant, ou autre selon l'action demandée (par défaut : annuler)
		switch($action) {
			case 'unhighlight':
			default:
				$entity->highlight = false;
		}
		$message = elgg_echo('pin:highlighted:false');
	}
}

if ($callback) {
	header('HTTP/1.1 200 OK');
	echo $message;
	exit;
} else {
	system_message($message);
	forward($_SESSION['last_forward_from']);
}

