<?php
/**
* Elgg read CMS page
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
define('cmspage', true);
global $CONFIG;

//gatekeeper();

$pagetype = get_input('pagetype', false);
$embed = get_input('embed', false);

if (!$pagetype) {
	// $body = elgg_echo('cmspages:notset');
	register_error(elgg_echo('cmspages:notset'));
	forward();
}
	
// Get entity
$options = array('metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1);
$cmspages = elgg_get_entities_from_metadata($options);
if ($cmspages) $cmspage = $cmspages[0];

// Set title
$title = $pagetype;
if ($cmspage->pagetitle) { $title = $cmspage->pagetitle; }
$page_title = $CONFIG->sitename . ' (' . $CONFIG->url . ') - ' . $title;
$vars['title'] = $page_title;


// Return full embed, for external use (we need CSS as well then)
if ($embed) {
	// Page headers : tell at least it's UTF-8
	header('Content-Type: text/html; charset=utf-8');
	$content = elgg_view('cmspages/view', array('pagetype' => $pagetype, 'entity' => $cmspage));
	
	// Full embed, for external use (so we need CSS as well then)
	if ($embed == 'full') {
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
		<head>
			<title><?php echo $page_title; ?></title>
			<?php echo elgg_view('page/elements/head', $vars); ?>
			<style>
			html, body { background:#FFFFFF !important; }
			</style>
		</head>
		<body>
			<div style="padding:0 4px;">
				<?php echo $content; ?>
			</div>
		</body>
		</html>
		<?php
		exit();
	}
	
	// Other embed = for use in Elgg (lightbox...)
	echo $content;
	exit;
}

// Full page mode : read view
// Note : cmspages/view view should return description only (and other elements should be hidden), 
// as it's designed for inclusion into other views
// Make breadcrumb clickable only if admin
if (elgg_is_admin_logged_in()) {
	elgg_push_breadcrumb(elgg_echo('cmspages'), 'cmspages');
} else {
	elgg_push_breadcrumb(elgg_echo('cmspages'));
}
elgg_push_breadcrumb($title);
// cmspages/read may render more content
$body = elgg_view('cmspages/read', array('pagetype' => $pagetype, 'entity' => $cmspage));
// Note : some plugins (such as metatags) rely on a defined title, so we need to set it
$CONFIG->title = $page_title;


// Display page
echo elgg_view_page($title, $body);

