<?php

//namespace Sabre\DAV;

// Group files
class GroupCollection extends Sabre\DAV\Collection {
	protected $group;
	function __construct($group) {
		$this->group = $group;
	}
	function getChildren() {
		$result = [];
		//Sub-groups structure inside group : seems to make more sense that not listing them in a group folder
		//if (elgg_is_active_plugin('au_subgroups') && (elgg_get_plugin_setting('display_subgroups', 'au_subgroups') != 'yes')) {
		if (elgg_is_active_plugin('au_subgroups')) {
			$subgroups = AU\SubGroups\get_subgroups($this->group, 0);
			foreach($subgroups as $subgroup) {
				$result[] = new GroupCollection($subgroup);
			}
		}
		// List files and optionally folders
		if (elgg_is_active_plugin('file_tools') && file_tools_use_folder_structure()) {
			// Support folder structure inside group if enabled : subfolders and folders files
			// Folders
			$folders = file_tools_get_folders($this->group->guid);
			foreach($folders as $folder) {
				$result[] = new FolderCollection($this->group, $folder['folder']);
			}
			// Files
			$dbprefix = elgg_get_config("dbprefix");
			$files_options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->group->guid, 'limit' => 0, 'distinct' => true);
			$files_options["joins"][] = "JOIN " . $dbprefix . "objects_entity oe ON oe.guid = e.guid";
			$files_options["wheres"][] = 
				"NOT EXISTS (
						SELECT 1 FROM " . $dbprefix . "entity_relationships r
						WHERE r.guid_two = e.guid AND
						r.relationship = '" . FILE_TOOLS_RELATIONSHIP . "')";
			$files = elgg_get_entities_from_relationship($files_options);
		} else {
			// All group files
			$files = elgg_get_entities(array('type' => 'object', 'subtype' => 'file', 'container_guid' => $this->group->guid, 'limit' => 0, 'distinct' => true));
		}
		// List files
		foreach($files as $ent) { $result[] = new EsopeDAVFile($ent->guid); }
		return $result;
	}
	function getName() {
		// Tell it's a special folder (subgroup) if displaying in a group folder
		// @TODO which would be most obvious way to tell it's a subgroup and not a regular folder ?
		if (elgg_is_active_plugin('au_subgroups')) {
			$parentgroup = AU\SUBGROUPS\get_parent_group($this->group);
			if ($parentgroup) { return '[subgroup] '. $this->group->name; }
			//if ($parentgroup) { return '[ '. $this->group->name . ' ]'; }
		}
		return $this->group->name;
	}
	
	// Edit functions
	function createFile($name, $data = null) {
		$own = elgg_get_logged_in_user_entity();
		// Only group members can create new files
		if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {
			// Access is set to group members
			$file = elgg_webdav_create_file($name, $data, array('owner_guid' => $own->guid, 'container_guid' => $this->group->guid, 'access_id' => $this->group->group_acl));
			if (elgg_instanceof($file, 'object', 'file')) {
				// After succesful creation of the file, you may choose to return the ETag of the new file here.
				// The returned ETag must be surrounded by double-quotes (The quotes should be part of the actual string).
				return '"' . $file->time_updated . $file->guid . '"';
			}
			throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:create'));
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	function createDirectory($name) {
		if (elgg_is_active_plugin('file_tools') && file_tools_use_folder_structure()) {
			$own = elgg_get_logged_in_user_entity();
			if (elgg_is_logged_in() && ($this->group->isMember($own) || $this->group->canEdit())) {
				$parent_guid = 0; // parent folder GUID
				$directory = file_tools_check_foldertitle_exists($name, $this->group->guid, $parent_guid);
				// @TODO : when moving a folder, we need to create it first, then delete the previous one
				if (!$existingfolder) {
error_log("GroupCollection createDirectory : no existing folder : nice !");
					$directory = new ElggObject();
					$directory->subtype = FILE_TOOLS_SUBTYPE;
					$directory->owner_guid = elgg_get_logged_in_user_guid();
					$directory->container_guid = $this->group->guid;
					// Default acess to group ACL or group access_id ?
					//$directory->access_id = $this->group->access_id;
					$directory->access_id = $this->group->group_acl;
					$directory->title = $name;
					$directory->parent_guid = $parent_guid;
					$order = elgg_get_entities_from_metadata(array(
						"type" => "object", "subtype" => FILE_TOOLS_SUBTYPE,
						"metadata_name_value_pairs" => array("name" => "parent_guid", "value" => $parent_guid),
						"count" => true
					));
					$directory->order = $order;
					$directory->save();
				// If exists, assume we're moving it, but still check we're allowed to do so !
				} else if ($directory->canEdit() && !empty($directory->parent_guid)) {
					$directory->parent_guid = $parent_guid;
				}
				return '"' . $directory->time_updated . $directory->guid . '"';
			}
		}
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:notimplemented'));
	}
}


