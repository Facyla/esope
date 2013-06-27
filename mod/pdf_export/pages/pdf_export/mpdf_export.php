<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php");
global $CONFIG;

$html = get_input('html', false);
$header = get_input('header', '');
$css_url = get_input('css_url', false);
$css = get_input('css', false);
$embed = get_input('embed', false);
$filename = get_input('filename', date('YmdHis', time()) . 'pdf');
if (empty($filename)) { $filename = date('YmdHis', time()) . 'pdf'; }

//==============================================================
//==============================================================
//==============================================================
// Note : change default temp folder
/*
define("_MPDF_TEMP_PATH", elgg_get_data_path() . 'pdf_export_mpdf_tmp/');
define("_MPDF_TTFONTDATAPATH", elgg_get_data_path() . 'pdf_export_mpdf_ttfontdata/');
*/
include($CONFIG->pluginspath .  'pdf_export/assets/mpdf/mpdf.php');

// Basic doc : mPDF( Charset, Format (A4), Default font size (0), Default font (''), Margin left, Margin right, Margin top, Margin bottom, Margin header (9), Margin footer (9),Orientation(P/L) )
//$mpdf=new mPDF('en-GB-x','A4','','',5,5,5,5,0,0);
//$mpdf=new mPDF('fr-FR-x','A4','','',5,5,5,5,0,0);
$mpdf=new mPDF('fr-FR-x','A4','','',10,10,10,10,0,0,'P');

// Use different Odd/Even headers and footers and mirror margins (1 or 0)
$mpdf->mirrorMargins = 1;

$mpdf->SetDisplayMode('fullpage','two');

// LOAD a stylesheet
if ($css) $stylesheet = $css;
else if ($css_url) $stylesheet = file_get_contents($css_url);
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

// $filename, $dest (true/false) = exporter fichier ou embed
if ($embed) $mpdf->Output('', ''); // Il ne faut PAS de nom de fichier si on embedde dans la page
else $mpdf->Output($filename, true); // Par défaut on exporte le fichier produit

exit;
//==============================================================
//==============================================================

