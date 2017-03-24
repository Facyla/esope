<?php
/**
 * Custom class to package Sebsauvage's VizHash
 * 
 */
class SebsauvageVizHash extends ElggDefaultIcons {
	
	protected $values = false;
	protected $values_index = false;
	
	// Display
	public function display() {
	
		// We hash the input string. (We don't use hash() to stay compatible with php4.)
		$hash=sha1($this->seed).md5($this->seed);
		$hash=$hash.strrev($hash);  # more data to make graphics

		// We convert the hash into an array of integers.
		$this->values=array();
		for($i=0; $i<strlen($hash); $i=$i+2){
			array_push($this->values,hexdec(substr($hash,$i,2)));
		}
		$this->values_index=0; // to walk the array.

		// Then use these integers to drive the creation of an image.
		$image = imagecreatetruecolor($this->width,$this->height);
		if (function_exists('imageantialias')) {
			imageantialias($image, true); // Use antialiasing (if available)
		}

		$r0 = $this->getInt();$r=$r0;
		$g0 = $this->getInt();$g=$g0;
		$b0 = $this->getInt();$b=$b0;

		// First, create an image with a specific gradient background.
		$op='v';
		if (($this->getInt()%2)==0) { $op='h'; };
		$image = $this->degrade($image,$op,array($r0,$g0,$b0),array(0,0,0));

		for($i=0; $i<7; $i=$i+1){
			$action=$this->getInt();
			$color = imagecolorallocate($image, $r,$g,$b);
			$r = ($r0 + $this->getInt()/25)%256;
			$g = ($g0 + $this->getInt()/25)%256;
			$b = ($b0 + $this->getInt()/25)%256;
			$r0=$r; $g0=$g; $b0=$b;
			$this->drawshape($image,$action,$color);
		}
		$color = imagecolorallocate($image,$this->getInt(),$this->getInt(),$this->getInt());
		$this->drawshape($image,$this->getInt(),$color);

		// Image expires in 7 days (to lighten the load on the server)
		// and allow image to be cached by proxies.
		$duration=7*24*60*60;
		header ('Expires: ' . gmdate ('D, d M Y H:i:s', time() + $duration) . ' GMT');
		header('Cache-Control: max-age='.$duration.', public');

		// Prevent some servers to add "Pragma:no-cache" by default
		header('Pragma:cache');

		header('Content-type: image/png');
		imagepng($image); // Return the image in PNG format.
		$content .= ' -- vizhash_gd '.$VERSION.' by sebsauvage.net';
		imagedestroy($image);
		exit;
	}
	
	
	// Returns a single integer from the $this->values array (0...255)
	protected function getInt(){
		$v= $this->values[$this->values_index];
		$this->values_index++;
		$this->values_index %= count($this->values); // Wrap around the array
		return $v;
	}

	// Returns a single integer from the array (roughly mapped to image width) 
	protected function getX(){
		return $this->width*$this->getInt()/256;
	}

	// Returns a single integer from the array (roughly mapped to image height) 
	protected function getY(){
		return $this->height*$this->getInt()/256;
	}

	# Gradient function taken from:
	# http://www.supportduweb.com/scripts_tutoriaux-code-source-41-gd-faire-un-degrade-en-php-gd-fonction-degrade-imagerie.html
	protected function degrade($img,$direction,$color1,$color2){
		if($direction=='h') {
			$size = imagesx($img); $sizeinv = imagesy($img);
		} else {
			$size = imagesy($img); $sizeinv = imagesx($img);
		}
		$diffs = array(
			(($color2[0]-$color1[0])/$size),
			(($color2[1]-$color1[1])/$size),
			(($color2[2]-$color1[2])/$size)
		);
		for($i=0;$i<$size;$i++){
			$r = $color1[0]+($diffs[0]*$i);
			$g = $color1[1]+($diffs[1]*$i);
			$b = $color1[2]+($diffs[2]*$i);
			if($direction=='h') {
				imageline($img,$i,0,$i,$sizeinv,imagecolorallocate($img,$r,$g,$b));
			} else {
				imageline($img,0,$i,$sizeinv,$i,imagecolorallocate($img,$r,$g,$b));
			}
		}
		return $img;
	}
	
	public function drawshape($image,$action,$color){
		switch($action%7){
		case 0:
			ImageFilledRectangle ($image,$this->getX(),$this->getY(),$this->getX(),$this->getY(),$color);  
			break;
		case 1:
		case 2:
			ImageFilledEllipse ($image, $this->getX(), $this->getY(), $this->getX(), $this->getY(), $color);  
			break;
		case 3:
			$points = array($this->getX(), $this->getY(), $this->getX(), $this->getY(), $this->getX(), $this->getY(),$this->getX(), $this->getY());
			ImageFilledPolygon ($image, $points, 4, $color);
			break;
		case 4:
		case 5:
		case 6:
			$start=$this->getInt()*360/256; $end=$start+$this->getInt()*180/256;
			ImageFilledArc ($image, $this->getX(), $this->getY(), $this->getX(), $this->getY(),$start,$end,$color,IMG_ARC_PIE);
			break;
		}
	}
	
}

