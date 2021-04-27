<?php
/**
 * 
 */
class ElggFeedback extends ElggObject {
	
	//private $entity = false;
	
	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "feedback";
	}
	
}

