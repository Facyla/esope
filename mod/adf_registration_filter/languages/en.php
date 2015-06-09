<?php
/**
 * English strings
 */


$en = array(
	
	// Overrides default message
	'invitefriends:introduction' => "To invite other people to join this site, please add their email addresses below (one per line).<br />
	Warning: registration is restricted to a defined list of email domains, please only invite allowed email addresses. You can check this list on the registration page.",
	
	'RegistrationException:NotAllowedEmail' => "Invalid domain. The email address does not belong to the list of allowed email domains. You connect use it to register on this site. Please use one of the allowed email domains listed on registration page.",
	'registration_filter:whitelist' => "Allowed registration domain list. One domain per line, no white space.<br />You can also use commas as separators.",
	'registration_filter:whitelist:default' => "",
	'registration_filter:register:whitelist' => "Registration is restricted to the following email address domains, please check it before registering: ",
	
);

add_translation('en', $en);
