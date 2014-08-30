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
		$linkedin_unique_id = $user_profile->identifier;
		$linkedin_name = $user_profile->firstName . ' ' . $user_profile->lastName;
		$linkedin_description = $user_profile->description;
		$linkedin_website = $user_profile->webSiteURL;
		$linkedin_profileurl = $user_profile->profileURL;
		$linkedin_photourl = $user_profile->photoURL;
		$linkedin_location = $user_profile->region;
		$linkedin_email = $user_profile->emailVerified;
		if (empty($linkedin_email)) $linkedin_email = $user_profile->email;
		
		$content .= '<img src="' . $CONFIG->url . 'mod/hybridauth/graphics/linkedin.png" style="float:left;" />';
		$content .= '<p>' . elgg_echo('hybridauth:connectedwith', array($linkedin->id, $linkedin_username)) . '</p>';
		//$content .= "And your provider user identifier is: <b>{$linkedin_unique_id}</b><br />";  
		//$content .= "<pre>" . print_r( $user_profile, true ) . "</pre><br />";
		
		if (elgg_is_logged_in()) { $user = elgg_get_logged_in_user_entity(); }
		
		// We're now logged in with LinkedIn, so check which user is associated to this account
		// A matching email is considered as a valid authentication (no need to add an explicit association)
		$email_user = get_user_by_email($linkedin_email);
		if (elgg_instanceof($email_user, 'user')) {
			$associated_user = $email_user;
		}
		// If email doesn't match, we can use explicit association (let's associate with a different email)
		if (!associated_user) {
			$associated_users = elgg_get_entities_from_metadata(array('metadata_names' => 'hybridauth_linkedin_uniqid', 'metadata_values' => $linkedin_unique_id, 'types' => 'user'));
			$associated_user = false;
			if ($associated_users) { $associated_user = $associated_users[0]; }
		}
		
		// Check if we're already logged in
		if (elgg_is_logged_in()) { $user = elgg_get_logged_in_user_entity(); }
	
		// Note : we need 2 separate "if" so we can perform post-login actions
		if (!elgg_is_logged_in()) {
			if ($associated_user) {
				// Log in the associated user
				login($associated_user);
				$user = $associated_user;
			} else {
				// Login/register to associate with an existing user
				// Note : we need to login user first, or register it, beccause we need to guarantee the association
			
				// Is there any account with same username ?
				$user = get_user_by_username($user_profile->displayName);
		
				// Explain options
				$content .= '<p><strong>' . elgg_echo('hybridauth:noacccount') . '</strong></p>';
				if ($user) {
					$content .= '<p>' . elgg_echo('hybridauth:existingacccount', array($linkedin_username, 'LinkedIn')) . '</p>';
				} else {
					if (strlen($linkedin_username) >= 4) {
						$content .= '<p><strong>' . elgg_echo('hybridauth:availableusername', array($linkedin_username)) . '</p>';
					}
				}
				$content .= '<h4>' . elgg_echo('hybridauth:logintoassociate', array('LinkedIn')) . '</h4>';
				$content .= '<p>' . elgg_echo('hybridauth:logintoassociate:details', array('LinkedIn', $linkedin_username, 'LinkedIn', 'LinkedIn')) . '</p>';
				$content .= '<p><a href="#hybridauth-linkedin-login" rel="toggle" class="elgg-button elgg-button-action">' . elgg_echo('hybridauth:loginnow') . '</a></p>';
				$login_vars = array('returntoreferer' => full_url());
				if ($user) $login_vars['username'] = $linkedin_username;
				$content .= '<div id="hybridauth-linkedin-login" style="display:none;">' . elgg_view_form('login', null, $login_vars) . '</div>';
				$content .= '<div class="clearfloat"></div>';
				$content .= '<h4>' . elgg_echo('hybridauth:registertoassociate') . '</h4>';
				$content .= '<p>' . elgg_echo('hybridauth:registertoassociate:details', array('LinkedIn', $linkedin_username, 'LinkedIn', 'LinkedIn')) . '</p>';
				$content .= '<p><a href="#hybridauth-linkedin-register" rel="toggle" class="elgg-button elgg-button-action">' . elgg_echo('hybridauth:registernow') . '</a></p>';
				$register_vars = array('name' => $linkedin_name);
				if (!$user) $register_vars['username'] = $linkedin_username;
				$content .= '<div id="hybridauth-linkedin-register" style="display:none;">' . elgg_view_form('register', null, $register_vars) . '</div>';
				$content .= '<div class="clearfloat"></div>';
			}
		}
	
		if (false && elgg_is_logged_in()) {
			// Create association if it none exist yet
			if (!$associated_user) {
				// No association means we need to associate with currently logged in user
				$user->hybridauth_linkedin_uniqid = $linkedin_unique_id; // Really unique user ID
				$content .= '<p>' . elgg_echo('hybridauth:association:success', array('LinkedIn')) . '</p>';
				$associated_user = $user;
			}
		
			// These are the option people get once all is set up (association done)
			// If we already have an association, then we can login safely, or check the association if already logged in
			// Already logged in => associated user has to remain unique so we can login with it
			if ($associated_user->guid != $user->guid) {
				// Another user is associated with this LinkedIn account => cannot associate nor update
				$content .= '<p>' . elgg_echo('hybridauth:otheraccountassociated', array('LinkedIn', 'LinkedIn')) . '</p>';
				$linkedin->logout();
			} else {
				// Same user as logged in => any further action is allowed
				$content .= '<p><strong>' . elgg_echo('hybridauth:association:ok', array($user->username, $user->name, $linkedin_username, 'LinkedIn')) . '</p>';
				// Revoke association
				$revoke_access = get_input('revoke', false);
				if ($revoke_access) {
					$linkedin_association_link = '<a href="' . $CONFIG->url . 'hybridauth/linkedin">' . elgg_echo('hybridauth:association:link', array('LinkedIn')) . '</a>';
					$content .= '<p>' . elgg_echo('hybridauth:revokeassociation:success', array('LinkedIn', $linkedin_association_link)) . '</p>';
					$user->hybridauth_linkedin_uniqid = null;
					$linkedin->logout();
				} else {
					$content .= '<p>' . elgg_echo('hybridauth:revokeassociation:details', array('LinkedIn', 'LinkedIn')) . '</p>';
					$content .= '<p><a href="?revoke=' . $linkedin_unique_id . '" class="elgg-button elgg-button-action">' . elgg_echo('hybridauth:revokeassociation', array('LinkedIn')) . '</a></p>';
				}
				// @TODO allow multiple associations ?
				//$content .= "<p>(FUTURE) You can also add another association if you wish to login with other LinkedIn accounts.</p>";
			}
		}
		
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


