<?php
/**
 * Class that represents an object of subtype survey
 */
class ElggSlider extends ElggObject {
	const SUBTYPE = "slider";

	private $slides = array();

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	
	
}

