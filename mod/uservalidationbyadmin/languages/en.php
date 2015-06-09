<?php
/**
 * Email user validation plugin language pack.
 *
 * @package Elgg.Core.Plugin
 * @subpackage Elgguservalidationbyadmin
 */

$english = array(
	'admin:users:unvalidated' => 'Unvalidated',
	
	'email:validate:subject' => "%s is requesting validation of account for %s!",
	'email:validate:body' => "Hello,

\"%1\$s\" is requesting validation of their account 

Account details and geolocation are:
Username : %8\$s
Email : %7\$s
IP address: %2\$s
Probable location: %3\$s

You can validate their account by clicking on the link below: 
%4\$s

Or check the full list of un-validated accounts: 
%6\$sadmin/users/unvalidated

If you can't click on the link, copy and paste it to your browser manually.

%5\$s
%6\$s
",

	'user:validate:subject' => "Congrats %s! Your account is activated",
	'user:validate:body' => "Hello %s,

This is to notify that your account at %s is activated by the admin. 

You can now login to the site with:

Username : %s
Password : the one you provided while registration

%s
%s
",

	'email:confirm:success' => "The user account is now validated",
	'email:confirm:fail' => "The user account could not be validated...",

	'uservalidationbyadmin:registerok' => "You will be notified once the admin approves your account",
	'uservalidationbyadmin:login:fail' => "Your account is not validated so the log in attempt failed. You have to wait until an admin validates your account.",

	'uservalidationbyadmin:admin:no_unvalidated_users' => 'No unvalidated users.',

	'uservalidationbyadmin:admin:unvalidated' => 'Unvalidated',
	'uservalidationbyadmin:admin:user_created' => 'Registered %s',
	'uservalidationbyadmin:admin:resend_validation' => 'Resend validation',
	'uservalidationbyadmin:admin:validate' => 'Validate',
	'uservalidationbyadmin:admin:delete' => 'Delete',
	'uservalidationbyadmin:confirm_validate_user' => 'Validate %s?',
	'uservalidationbyadmin:confirm_resend_validation' => 'Resend validation email to %s?',
	'uservalidationbyadmin:confirm_delete' => 'Delete %s?',
	'uservalidationbyadmin:confirm_validate_checked' => 'Validate checked users?',
	'uservalidationbyadmin:confirm_resend_validation_checked' => 'Resend validation to checked users?',
	'uservalidationbyadmin:confirm_delete_checked' => 'Delete checked users?',
	'uservalidationbyadmin:check_all' => 'All',

	'uservalidationbyadmin:errors:unknown_users' => 'Unknown users',
	'uservalidationbyadmin:errors:could_not_validate_user' => 'Could not validate user.',
	'uservalidationbyadmin:errors:could_not_validate_users' => 'Could not validate all checked users.',
	'uservalidationbyadmin:errors:could_not_delete_user' => 'Could not delete user.',
	'uservalidationbyadmin:errors:could_not_delete_users' => 'Could not delete all checked users.',
	'uservalidationbyadmin:errors:could_not_resend_validation' => 'Could not resend validation request.',
	'uservalidationbyadmin:errors:could_not_resend_validations' => 'Could not resend all validation requests to checked users.',

	'uservalidationbyadmin:messages:validated_user' => 'User validated.',
	'uservalidationbyadmin:messages:validated_users' => 'All checked users validated.',
	'uservalidationbyadmin:messages:deleted_user' => 'User deleted.',
	'uservalidationbyadmin:messages:deleted_users' => 'All checked users deleted.',
	'uservalidationbyadmin:messages:resent_validation' => 'Validation request resent.',
	'uservalidationbyadmin:messages:resent_validations' => 'Validation requests resent to all checked users.',
	
	'uservalidationbyadmin:settings:usernames' => "Usernames to be warned (must be admins)",
	'uservalidationbyadmin:user' => "Username %s",
	
);

add_translation("en", $english);
