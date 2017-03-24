<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

$title = elgg_echo('default_icons:title');

elgg_push_breadcrumb(elgg_echo('default_icons'), 'default_icons');
elgg_push_breadcrumb($title);



$sidebar = "";

$content = '';
$content .= 'Tests icônes';

// Default seed : unique (guid) + variable (username)
$user_seed = elgg_get_logged_in_user_entity()->guid . '-' . elgg_get_logged_in_user_entity()->username;

$action = get_input('action');
$algorithm = get_input('algorithm', 'ringicon');
$seed = get_input('seed', $user_seed);
$num = get_input('num', 3);
$width = get_input('width', 128);
$mono = get_input('mono', 'no');
if ($mono != 'yes') { $mono = false; }
$format = 'png';

if (($action == 'render') && !empty($algorithm) && !empty($seed)) {
	switch($algorithm) {
		case 'unique_image':
			elgg_load_library('exorithm:unique_image');
			//echo elgg_view('default_icons/exorithm_unique_image', array('seed' => $seed, 'width' => $width, 'steps' => $num));
			$image = new ExorithmUniqueImage($seed, $width, $num, $format, $background);
			$image->display();
			break;
		
		case 'vizhash':
			elgg_load_library('sebsauvage:vizhash');
			$image = new SebsauvageVizHash($seed, $width, $num, $format, $background);
			$image->display();
			break;
		
		case 'ideinticon':
			elgg_load_library('tiborsaas:ideinticon');
			$image = new Identicon();
			$image->hashBase($seed);
			$image->setSize($width);
			$image->rotator(TRUE); // more variation to the identicon by rotating it
			$image->filterize(TRUE);
			
			// Requires a base image : unique or set of up to 65k images
			$image->setImage(elgg_get_plugins_path().'default_icons/graphics/white.png');
			//$image->useImagePool(elgg_get_plugins_path().'default_icons/vendors/tiborsaas/Ideinticon/imagepool' );
			
			// Display on the output
			echo $image->display();
			// this will generate the identicon and save it to a path
			//$image->setOutputPath( 'out' );
			//$image->setOutputFilename( $i.'.png' );
			//$image->generate( TRUE );
			exit;
			break;
		
		case 'ringicon':
		default:
			elgg_load_library('splitbrain:php-ringicon');
			// Uses $seed, $num, $width, $mono
			$num = max(2, $num); // Between 2 and 4 (more than 4 adds white circles from the center)
			//use splitbrain\RingIcon\RingIcon;
			// define size and number of rings
			$ringicon = new splitbrain\RingIcon\RingIcon($width, $num);
			// decide if monochrome image is wanted
			$ringicon->setMono($mono);
			// completely random image directly output to browser
			$ringicon->createImage($seed); // seed (or random), file (or printed to browser)
			// example to save an image based on an email address:
			// $ringicon->createImage('mail@example.com', '/tmp/avatar.png');
			exit;
	}
}

// Generation form

$algorithm_opt = ['ringicon' => "RingIcon", 'vizhash' => "VizHash", 'unique_image' => "Exorithm Unique image", 'ideinticon' => "Ideinticon"];
$num_opt = ['2' => '2', '3' => '3', '4' => '4', '5' => '5'];
$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

$content .= '<form method="GET">';
$content .= '<p>';
$content .= '<label>Algorithme ' . elgg_view('input/select', array('name' => 'algorithm', 'value' => $algorithm, 'options_values' => $algorithm_opt)) . ' &nbsp; ';
$content .= '<label>Identifiant ' . elgg_view('input/text', array('name' => 'seed', 'value' => $seed, 'style' => "max-width:30ex;")) . '</label>';
$content .= '</p>';
$content .= '<p>';
$content .= '<label>Largeur en px ' . elgg_view('input/text', array('name' => 'width', 'value' => $width, 'style' => "max-width:10ex;")) . ' &nbsp; ';
$content .= '<label>Niveau de complexité ' . elgg_view('input/select', array('name' => 'num', 'value' => $num, 'options_values' => $num_opt)) . ' &nbsp; ';
$content .= '<label>Monochrome ' . elgg_view('input/select', array('name' => 'mono', 'value' => $mono, 'options_values' => $ny_opt));
$content .= '</p>';
$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('generate'))) . '</p>';
$content .= '</form>';

$img_base_url = elgg_get_site_url() . "default_icons/icon?seed=$seed";
if (!empty($num)) $img_base_url .= "&num=$num";
if (!empty($background)) $img_base_url .= "&background=$background";
if (!empty($mono)) $img_base_url .= "&mono=$mono";
$img_base_url .= "&algorithm=";
$icon_sizes = elgg_get_config('icon_sizes');
foreach($algorithm_opt as $algo_name => $algo_label) {
	$content .= '<p>';
	$content .= $algo_label . '&nbsp;:<br />';
	
	foreach($icon_sizes as $size) {
		if (empty($size['w']) || ($size['w'] > 200)) continue;
		$img_url = $img_base_url . "$algo_name&width={$size['w']}";
		$content .= elgg_view('output/img', array(
				'src' => $img_url, 'alt' =>"$seed - $algo_label",
				'style' => "border:2px solid black;",
			));
		$content .= ' &nbsp; ';
		$content .= elgg_view('output/img', array(
				'src' => $img_url, 'alt' =>"$seed - $algo_label",
				'style' => "border:2px solid black; border-radius:{$size['w']}px;",
			));
		$content .= " {$size['w']}px<br />";
	}
	$content .= '</p>';
}

// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

