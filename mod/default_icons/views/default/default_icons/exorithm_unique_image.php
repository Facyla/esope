<?php
// Source : http://www.exorithm.com/algorithm/view/unique_image

$seed = elgg_extract('seed', $vars);
$width = (int)elgg_extract('width', $vars, 200);
if (empty($width) || ($width < 16)) { $width = 16; }
$steps = (int)elgg_extract('steps', $vars, 5);
if (empty($steps) || ($steps < 1)) { $steps = 5; }
$background = elgg_extract('background', $vars, "#FFFFFF");

// Generate image
$image = unique_image($seed, $width, $steps);

// Définit le contenu de l'en-tête - dans ce cas, image/jpeg
//header('Content-Type: image/jpeg');
header('Content-Type: image/png');
//header('Content-Type: image/gif');

// Affichage de l'image
//imagejpeg($image, null, 100); // resource $image [, mixed $to [, int $quality ]]) quality = 0-100
imagepng($image, null, 0, PNG_ALL_FILTERS); // resource $image [, string $filename [, int $quality [, int $filters ]]] quality = 0 (aucune compression) à 9
//imagegif($image);

// Libération de la mémoire
imagedestroy($image);
exit;


/**
 * unique_image
 *
 * Generate a pseudo-unique "hash" image based on a string.
 *
 * @version 0.3
 * @author Contributors at eXorithm
 * @link http://www.exorithm.com/algorithm/view/unique_image Listing at eXorithm
 * @link http://www.exorithm.com/algorithm/history/unique_image History at eXorithm
 * @license http://www.exorithm.com/home/show/license
 *
 * @param mixed $string 
 * @return resource GD image
 */
function unique_image($string='whatever', $size = 200, $steps = 5, $background = '#FFFFFF'){
	$step=$size/$steps;
	
	$image = image_create_alpha($size, $size, $background);
	
	$n = 0;
	$prev = 0;
	$len = strlen($string);
	$sum = 0;
	for ($i=0;$i<$len;$i++) $sum += ord($string[$i]);
	
	for ($i=0;$i<$steps;$i++) {
		for ($j=0;$j<$steps;$j++) {
			$letter = $string[$n++ % $len];
			
			$u = ($n % (ord($letter)+$sum)) + ($prev % (ord($letter)+$len)) + (($sum-1) % ord($letter));
			$color = imagecolorallocate($image, pow($u*$prev+$u+$prev+5,2)%256, pow($u*$prev+$u+$prev+3,2)%256, pow($u*$prev+$u+$prev+1,2)%256);
			if (($u%2)==0)
				imagefilledpolygon($image, array($i*$step, $j*$step, $i*$step+$step, $j*$step, $i*$step, $j*$step+$step), 3, $color);
			$prev = $u;
			
			$u = ($n % (ord($letter)+$len)) + ($prev % (ord($letter)+$sum)) + (($sum-1) % ord($letter));
			if (($u%2)==0)
				imagefilledpolygon($image, array($i*$step, $j*$step+$step, $i*$step+$step, $j*$step+$step, $i*$step+$step, $j*$step), 3, $color);
			$prev = $u;
		
		}
	}
	
	return $image;
}

/**
 * image_create_alpha
 *
 * Helper function to create a new blank image with transparency.
 *
 * @version 0.1
 * @author Contributors at eXorithm
 * @link http://www.exorithm.com/algorithm/view/image_create_alpha Listing at eXorithm
 * @link http://www.exorithm.com/algorithm/history/image_create_alpha History at eXorithm
 * @license http://www.exorithm.com/home/show/license
 *
 * @param mixed $width 
 * @param mixed $height 
 * @return resource GD image
 */
function image_create_alpha($width='', $height='', $background = false){
	// Create a normal image and apply required settings
	$img = imagecreatetruecolor($width, $height);
	
	if ($background) {
		$colors = hex2rgb($background);
		// set background to white
		$white = imagecolorallocate($img, $colors[0], $colors[1], $colors[2]);
		imagefill($img, 0, 0, $white);
		return $img;
	}
	
	// Transparent background
	imagealphablending($img, false);
	imagesavealpha($img, true);
	
	// Apply the transparent background
	$trans = imagecolorallocatealpha($img, 0, 0, 0, 127);
	for ($x = 0; $x < $width; $x++){
		for ($y = 0; $y < $height; $y++){
			imagesetpixel($img, $x, $y, $trans);
		}
	}
	
	return $img;
}


function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}


