<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/


/* Notes de conception
Section : 1 seule, tout le document est dedans (page de garde + entête et pied de page)
Chapitres et divers éléments structurés pré-remplis
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
$html = '';
$text_content = get_input('text_content', $html);

$base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPWord/samples/';
// Elgg data file path
$file_path = phpoffice_filepath();

$own = elgg_get_logged_in_user_entity();


if ($export == 'yes') {
	// User vars
	$creator = get_input('creator', 'WeePy');
	$creator = get_input('company', 'natural idées,');
	$doctitle = get_input('title', 'EU project title');
	$description = get_input('description', 'This EU project... (full description)');
	$category = get_input('category', 'Deliverable');
	$lasteditor = get_input('lasteditor', $own->name);
	$subject = get_input('subject', 'My subject');
	$keywords = get_input('keywords', 'EU, H2020, project, deliverable, WeePy');
	
	$filename = 'sample'; // the write function handles the filepath and extension
	$file = $file_path . $filename . '.' . $format; // Export requires a full file path
	
	// New Word document
	$content .= date('H:i:s') . '  Create new PhpWord object' . EOL;

	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	
	// Set document properties
	$properties = $phpWord->getDocInfo();
	$properties->setCreator($creator);
	$properties->setCompany($company);
	$properties->setTitle($doctitle);
	$properties->setDescription($description);
	$properties->setCategory($category);
	$properties->setLastModifiedBy($lasteditor);
	$properties->setCreated(time()); // mktime(0, 0, 0, 3, 12, 2014)
	$properties->setModified(time());
	$properties->setSubject($subject);
	$properties->setKeywords($keywords);
	
	
	// Document containers : section, header, footer
	
	// Section 1 : New portrait section
	$section = $phpWord->addSection();

	// Add first page header
	$header = $section->addHeader();
	$header->firstPage();
	$table = $header->addTable();
	$table->addRow();
	$cell = $table->addCell(4500);
	$textrun = $cell->addTextRun();
	$textrun->addText(htmlspecialchars('This is the header with '));
	$textrun->addLink('http://weepy.eu', htmlspecialchars('link to WeePy'));
	$table->addCell(4500)->addImage(
			elgg_get_plugins_path() . 'theme_weepy/graphics/logo_WP.jpg',
			array('width' => 86, 'height' => 73, 'align' => 'right')
		);

	// Add header for all other pages
	$subsequent = $section->addHeader();
	$subsequent->addText(htmlspecialchars('All subsequent pages in Section 1 will Have this header!'));
	$subsequent->addImage(elgg_get_plugins_path() . 'theme_weepy/graphics/logo_WP.jpg', array('width' => 86, 'height' => 73));


	// Add footer (for all pages of this section)
	$footer = $section->addFooter();
	$footer->addPreserveText(htmlspecialchars('Page {PAGE} of {NUMPAGES}.'), null, array('align' => 'center'));
	$footer->addLink('http://weepy.eu', htmlspecialchars('Direct WeePy'));

	// Write some text
	$section->addTextBreak();
	$section->addText(htmlspecialchars('Some text...'));

	// Create a second page
	$section->addPageBreak();

	// Write some text
	$section->addTextBreak();
	$section->addText(htmlspecialchars('Some text on page 2...'));

	// Create a third page
	$section->addPageBreak();

	// Write some text
	$section->addTextBreak();
	$section->addText(htmlspecialchars('Some text on page 3...'));

	// Section 2 : New portrait section
	$section2 = $phpWord->addSection();

	// New section header
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
	$content .= '<p>Deliverable templates can be generated from various input data.</p>';
	
	// Content form to generate the presentation
	$content .= '<form method="POST">';
	$content .= '<p><label>Creator' . elgg_view('input/text', array('name' => 'creator', 'value' => "WeePy consortium")) . '</label></p>';
	$content .= '<p><label>Company' . elgg_view('input/text', array('name' => 'company', 'value' => "natural idées,")) . '</label></p>';
	$content .= '<p><label>Title' . elgg_view('input/text', array('name' => 'title', 'value' => "EU project deliverable")) . '</label></p>';
	$content .= '<p><label>Description' . elgg_view('input/plaintext', array('name' => 'description', 'value' => "This EU project... (full description)")) . '</label></p>';
	$content .= '<p><label>Category' . elgg_view('input/text', array('name' => 'category', 'value' => "Deliverable")) . '</label></p>';
	$content .= '<p><label>Last editor' . elgg_view('input/text', array('name' => 'lasteditor', 'value' => $own->name)) . '</label></p>';
	$content .= '<p><label>Subject' . elgg_view('input/text', array('name' => 'subject', 'value' => "Deliverable subject")) . '</label></p>';
	$content .= '<p><label>Keywords' . elgg_view('input/text', array('name' => 'keywords', 'value' => "EU, H2020, project, deliverable, WeePy")) . '</label></p>';
	
	//$content .= '<p><label>Content' . elgg_view('input/longtext', array('name' => 'text_content')) . '</label></p>';
	$content .= '<p><label>Download file' . elgg_view('input/select', array('name' => 'export', 'options_values' => $yn_opt)) . '</label></p>';
	$content .= '<p><label>Export format' . elgg_view('input/select', array('name' => 'format', 'options_values' => $format_opt)) . '</label></p>';
	$content .= '<p>' . elgg_view('input/submit', array('value' => "Generate document")) . '</p>';
	$content .= '</form>';
}



// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

