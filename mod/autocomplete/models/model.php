<?php

function autocomplete_members_complete($q) {
	global $CONFIG;
	
	$query = "SELECT name, username FROM {$CONFIG->dbprefix}users_entity ";
	$query .= "WHERE name LIKE '".sanitise_string($q)."%'";
	$results = get_data($query);
	if ($results) {
		foreach($results as $r) {
			$body .= "{$r->name} ({$r->username})\n";
		}
		return $body;
	}
}

function autocomplete_member_to_user($member) {
	$i = strrpos($member,'(');
	if ($i === false) {
		return 0;
	} else {
		$username = substr($member,$i+1,-1);
		if ($username) {
			return get_user_by_username($username);
		} else {
			return 0;
		}
	}
}

function autocomplete_member_to_user_guid($member) {
	$user = autocomplete_member_to_user($member);
	if ($user) {
		return $user->getGUID();
	} else {
		return 0;
	}
}
?>