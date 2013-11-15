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

$pagetype = 'homepage-public';
$lang = $CONFIG->language;

if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('adf_platform:cmspages:notactivated')); }

// Return full embed, for external use (we need CSS as well then)
// Display page
// Send page headers : tell at least it's UTF-8
$title = $CONFIG->sitename . ' (' . $CONFIG->url . ')';
$vars['title'] = $title;
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
	<title><?php echo $title; ?></title>
	<?php
	echo elgg_view('page/elements/head', $vars);
	// Note : CSS et JS à n'ajouter que si on peut les désactiver via la config de la vue cmspages
	// Ajout des feuilles de style personnalisées
	//if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
	// Ajout des JS personnalisés
	//if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";
	?>
</head>
<body>
	<div id="<?php echo $pagetype; ?>">
		<?php echo elgg_view('cmspages/view', array('pagetype' => $pagetype)); ?>
	</div>
</body>
</html>

