<?php
class ElggAnnouncement extends ElggObject {

	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = 'announcement';
	}
}
