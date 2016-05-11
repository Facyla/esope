<?php

//namespace Sabre\DAV;

// Elgg File mapper
class EsopeDAVFile extends Sabre\DAV\File {
	private $entity;
	function __construct($guid) {
		$this->entity = get_entity($guid);
		if (!elgg_instanceof($this->entity, 'object', 'file')) {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:noaccess'));
		}
	}
	function getName() {
		return $this->entity->originalfilename;
		//return $this->entity->title;
	}
	function get() {
		return $this->entity->grabFile();
		// reafile() is used in file/download but returns directly (here we prefer to pass content)
		//return readfile($this->entity->getFilenameOnFilestore());
		//return fopen($this->entity->getFilenameOnFilestore(), 'r');
	}
	function getSize() {
		// Failsafe behaviour : don't return directly value (in case there are errors it will not lag)
		$size = $this->entity->getSize();
		if ($size) { return $size; }
		return null;
		//return filesize($this->entity->getFilenameOnFilestore());
	}
	
	// Update file content
	function put($data) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:updatedata'));
		if ($this->entity->canEdit()) {
			// Convert data to string if it is a resource (mostly)
			if (is_resource($data)) {
				$data = stream_get_contents($data);
			}
			// Open the file to guarantee the directory exists
			$this->entity->open("write");
			$this->entity->write($data);
			$this->entity->close();
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:updatedata'));
		}
	}
	// ETag has to be unique and change when file changes
	function getETag() {
		return $this->entity->time_updated . $this->entity->guid;
	}
	function getContentType() {
		$mime = $this->entity->getMimeType();
		//if (!$mime) { $mime = "application/octet-stream"; }
		if ($mime) { return $mime; }
		return null;
	}
	function getLastModified() {
		return $this->entity->time_updated;
	}
	// @TODO : allow deletion or not, and whom ?
	// @TODO : we could also disable the file, and remove it after a certain time (enable restoring files)
	function delete() {
		/* VERY IMPORTANT : when moving files, WebDAV deletes the old file and creates a new one, 
		 * resulting in losing all Elgg-specific properties, metadata, annotations and relations
		 * So we better not enable this until it's handled !!
		 */
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:toodangerousyet'));
		// Allow only owner to delete files, or anyone who has edit rights ?
		//if (elgg_get_logged_in_user_guid()) {
		//if ($this->entity->canEdit()) {
		if ($this->entity->owner_guid == elgg_get_logged_in_user_guid()) {
			$this->entity->delete();
			//$this->entity->disable();
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:delete'));
		}
	}
	function setName($name) {
		if ($this->entity->canEdit()) {
			$this->entity->originalfilename = $name; // prefered way
			if (empty($this->entity->title)) { $this->entity->title = $name; }// Also set title if none set
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:rename'));
		}
	}
}


