<?php
//============================================================+
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates a PDF document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */


require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php");
global $CONFIG;

$html = get_input('html', false);
$header = get_input('header', '');
$css_url = get_input('css_url', false);
$css = get_input('css', false);
$filename = get_input('filename');

// @TODO : needs some rewriting, as we now use a generator switcher to prepare content
$body = '';
$error = false;
$separator = '<hr /><br /><br />';

$html = '';
/* @TODO : Ne marche pas en l'état...
if ($css) {
	//$html .= '<style>' . $css . '</style>';
	$html .= <<<EOF
$css
EOF;
}
*/

$pub_date_format = elgg_echo('pdfexport:entitydate:format');
$gen_date_format = elgg_echo('pdfexport:generated:format');


// Get input data
$guid = get_input('guid', false);

if ($guid && ($object = get_entity($guid)) ) {

  // Ne doit pas être trop long (pas de retour à la ligne)
  /*
  $pdf_header_title = 'Export PDF de ' . $guid;
  */
  $pdf_header_title = '';
  $pdf_header_string = '';
  $pdf_header_logo = '';
  $pdf_header_logo_width = '';
  
  // Titre pour nom de fichier et dans le texte
  $pdf_title = $object->title;
  if (empty($pdf_title)) $pdf_title = $object->name;
  if (empty($pdf_title)) $pdf_title = elgg_echo('untitled');
  
  if (!empty($object->owner_guid)) $owner = get_entity($object->owner_guid);
  if (!empty($object->container_guid)) $container = get_entity($object->container_guid);
  if (!empty($object->site_guid)) $owner = get_entity($object->site_guid);
  
  $pdf_author = 'FormaVia';
  $pdf_author .= ' - ' . $site->name;
  $pdf_author .= ' - ' . $container->name;
  
  $pdf_subject = $pdf_title;
  if (is_array($object->tags)) $pdf_tags = 'FormaVia, ' . implode(', ', $object->tags);
  else if (!empty($object->tags)) $pdf_tags = 'FormaVia, ' . $object->tags;
  else $pdf_tags = 'FormaVia';
  
  $pdf_filename = $guid . '_' . elgg_get_friendly_title($pdf_title) . '_' . date('YmdHis', time()) . '.pdf';
  
  $intro .= '<a href="' . $object->getURL() . '">' . $object->getURL() . '</a><br />';
  
  // Page content
  if ($object instanceof ElggObject) {
    // Différent si dans groupe ou à titre personnel (portfolio)
    if ($container instanceof ElggGroup) {
      $intro .= elgg_echo('pdfexport:publishedin') . '<a href="' . $container->getURL() . '">' . $container->name . '</a>';
      //$intro .= ' le ' . date('d/m/Y à H:i', $object->time_created);
      $intro .= elgg_echo('pdfexport:publisheddate') . date($pub_date_format, $object->time_created);
      if ($object->time_updated > $object->time_created) $intro .= ' (dernière mise à jour le ' . date($pub_date_format, $object->time_updated) . ')';
    } else {
      $intro .= elgg_echo('pdfexport:publishedby') . '<a href="' . $owner->getURL() . '">' . $owner->name . '</a>';
      $intro .= elgg_echo('pdfexport:publisheddate') . date($pub_date_format, $object->time_created);
      if ($object->time_updated > $object->time_created) $intro .= ' (dernière mise à jour le ' . date($pub_date_format, $object->time_updated) . ')';
    }
    $intro .= '<br />';
    if (!empty($object->tags)) $intro .= 'Tags : ' . elgg_view('output/tags', array('tags' => $object->tags)) . '<br />';
    $html .= elgg_view_title($pdf_title);
    $html .= $object->description;
    
  } else if ($object instanceof ElggUser) {
    $error = true; $body = elgg_echo('pdfexport:error:user');
    $html .= elgg_view_title($pdf_title);
    $html .= elgg_view_entity($object, false, false); // guid, full, bypass override
    
  } else if ($object instanceof ElggGroup) {
    $error = true; $body = elgg_echo('pdfexport:error:group');
    $html .= elgg_view_title($pdf_title);
    $html .= elgg_view_entity($object, false, false); // guid, full, bypass override
    
  } else if ($object instanceof ElggSite) {
    $error = true; $body = elgg_echo('pdfexport:error:site');
    $html .= elgg_view_title($pdf_title);
    $html .= elgg_view_entity($object, false, false); // guid, full, bypass override
    
  } else {
    $error = true; $body = elgg_echo('pdfexport:error:badtype');
  }
  
  $intro .= elgg_echo('pdfexport:generated') . date($gen_date_format, time()) . '<br />';
  $html = '<em>' . $intro . '</em>' . $separator . $html;
  
} else {
  $error = true;
  $body .= elgg_echo('pdfexport:error:guid');
}


if (!$error) {
  $tcpdf_lib = dirname(dirname(dirname(__FILE__))) . '/assets/tcpdf/';
  pdf_export_get_config();
  require_once($tcpdf_lib . 'tcpdf.php');
  
  //if (empty($pdf_header_title)) $pdf_header_title = PDF_HEADER_TITLE;
  //if (empty($pdf_header_string)) $pdf_header_string = PDF_HEADER_STRING;
  if (empty($pdf_header_logo)) $pdf_header_logo = PDF_HEADER_LOGO;
  if (empty($pdf_header_logo_width)) $pdf_header_logo_width = PDF_HEADER_LOGO_WIDTH;
  
  // create new PDF document
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor($pdf_author);
  $pdf->SetTitle($pdf_header_title);
  $pdf->SetSubject($pdf_subject);
  $pdf->SetKeywords($pdf_tags);

  // set default header data
  //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
  $pdf->SetHeaderData($pdf_header_logo, $pdf_header_logo_width, $pdf_header_title, $pdf_header_string);
  
  // set default footer data
  //$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  //set margins
  // Marges globales (header affichés dans marge top)
  //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  //set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  //set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  //set some language-dependent strings
  $pdf->setLanguageArray($l);

  // ---------------------------------------------------------
  // set font
  $pdf->SetFont('dejavusans', '', 10);
  
  // add a page
  $pdf->AddPage();

  // output the HTML content
  $pdf->writeHTML($html, true, false, true, false, '');

  // reset pointer to the last page
  $pdf->lastPage();

  // ---------------------------------------------------------
  //Close and output PDF document
  $pdf->Output($pdf_filename, 'I');
  
}

if ($error) {
  ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>FormaVia - Export PDF</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
  <?php echo $body; ?>
</body>
</html>
  <?php  
}

