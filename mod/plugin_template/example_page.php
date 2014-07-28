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

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
global $CONFIG;

$title = "Titre";

$body = "Contenu de la page";


// Affichage
echo elgg_view_page($title, $body);


