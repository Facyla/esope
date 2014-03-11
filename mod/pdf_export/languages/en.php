<?php
$english = array(
	
	'pdfexport'	=>	"PDF export",
	'pdfexport:download:alt' => "Download as PDF",
	'pdfexport:download:title' => "Download this content as a PDF file",
	
	// PDF introduction header
	'pdfexport:separator' => "<hr /><br /><br />",
	'pdfexport:publishedby' => "Published by ",
	'pdfexport:publishedin' => "Published in ",
	'pdfexport:publisheddate' => "on ",
	'pdfexport:generated' => "Page generated on ",
	'pdfexport:generated:format' => "d/m/Y at H:i",
	'pdfexport:entitydate:format' => "d/m/Y",
	'pdfexport:lastupdated' => "last updated on ",
	'pdfexport:tags' => "Tags",
	
	// Errors
	'pdfexport:externalhtml' => "Page generated from an external content",
	'pdfexport:error:guid' => "No page to export, or invalid GUID",
	'pdfexport:error:badtype' => "Cannot export this type of entity",
	'pdfexport:error:user' => "Cannot export site members.",
	'pdfexport:error:group' => "Cannot export groups.",
	'pdfexport:error:site' => "Cannot export sites.",
	
	// Settings
	'pdf_export:disableintro' => "Disable metadata block on exported PDF (default: no, as it provides useful information on exported page content)",
	'pdf_export:validsubtypes' => "Content types (subtypes) for which  PDF export is enabled. Clear list to restore default values.",
	'pdf_export:validsubtypes:default' => "Default list: %s",
	
);

add_translation('en', $english);

