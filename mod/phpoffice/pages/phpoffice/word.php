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

$title = elgg_echo('phpoffice:word:title');

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
	
	$phpWord = new \PhpOffice\PhpWord\PhpWord();

	$section = $phpWord->addSection();
	\PhpOffice\PhpWord\Shared\Html::addHtml($section, $text_content);
	
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



$content .= '<h3>Samples (not working but useful code examples)</h3>';

$samples = array('Sample_01_SimpleText.php', 'Sample_02_TabStops.php', 'Sample_03_Sections.php', 'Sample_04_Textrun.php', 'Sample_05_Multicolumn.php', 'Sample_06_Footnote.php', 'Sample_07_TemplateCloneRow.php', 'Sample_08_ParagraphPagination.php', 'Sample_09_Tables.php', 'Sample_10_EastAsianFontStyle.php', 'Sample_11_ReadWord2007.php', 'Sample_11_ReadWord97.php', 'Sample_12_HeaderFooter.php', 'Sample_13_Images.php', 'Sample_14_ListItem.php', 'Sample_15_Link.php', 'Sample_16_Object.php', 'Sample_17_TitleTOC.php', 'Sample_18_Watermark.php', 'Sample_19_TextBreak.php', 'Sample_20_BGColor.php', 'Sample_21_TableRowRules.php', 'Sample_22_CheckBox.php', 'Sample_23_TemplateBlock.php', 'Sample_24_ReadODText.php', 'Sample_25_TextBox.php', 'Sample_26_Html.php', 'Sample_27_Field.php', 'Sample_28_ReadRTF.php', 'Sample_29_Line.php', 'Sample_30_ReadHTML.php', 'Sample_31_Shape.php', 'Sample_32_Chart.php', 'Sample_33_FormField.php', 'Sample_34_SDT.php', 'Sample_35_InternalLink.php', 'Sample_36_RTL.php', 'Sample_Footer.php', 'Sample_Header.php');

$content .= '<ul>';
foreach($samples as $sample) {
	$content .= '<li><a href="' . elgg_get_site_url() . 'phpoffice/word/' . $sample . '">' . $sample . '</a></li>';
}
$content .= '</ul>';


// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

