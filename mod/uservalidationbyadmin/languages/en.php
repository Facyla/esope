<?php

return array(
	'uservalidationbyadmin' => "User validation by admin",
	
	// general stuff
	'uservalidationbyadmin:validate' => "Validate",
	'uservalidationbyadmin:validate:confirm' => "Are your sure you wish to validate this user?",
	
	// plugin settings
	'uservalidationbyadmin:settings:admin_notify' => "When do you wish to receive a notification about users needing validation",
	'uservalidationbyadmin:settings:admin_notify:direct' => "When a user registers",
	'uservalidationbyadmin:settings:admin_notify:daily' => "Daily",
	'uservalidationbyadmin:settings:admin_notify:weekly' => "Weekly",
	'uservalidationbyadmin:settings:admin_notify:none' => "No notification",
	
	// user settings
	'uservalidationbyadmin:usersettings:nonadmin' => "Only site administrators have settings for this plugin.",
	'uservalidationbyadmin:usersettings:notify' => "I want to receive notifications about pending approvals",
	
	// login
	'uservalidationbyadmin_pam_handler:failed' => "Your account needs to be validated by an administrator, you'll be notified when this happens",
	'uservalidationbyadmin:login:error' => "Your account needs to be validated by an administrator, you'll be notified when this happens",
	
	// listing
	'admin:users:pending_approval' => "Pending approval",
	
	'uservalidationbyadmin:pending_approval:description' => "Below you can find a list of users who require your approval before they can use this community",
	'uservalidationbyadmin:pending_approval:title' => "Users awaiting approval",
	
	'uservalidationbyadmin:bulk_action:select' => "Please select at least one user to perform this action",
	
	// notifiction
	'uservalidationbyadmin:notify:validate:subject' => "Your account on %s has been approved",
	'uservalidationbyadmin:notify:validate:message' => "Hi %s,

Your account on %s has been validated, you can now start using the site.

Go to: %s to start your experience.",

		'uservalildationbyadmin:notify:admin:subject' => "Users are awaiting your approval",
		'uservalildationbyadmin:notify:admin:message' => "Hi %s,

%s users are awaiting your approval on %s.
Please visit %s in order to approve/delete the users.",
	
	// actions
	// validate
	'uservalidationbyadmin:actions:validate:error:save' => "An unknown error occured while validating %s",
	'uservalidationbyadmin:actions:validate:success' => "%s has been validated",
	
	// bulk action
	'uservalidationbyadmin:actions:bulk_action:error:invalid_action' => "The selected action is invalid",
	'uservalidationbyadmin:actions:bulk_action:success:delete' => "Successfully deleted the users",
	'uservalidationbyadmin:actions:bulk_action:success:validate' => "Successfully validated the users",
);
