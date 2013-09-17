<?php
/**
* Elgg read CMS page
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

// Load Elgg engine
//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
define('cmspage', true);
global $CONFIG;

//gatekeeper();

$pagetype = get_input('pagetype');
$embed = get_input('embed', false);

if($pagetype) {
	
	// Return full embed, for external use (we need CSS as well then)
	if ($embed == 'full') {
		// Display page
		// Send page headers : tell at least it's UTF-8
		$title = $CONFIG->sitename . ' (' . $CONFIG->url . ') - CMSPages: ' . $pagetype;
		$vars['title'] = $title;
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
				<?php echo $body; ?>
			</div>
		</body>
		</html>
		<?php
		exit();
	}
	
	// Return embed for use in Elgg (lightbox...)
	if ($embed) {
		header('Content-Type: text/html; charset=utf-8');
		echo elgg_view('cmspages/view', array('pagetype' => $pagetype));
		exit;
	}
	
	// cmspages/view view should return description only (and other elements should be hidden), as it's designed for inclusion into other views
	// cmspages/read may render more content
	$body = elgg_view('cmspages/read', array('pagetype' => $pagetype));
	
} else {
	// $body = elgg_echo('cmspages:notset');
	register_error(elgg_echo('cmspages:notset'));
	forward();
}

/* Note 20121119 : tout cela n'a plus de sens en v1.8 et hors d'un contexte multisite
// Si externalblog est activé et qu'on a paramétré la prise en compte des layouts choisis, on applique ce layout
// @todo : On anticipe sur la possibilité de choisir divers blocs et le layout via les pages CMS...?
$exbloglayout = elgg_get_plugin_setting('layout', 'cmspages');
$exbloglayout = ($exbloglayout == "exbloglayout") ? true : false;
// Ca ne fonctionne que si externalblog est activé
if ($exbloglayout && elgg_is_active_plugin('externalblog') && ($layout = elgg_get_plugin_setting('layout', 'externalblog'))) {
	
	// On utilise alors les blocs définis via externalblog
	$content = '<div style="padding:5px 20px; margin:0; border:0;">' . $body . '</div>';
	$body = externalblog_layout_switch($content, array('title' => $title));
}
*/


// Display page
echo elgg_view_page($title, $body);

