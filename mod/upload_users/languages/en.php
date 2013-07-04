<?php
/**
 * Elgg upload_users plugin language file
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @copyright Mediamaisteri Group 2008-2009
 * @link http://www.mediamaisteri.com/
 */

$english = array(
	
'admin:users:upload' => 'Upload Users',
'upload_users:upload_users' => 'Upload Users',
'upload_users:choose_file' => 'Choose file',
'upload_users:encoding' => 'Choose encoding',
'upload_users:delimiter' => 'Choose delimiter',
'upload_users:send_email' => 'Send email to new users',
'upload_users:yes' => 'Yes',
'upload_users:no' => 'No',

'upload_users:create_users' => 'Create user accounts',
'upload_users:success' => 'User created succesfully',
'upload_users:statusok' => 'User can be created',
'upload_users:creation_report' => 'Created users',
'upload_users:process_report' => 'Preview of Created Users',
'upload_users:no_created_users' => 'No created users.',
'upload_users:number_of_accounts' => 'Total number of accounts',
'upload_users:number_of_errors' => 'Number of errors',

'upload_users:submit' => 'Submit',

'upload_users:upload_help' => '<p>Choose a CSV file and upload it to create new user accounts. </p><p>The first row in the file must include information what the columns include. Required fields are username, name, email. If password field is not in the file a new random password will be generated. If you wish you can send the account information automatically to the user. </p><p>You can add any number of fields. All the other fields will be added as metadata for the user. If your delimiter is something else than a comma (,) a value can be a comma separates list of tags</p><p>Here is an example of a csv file:</p>',

/*
 * Error messages
 * 
 */

'upload_users:error:file_open_error' => 'Error opening file',
'upload_users:error:wrong_csv_format' => 'CSV file in wrong format',


/*
 * emails
 * 
 */

'upload_users:email:message' => 'Hello %s!

A user account has been created for you for %s. Use your username and password to login.

Username: %s
Password: %s

Go to address %s to login.

',
'upload_users:email:subject' => 'Your user account for %s',


/* MISC */

'upload_users:mapping:custom' => 'custom ...',
	
);

add_translation("en",$english);
?>