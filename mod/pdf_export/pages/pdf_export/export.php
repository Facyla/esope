<?php
/**
 * Generates a PDF file from input data
 * This file is a wrapper for various PDF libraries :
 * it collects input data and send them to appropriate export wrappers
 * @author Facyla ~ Florian DANIEL
 */

global $CONFIG;

$debug = get_input('debug', false);

$error = false;
$html = '';
$intro = '';
$separator = elgg_echo('pdfexport:separator');
$date_format = elgg_echo('pdfexport:entitydate:format');
$gen_date_format = elgg_echo('pdfexport:generated:format');

// Handle untranslated languages case (set defaults, should not be empty)
if (empty($separator)) { $separator = '<hr /><br /><br />'; }
if (empty($date_format)) { $date_format = 'd/m/Y'; }
if (empty($gen_date_format)) { $gen_date_format = 'd/m/Y \a\t H:i'; }


// Get input data
// Si une URL de récupération des données HTML est fournie, on l'utilise
$export_html = get_input('export_html', false);
if (!empty($export_html)) {
	$html = file_get_contents($export_html);
}
// Sinon on prend les autres modes de récupération de données
$guid = get_input('guid', false);
$embed = get_input('embed', false);
$generator = get_input('generator', 'mpdf');

// Load CSS files
$css = '';
$css_files = elgg_get_loaded_css();
foreach ($css_files as $css_file) { $css .= file_get_contents($css_file) . "\n"; }

// Disable intro text if asked in setttings (default: no = keep intro)
$disableintro = elgg_get_plugin_setting('disableintro', 'pdf_export');


// Generate page content (exception for TCPDF, needs some rewriting before using such inputs)
if ($guid && ($object = get_entity($guid)) && ($generator != 'tcpdf') ) {
	
	// Titre pour nom de fichier et dans le texte
	$pdf_title = $object->title;
	if (empty($pdf_title)) $pdf_title = $object->name;
	if (empty($pdf_title)) $pdf_title = elgg_echo('untitled');
	// Conteneur et auteur
	if (!empty($object->owner_guid)) $owner = get_entity($object->owner_guid);
	if (!empty($object->container_guid)) $container = get_entity($object->container_guid);
	//if (!empty($object->site_guid)) $site = get_entity($object->site_guid);
	// Nom de l'auteur du PDF
	$pdf_author = $CONFIG->site->name;
	$pdf_author .= ' - ' . $container->name;
	if ($owner->name != $container->name) { $pdf_author .= ' - ' . $owner->name; }
	// Autres données utiles
	/*
	$pdf_subject = $pdf_title;
	if (is_array($object->tags)) $pdf_tags = $CONFIG->site->name . ', ' . implode(', ', $object->tags);
	else if (!empty($object->tags)) $pdf_tags = $CONFIG->site->name . ', ' . $object->tags;
	else $pdf_tags = $CONFIG->site->name;
	*/
	// Nom du fichier exporté (unique et daté)
	$pdf_filename = $guid . '_' . elgg_get_friendly_title($pdf_title) . '_' . date('YmdHis', time()) . '.pdf';
	
	
	// Page content : intro + html
	if ($object instanceof ElggObject) {
		
		// INTRO - if not disabled
		if ($disableintro != 'yes') {
			// Différent si dans groupe ou à titre personnel (portfolio)
			if ($container instanceof ElggGroup) {
				$intro .= elgg_echo('pdfexport:publishedin') . '<a href="' . $container->getURL() . '">' . $container->name . '</a>';
				//$intro .= ' le ' . date('d/m/Y à H:i', $object->time_created);
				$intro .= elgg_echo('pdfexport:publisheddate') . date($date_format, $object->time_created);
				if ($object->time_updated > $object->time_created) $intro .= ' (' . elgg_echo('pdfexport:lastupdated') . date($date_format, $object->time_updated) . ')';
			} else {
				$intro .= elgg_echo('pdfexport:publishedby') . '<a href="' . $owner->getURL() . '">' . $owner->name . '</a> ';
				$intro .= elgg_echo('pdfexport:publisheddate') . date($date_format, $object->time_created);
				if ($object->time_updated > $object->time_created) $intro .= ' (' . elgg_echo('pdfexport:lastupdated') . date($date_format, $object->time_updated) . ')';
			}
			$intro .= '<br />';
			if (!empty($object->tags)) $intro .= elgg_echo('pdfexport:tags') . ': ' . elgg_view('output/tags', array('tags' => $object->tags)) . '<br />';
		}
		
		// HTML content
		$html .= elgg_view_title($pdf_title);
		$html .= elgg_view('output/longtext', array('value' => $object->description));
		
	} else if ($object instanceof ElggUser) {
		$error = true;
		$body = elgg_echo('pdfexport:error:user');
		$html .= elgg_view_title($pdf_title);
		$html .= elgg_view_entity($object, false, false); // guid, full, bypass override
		
	} else if ($object instanceof ElggGroup) {
		$error = true;
		$body = elgg_echo('pdfexport:error:group');
		$html .= elgg_view_title($pdf_title);
		$html .= elgg_view_entity($object, false, false); // guid, full, bypass override
		
	} else if ($object instanceof ElggSite) {
		$error = true;
		$body = elgg_echo('pdfexport:error:site');
		$html .= elgg_view_title($pdf_title);
		$html .= elgg_view_entity($object, false, false); // guid, full, bypass override
		
	} else {
		$error = true;
		$body = elgg_echo('pdfexport:error:badtype');
	}
	
	// Complément pour l'entête - si non désactivé
	if ($disableintro != 'yes') {
		$intro .= '<a href="' . $object->getURL() . '">' . $object->getURL() . '</a><br />';
		$intro .= elgg_echo('pdfexport:generated') . date($gen_date_format, time()) . '<br />';
		// Composition du contenu
		$html = '<em>' . $intro . '</em>' . $separator . $html;
	}
	
} else {
	if (!empty($html)) {
		if ($disableintro != 'yes') {
			$intro .= elgg_echo('pdfexport:externalhtml');
		}
		$pdf_title = get_input('title');
		// Nom du fichier exporté (daté)
		$pdf_filename = date('YmdHis', time()) . '_' . elgg_get_friendly_title($pdf_title) . '.pdf';
	} else if ($generator != 'tcpdf') {
		$error = true;
		$body .= elgg_echo('pdfexport:error:guid');
	}
}


// Provides useful info for debugging
if ($debug) {
	echo '<h2>FILENAME</h2>' . nl2br(htmlentities($pdf_filename)) . '<hr />';
	echo '<h2>INTRO</h2>' . nl2br(htmlentities($intro)) . '<hr />';
	echo '<h2>CSS</h2>' . nl2br(htmlentities($css)) . '<hr />';
	echo '<h2>HTML</h2>' . nl2br(htmlentities($html)) . '<hr />';
	exit;
}


// Generate the PDF
if (!$error) {
	// Infos utiles à rendre disponibles pour l'export
	set_input('html', $html);
	set_input('header', $intro);
	//set_input('css_url', $css_url);
	set_input('css', $css);
	set_input('filename', $pdf_filename);
	
	switch($generator) {
		case 'mpdf':
			include('mpdf_export.php');
			break;
		
		case 'dompdf':
			include('dompdf_export.php');
			break;
		
		case 'html2fpdf':
			include('html2fpdf_export.php');
			break;
		
		case 'cpdf':
			include('cpdf_export.php');
			break;
		
		case 'tcpdf':
		default:
			include('tcpdf_export.php');
	}
}

