<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

use PhpOffice\PhpPresentation\Autoloader;
use PhpOffice\PhpPresentation\Settings;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\AbstractShape;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\Shape\Drawing;
use PhpOffice\PhpPresentation\Shape\MemoryDrawing;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\RichText\BreakElement;
use PhpOffice\PhpPresentation\Shape\RichText\TextElement;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color;


// Set writers
$writers = array('PowerPoint2007' => 'pptx', 'ODPresentation' => 'odp');
$format_opt = array_flip($writers);
$yn_opt = array('yes' => 'Yes', 'no' => 'No (save information)');

$title = elgg_echo('phpoffice:presentation:title');

elgg_push_breadcrumb(elgg_echo('phpoffice'), 'phpoffice');
elgg_push_breadcrumb(elgg_echo('phpoffice:presentation'), 'phpoffice/presentation');
//elgg_push_breadcrumb($title);


$sidebar = "";
$content = '';

$content .= '';


// Main form vars
$export = get_input('export', false);
$format = get_input('format', 'pptx');
if (!in_array($format, $writers)) { $format = 'pptx'; }
// File generation input data
$slide_content = get_input('slide_content', 'Thank you for using PHPPresentation!');

$base = elgg_get_plugins_path() . 'phpoffice/vendors/PHPPresentation/samples/';
// Elgg data file path
$file_path = phpoffice_filepath();


if ($export == 'yes') {
	$report = '';
	// Filename : use both internal failsafe name AND exported name (should be different)
	// @TODO should use a GUID so we can generate files only when changes have been made)
	// @TODO Note : template may have changed meanwhile...
	$internal_filename = 'sample.' . $format;
	$filename = 'sample.' . $format;
	$file = $file_path . $internal_filename;
	
	// @TODO check existing generated file and updates
	// @TODO should also mark the Elgg object with a lastgenerated timestamp (for each format) to avoid generating new files if content has not changed
	$file_exists = false;
	
	
	if (!$file_exists) {
		// Generate a new file
		$objPHPPresentation = new PhpPresentation();
		
		
		// MAIN DOCUMENT PROPERTIES
		$report .= date('H:i:s') . ' Set properties'.EOL;
		$objPHPPresentation->getProperties()->setCreator('PHPOffice')
				->setLastModifiedBy('PHPPresentation Team')
				->setTitle('Sample 02 Title')
				->setSubject('Sample 02 Subject')
				->setDescription('Sample 02 Description')
				->setKeywords('office 2007 openxml libreoffice odt php')
				->setCategory('Sample Category');

		/* SIMPLE EXAMPLE
		// Create slide
		$currentSlide = $objPHPPresentation->getActiveSlide();

		// Create a shape (drawing)
		$shape = $currentSlide->createDrawingShape();
		$shape->setName('PHPPresentation logo')
				->setDescription('PHPPresentation logo')
				->setPath($base . 'resources/phppowerpoint_logo.gif')
				->setHeight(36)
				->setOffsetX(10)
				->setOffsetY(10);
		$shape->getShadow()->setVisible(true)
				->setDirection(45)
				->setDistance(10);

		// Create a shape (text)
		$shape = $currentSlide->createRichTextShape()
				->setHeight(300)
				->setWidth(600)
				->setOffsetX(170)
				->setOffsetY(180);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
		$textRun = $shape->createTextRun($slide_content);
		$textRun->getFont()->setBold(true)
				->setSize(60)
				->setColor( new Color( 'FFE06B20' ) );
		*/
		
		/* COMPLEX EXAMPLE */
		$colorBlack = new Color( 'FF000000' );
		
		// Remove first slide
		$report .= date('H:i:s') . ' Remove first slide'.EOL;
		$objPHPPresentation->removeSlideByIndex(0);

		// Create templated slide
		$report .= date('H:i:s') . ' Create templated slide'.EOL;
		$currentSlide = createTemplatedSlide($objPHPPresentation); // local function

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape();
		$shape->setHeight(200);
		$shape->setWidth(600);
		$shape->setOffsetX(10);
		$shape->setOffsetY(400);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_LEFT );

		$textRun = $shape->createTextRun('Introduction to');
		$textRun->getFont()->setBold(true);
		$textRun->getFont()->setSize(28);
		$textRun->getFont()->setColor($colorBlack);

		$shape->createBreak();

		$textRun = $shape->createTextRun('PHPPresentation');
		$textRun->getFont()->setBold(true);
		$textRun->getFont()->setSize(60);
		$textRun->getFont()->setColor($colorBlack);


		// Create templated slide
		$report .= date('H:i:s') . ' Create templated slide'.EOL;
		$currentSlide = createTemplatedSlide($objPHPPresentation); // local function

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape();
		$shape->setHeight(100)
		->setWidth(930)
		->setOffsetX(10)
		->setOffsetY(50);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

		$textRun = $shape->createTextRun('What is PHPPresentation?');
		$textRun->getFont()->setBold(true)
				     ->setSize(48)
				     ->setColor($colorBlack);

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape()
			->setHeight(600)
			->setWidth(930)
			->setOffsetX(10)
			->setOffsetY(130);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
				                              ->setMarginLeft(25)
				                              ->setIndent(-25);
		$shape->getActiveParagraph()->getFont()->setSize(36)
				                         ->setColor($colorBlack);
		$shape->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_BULLET);

		$shape->createTextRun('A class library');
		$shape->createParagraph()->createTextRun('Written in PHP');
		$shape->createParagraph()->createTextRun('Representing a presentation');
		$shape->createParagraph()->createTextRun('Supports writing to different file formats');


		// Create templated slide
		$report .= date('H:i:s') . ' Create templated slide'.EOL;
		$currentSlide = createTemplatedSlide($objPHPPresentation); // local function

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape()
			->setHeight(100)
			->setWidth(930)
			->setOffsetX(10)
			->setOffsetY(50);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT );

		$textRun = $shape->createTextRun('What\'s the point?');
		$textRun->getFont()->setBold(true)
				     ->setSize(48)
				     ->setColor($colorBlack);

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape();
		$shape->setHeight(600)
		->setWidth(930)
		->setOffsetX(10)
		->setOffsetY(130);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
				                              ->setMarginLeft(25)
				                              ->setIndent(-25);
		$shape->getActiveParagraph()->getFont()->setSize(36)
				                         ->setColor($colorBlack);
		$shape->getActiveParagraph()->getBulletStyle()->setBulletType(Bullet::TYPE_BULLET);

		$shape->createTextRun('Generate slide decks');
		$shape->createParagraph()->getAlignment()->setLevel(1)
				                           ->setMarginLeft(75)
				                           ->setIndent(-25);
		$shape->createTextRun('Represent business data');
		$shape->createParagraph()->createTextRun('Show a family slide show');
		$shape->createParagraph()->createTextRun('...');

		$shape->createParagraph()->getAlignment()->setLevel(0)
				                           ->setMarginLeft(25)
				                           ->setIndent(-25);
		$shape->createTextRun('Export these to different formats');
		$shape->createParagraph()->getAlignment()->setLevel(1)
				                           ->setMarginLeft(75)
				                           ->setIndent(-25);
		$shape->createTextRun('PHPPresentation 2007');
		$shape->createParagraph()->createTextRun('Serialized');
		$shape->createParagraph()->createTextRun('... (more to come) ...');


		// Create templated slide
		$report .= date('H:i:s') . ' Create templated slide'.EOL;
		$currentSlide = createTemplatedSlide($objPHPPresentation); // local function

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape();
		$shape->setHeight(100)
		->setWidth(930)
		->setOffsetX(10)
		->setOffsetY(50);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_LEFT );

		$textRun = $shape->createTextRun('Need more info?');
		$textRun->getFont()->setBold(true)
				     ->setSize(48)
				     ->setColor($colorBlack);

		// Create a shape (text)
		$report .= date('H:i:s') . ' Create a shape (rich text)'.EOL;
		$shape = $currentSlide->createRichTextShape();
		$shape->setHeight(600)
		->setWidth(930)
		->setOffsetX(10)
		->setOffsetY(130);
		$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_LEFT );

		$textRun = $shape->createTextRun('Check the project site on GitHub:');
		$textRun->getFont()->setSize(36)
				     ->setColor($colorBlack);

		$shape->createBreak();

		$textRun = $shape->createTextRun('https://github.com/PHPOffice/PHPPresentation/');
		$textRun->getFont()->setSize(32)
				     ->setColor($colorBlack);
		$textRun->getHyperlink()->setUrl('https://github.com/PHPOffice/PHPPresentation/')
				          ->setTooltip('PHPPresentation');
		
		
		
		// GENERATE PRESENTATION FILES
		if ($format == 'pptx') {
			$oWriterPPTX = IOFactory::createWriter($objPHPPresentation, 'PowerPoint2007');
			$oWriterPPTX->save($file);
		} else if ($format == 'odp') {
			$oWriterODP = IOFactory::createWriter($objPHPPresentation, 'ODPresentation');
			$oWriterODP->save($file);
		}
	}
	
	// Download file
	// fix for IE https issue
	header("Pragma: public");
	if ($format == 'pptx') {
		header("Content-type: application/vnd.openxmlformats-officedocument.presentationml.presentation");
	} else if ($format == 'odp') {
		header("Content-type: application/vnd.openxmlformats-officedocument.presentationml.presentation");
	}
	header("Content-Disposition: attachment; filename=\"$filename\"");
	//header("Expires: " . date("r", time()));
	//header("Cache-Control: no-cache");
	header("Content-Length: " . filesize($file));
	while (ob_get_level()) { ob_end_clean(); }
	flush();
	readfile($file);
	exit;
	
} else {
	// Instructions
	$content .= '<p>Presentations can be generated from custom content : define each slide content to generate and download the presentation in PPTX or ODP format.</p>';
	
	// Content form to generate the presentation
	$content .= '<form method="POST">';
	$content .= '<p><label>Slide content' . elgg_view('input/plaintext', array('name' => 'slide_content')) . '</label></p>';
	$content .= '<p><label>Download file' . elgg_view('input/select', array('name' => 'export', 'options_values' => $yn_opt)) . '</label></p>';
	$content .= '<p><label>Presentation export format' . elgg_view('input/select', array('name' => 'format', 'options_values' => $format_opt)) . '</label></p>';
	$content .= '<p>' . elgg_view('input/submit', array('value' => "Generate presentation")) . '</p>';
	$content .= '</form>';
	
	/*
	$content .= '<p>';
	$content .= '<a href="?export=yes&format=pptx" class="elgg-button elgg-button-action">Download as PPTX</a>';
	$content .= '<a href="?export=yes&format=odp" class="elgg-button elgg-button-action">Download as ODP</a>';
	$content .= '</p>';
	*/
}


// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

