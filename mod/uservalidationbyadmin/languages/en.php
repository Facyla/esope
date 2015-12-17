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
	
	
	'uservalidationbyadmin:admin:listnotified' => "List of administrators and their notification settings",
	'uservalidationbyadmin:admin:usersettings' => "edit settings",
	'uservalidationbyadmin:settings:emailvalidation' => "Allow admins to validate account through direct email validation link",
	'uservalidationbyadmin:settings:admin:additionalinfo' => "Add additional information about user in notification email",
	'uservalidationbyadmin:settings:user:additionalinfo' => "Add additional information for the user in confirmation email (after validation)",
	'uservalidationbyadmin:userinfo' => "Pending approval for %s : username %s, email %s",
	'uservalidationbyadmin:userinfo:geo' => "Pending approval for %s : username %s, email %s, IP %s, Geo %s",
	'uservalidationbyadmin:user_validation_link' => "Immediate confirmation link for %s : %s",
	
		'uservalidationbyadmin:notify:admin:message:alternate' => "Hi %s,

%s users are awaiting your approval on %s:
%s

Please visit %s in order to approve/delete the users.",
	
	'uservalidationbyadmin:notify:validate:message:alternate' => "Hi %s,

Your account on %s has been validated, you can now start using the site.

Username: %s
Registration email: %s
Password: the one you have chosen when you registered

Go to: %s to start your experience.",
	
	'uservalidationbyadmin:actions:validate:error:code' => "Validation code is not valid",
	
);
