<?php
/**
 * Page admin pour supprimer massivement des comptes de spam
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.net/
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

// Deprecated tool URL
$full_url = current_page_url();
error_log("Deprecated tools URL used : $full_url - redirecting to esope/tools");
register_error("Ces outils sont désormais accessibles depuis une page unique d'outils d'administration avancés. Veuillez mettre à jour vos marques-pages.");
forward('esope/tools');

