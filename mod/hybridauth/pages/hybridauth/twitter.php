<?php
global $CONFIG;

$content = '';

// config and includes
$config = dirname(dirname(dirname(__FILE__))) . '/hybridauth_config.php';

try{
	// hybridauth EP
	$hybridauth = new Hybrid_Auth( $config );

	// automatically try to login with Twitter
	$twitter = $hybridauth->authenticate( "Twitter" );

	// return TRUE or False <= generally will be used to check if the user is connected to twitter before getting user profile, posting stuffs, etc..
	$is_user_logged_in = $twitter->isUserConnected();
	
	if ($is_user_logged_in) {
		// User profile data
		$user_profile = $twitter->getUserProfile();
		$twitter_unique_id = $user_profile->identifier;
		$twitter_username = $user_profile->displayName;
		$twitter_name = $user_profile->firstName;
		$twitter_description = $user_profile->description;
		$twitter_website = $user_profile->webSiteURL;
		$twitter_profileurl = $user_profile->profileURL;
		$twitter_photourl = $user_profile->photoURL;
		$twitter_location = $user_profile->region;
	
		$content .= '<img src="' . $CONFIG->url . 'mod/hybridauth/graphics/twitter.png" style="float:left;" />';
		$content .= "<p>You are now connected with <b>{$twitter->id}</b> as <b>{$twitter_username}</b></p>";
		//$content .= "Your unique Twitter identifier is: <b>{$twitter_unique_id}</b><br />";  
		//$content .= "<pre>" . print_r( $user_profile, true ) . "</pre><br />";
	
		// Check if user is registered locally - note we cannot use email (not provided by Twitter API)
		// As we cannot rely on email, we need to associate an existing account with Twitter : $user->hybridauth_twitter_uniqid = $twitter_username;
	
		// We're now logged in with Twitter, so check which user is associated to this account
		$associated_users = elgg_get_entities_from_metadata(array('metadata_names' => 'hybridauth_twitter_uniqid', 'metadata_values' => $twitter_unique_id, 'types' => 'user'));
		$associated_user = false;
		if ($associated_users) { $associated_user = $associated_users[0]; }
		// Check if we're already logged in
		if (elgg_is_logged_in()) { $user = elgg_get_logged_in_user_entity(); }
	
		// Note : we need 2 separate "if" so we can perform post-login actions
		if (!elgg_is_logged_in()) {
			if ($associated_user) {
				// Log in the associated user
				login($associated_user);
				$user = $associated_user;
			} else {
				// Note : we need to login user first, or register it, beccause we need to guarantee the association
			
				// Is there any account with same username ?
				$user = get_user_by_username($user_profile->displayName);
		
				// Explain options
				$content .= "<p><strong>There is no account associated with this Twitter account yet. You have 2 options :</strong></p>";
				if ($user) {
					$content .= "<p><strong>There is an existing account using the same username $twitter_username.</strong><br />If you own this account, we suggest you prefer option 1 and login to associate it with your Twitter account. If you don't, please use another username to register.</p>";
				} else {
					if (strlen($twitter_username) >= 4) {
						$content .= "<p><strong>The username $twitter_username is available on this site.<br />If you do not have any account yet, you may use this username to register.</strong></p>";
					}
				}
				$content .= '<h4>Login to associate your account with Twitter</h4>';
				$content .= "<p>Use this option if you already have an account and wish to associate it with your Twitter account $twitter_username.<br />Please use the form below to login, and get back to this page to confirm the association with your Twitter account.<br />You'll be then able to login directly with Twitter.</p>";
				$content .= '<p><a href="#hybridauth-twitter-login" rel="toggle" class="elgg-button elgg-button-action">Login now</a></p>';
				$login_vars = array('returntoreferer' => full_url());
				if ($user) $login_vars['username'] = $twitter_username;
				$content .= '<div id="hybridauth-twitter-login" style="display:none;">' . elgg_view_form('login', null, $login_vars) . '</div>';
				$content .= '<div class="clearfloat"></div>';
				$content .= '<h4>Or create an account on this site</h4>';
				$content .= "<p>Prefer this option if you do not have any account on this site, or wish to associate your Twitter account $twitter_username with a new account.<br />Please complete the registration form with a valid email address, and confirm the registration.<br />Once your account is created, it will be associated with your Twitter account so we will be able to login with Twitter.</p>";
				$content .= '<p><a href="#hybridauth-twitter-register" rel="toggle" class="elgg-button elgg-button-action">Create an account now</a></p>';
				$register_vars = array('name' => $twitter_name);
				if (!$user) $register_vars['username'] = $twitter_username;
				$content .= '<div id="hybridauth-twitter-register" style="display:none;">' . elgg_view_form('register', null, $register_vars) . '</div>';
				$content .= '<div class="clearfloat"></div>';
			}
		}
	
		if (elgg_is_logged_in()) {
			// Create association if it none exist yet
			if (!$associated_user) {
				// No association means we need to associate with currently logged in user, or login/register to associate with an existing user
				$user->hybridauth_twitter_uniqid = $twitter_unique_id; // Really unique user ID
				$content .= "<p>No account was associated with this Twitter account yet. Association successful : you can now login with your Twitter account.</p>";
				$associated_user = $user;
			}
		
			// These are the option people get once all is set up (association done)
			// If we already have an association, then we can login safely, or check the association if already logged in
			// Already logged in => associated user has to remain unique so we can login with it
			if ($associated_user->guid != $user->guid) {
				// Another user is associated with this Twitter account => cannot associate nor update
				$content .= "<p>Another account is already associated with this Twitter account : sorry but cannot continue with association.<br />Logging out from Twitter.</p>";
				$twitter->logout();
			} else {
				// Same user as logged in => any further action is allowed
				$content .= "<p><strong>Account {$user->username} ({$user->name}) is associated with your Twitter account $twitter_username.</strong> You can login with Twitter.</p>";
				// Revoke association
				$revoke_access = get_input('revoke', false);
				if ($revoke_access) {
					$content .= '<p>Twitter association removed. You can <a href="' . $CONFIG->url . 'hybridauth/twitter">set up a new Twitter association</a> or keep browsing the site</p>';
					$user->hybridauth_twitter_uniqid = null;
					$twitter->logout();
				} else {
					$content .= "<p>Do you want to revoke access with Twitter ? If you do this, you won't be able to connect with Twitter anymore.<br /><em>Note : you will be able to enable a new Twitter association at any time.</em></p>";
					$content .= '<p><a href="?revoke=' . $twitter_unique_id . '" class="elgg-button elgg-button-action">Revoke Twitter association</a></p>';
				}
				// @TODO allow multiple associations ?
				//$content .= "<p>(FUTURE) You can also add another association if you wish to login with other Twitter accounts.</p>";
			}
		}
	
	
		// User contacts
		/*
		$user_contacts = $twitter->getUserContacts();
		$content .= "User contacts: <br /><pre>" . print_r( $user_contacts, true ) . "</pre><br />";
		*/
	
		// User activity
		/*
		$user_activity = $twitter->getUserActivity();
		$content .= "User activity: <br /><pre>" . print_r( $user_activity, true ) . "</pre><br />";
		*/
	
		// uncomment the line below to post something to twitter if you want to
		// $twitter->setUserStatus( "Hello world!" );

		// ex. on how to access the twitter api with hybridauth
		//     Returns the current count of friends, followers, updates (statuses) and favorites of the authenticating user.
		//     https://dev.twitter.com/docs/api/1/get/account/totals
		// print recived stats 
		/*
		$account_totals = $twitter->api()->get( 'account/totals.json' );0
		$content .= "Here some of yours stats on Twitter:<br /><pre>" . print_r( $account_totals, true ) . "</pre>";
		*/

		// logout
		/*
		$content .= "Logging out.."; 
		$twitter->logout();
		*/
	}
	
} catch(Exception $e) {
	// In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
	// let hybridauth forget all about the user so we can try to authenticate again.

	// Display the recived error, 
	// to know more please refer to Exceptions handling section on the userguide
	switch($e->getCode()){ 
		case 0 : $content .= "Unspecified error."; break;
		case 1 : $content .= "Hybridauth configuration error."; break;
		case 2 : $content .= "Provider not properly configured."; break;
		case 3 : $content .= "Unknown or disabled provider."; break;
		case 4 : $content .= "Missing provider application credentials."; break;
		case 5 : $content .= "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
		case 6 : $content .= "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
			$twitter->logout();
			break;
		case 7 : $content .= "User not connected to the provider.";
			$twitter->logout();
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


$title = "Hybridauth Twitter integration";

$body = elgg_view_layout('one_column', array('content' => $content));

// Affichage
echo elgg_view_page($title, $body);

