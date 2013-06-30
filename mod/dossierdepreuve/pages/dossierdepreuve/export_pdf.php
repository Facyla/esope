<?php
/**
 * Elgg dossierdepreuve dossier export page
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

global $CONFIG;
dossierdepreuve_gatekeeper();

$dossierdepreuve_guid = (int) get_input('guid', false);
$embed = get_input('embed', false);
$generator = get_input('generator', 'mpdf');

// Si on a un GUID, on regarde si le dossier est valide
if ($dossierdepreuve_guid && ($dossierdepreuve = get_entity($dossierdepreuve_guid))) {
	if (!($dossierdepreuve = get_entity($dossierdepreuve_guid))) {
		register_error(elgg_echo('dossierdepreuve:error:invalid'));
		forward(REFERRER);
	}
}

// Si on n'a pas de GUID ou si le dossier est invalide, c'est terminé
if (!elgg_instanceof($dossierdepreuve, 'object', 'dossierdepreuve')) {
	register_error(elgg_echo('dossierdepreuve:error:invalid'));
	forward(REFERRER);
}

// Si on a un dossier, il faut encore vérifier qu'on peut l'éditer..
if (!($dossierdepreuve->canEdit())) {
	register_error(elgg_echo('dossierdepreuve:error:cantedit'));
	forward(REFERRER);
}


// Set the page owner
$page_owner = $dossierdepreuve->getOwnerEntity();
elgg_set_page_owner_guid($page_owner->guid);

// Get the dossierdepreuve exported content
set_input('type', 'html');
$title = elgg_view_title(elgg_echo('dossierdepreuve:export', array($page_owner->name)));
$html = elgg_view("dossierdepreuve/export",array('entity' => $dossierdepreuve));

// Useful PDF generation vars
$separator = '<hr /><br /><br />';
$date_format = 'd/m/Y';
$gen_date_format = 'd/m/Y à H:i';

// Load CSS files
$css = '';
$css_files = elgg_get_loaded_css();
foreach ($css_files as $css_file) { $css .= file_get_contents($css_file) . "\n"; }
$css .= elgg_get_plugin_setting('css', 'adf_public_platform');


// Titre du PDF
$pdf_title = $dossierdepreuve->title;

// Conteneur et auteur
if (!empty($dossierdepreuve->owner_guid)) $owner = get_entity($dossierdepreuve->owner_guid);
if (!empty($dossierdepreuve->container_guid)) $container = get_entity($dossierdepreuve->container_guid);

// Nom de l'auteur du PDF
$pdf_author = $CONFIG->site->name;
$pdf_author .= ' - ' . $container->name;
$pdf_author .= ' - ' . $owner->name;

// Nom du fichier exporté (unique et daté)
$pdf_filename = $guid . '_' . elgg_get_friendly_title($pdf_title) . '_' . date('YmdHis', time()) . '.pdf';


// Différent si dans groupe ou à titre personnel (portfolio)
if ($container instanceof ElggGroup) {
	$intro .= elgg_echo('pdfexport:publishedin') . '<a href="' . $container->getURL() . '">' . $container->name . '</a>';
	//$intro .= ' le ' . date('d/m/Y à H:i', $dossierdepreuve->time_created);
	$intro .= elgg_echo('pdfexport:publisheddate') . date($date_format, $dossierdepreuve->time_created);
	if ($dossierdepreuve->time_updated > $dossierdepreuve->time_created) $intro .= ' (dernière mise à jour le ' . date($date_format, $dossierdepreuve->time_updated) . ')';
} else {
	$intro .= elgg_echo('pdfexport:publishedby') . '<a href="' . $owner->getURL() . '">' . $owner->name . '</a> ';
	$intro .= elgg_echo('pdfexport:publisheddate') . date($date_format, $dossierdepreuve->time_created);
	if ($dossierdepreuve->time_updated > $dossierdepreuve->time_created) $intro .= ' (dernière mise à jour le ' . date($date_format, $dossierdepreuve->time_updated) . ')';
}
$intro .= '<br />';
if (!empty($dossierdepreuve->tags)) $intro .= 'Tags : ' . elgg_view('output/tags', array('tags' => $dossierdepreuve->tags)) . '<br />';

// Compléments pour l'entête
$intro .= '<a href="' . $dossierdepreuve->getURL() . '">' . $dossierdepreuve->getURL() . '</a><br />';
$intro .= elgg_echo('pdfexport:generated') . date($gen_date_format, time()) . '<br />';

// Composition du contenu final
$html = '<em>' . $intro . '</em>' . $separator . $html;


// Infos utiles à rendre disponibles pour l'export
set_input('html', $html);
set_input('header', $intro);
set_input('css', $css);
set_input('filename', $pdf_filename);

$pdf_export_url = elgg_get_plugins_path() . 'pdf_export/pages/pdf_export/';
switch($generator) {
	case 'mpdf':
		include($pdf_export_url . 'mpdf_export.php');
		break;
	
	case 'dompdf':
		include($pdf_export_url . 'dompdf_export.php');
		break;
	
	case 'html2fpdf':
		include($pdf_export_url . 'html2fpdf_export.php');
		break;
	
	case 'cpdf':
		include($pdf_export_url . 'cpdf_export.php');
		break;
	
	case 'tcpdf':
	default:
		include($pdf_export_url . 'tcpdf_export.php');
}


