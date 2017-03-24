<?php
/**
 * Custom class to package Exorithm's unique image
 * Source : http://www.exorithm.com/algorithm/view/unique_image
 */
class ExorithmUniqueImage extends ElggDefaultIcons {
	
	// Render the image to the client
	public function display() {
		
		// Genère l' image
		$image = $this->unique_image($this->seed, $this->width, $this->steps, $this->background);
		
		// Définit le contenu de l'en-tête et affiche l'image
		switch($this->format) {
			case 'gif':
				header('Content-Type: image/gif');
				imagegif($image);
				break;
			
			case 'jpeg':
				header('Content-Type: image/jpeg');
				// resource $image [, mixed $to [, int $quality ]]) quality = 0-100
				imagejpeg($image, null, 100);
				break;
			
			case 'png':
			default:
				header('Content-Type: image/png');
				// resource $image [, string $filename [, int $quality [, int $filters ]]] quality = 0 (aucune compression) à 9
				imagepng($image, null, 0, PNG_ALL_FILTERS);
		}
		
		// Libération de la mémoire
		imagedestroy($image);
		exit;
	}


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
	protected function unique_image($string='whatever', $size = 200, $steps = 5, $background = '#FFFFFF'){
		$step=$size/$steps;
	
		$image = $this->image_create_alpha($size, $size, $background);
	
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
	protected function image_create_alpha($width='', $height='', $background = false){
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
	
}

