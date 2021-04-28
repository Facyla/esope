<?php
/**
 * Class that represents an object of subtype survey
 */
class ElggSurveyQuestion extends ElggObject {
	const SUBTYPE = "survey_question";

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	
}

