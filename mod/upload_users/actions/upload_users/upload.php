<?php

/**
 * Upload users. Processes the uploaded file and prints a report of the cerated files.
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @copyright Mediamaisteri Group 2009
 * @link http://www.mediamaisteri.com/
 */
$upload = new UploadUsers();

elgg_push_context('admin');

/// Get the input from the form or hidden fields
$encoding = get_input('encoding');
$delimiter = get_input('delimiter');
$notification = get_input('notification');
$confirm = get_input('confirm', false);

/// Set the parameters
$upload->setEncoding($encoding);
$upload->setDelimiter($delimiter);
$upload->setNotification($notification);


if (!$confirm) {
	/// Open the file
	if (!$upload->openFile('csvfile')) {
		forward("admin/users/upload");
	}

	/// Process the file
	if (!$upload->processFile()) {
		forward("admin/users/upload");
	}

	/// Check the users
	$upload->checkUsers();
	/// Print the processed users for confirmation
	$body = $upload->getConfirmationReport();
	$title = elgg_view_title(elgg_echo('upload_users:process_report'));
/// Create the users and print the report
} else {
	/// Create the users
	$upload->createUsers($_POST);
	/// Everything was fine -> Display the creation report
	$body = $upload->getCreationReport();
	$title = elgg_view_title(elgg_echo('upload_users:creation_report'));
}

elgg_pop_context();

header('Content-type: text/html');
print $body;
exit;