<?php

//namespace Sabre\DAV;


// GROUPS folder + subgroups support if enabled
class GroupsCollection extends Sabre\DAV\Collection {
	protected $groups;
	function __construct($parent = false) {
		// Note : list all groups (and not only own) because we can read them on web site
		//$this->groups = elgg_get_logged_in_user_entity()->getGroups('', 0);
		// Note : it seems to make more sense not to list subgroups here and rather display them in the tree
		// We could check plugin setting to behave the same as on site but this would result in 2 navigation paths
		//if (elgg_is_active_plugin('au_subgroups') && (elgg_get_plugin_setting('display_subgroups', 'au_subgroups') != 'yes')) {
		if (elgg_is_active_plugin('au_subgroups')) {
			// Do not list subgroups here but make it a tree
			$dbprefix = elgg_get_config('dbprefix');
			$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0, 'wheres' => array("NOT EXISTS ( SELECT 1 FROM {$dbprefix}entity_relationships WHERE guid_one = e.guid AND relationship = '" . AU\SubGroups\AU_SUBGROUPS_RELATIONSHIP . "' )")));
			$this->groups = $groups;
		} else {
			$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0));
			$this->groups = $groups;
		}
	}
	// List folders = groups
	function getChildren() {
		$result = [];
		foreach($this->groups as $group) {
			// @Note : do not throw error if file tool not enabled, because embed tool lets use file too, 
			// and there still may exist files in group...
			//if ($group->file_enable == 'yes') {} else {}
			$result[] = new GroupCollection($group);
		}
		return $result;
	}
	function getName() { return 'groups'; }
	// Edit functions - readonly folder
	// Cannot create files in groups list...
	function createFile($name, $data = null) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	// Cannot create groups from WebDAV
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:groupcreate'));
	}
}

