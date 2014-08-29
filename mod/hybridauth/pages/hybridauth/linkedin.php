<?php
global $CONFIG;

$content = '';

// config and includes
$config = dirname(dirname(dirname(__FILE__))) . '/hybridauth_config.php';

try{
	// hybridauth EP
	$hybridauth = new Hybrid_Auth( $config );

	// automatically try to login with Linkedin
	$linkedin = $hybridauth->authenticate( "LinkedIn" );

	// return TRUE or False <= generally will be used to check if the user is connected to linkedin before getting user profile, posting stuffs, etc..
	$is_user_logged_in = $linkedin->isUserConnected();
	
	if ($is_user_logged_in) {
		// User profile data
		$user_profile = $linkedin->getUserProfile();
		$linkedin_username = $user_profile->displayName;
		$linkedin_uniqid = $user_profile->identifier;
		
		$content .= '<img src="' . $CONFIG->url . 'mod/hybridauth/graphics/linkedin.png" style="float:left;" />';
		$content .= "<p>You are now connected with <b>{$linkedin->id}</b> as <b>{$linkedin_username}</b></p>";
		//$content .= "And your provider user identifier is: <b>{$linkedin_uniqid}</b><br />";  
		//$content .= "<pre>" . print_r( $user_profile, true ) . "</pre><br />";
		
		if (elgg_is_logged_in()) { $user = elgg_get_logged_in_user_entity(); }
		
		// @TODO : internalize Twitter version first, then adapt here
		
		
		// User contacts
		/*
		$user_contacts = $linkedin->getUserContacts();
		$content .= "User contacts: <br /><pre>" . print_r( $user_contacts, true ) . "</pre><br />";
		*/
	
		// User activity
		/*
		$user_activity = $linkedin->getUserActivity();
		$content .= "User activity: <br /><pre>" . print_r( $user_activity, true ) . "</pre><br />";
		*/
	
		// Set status : post something to linkedin if you want to
		// $linkedin->setUserStatus( "Hello world!" );

		// ex. on how to access the linkedin api with hybridauth
		//     Returns the current count of friends, followers, updates (statuses) and favorites of the authenticating user.
		//     https://dev.linkedin.com/docs/api/1/get/account/totals
		//$account_totals = $linkedin->api()->get( 'account/totals.json' ); // see linkedin api doc
		//$content .= "Here some of yours stats on Linkedin:<br /><pre>" . print_r( $account_totals, true ) . "</pre>";

		// logout
		/*
		$content .= "Logging out.."; 
		$linkedin->logout(); 
		*/
	}
	
} catch( Exception $e ) {
	// In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
	// let hybridauth forget all about the user so we can try to authenticate again.

	// Display the recived error, 
	// to know more please refer to Exceptions handling section on the userguide
	switch( $e->getCode() ){
		case 0 : $content .= "Unspecified error."; break;
		case 1 : $content .= "Hybridauth configuration error."; break;
		case 2 : $content .= "Provider not properly configured."; break;
		case 3 : $content .= "Unknown or disabled provider."; break;
		case 4 : $content .= "Missing provider application credentials."; break;
		case 5 : $content .= "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
		case 6 : $content .= "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
			$linkedin->logout();
			break;
		case 7 : $content .= "User not connected to the provider."; 
			$linkedin->logout();
			break;
		case 8 : $content .= "Provider does not support this feature."; break;
	}
	
	// well, basically your should not display this to the end user, just give him a hint and move on..
	/*
	$content .= "<br /><br /><b>Original error message:</b> " . $e->getMessage();
	$content .= "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>"; 
	*/

	/*
		// If you want to get the previous exception - PHP 5.3.0+ 
		// http://www.php.net/manual/en/language.exceptions.extending.php
		if ( $e->getPrevious() ) {
			$content .= "<h4>Previous exception</h4> " . $e->getPrevious()->getMessage() . "<pre>" . $e->getPrevious()->getTraceAsString() . "</pre>";
		}
	*/
}


$title = "Hybridauth Linkedin integration";

$body = elgg_view_layout('one_column', array('content' => $content));

// Affichage
echo elgg_view_page($title, $body);


