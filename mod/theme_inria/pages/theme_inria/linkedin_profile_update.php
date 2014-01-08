<?php
global $CONFIG;

if (!elgg_is_active_plugin('hybridauth')) {
	register_error("Hybridauth must be activated and configured first !");
	forward();
}
gatekeeper();

elgg_push_context('LinkedIn');

$own = elgg_get_logged_in_user_entity();

$title = elgg_echo('hybridauth:linkedin:title');
$content = '';
$sidebar = '';

$content .= '<style>
#linkedin-import-form { padding: 10px 10px 10px 10px; }
#linkedin-import-form label { display: block; width: 20%; float: left; font-size:0.8em; }
.linkedin-import-field-content { border:1px solid #ccc; padding:2px 6px; margin:0; background:#f6f6f6; font-size:0.75em; float: right; width: 75%; min-height: 40px; }
.linkedin-photo { float:right; width:60px; }
</style>';


// config and includes
elgg_load_library('hybridauth');
elgg_load_library('elgg:hybridauth');
$config = dirname(dirname(dirname(dirname(__FILE__)))) . '/hybridauth/hybridauth_config.php';

// Try authentication
try{
	// hybridauth EP
	$hybridauth = new Hybrid_Auth( $config );

	// automatically try to login with Linkedin
	$linkedin = $hybridauth->authenticate( "LinkedIn" );

	// (bool) check if the user is connected to linkedin before getting user profile, posting stuffs, etc..
	$is_user_logged_in = $linkedin->isUserConnected();
	
	// Logged in ? fine, let's proceed !
	if ($is_user_logged_in) {
		
		// Logout asked
		if (get_input('linkedin_logout', false) == 'logout') {
			$linkedin->logout(); 
			$content .= elgg_echo('hybridauth:linkedin:loggedout'); 
			
			$sidebar .= '<a class="elgg-button elgg-button-action" href="?">' . elgg_echo('hybridauth:linkedin:login', array('LinkedIn')) . '</a>';
			
		} else {
			// Note on Scope : must accept full profile info for these data, which can be set in the application settings
			
			// User profile data
			//$user_profile = $linkedin->getUserProfile(); // Limited fields
			$xml_response = $linkedin->api()->profile('~:(first-name,last-name,public-profile-url,picture-urls::(original),summary,headline,industry,current-status,educations,positions,skills,languages,publications,certifications,three-past-positions)');
			$user_profile = @ new SimpleXMLElement( $xml_response['linkedin'] );
			
			
			// Format profile details makes clearer code..
			$display_name = $user_profile->{'first-name'} . ' ' . $user_profile->{'last-name'};
			$photo_url = $user_profile->{'picture-urls'}->{'picture-url'};
			$photo = '<a href="' . $photo_url . '" target="_blank"><img class="linkedin-photo" src="' . $photo_url . '" />' . $photo_url . '</a><div class="clearfloat"></div>';
			$summary = $user_profile->summary;
			$profile_url = '<a target="_blank" href="' . $user_profile->{'public-profile-url'} . '">' . $user_profile->{'public-profile-url'} . '</a>';
			$industry = $user_profile->industry;
			$headline = $user_profile->headline;
			$status = $user_profile->{'current-status'}; //current-status-timestamp could be useful, as it may be quite old...
			// Skills
			$skills = array();
			foreach ($user_profile->skills->skill as $skill) { $skills[] = $skill->skill->name; }
			$skills = implode(', ', $skills);
			// Positions
			$positions = '';
			foreach ($user_profile->positions->position as $position) {
				if ($position->{'is-current'} == 'false') continue; // Skip previous positions
				$start_date = $position->{'start-date'}->year;
				if (!empty($position->{'start-date'}->month)) $start_date = $position->{'start-date'}->month . '/' . $start_date;
				$end_date = $position->{'end-date'}->year;
				if (!empty($position->{'end-date'}->month)) $end_date = $position->{'end-date'}->month . '/' . $end_date;
				if ($position->{'is-current'} == 'true') { $start_date .= ' - ' . elgg_echo('now'); } else { $start_date .= ' - ' . $end_date; }
				$positions .= '<h4>' . $position->title . '</h4>';
				$positions .= '<p>';
				$positions .= $position->company->name;
				$details = '';
				if (!empty($position->company->type)) $details .= $position->company->type;
				if (!empty($position->company->industry)) {
					if (!empty($details)) $details .= ', ';
					$details .= $position->company->industry;
				}
				if (!empty($details)) $positions .= ' (' . $details . ')';
				$positions .= ' <i>' . $start_date . '</i>';
				$positions .= '</p>';
				if (!empty($position->summary)) $positions .= '<p>' . $position->summary . '</p>';
			}
			// Education
			$educations = '';
			foreach ($user_profile->educations->education as $education) {
				$start_date = $education->{'start-date'}->year;
				if (!empty($education->{'start-date'}->month)) $start_date = $education->{'start-date'}->month . '/' . $start_date;
				$end_date = $education->{'end-date'}->year;
				if (!empty($education->{'end-date'}->month)) $end_date = $education->{'end-date'}->month . '/' . $end_date;
				$educations .= '<h4>' . $start_date . ' - ' . $end_date . '&nbsp;: ' . $education->{'school-name'} . '</h4>';
				$details = '';
				if (!empty($education->degree)) $details .= $education->degree;
				if (!empty($education->{'field-of-study'})) {
					if (!empty($details)) $details .= ' - ';
					$details .= $education->{'field-of-study'};
				}
				if (!empty($details)) $educations .= '<p>' . $details . '</p>';
			}
			//$educations .= print_r($user_profile->educations, true);
			
			
			$sidebar .= '<p>' . elgg_echo('hybridauth:linkedin:logged', array('Linkedin', $display_name)). '</p>';
			$sidebar .= '<a class="elgg-button elgg-button-action" href="?linkedin_logout=logout">' . elgg_echo('hybridauth:linkedin:logout') . '</a>';
			
			
			// TRAITEMENT DU FORMULAIRE
			// @TODO make this one single array...
			// This is used for auto-generation of the form inputs ('linkedin-metadata-name' => 'form_name')
			// Note 'form_name' must match in both arrays !
			$mapped_linkedin_form_fields = array('public-profile-url' => "profile_url", 'photo' => 'photo', 'skills' => 'skills', 'industry' => 'industry', 'headline' => 'headline', 'status' => 'status', 'summary' => 'summary', 'positions' => 'positions', 'educations' => 'educations');
			// This is used to map form values to Elgg metadata (or special cases) : ('form_name' => 'elgg_metadata_name')
			$mapped_form_elgg_fields = array('profile_url' => "linkedin", 'photo' => 'avatar', 'skills' => 'skills', 'industry' => 'industry', 'headline' => 'briefdescription', 'status' => 'briefdescription', 'summary' => 'description', 'positions' => 'description', 'educations' => 'education');
			// Process form data : fields import
			// @TODO : erreur dans les noms récupérés
			foreach ($mapped_form_elgg_fields as $field => $elgg_field) {
				// Import only if asked to...
				if (get_input($field) == 'yes') {
					switch ($field) {
						// Avatar update
						case 'photo':
							if (hybridauth_update_avatar($photo_url, $own)) $form_report .= 'Photo...OK<br />';
							break;
						
						// Add with a ', ' separator
						case 'skills':
							$own->{$elgg_field} = implode(',', $own->{$elgg_field}) . ', ' . $$field;
							break;
						
						// Add with a '<hr />' separator
						case 'education':
						case 'headline':
						case 'status':
						case 'positions':
						case 'summary':
							$own->{$elgg_field} = $own->{$elgg_field} . '<hr .>' . $$field;
							break;
						
						// Update fields (replace former content)
						default:
							$own->{$elgg_field} = $$field;
					}
					$form_report .= "Import $elgg_field => $field...OK<br />";
				}
			}
			// Import report
			if (!empty($form_report)) {
				$str_editprofile = '<a href="' . $CONFIG->url . 'profile/' . $own->username . '/edit">' . elgg_echo('hybridauth:linkedin:editprofile'). '</a>';
				$str_editavatar = '<a href="' . $CONFIG->url . 'avatar/edit/' . $own->username . '">' . elgg_echo('hybridauth:linkedin:editavatar'). '</a>';
				$str_viewprofile = '<a href="' . $CONFIG->url . 'profile/' . $own->username . '">' . elgg_echo('hybridauth:linkedin:viewprofile'). '</a>';
				$content .= '<div class="linkedin-import-report"><strong>' . elgg_echo('hybridauth:linkedin:import:done') . '</strong><br />' . $form_report . '<br />';
				$content .= '<p>' . elgg_echo('hybridauth:linkedin:import:after', array($str_editprofile, $str_editavatar, $str_viewprofile)) . '</p>';
				$content .= '</div><div class="clearfloat"></div>';
			}
			
			
			// Formulaire pour MAJ des infos
			$title = elgg_echo('hybridauth:linkedin:import:title');
			$content .= elgg_echo('hybridauth:linkedin:import:details');
			$content .= '<div class="clearfloat"></div><br />';
			$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
			$content .= '<form id="linkedin-import-form" action="" method="POST">';
			$content .= elgg_view('input/securitytokens');
			
			foreach ($mapped_linkedin_form_fields as $linkedin_metaname => $form_name) {
				$content .= '<label>' . elgg_view('input/dropdown', array('name' => $form_name, 'options_values' => $no_yes_opt, 'value' => 'no')) . ' ' . elgg_echo("hybridauth:linkedin:import:$form_name") . '</label>';
				$content .= '<div class="linkedin-import-field-content">' . $$form_name . '</div>';
				$content .= '<div class="clearfloat"></div><br />';
			}
			
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
				  . "to the provider and he should authenticate again."; 
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


// Render page
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Affichage
echo elgg_view_page($title, $body);


