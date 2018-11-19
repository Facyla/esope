<?php
/**
* Elgg CMS pages
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

exit; // Tests and development - now intergated into main plugin functions

gatekeeper();
global $CONFIG;

// Facyla : this tool is rather for local admins and webmasters than main admins, so use custom access rights : OK if custom rights match, or use default behaviour
if (in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) {
} else {
  admin_gatekeeper();
}


$pagetype = elgg_get_friendly_title(get_input('pagetype')); // the pagetype e.g about, terms, etc. - default to "mainpage"

// Build the page content
$title = elgg_echo('cmspages');

$body = '';
$template = <<<TEMPLATE
 {{bandeau}} Test après bandeau{{listing-blog}} Après liste des articles
TEMPLATE;

echo cmspages_render_template($template);

