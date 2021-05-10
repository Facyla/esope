<?php

class ElggContentLifeCycle extends ElggObject {
	
	// Constants
	//const SUBTYPE = "plugin_template";
	
	// Cached vars
	//private $entities = [];
	// In functions : if ($this->responses_by_question) { return; } else { /* compute it */ }
	
	/**
	 * Set subtype
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = "content_lifecycle";
	}
	
	
	// DROITS ET WORKFLOW
	
	// Pas de commentaire sur les modes de livraison
	public function canComment($user_guid = 0, $default = null) {
		return false;
	}
	
	// Seul un admin peut modifier un mode de livraison
	public function canEdit($user_guid = 0) {
		if (elgg_is_admin_logged_in()) { return true; }
		return false;
	}
	
	// Un mode de livraison déjà utilisé ne devrait pas être supprimé
	public function canDelete($user_guid = 0) {
		if (elgg_is_admin_logged_in()) { return true; }
		return false;
	}
	
	
}
