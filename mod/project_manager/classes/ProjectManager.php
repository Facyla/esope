<?php
/**
 * Class that represents an object of subtype survey
 */
class ProjectManager extends ElggObject {
	const SUBTYPE = "project_manager";

	/** @var array $responses Cache for number of responders for each question */
	//private $responses_by_question = array();

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	
	
}

