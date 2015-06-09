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
		
		// Logout
		if (get_input('linkedin_logout', false) == 'logout') {
			$linkedin->logout(); 
			$content .= 'Logged out from Linkedin..'; 
			$content .= '<span style="float:right;"><a class="elgg-button elgg-button-action" href="?">Log to Linkedin</a></span>'; 
			
		} else {
			
			$user_profile = $linkedin->getUserProfile();
			$content .= '<span style="float:right;"><a class="elgg-button elgg-button-action" href="?linkedin_logout=logout">Couper la connexion à Linkedin</a></span>';
			$content .= '<p>You are now connected with <b>Linkedin</b> as <b>' . $user_profile->displayName . '</b></p>';
			
			// Scope : must accept full profile info, can be set in the application settings
			// Required scopes : r_basicprofile, r_fullprofile
			
			/* Use this form to make some things with the data
			$content .= '<form action="" method="POST">';
			// Do things with the data
			$content .= '</form>';
			*/
			
			/*
			// User profile data
			//$content .= '<pre>" . print_r( $user_profile, true ) . "</pre><br />";
			$content .= '<p>Profile URL : " . $user_profile->profileURL . '</p>';
			$content .= '<p>Photo URL : " . $user_profile->photoURL . '</p>';
			$content .= '<p>Description : " . $user_profile->description . '</p>';
			*/
		
			//$xml_response = $linkedin->api()->profile('~:(public-profile-url,picture-url,summaryheadline,industry,current-status,educations,positions,skill,language,publication,company,certifications,three-past-positions)');
			$xml_response = $linkedin->api()->profile('~:(public-profile-url,picture-url,summary,headline,industry,current-status,educations,positions,skills,languages,publications,certifications,three-past-positions)');
			$user_fullprofile = @ new SimpleXMLElement( $xml_response['linkedin'] );
			$content .= '<p><strong>Public profile URL :</strong> <a href="' . $user_fullprofile->{'public-profile-url'} . '">' . $user_fullprofile->{'public-profile-url'} . '</a></p>';
			$content .= '<p><strong>Photo URL :</strong> ' . $user_fullprofile->{'picture-url'} . ' <img src="' . $user_fullprofile->{'picture-url'} . '" style="float:right;" /></p>';
			$content .= '<p><strong>Industry :</strong> ' . $user_fullprofile->industry . '</p>';
			$content .= '<p><strong>Headline :</strong> ' . $user_fullprofile->headline . '</p>';
			$content .= '<p><strong>Current-status :</strong> ' . $user_fullprofile->{'current-status'} . '</p>';
			$content .= '<p><strong>Description :</strong> ' . $user_fullprofile->summary . '</p>';
			/*
			$content .= '<p>Educations (current only) : ";
			foreach ($user_fullprofile->educations as $education) {
				$content .= print_r($education, true);
			}
			$content .= '</p>';
			*/
			$content .= '<p><strong>Current position :</strong> ';
			foreach ($user_fullprofile->positions->position as $position) {
				$start_date = $position->{'start-date'}->month . ' ' . $position->{'start-date'}->year;
				$content .= '<h4>' . $position->title . '</h4><p>' . $position->company->name . ' (' . $position->company->type . ', ' . $position->company->industry . ') <i>since ' . $start_date . '</i></p>';
				$content .= '<p>' . $position->summary . '</p>';
				//$content .= print_r($position, true);
			}
			$content .= '</p>';
		
			//$content .= '<pre>' . print_r( $user_fullprofile, true ) . "</pre><br />";
		
			/* Full list of available Linkedin data 
	<person>
		<id>
		<first-name />
		<last-name />
		<headline>
		<location>
		  <name>
		  <country>
		    <code>
		  </country>
		</location>
		<industry>
		<distance>
		<relation-to-viewer>
		  <distance>
		</relation-to-viewer>
		<num-recommenders>
		<current-status>
		<current-status-timestamp>
		<connections total="" >
		<summary/>
		<positions total="">
		  <position>
		    <id>
		    <title>
		    <summary>
		    <start-date>
		      <year>
		      <month>
		    </start-date>
		    <is-current>
		    <company>
		      <name>
		    </company>
		  </position>
		<educations total="">
		  <education>
		    <id>
		    <school-name>
		    <degree>
		    <start-date>
		      <year>
		    </start-date>
		    <end-date>
		      <year>
		    </end-date>
		  </education>
		</educations>
		<member-url-resources>
		  <member-url>
		    <url>
		    <name>
		  </member-url>
		<api-standard-profile-request>
		  <url>
		  <headers>
		    <http-header>
		      <name>
		      <value>
		    </http-header>
		  </headers>
		</api-standard-profile-request>
		<site-standard-profile-request>
		  <url>
		</site-standard-profile-request>
		<picture-url>
	</person>
			*/
			
		}
	}
}
catch( Exception $e ) {  
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
		case 5 : $content .= "Authentication failed. " 
				  . "The user has canceled the authentication or the provider refused the connection."; 
			   break;
		case 6 : $content .= "User profile request failed. Most likely the user is not connected "
				  . "to the provider and he should to authenticate again."; 
			   $linkedin->logout();
			   break;
		case 7 : $content .= "User not connected to the provider."; 
			   $linkedin->logout();
			   break;
		case 8 : $content .= "Provider does not support this feature."; break;
	} 

	// well, basically your should not display this to the end user, just give him a hint and move on..
	$content .= "<br /><br /><b>Original error message:</b> " . $e->getMessage();

	$content .= "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>"; 

	/*
		// If you want to get the previous exception - PHP 5.3.0+ 
		// http://www.php.net/manual/en/language.exceptions.extending.php
		if ( $e->getPrevious() ) {
			$content .= "<h4>Previous exception</h4> " . $e->getPrevious()->getMessage() . "<pre>" . $e->getPrevious()->getTraceAsString() . "</pre>";
		}
	*/
}


$title = "Linkedin details";

$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => ''));
$body = $content;

// Affichage
echo elgg_view_page($title, $body);


