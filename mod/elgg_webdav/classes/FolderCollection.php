<?php

//namespace Sabre\DAV;


// Folder content : subfolders and files
class FolderCollection extends Sabre\DAV\Collection {
	protected $container;
	protected $folder;
	protected $subfolders;
	protected $files;
	function __construct($container, $folder) {
		$this->container = $container;
		$this->folder = $folder;
	}
	function getSubfolders() {
		if (!isset($this->subfolders)) {
			$this->subfolders = file_tools_get_sub_folders($this->folder);
		}
		return $this->subfolders;
	}
	function getFolderFiles() {
		if (!isset($this->files)) {
			$dbprefix = elgg_get_config("dbprefix");
			$files_options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->container->guid, 'limit' => 0, 'distinct' => true);
			//$files_options["joins"][] = "JOIN " . $dbprefix . "objects_entity oe ON oe.guid = e.guid";
			$files_options["relationship"] = FILE_TOOLS_RELATIONSHIP;
			$files_options["relationship_guid"] = $this->folder->guid;
			$files_options["inverse_relationship"] = false;
			$this->files = elgg_get_entities_from_relationship($files_options);
		}
		return $this->files;
	}
	function getChildren() {
		$result = [];
		// Subfolders
		if ($this->getSubfolders()) {
			foreach($this->getSubfolders() as $subfolder) {
				$result[] = new FolderCollection($this->container, $subfolder);
			}
		}
		// Folders files
		if ($this->getFolderFiles()) {
			foreach($this->getFolderFiles() as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		}
		// Return folders and files list
		return $result;
	}
	function getName() { return $this->folder->title; }
	
	// Edit functions
	function setName($name) {
		// Cannot rename to an existing name (in the same container)
		$existingfolder = file_tools_check_foldertitle_exists($name, $this->container->guid, $this->folder->guid);
		if (!$existingfolder && $this->folder->canEdit()) {
			$this->folder->title = sanitise_string($name);
			$this->folder->save();
			return '"' . $this->folder->time_updated . $this->folder->guid . '"';
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:alreadyexists'));
	}
	function createFile($name, $data = null) {
		$own = elgg_get_logged_in_user_entity();
		// Only group members can create new files
		if (elgg_is_logged_in() && ((elgg_instanceof($this->container, 'group') && $this->container->isMember($own)) || $this->container->canEdit())) {
			// Access is set to group members
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $own->guid, 'container_guid' => $this->container->guid, 'access_id' => $this->container->group_acl));
			if (elgg_instanceof($file, 'object', 'file')) {
				// Set parent folder
				//remove_entity_relationships($file->guid, FILE_TOOLS_RELATIONSHIP, true);
				add_entity_relationship($this->folder->guid, FILE_TOOLS_RELATIONSHIP, $file->guid);
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	// @TODO check if allowed and enable to create new subfolder (inherit parent properties)
	function createDirectory($name) {
		if (file_tools_use_folder_structure()) {
			$own = elgg_get_logged_in_user_entity();
			if (elgg_is_logged_in() && ((elgg_instanceof($this->container, 'group') && $this->container->isMember($own)) || $this->container->canEdit())) {
				$parent_guid = $this->folder->guid; // parent folder GUID
				$existingfolder = file_tools_check_foldertitle_exists($name, $this->container->guid, $parent_guid);
				if (!$existingfolder) {
					$directory = new ElggObject();
					$directory->subtype = FILE_TOOLS_SUBTYPE;
					$directory->owner_guid = elgg_get_logged_in_user_guid();
					$directory->container_guid = $this->container->guid;
					// Default acess to parent folder access
					$directory->access_id = $this->folder->access_id;
					$directory->title = $name;
					$directory->parent_guid = $parent_guid;
					$order = elgg_get_entities_from_metadata(array(
						"type" => "object", "subtype" => FILE_TOOLS_SUBTYPE,
						"metadata_name_value_pairs" => array("name" => "parent_guid", "value" => $parent_guid),
						"count" => true
					));
					$directory->order = $order;
					$directory->save();
				}
				return '"' . $directory->time_updated . $directory->guid . '"';
			}
		}
		//if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
	function getLastModified() {
		return $this->folder->time_updated;
	}
	function delete() {
		/* VERY IMPORTANT : when moving files and folders, WebDAV deletes the old ones and creates new ones, 
		 * resulting in losing all Elgg-specific properties, metadata, annotations and relations
		 * So we better not enable this for files until it's handled !!
		 * Still, it's OK for folders, would result at worst in duplicate (if user ignores error report)
		 */
		//throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:toodangerousyet'));
		// @TODO Important : do NOT delete folder content ? But mounted filesystem tells to do so to server (delete all files + folder recursively)
		// file_tools behaviour is to remove the folder so subfolders and contained files ends up in root directory (or we could move to parent)
		if ($this->folder->canEdit()) {
			/*
			// @TODO move children files and folders to parent folder
			// file_tools_change_children_access($folder, $change_files = true)
			$parent_guid = $this->folder->parent_guid;
			// Move subfolders 1 level upper
			if ($this->getSubfolders()) {
				foreach($this->getSubfolders() as $subfolder) {
					$subfolder->parent_guid = $parent_guid;
					//$subfolder->save();
				}
			}
			if ($this->getFolderFiles()) {
				foreach($this->getFolderFiles() as $file) {
					remove_entity_relationships($file->guid, FILE_TOOLS_RELATIONSHIP, true);
					add_entity_relationship($parent_guid, FILE_TOOLS_RELATIONSHIP, $file->guid);
				}
			}
			*/
			if ($this->folder->delete()) {
				// @TODO return something to trigger tree update ?
			} else {
				throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:couldnotdelete'));
			}
		} else {
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notallowed'));
		}
	}
}

