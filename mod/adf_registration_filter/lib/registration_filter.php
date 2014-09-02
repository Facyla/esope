<?php
// Validates the email against the admin-defined list of allowed email domains
function adf_registration_filter($email = null) {
	
	// email must be set, and can't be less than 6 cars long (ie. c@c.cc)
	if (!isset($email) || (strlen($email) < 6)) return false;
	
	// Domain must be at least 4 cars long (c.cc)
	$email_a = explode('@', $email);
	if (strlen($email_a[1]) < 4) return false;
	
	// Get and prepare valid domain config array from plugin settings
	$whitelist = elgg_get_plugin_setting('whitelist', 'adf_registration_filter');
	$whitelist = preg_replace('/\r\n|\r/', "\n", $whitelist);
	// Add csv support - cut also on ";" and ","
	$whitelist = str_replace(array(' ', '<p>', '</p>'), '', $whitelist); // Delete all white spaces
	$whitelist = str_replace(array(';', ','), "\n", $whitelist);
	$whitelist = explode("\n",$whitelist);
	
	//error_log($email_a[1] . " = " . implode(", ", $whitelist)); // debug
	// Email domain has to be in the list
	if (!in_array($email_a[1], $whitelist)) { return false; }
	
	// If we've gotten so far.. it's OK !
	return true;
}

