<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

date_default_timezone_set('UTC');
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');

Autoloader::register();
Settings::loadConfig();

// Set writers
//$writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html', 'PDF' => 'pdf');
$writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html');

$format_opt = array_flip($writers);
$yn_opt = array('yes' => 'Yes', 'no' => 'No (save information)');

$title = elgg_echo('phpoffice:word:title') . " - Header and Footer";

elgg_push_breadcrumb(elgg_echo('phpoffice'), 'phpoffice');
elgg_push_breadcrumb(elgg_echo('phpoffice:word'), 'phpoffice/word');
//elgg_push_breadcrumb($title);


$sidebar = "";
$content = '';

// Main form vars
$export = get_input('export', false);
$format = get_input('format', 'docx');
if (!in_array($format, $writers)) { $format = 'docx'; }

// File generation input data
$html = '<h1>Adding element via HTML</h1>';
$html .= '<p>Some well formed HTML snippet needs to be used</p>';
$html .= '<p>With for example <strong>some<sup>1</sup> <em>inline</em> formatting</strong><sub>1</sub></p>';
$html .= '<p>Unordered (bulleted) list:</p>';
$html .= '<ul><li>Item 1</li><li>Item 2</li><ul><li>Item 2.1</li><li>Item 2.1</li></ul></ul>';
$html .= '<p>Ordered (numbered) list:</p>';
$html .= '<ol><li>Item 1</li><li>Item 2</li></ol>';
$text_content = get_input('text_content', $html);

$base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPWord/samples/';
// Elgg data file path
$file_path = phpoffice_filepath();


if ($export == 'yes') {
	$filename = 'sample'; // the write function handles the filepath and extension
	$file = $file_path . $filename . '.' . $format; // Export requires a full file path
	
	// New Word document
	$content .= date('H:i:s') . '  Create new PhpWord object' . EOL;

	$phpWord = new \PhpOffice\PhpWord\PhpWord();

	// New portrait section
	$section = $phpWord->addSection();

	// Add first page header
	$header = $section->addHeader();
	$header->firstPage();
	$table = $header->addTable();
	$table->addRow();
	$cell = $table->addCell(4500);
	$textrun = $cell->addTextRun();
	$textrun->addText(htmlspecialchars('This is the header with '));
	$textrun->addLink('http://google.com', htmlspecialchars('link to Google'));
	$table->addCell(4500)->addImage(
		  elgg_get_plugins_path() . 'phpoffice/graphics/phpword.png',
		  array('width' => 80, 'height' => 80, 'align' => 'right')
	);

	// Add header for all other pages
	$subsequent = $section->addHeader();
	$subsequent->addText(htmlspecialchars('Subsequent pages in Section 1 will Have this!'));
	$subsequent->addImage(elgg_get_plugins_path() . 'phpoffice/graphics/phpword.png', array('width' => 80, 'height' => 80));

	// Add footer
	$footer = $section->addFooter();
	$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.'), null, array('align' => 'center'));
	$footer->addLink('http://google.com', htmlspecialchars('Direct Google'));

	// Write some text
	$section->addTextBreak();
	$section->addText(htmlspecialchars('Some text...'));

	// Create a second page
	$section->addPageBreak();

	// Write some text
	$section->addTextBreak();
	$section->addText(htmlspecialchars('Some text...'));

	// Create a third page
	$section->addPageBreak();

	// Write some text
	$section->addTextBreak();
	$section->addText(htmlspecialchars('Some text...'));

	// New portrait section
	$section2 = $phpWord->addSection();

	$sec2Header = $section2->addHeader();
	$sec2Header->addText(htmlspecialchars('All pages in Section 2 will Have this!'));

	// Write some text
	$section2->addTextBreak();
	$section2->addText(htmlspecialchars('Some text...'));
	
	
	// @TODO check existing generated file and updates
	// @TODO should also mark the Elgg object with a lastgenerated timestamp (for each format) to avoid generating new files if content has not changed
	$file_exists = false;
	
	
	if (!$file_exists) {
		// GENERATE FILES
		phpoffice_write_word($phpWord, $filename, $writers);
	}
	
	// Download file
	// fix for IE https issue
	header("Pragma: public");
	if ($format == 'docx') {
		header("Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
	} else if ($format == 'odt') {
		header("Content-type: application/vnd.oasis.opendocument.text");
	} else if ($format == 'rtf') {
		header("Content-type: application/rtf");
	} else if ($format == 'html') {
		header("Content-type: text/html");
	} else if ($format == 'pdf') {
		header("Content-type: application/pdf");
	}
	header("Content-Disposition: attachment; filename=\"$filename.$format\"");
	//header("Expires: " . date("r", time()));
	//header("Cache-Control: no-cache");
	header("Content-Length: " . filesize($file));
	while (ob_get_level()) { ob_end_clean(); }
	flush();
	readfile($file);
	exit;
	
} else {
	// Instructions
	$content .= '<p>Documents can be generated from rich content.</p>';
	
	// Content form to generate the presentation
	$content .= '<form method="POST">';
	$content .= '<p><label>Content' . elgg_view('input/longtext', array('name' => 'text_content')) . '</label></p>';
	$content .= '<p><label>Download file' . elgg_view('input/select', array('name' => 'export', 'options_values' => $yn_opt)) . '</label></p>';
	$content .= '<p><label>Export format' . elgg_view('input/select', array('name' => 'format', 'options_values' => $format_opt)) . '</label></p>';
	$content .= '<p>' . elgg_view('input/submit', array('value' => "Generate document")) . '</p>';
	$content .= '</form>';
}



// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

