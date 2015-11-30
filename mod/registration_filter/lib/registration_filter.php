<?php
// Validates the email against the admin-defined list of allowed email domains
function registration_filter($email = null) {
	
	// Quick test : email must at least be set, and can't be less than 6 cars long (ie. c@c.cc)
	if (!isset($email) || (strlen($email) < 6)) { return false; }
	
	// Domain must be at least 4 cars long (c.cc)
	$email_a = explode('@', $email);
	if (strlen($email_a[1]) < 4) { return false; }
	
	// Check active filter
	$whitelist_enable = elgg_get_plugin_setting('whitelist_enable', 'registration_filter');
	$blacklist_enable = elgg_get_plugin_setting('blacklist_enable', 'registration_filter');
	
	/* Whitelist mode */
	if ($whitelist_enable == 'yes') {
		// Get and prepare valid domain config array from plugin settings
		$whitelist = elgg_get_plugin_setting('whitelist', 'registration_filter');
		$whitelist = preg_replace('/\r\n|\r/', "\n", $whitelist);
		// Add csv support - cut also on ";" and ","
		$whitelist = str_replace(array(' ', '<p>', '</p>'), '', $whitelist); // Delete all white spaces
		$whitelist = str_replace(array(';', ','), "\n", $whitelist);
		$whitelist = explode("\n",$whitelist);
		
		//error_log($email_a[1] . " = " . implode(", ", $whitelist)); // debug
		// Exact match mode : email domain has to be in the list
		if (!in_array($email_a[1], $whitelist)) { return false; }
		// @TODO : enable wildcards ?
		/*
		if ($whitelist) foreach ($whitelist as $pattern) {
			$pattern = str_replace('.', '\.', $pattern);
			$pattern = str_replace('*', '.*', $pattern);
			if (preg_match($pattern, $url)) { return true; }
		}
		*/
	}
	
	/* Blacklist mode */
	if ($blacklist_enable == 'yes') {
		// Get and prepare valid domain config array from plugin settings
		$blacklist = elgg_get_plugin_setting('blacklist', 'registration_filter');
		$blacklist = preg_replace('/\r\n|\r/', "\n", $blacklist);
		// Add csv support - cut also on ";" and ","
		$blacklist = str_replace(array(' ', '<p>', '</p>'), '', $blacklist); // Delete all white spaces
		$blacklist = str_replace(array(';', ','), "\n", $blacklist);
		$blacklist = explode("\n",$blacklist);
		
		//error_log($email_a[1] . " = " . implode(", ", $blacklist)); // debug
		// Exact match mode : email domain has to be in the list
		if (in_array($email_a[1], $blacklist)) { return false; }
		// @TODO : enable wildcards mode (email domain terminal match)
		/*
		// @TODO : Allow wildcards : use ".*" as a wildcard (not "*"), and "\." for dots (not ".")
		// @TODO : auto-replace * and . so we can use simply *.domain.tld
		// @TODO : and also duplicate filter so we can have raw domain too => domain.tld)
		if ($blacklist) foreach ($blacklist as $pattern) {
			//@TODO tester en direct sur longueur dispo si * au début, sinon exact match - plus simple/rapide ?
			//if (substr())
			$pattern = str_replace('.', '\.', $pattern);
			$pattern = str_replace('*', '.*', $pattern);
			$pattern = "`^$pattern/*$`i";
			if (preg_match($pattern, $url)) { return false; }
		}
		*/
	}
	
	// If we've gotten so far.. it's OK !
	return true;
}

