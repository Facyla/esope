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

gatekeeper();

// Facyla : this tool is rather for local admins and webmasters than main admins, so use custom access rights : OK if custom rights match, or use default behaviour
if (in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) {
} else {
  admin_gatekeeper();
}


$pagetype = elgg_get_friendly_title(get_input('pagetype')); // the pagetype e.g about, terms, etc. - default to "mainpage"

// Build the page content
//$title = elgg_echo('cmspages');
//elgg_set_page_owner_guid($_SESSION['guid']); // Set admin user for owner block
elgg_set_page_owner_guid(1);
$menu = elgg_view('cmspages/menu', array('pagetype' => $pagetype));
$edit = elgg_view('cmspages/forms/edit', array('pagetype' => $pagetype));
//$body = elgg_view('page/elements/wrapper', array('body' => $menu . $edit));
$body = $menu . $edit;

$params = array('content' => elgg_view_title($title).$body, 'sidebar' => '');
$page = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $page);
