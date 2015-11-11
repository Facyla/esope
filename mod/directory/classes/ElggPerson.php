<?php
/**
 * Class that represents an object of subtype person
 */
class ElggPerson extends ElggObject {
	const SUBTYPE = "person";

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	
	
}

