<?php
/**
 * Class that represents an object of subtype organisation
 */
class ElggOrganisation extends ElggObject {
	const SUBTYPE = "organisation";

	/** Set subtype */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = $this::SUBTYPE;
	}
	
	/* Get Contacts */
	protected function getContacts() {
		return $this->contacts;
	}
	
	
}

