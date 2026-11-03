<?php

return [
	// menus
	'login_by_email:menu:login:new_request' => "Request new login code",
	
	// plugin settings
	'login_by_email:settings:code_validity' => "Login code validity timeout",
	'login_by_email:settings:code_validity:help' => "How long (in minutes) is the login code/link valid",
	'login_by_email:settings:disable_classic_login' => "Disable classic login method",
	'login_by_email:settings:disable_classic_login:help' => "No longer allow login by username/password",
	
	'login_by_email:settings:whitelist' => "Whitelist settings",
	'login_by_email:settings:whitelist:description' => "When selecting users, only those users are allowed to use the login by e-mail feature. When no users are selected, all users are allowed to login by e-mail.",
	'login_by_email:settings:whitelist:admin' => "Please note that site administrators are automatically whitelisted.",
	'login_by_email:settings:whitelist:users' => "Please select the users",
	'login_by_email:settings:whitelist:users:help' => "Search for a user and select them from the list.",
	
	// enter code page
	'login_by_email:code:title' => "Enter login code",
	'login_by_email:code:description' => "An e-mail has been sent to you, please check your inbox for a login code.
You can use the link in the e-mail to directly login or enter the code from the e-mail below to login.

PS: if you can't find the e-mail in your inbox, check the spam folder.",
	'login_by_email:code:code' => "Please enter the login code",
	
	// notifications
	'login_by_email:notification:request_link:subject' => "New login request for %s",
	'login_by_email:notification:request_link:message' => "You've requested a login code for %s.

You can login directly using this link:
%s

or you can enter the following code on the login page:
%s",
	
	// actions
	'login_by_email:action:request_link:success' => "Login code requested, check your e-mail inbox",
	
	'login_by_email:action:code:error:code' => "Invalid login code. Please try again.",
	'login_by_email:action:code:error:code_expired' => "The login code has expired. Please request a new one.",
];
