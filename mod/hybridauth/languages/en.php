<?php

$en = array(
	
	'hybridauth:index' => "Hybridauth identity providers integration",
	
	'hybridauth:settings:main' => "Main settings",
	'hybridauth:settings:providers' => "Identity providers and API keys",
	
	'hybridauth:available:twitter' => "Enable Twitter integration",
	'hybridauth:apikey:twitter' => "Application ID/key",
	'hybridauth:secret:twitter' => "Application secret",
	
	'hybridauth:available:linkedin' => "Enable Linkedin integration",
	'hybridauth:apikey:linkedin' => "Application ID/key",
	'hybridauth:secret:linkedin' => "Application secret",
	
	'hybridauth:available:google' => "Enable Google integration",
	'hybridauth:apikey:google' => "Application ID/key",
	'hybridauth:secret:google' => "Application secret",
	
	'hybridauth:available:facebook' => "Enable Facebook integration",
	'hybridauth:apikey:facebook' => "Application ID/key",
	'hybridauth:secret:facebook' => "Application secret",
	
	// Login / registration
	'hybridauth:settings:login' => "Allow login with enabled identity providers",
	'hybridauth:settings:register' => "Allow registration with enabled identity providers",
	'hybridauth:settings:register:details' => "The registration process requires a valid registration but will pre-fill some fields",
	
	'hybridauth:configureassociation' => "Configure association with %s account",
	'hybridauth:loginwith' => "Login with %s",
	'hybridauth:orloginwith' => "Or login with",
	
	// Linkedin
	'hybridauth:linkedin:title' => "Linkedin",
	'hybridauth:linkedin:login' => "Connect %s account",
	'hybridauth:linkedin:logged' => "You are now connected with <b>%s</b> as <b>%s</b>",
	'hybridauth:linkedin:logout' => "Disconnect Linkedin",
	'hybridauth:linkedin:loggedout' => "Logged out from Linkedin.",
	'hybridauth:linkedin:import' => "Import selected fields !",
	'hybridauth:linkedin:import:done' => "FIELDS IMPORT FROM LINKEDIN FINISHED :",
	'hybridauth:linkedin:import:after' => "Import done, please %s, %s and %s.",
	'hybridauth:linkedin:editprofile' => "complete or edit your profile",
	'hybridauth:linkedin:editavatar' => "resize your avatar",
	'hybridauth:linkedin:viewprofile' => "check your updated profile",
	
	'hybridauth:linkedin:import:title' => "Import informations from your LinkedIn profile",
	'hybridauth:linkedin:import:details' => "<p>You can import some informations from your LinkedIn profile to start or update your profile informations.</p><p>You can preview the importable fields below, and choose for each of them wether you'd like to import it or not. Some informations will be appended to your profile existing informations (so you don't loose existing fields content).</p><p>Once import is done, it is advised to review your updated profile by following the suggested links.",
	'hybridauth:linkedin:import:profile_url' => "Import public profile URL (replaces : LinkedIn Profile)",
	'hybridauth:linkedin:import:photo' => "Import photo (replaces your current avatar)",
	'hybridauth:linkedin:import:industry' => "Import industry (replaces : Secteur professionnel)",
	'hybridauth:linkedin:import:headline' => "Import title (added to : Brief description)",
	'hybridauth:linkedin:import:status' => "Import status (added to : Brief description)",
	'hybridauth:linkedin:import:summary' => "Import summary (added to : About me",
	'hybridauth:linkedin:import:positions' => "Import current positions (added to : About me",
	'hybridauth:linkedin:import:educations' => "Import studies (added to : Studies)",
	'hybridauth:linkedin:import:skills' => "Import skills (added to : Skills)",
	
	// Login and registration
	'hybridauth:connectedwith' => "You are now connected with <b>%s</b> as <b>%s</b>",
	'hybridauth:noacccount' => "There is no account associated yet. You have 2 options :",
	'hybridauth:existingacccount' => "<strong>There is an existing account using the same username %s.</strong><br />If you own this account, we suggest you prefer option 1 and login to associate it with your %s account. If you don't, please use another username to register.",
	'hybridauth:availableusername' => "The username %s is available on this site.<br />If you do not have any account yet, you may use this username to register.</strong>",
	'hybridauth:logintoassociate' => "Login to associate your account with %s",
	'hybridauth:logintoassociate:details' => "Use this option if you already have an account and wish to associate it with your %s account %s.<br />Please use the form below to login, and get back to this page to confirm the association with your %s account.<br />You'll be then able to login directly with %s.",
	'hybridauth:loginnow' => "Login now",
	'hybridauth:registertoassociate' => "Or create an account on this site",
	'hybridauth:registertoassociate:details' => "Prefer this option if you do not have any account on this site, or wish to associate your %s account %s with a new account.<br />Please complete the registration form with a valid email address, and confirm the registration.<br />Once your account is created, it will be associated with your %s account so we will be able to login with %s.",
	'hybridauth:registernow' => "Create an account now",
	'hybridauth:association:success' => "Association successful : you can now login with your %s account.",
	'hybridauth:otheraccountassociated' => "Another account is already associated with this %s account : sorry but cannot continue with association.<br />Logging out from %s.",
	'hybridauth:revokeassociation:details' => "Do you want to revoke access with %s ? If you do this, you won't be able to connect with Twitter anymore.<br /><em>Note : you will be able to enable a new %s association at any time.</em>",
	'hybridauth::association:ok' => "Account %s (%s) is associated with your account %s.</strong> You can login with %s.",
	'hybridauth:association:link' => "set up a new %s association",
	'hybridauth:revokeassociation:success' => "%s association removed. You can %s or keep browsing the site.",
	'hybridauth:revokeassociation' => "Revoke %s association",
	
);

add_translation("en",$en);

