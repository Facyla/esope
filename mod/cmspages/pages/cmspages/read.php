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

$pagetype = get_input('pagetype');
$embed = get_input('embed', false);


if ($pagetype) {
	
	// Get entity
	$options = array('metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage', 'limit' => 1);
	$cmspages = elgg_get_entities_from_metadata($options);
	if ($cmspages) $cmspage = $cmspages[0];
	
	// Set title
	if ($cmspage->title) $title = $cmspage->title; else $title = $pagetype;
	$title = $CONFIG->sitename . ' (' . $CONFIG->url . ') - ' . $title;
	$vars['title'] = $title;
	
	
	// Return full embed, for external use (we need CSS as well then)
	if ($embed == 'full') {
		// Display page
		// Send page headers : tell at least it's UTF-8
		header('Content-Type: text/html; charset=utf-8');
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
		<head>
			<title><?php echo $title; ?></title>
			<?php echo elgg_view('page/elements/head', $vars); ?>
			<style>
			html, body { background:#FFFFFF !important; }
			</style>
		</head>
		<body>
			<div style="padding:0 4px;">
				<?php echo elgg_view('cmspages/view', array('pagetype' => $pagetype, 'entity' => $cmspage)); ?>
			</div>
		</body>
		</html>
		<?php
		exit();
	}
	
	// Other embed = for use in Elgg (lightbox...)
	if ($embed) {
		header('Content-Type: text/html; charset=utf-8');
		echo elgg_view('cmspages/view', array('pagetype' => $pagetype, 'entity' => $cmspage));
		exit;
	}
	
	// Full page mode
	// cmspages/view view should return description only (and other elements should be hidden), as it's designed for inclusion into other views
	// cmspages/read may render more content
	$body = elgg_view('cmspages/read', array('pagetype' => $pagetype, 'entity' => $cmspage));
	// Note : plugins like metatags rely on a defined title, so we need to set it
	$CONFIG->title = $title;
	
} else {
	// $body = elgg_echo('cmspages:notset');
	register_error(elgg_echo('cmspages:notset'));
	forward();
}


// Display page
echo elgg_view_page($title, $body);

