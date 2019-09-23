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

$title = elgg_echo('phpoffice:word:title') . " - TemplateCloneRow";

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


if ($export == 'yes') {
	$filename = 'sample_templateclonerow'; // the write function handles the filepath and extension
	$file = $file_path . $filename . '.' . $format; // Export requires a full file path
	
	// New Word document
	$content .= date('H:i:s') . '   Creating new TemplateProcessor instance...' . EOL;

	$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('resources/Sample_07_TemplateCloneRow.docx');

	// Variables on different parts of document
	$templateProcessor->setValue('weekday', htmlspecialchars(date('l'))); // On section/content
	$templateProcessor->setValue('time', htmlspecialchars(date('H:i'))); // On footer
	$templateProcessor->setValue('serverName', htmlspecialchars(realpath(__DIR__))); // On header

	// Simple table
	$templateProcessor->cloneRow('rowValue', 10);

	$templateProcessor->setValue('rowValue#1', htmlspecialchars('Sun'));
	$templateProcessor->setValue('rowValue#2', htmlspecialchars('Mercury'));
	$templateProcessor->setValue('rowValue#3', htmlspecialchars('Venus'));
	$templateProcessor->setValue('rowValue#4', htmlspecialchars('Earth'));
	$templateProcessor->setValue('rowValue#5', htmlspecialchars('Mars'));
	$templateProcessor->setValue('rowValue#6', htmlspecialchars('Jupiter'));
	$templateProcessor->setValue('rowValue#7', htmlspecialchars('Saturn'));
	$templateProcessor->setValue('rowValue#8', htmlspecialchars('Uranus'));
	$templateProcessor->setValue('rowValue#9', htmlspecialchars('Neptun'));
	$templateProcessor->setValue('rowValue#10', htmlspecialchars('Pluto'));

	$templateProcessor->setValue('rowNumber#1', htmlspecialchars('1'));
	$templateProcessor->setValue('rowNumber#2', htmlspecialchars('2'));
	$templateProcessor->setValue('rowNumber#3', htmlspecialchars('3'));
	$templateProcessor->setValue('rowNumber#4', htmlspecialchars('4'));
	$templateProcessor->setValue('rowNumber#5', htmlspecialchars('5'));
	$templateProcessor->setValue('rowNumber#6', htmlspecialchars('6'));
	$templateProcessor->setValue('rowNumber#7', htmlspecialchars('7'));
	$templateProcessor->setValue('rowNumber#8', htmlspecialchars('8'));
	$templateProcessor->setValue('rowNumber#9', htmlspecialchars('9'));
	$templateProcessor->setValue('rowNumber#10', htmlspecialchars('10'));

	// Table with a spanned cell
	$templateProcessor->cloneRow('userId', 3);

	$templateProcessor->setValue('userId#1', htmlspecialchars('1'));
	$templateProcessor->setValue('userFirstName#1', htmlspecialchars('James'));
	$templateProcessor->setValue('userName#1', htmlspecialchars('Taylor'));
	$templateProcessor->setValue('userPhone#1', htmlspecialchars('+1 428 889 773'));

	$templateProcessor->setValue('userId#2', htmlspecialchars('2'));
	$templateProcessor->setValue('userFirstName#2', htmlspecialchars('Robert'));
	$templateProcessor->setValue('userName#2', htmlspecialchars('Bell'));
	$templateProcessor->setValue('userPhone#2', htmlspecialchars('+1 428 889 774'));

	$templateProcessor->setValue('userId#3', htmlspecialchars('3'));
	$templateProcessor->setValue('userFirstName#3', htmlspecialchars('Michael'));
	$templateProcessor->setValue('userName#3', htmlspecialchars('Ray'));
	$templateProcessor->setValue('userPhone#3', htmlspecialchars('+1 428 889 775'));

	$content .= date('H:i:s') . ' Saving the result document...' . EOL;
	$templateProcessor->saveAs($filename);

	$content .= getEndingNotes(array('Word2007' => 'docx'));
	
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
