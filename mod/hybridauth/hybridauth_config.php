<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------


global $CONFIG;
$base_url = $CONFIG->url . 'hybridauth/endpoint';

$hybridauth_config = 	array(
	"base_url" => $base_url, 
	
	"providers" => array(
		/*
		"OpenID" => array("enabled" => true),
		"AOL"  => array("enabled" => true),
		"Yahoo" => array("enabled" => true, "keys" => array( "id" => "", "secret" => "" )),
		"Google" => array("enabled" => true, "keys" => array( "id" => "", "secret" => "" )),
		"Facebook" => array("enabled" => true, "keys" => array( "id" => "", "secret" => "" )),
		"Foursquare" => array("enabled" => true, "keys" => array( "id" => "", "secret" => "" ))
		"Live" => array("enabled" => true, "keys" => array( "id" => "", "secret" => "" )),
		"Twitter" => array("enabled" => true, "keys" => array( "key" => "", "secret" => "" )),
		"MySpace" => array("enabled" => true, "keys" => array( "key" => "", "secret" => "" )),
		"LinkedIn" => array("enabled" => true, "keys" => array( "key" => "", "secret" => "" )),
		*/
	),
	
	// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
	"debug_mode" => false,
	
	"debug_file" => "",
);

$providers = array('twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google', 'facebook' => 'Facebook');

foreach ($providers as $key => $name) {
	// Add provider only if activated
	if (elgg_get_plugin_setting($key.'_enable', 'hybridauth') == 'yes') {
		// Settings may vary from one to another
		switch($key) {
			case 'openid':
			case 'aol':
				$hybridauth_config["providers"][$name] = array("enabled" => true);
				break;
		
			case 'yahoo':
			case 'google':
			case 'facebook':
			case 'foursquare':
				$hybridauth_config["providers"][$name] = array(
						"enabled" => true, 
						"keys" => array(
							"id" => elgg_get_plugin_setting($key.'_apikey', 'hybridauth'), 
							"secret" => elgg_get_plugin_setting($key.'_secret', 'hybridauth'),
						)
					);
				break;
		
			case 'twitter':
			case 'myspace':
			case 'linkedin':
				$hybridauth_config["providers"][$name] = array(
						"enabled" => true, 
						"keys" => array(
							"key" => elgg_get_plugin_setting($key.'_apikey', 'hybridauth'), 
							"secret" => elgg_get_plugin_setting($key.'_secret', 'hybridauth')
							)
					);
				break;
		
			default:
				$hybridauth_config["providers"][$name] = array("enabled" => true, "keys" => array( "id" => "", "secret" => "" ));
		}
	}
}



return $hybridauth_config;


