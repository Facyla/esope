<?php
/**
 * English strings
 */

return array(
	'registration_filter' => "Registration filter",
	
	'registration_filter:whitelist_enable' => "Enable whitelist mode",
	'registration_filter:whitelist_enable:details' => "If enabled, only emails from the defined list of domains will be allowed to register on the site.",
	'registration_filter:blacklist_enable' => "Enable blacklist mode",
	'registration_filter:blacklist_enable:details' => "If enabled, emails matching the blacklist filter will not be allowed to register on the site.",
	'registration_filter:modes' => "While both modes can be enabled at the same time, it is usually useless to enable the blacklist mode if whitelist mode is already enabled, as only allowed domains will be allowed to register.",
	
	'registration_filter:whitelist' => "Allowed registration domain list.",
	'registration_filter:whitelist:details' => "One domain per line, no white space.<br />You can also use commas as separators.",
	'registration_filter:whitelist:default' => "",
	'registration_filter:register:whitelist' => "Registration is restricted to the following email address domains, please check it before registering: ",
	
	'registration_filter:blacklist' => "Forbidden registration domain list.",
	'registration_filter:blacklist:details' => "",
	'registration_filter:blacklist:default' => "", // Enables themes defaults
	
	
	// Overrides
	'invitefriends:introduction' => "To invite other people to join this site, please add their email addresses below (one per line).<br />
	Warning: registration is restricted to a defined list of email domains, please only invite allowed email addresses. You can check this list on the registration page.",
	
	'RegistrationException:NotAllowedEmail' => "Invalid domain. The email address does not belong to the list of allowed email domains. You connect use it to register on this site. Please use one of the allowed email domains listed on registration page.",
	
);

