<?php

//namespace Sabre\DAV;


// User files
class UserCollection extends Sabre\DAV\Collection {
	protected $user;
	function __construct($user) {
		$this->user = $user;
	}
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->user->guid, 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return $this->user->name; }
	
	// Edit functions
	function createFile($name, $data = null) {
		// Only owner can edit its own files
		if (elgg_is_logged_in() && ($this->user->guid == elgg_get_logged_in_user_guid())) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => $this->user_guid, 'access_id' => 0));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create') . " - Only owner user can create files here.");
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:readonly'));
	}
	// Directory creation is not implemented yet
	function createDirectory($name) {
		// Only owner can edit its own files
		//if (elgg_is_logged_in() && ($this->user->guid == elgg_get_logged_in_user_guid())) {}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
}


