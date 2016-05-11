<?php

//namespace Sabre\DAV;

// PRIVATE (personal) folder : lists owner files (not those in groups !)
// @TODO list folders if enabled
class PrivateCollection extends Sabre\DAV\Collection {
	protected $user_guid;
	function __construct() {
		$this->user_guid = elgg_get_logged_in_user_guid();
	}
	// Return user personal files (or also in groups ?)
	// @TODO return sub-folders if enabled
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->user_guid, 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return 'private'; }
	// Edit functions
	function createFile($name, $data = null) {
		if (elgg_is_logged_in()) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => $this->user_guid, 'access_id' => 0));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:permissiondenied'));
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
}

