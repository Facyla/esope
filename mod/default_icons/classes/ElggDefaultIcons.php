<?php
/**
 * Extended class to override the time_created
 * 
 * @property string $comments_on Whether commenting is allowed (Off, On)
 * @property string $excerpt     An excerpt of the default_icons post used when displaying the post
 */
//class ElggDefaultIcon extends ElggObject {
class ElggDefaultIcons extends ElggObject {
	
	// Cached vars
	protected $seed = '';
	protected $width = '';
	protected $height = '';
	protected $steps = '';
	protected $background = '';
	protected $format = '';
	
	
	function __construct($seed = '', $width = 200, $steps = 4, $format = 'png', $background = "#FFFFFF") {
		$this->seed = $seed;
		$this->width = $width;
		$this->height = $width; // square ratio
		$this->steps = $steps;
		$this->background = $background;
		$this->format = $format;
	}
	
	/**
	 * Set subtype
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "default_icons";
	}
	 */
	
	
	// Converts hex color code to rgb values
	// Accepts #FFF or #FFFFFF syntax
	// @TODO transparency also ?
	protected function hex2rgb($hex) {
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
	
	
}

