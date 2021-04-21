<?php
/**
 * English strings
 */

return [
	'account_lifecycle' => "Registration filter",
	
	// Plugin settings
	'account_lifecycle:whitelist_enable' => "Enable whitelist mode",
	'account_lifecycle:whitelist_enable:details' => "If enabled, only emails from the defined list of domains will be allowed to register on the site.",
	'account_lifecycle:blacklist_enable' => "Enable blacklist mode",
	'account_lifecycle:blacklist_enable:details' => "If enabled, emails matching the blacklist filter will not be allowed to register on the site.",
	'account_lifecycle:modes' => "While both modes can be enabled at the same time, it is usually useless to enable the blacklist mode if whitelist mode is already enabled, as only allowed domains will be allowed to register.",
	
	'account_lifecycle:extend_registration_form' => "Extend registration form",
	'account_lifecycle:extend_registration_form:details' => "<strong>Yes&nbsp;:</strong> adds the list of allowed domains to the registration form (<em>forms/register</em> view). If the list is too long, it will be shortened (185 chars) with a more link to display the full list.<br /><strong>No&nbsp;:</strong> registration form remains unchanged.",
	
	
	'account_lifecycle:whitelist' => "Allowed registration domain list.",
	'account_lifecycle:whitelist:details' => "One domain per line, no white space.<br />You can also use commas as separators.",
	'account_lifecycle:whitelist:default' => "",
	'account_lifecycle:register:whitelist' => "Registration is restricted to the following email address domains, please check it before registering: ",
	
	'account_lifecycle:blacklist' => "Forbidden registration domain list.",
	'account_lifecycle:blacklist:details' => "",
	'account_lifecycle:blacklist:default' => "", // Enables themes defaults
	
	
	// Overrides
	'invitefriends:introduction' => "To invite other people to join this site, please add their email addresses below (one per line).<br />
	Warning: registration is restricted to a defined list of email domains, please only invite allowed email addresses. You can check this list on the registration page.",
	
	'RegistrationException:NotAllowedEmail' => "Invalid domain. The email address does not belong to the list of allowed email domains. You connect use it to register on this site. Please use one of the allowed email domains listed on registration page.",
	
];

