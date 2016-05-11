<?php

//namespace Sabre\DAV;


// PUBLIC folder : list all accessible files, in read-only mode
class PublicCollection extends Sabre\DAV\Collection {
	function getChildren() {
		$result = [];
		$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'limit' => 0));
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() { return 'public'; }
	// Edit functions - readonly folder
	// Note : should we allow new files here ? better not because we cannot do that on web site !! 
	// => use groups or personal account instead
	function createFile($name, $data = null) {
		/*
		// Only members can create new files
		if (elgg_is_logged_in()) {
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $this->user_guid, 'container_guid' => elgg_get_site_entity()->guid));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After successful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		*/
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:readonly'));
	}
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:readonly'));
		/*
		if (elgg_is_logged_in()) {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
		}
		*/
	}
}


