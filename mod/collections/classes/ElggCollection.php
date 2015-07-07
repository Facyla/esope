<?php
/**
 * Class that represents an object of subtype survey
 */
class ElggCollection extends ElggObject {
	const SUBTYPE = "collection";

	private $entities = array();
	private $entities_comment = array();

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	
	
}

