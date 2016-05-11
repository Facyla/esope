<?php

//namespace Sabre\DAV;



// USERS folder
class UsersCollection extends Sabre\DAV\Collection {
	protected $users;
	function __construct() {
		$this->users = elgg_get_entities(array('type' => 'user', 'limit' => 0));
	}
	function getChildren() {
		$result = [];
		foreach($this->users as $user) {
			$result[] = new UserCollection($user);
		}
		return $result;
	}
	function getName() { return 'users'; }
	// Edit functions - readonly folder
	// Cannot create files or folders in users list...
	function createFile($name, $data = null) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:file:readonly'));
	}
	// Cannot create users from WebDAV
	function createDirectory($name) {
		throw new Sabre\DAV\Exception\Forbidden(elgg_echo('elgg_webdav:error:directory:usercreate'));
	}
}


