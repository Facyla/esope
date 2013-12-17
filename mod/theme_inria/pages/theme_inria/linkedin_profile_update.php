<?php
global $CONFIG;

if (!elgg_is_active_plugin('hybridauth')) forward();
gatekeeper();

$own = elgg_get_logged_in_user_entity();
$content = '';

// config and includes
elgg_load_library('hybridauth');
elgg_load_library('elgg:hybridauth');
$config = dirname(dirname(dirname(dirname(__FILE__)))) . '/hybridauth/hybridauth_config.php';


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
			$content .= elgg_echo('hybridauth:linkedin:loggedout'); 
			$content .= '<span style="float:right;"><a class="elgg-button elgg-button-action" href="?">' . elgg_echo('hybridauth:linkedin:logged', array('LinkedIn')) . '</a></span>'; 
			
		} else {
			
			// User profile data
			$user_profile = $linkedin->getUserProfile(); // Limited fields
			$content .= '<span style="float:right;"><a class="elgg-button elgg-button-action" href="?linkedin_logout=logout">' . elgg_echo('hybridauth:linkedin:logout') . '</a></span>';
			$content .= '<p>' . elgg_echo('hybridauth:linkedin:logged', array('Linkedin', $user_profile->displayName)). '</p>';
			
			$xml_response = $linkedin->api()->profile('~:(public-profile-url,picture-urls::(original),summary,headline,industry,current-status,educations,positions,skills,languages,publications,certifications,three-past-positions)');
			$user_profile = @ new SimpleXMLElement( $xml_response['linkedin'] );
			
			// Scope : must accept full profile info, which can be set in the application settings
			// Required scope : r_fullprofile
			
			// Prepare some fields
			$positions = '';
			foreach ($user_profile->positions->position as $position) {
				$start_date = $position->{'start-date'}->month . ' ' . $position->{'start-date'}->year;
				$positions .= '<h4>' . $position->title . '</h4><p>' . $position->company->name . ' (' . $position->company->type . ', ' . $position->company->industry . ') <i>since ' . $start_date . '</i></p>';
				$positions .= '<p>' . $position->summary . '</p>';
			}
			$skills = print_r($user_profile->skills, true);
			
			// Traitement du formulaire
			$mapped_fields = array('public-profile-url' => "linkedin", 'photo' => 'avatar', 'industry' => 'industry', 'headline' => 'briefdescription', 'status' => 'briefdescription', 'summary' => 'description', 'positions' => 'description');
			foreach ($mapped_fields as $field => $elgg_field) {
				if (get_input($field) == 'yes') {
					switch ($field) {
						case 'photo':
							$img_url = $user_profile->{'picture-urls'}->{'picture-url'};
							if (hybridauth_update_avatar($img_url, $own)) $form_report .= 'Photo...OK<br />';
							break;
						
						case 'skills':
							$own->skills = $own->{$elgg_field} . ', ' . $skills;
							$form_report .= 'Skills...OK<br />';
							break;
						
						case 'positions':
							$own->description = $own->{$elgg_field} . '<hr .>' . $positions;
							$form_report .= 'Pro...OK<br />';
							break;
						
						// Complete briefdescription field (add at the end)
						case 'headline':
						case 'status':
							$own->briefdescription = $own->briefdescription . '<hr .>' . $user_profile->{$field};
							$form_report .= 'Brief description...OK<br />';
							break;
						
						// Complete description field (add at the end)
						case 'summary':
							$own->description = $own->description . '<hr .>' . $user_profile->{$field};
							$form_report .= 'Description...OK<br />';
							break;
						
						// Update fields (replace)
						default:
							$own->{$elgg_field} = $user_profile->{$field};
							$form_report .= $field . '...OK<br />';
					}
				}
			}
			if (!empty($form_report)) {
				$str_editprofile = '<a href="' . $CONFIG->url . 'profile/' . $own->username . '/edit">' . elgg_echo('hybridauth:linkedin:editprofile'). '</a>';
				$str_editavatar = '<a href="' . $CONFIG->url . 'avatar/edit/' . $own->username . '">' . elgg_echo('hybridauth:linkedin:editavatar'). '</a>';
				$str_viewprofile = '<a href="' . $CONFIG->url . 'profile/' . $own->username . '">' . elgg_echo('hybridauth:linkedin:viewprofile'). '</a>';
				$content .= '<blockquote><strong>' . elgg_echo('hybridauth:linkedin:import:done') . '</strong><br />' . $form_report;
				$content .= '<p>' . elgg_echo('hybridauth:linkedin:import:after', array($str_editprofile, $str_editavatar, $str_viewprofile)) . '</p>';
				$content .= '<hr /></blockquote>';
			}
			
			
			// Formulaire pour MAJ des infos
			$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
			$content .= '<form action="" method="POST">';
			$content .= elgg_view('input/securitytokens');
			
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:public-profile-url') . ' : ' . elgg_view('input/dropdown', array('name' => 'public-profile-url', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p><a target="_new" href="' . $user_profile->{'public-profile-url'} . '">' . $user_profile->{'public-profile-url'} . '</a></p>';
			
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:photo') . ' : ' . elgg_view('input/dropdown', array('name' => 'photo', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $user_profile->{'picture-urls'}->{'picture-url'} . ' <img src="' . $user_profile->{'picture-urls'}->{'picture-url'} . '" style="float:right;" /></p>';
			
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:industry') . ' : ' . elgg_view('input/dropdown', array('name' => 'industry', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $user_profile->industry . '</p>';
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:headline') . ' : ' . elgg_view('input/dropdown', array('name' => '', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $user_profile->headline . '</p>';
			
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:status') . ' : ' . elgg_view('input/dropdown', array('name' => 'status', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $user_profile->{'current-status'} . '</p>';
			
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:summary') . ' : ' . elgg_view('input/dropdown', array('name' => 'summary', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $user_profile->summary . '</p>';
			/* Empty if not a student ?
			$content .= '<p>Educations (current only) : ";
			foreach ($user_profile->educations as $education) {
				$content .= print_r($education, true);
			}
			$content .= '</p>';
			*/
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:positions') . ' : ' . elgg_view('input/dropdown', array('name' => 'positions', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $positions . '</p>';
		
			$content .= '<label>' . elgg_echo('hybridauth:linkedin:import:skills') . ' : ' . elgg_view('input/dropdown', array('name' => 'skills', 'options_values' => $no_yes_opt, 'value' => 'no')) . '</label>';
			$content .= '<p>' . $skills . '</p>';
		
			//$content .= '<pre>' . print_r( $user_profile, true ) . "</pre><br />";
		
			/* List of available Linkedin data 
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
				<num-recommenders>
				<current-status>
				<current-status-timestamp>
				<connections total="" >
				<summary/>
			*/
			
			$content .= elgg_view('input/submit', array('value' => elgg_echo('hybridauth:linkedin:import')));
			$content .= '</form>';
			
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


