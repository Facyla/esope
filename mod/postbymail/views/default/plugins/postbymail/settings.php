<?php
global $CONFIG;

// Select values
$no_yes_opt = array('no' => elgg_echo('postbymail:settings:disabled'), 'yes' => elgg_echo('postbymail:settings:enabled'));
$yes_no_opt = array_reverse($no_yes_opt, true);

$replymode_opt = array('replybutton' => elgg_echo('postbymail:settings:replymode:replybutton'), 'replyemail' => elgg_echo('postbymail:settings:replymode:replyemail'));

$cron_options = array( 
	'minute' => elgg_echo('postbymail:cron:minute'), 
	'fiveminute' => elgg_echo('postbymail:cron:fiveminute'), 
	'fifteenmin' => elgg_echo('postbymail:cron:fifteenmin'), 
	'halfhour' => elgg_echo('postbymail:cron:halfhour'), 
	'hourly' => elgg_echo('postbymail:cron:hourly'), 
	'daily' => elgg_echo('postbymail:cron:daily'), 
	'weekly' => elgg_echo('postbymail:cron:weekly'), 
	);

$scope_options = array( 
		'none' => elgg_echo('postbymail:settings:scope:none'), 
		'forumonly' => elgg_echo('postbymail:settings:scope:forumonly'), 
		'comments' => elgg_echo('postbymail:settings:scope:comments'), 
	);

$mailpost_options = array( 
	'none' => elgg_echo('postbymail:settings:mailpost:none'), 
	'grouponly' => elgg_echo('postbymail:settings:mailpost:grouponly'), 
	'useronly' => elgg_echo('postbymail:settings:mailpost:useronly'), 
	'userandgroup' => elgg_echo('postbymail:settings:mailpost:groupanduser'), 
);


// Defaults
if (empty($vars['entity']->separator)) $vars['entity']->separator = elgg_echo('postbymail:default:separator');
if (empty($vars['entity']->separatordetails)) $vars['entity']->separatordetails = elgg_echo('postbymail:default:separatordetails');
if (empty($vars['entity']->cron)) $vars['entity']->cron = 'fiveminute';
// INBOX is default but we should allow empty value depending on the server
if (!isset($vars['entity']->inboxfolder)) $vars['entity']->inboxfolder = 'INBOX';



// Settings form

// EMAIL REPLIES
echo '<fieldset style="border:1px solid grey; padding:1ex; margin:1ex 0;">';
	echo '<legend>' . elgg_echo('postbymail:settings:replybymail') . '</legend>';
	echo '<p><em>' . elgg_echo('postbymail:settings:replybymail:details') . '</em></p>';
	
	// Forums seulement ou tous types de commentaires ?
	echo '<p><label>' . elgg_echo('postbymail:settings:scope') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[scope]', 'options_values' => $scope_options, 'value' => $vars['entity']->scope));
	echo '</label></p>';
	
	// Reply mode
	// Default : Ajout bouton de réponse par email
	// Alternative : Modification de l'email d'expédition (pour réponse directe), avec séparateur en début de mail
	echo '<p><label>' . elgg_echo('postbymail:settings:replymode') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[replymode]', 'options_values' => $replymode_opt, 'value' => $vars['entity']->replymode));
	echo '</label><br />' . elgg_echo('postbymail:settings:replymode:details') . '</p>';
	
	echo '<p><label>' . elgg_echo('postbymail:settings:replybuttonaddtext') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[replybuttonaddtext]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->replybuttonaddtext));
	echo '</label><br />' . elgg_echo('postbymail:settings:replybuttonaddtext:details') . '</p>';
	
	// Séparateur message/signature
	echo '<p><label>' . elgg_echo('postbymail:settings:separator');
	echo elgg_view('input/text', array('name' => 'params[separator]', 'style' => 'width:94%;', 'value' => $vars['entity']->separator));
	echo '</label></p>';
	
	// Explication sous le séparateur
	echo '<p><label>' . elgg_echo('postbymail:settings:separatordetails') . '</label>';
	echo elgg_view('input/plaintext', array('name' => 'params[separatordetails]', 'value' => $vars['entity']->separatordetails, 'style' => "width:94%;"));
	//echo '<textarea id="params[header]" class="NoEditor NoRichText mceNoeditor" name="params[separatordetails]" >' . $vars['entity']->separatordetails . '</textarea>';
	echo '</label></p>';

echo '</fieldset>';


// EMAIL PUBLICATION
// Activer la publication dans les groupes et/ou pour les membres
echo '<fieldset style="border:1px solid grey; padding:1ex; margin:1ex 0;">';
	echo '<legend>' . elgg_echo('postbymail:settings:postbymail') . '</legend>';
	echo '<p><em>' . elgg_echo('postbymail:settings:postbymail:details') . '</em></p>';

	echo '<p><label>' . elgg_echo('postbymail:settings:mailpost') . ' ' . elgg_view('input/dropdown', array('name' => 'params[mailpost]', 'options_values' => $mailpost_options, 'value' => $vars['entity']->mailpost));
	echo '</label></p>';

echo '</fieldset>';


// GLOBAL SETTINGS
echo '<fieldset style="border:1px solid grey; padding:1ex; margin:1ex 0;">';
	echo '<legend>' . elgg_echo('postbymail:settings:admin') . '</legend>';
	
	// Fréquence du cron ?
	echo '<p><label>' . elgg_echo('postbymail:settings:cron') . ' ';
	echo elgg_view('input/dropdown', array('name' => 'params[cron]', 'options_values' => $cron_options, 'value' => $vars['entity']->cron));
	echo '</label><br />' . elgg_echo('postbymail:settings:cron:help') . '</p>';
	
	// Admin users who should be notified
	echo '<p><label>' . elgg_echo('postbymail:settings:notifylist');
	echo elgg_view('input/text', array( 'name' 	=> 'params[notifylist]', 'value' 	=> $vars['entity']->notifylist, ));
	echo '</label></p>';
	
echo '</fieldset>';


// EMAIL SETTINGS
echo '<fieldset style="border:1px solid grey; padding:1ex; margin:1ex 0;">';
	echo '<legend>' . elgg_echo('postbymail:settings:email:title') . '</legend>';
	echo '<p><em>' . elgg_echo('postbymail:settings:email:details') . '<em></p>';

	// server
	echo '<p><label style="clear:left;">' . elgg_echo('postbymail:settings:server') . ' ';
	echo elgg_view('input/text', array('name' => 'params[server]', 'style' => 'width:94%;', 'value' => $vars['entity']->server));
	echo '</label><p/>';

	// protocol
	echo '<p><label style="clear:left;">' . elgg_echo('postbymail:settings:protocol') . '';
	echo elgg_view('input/text', array('name' => 'params[protocol]', 'style' => 'width:94%;', 'value' => $vars['entity']->protocol));
	echo '</label><p/>';
	
	/*
	// mailbox
	echo '<label style="clear:left;">' . elgg_echo('postbymail:settings:mailbox') . ' :</label> ';
	echo elgg_view('input/text', array('name' => 'params[mailbox]', 'style' => 'width:94%;', 'value' => $vars['entity']->mailbox));
	echo '</label><p/>';
	*/
	
	// username
	echo '<p><label style="clear:left;">' . elgg_echo('postbymail:settings:username') . ' ';
	echo elgg_view('input/text', array('name' => 'params[username]', 'style' => 'width:94%;', 'value' => $vars['entity']->username));
	echo '</label><p/>';
	// post by email address
	echo '<p><label style="clear:left;">' . elgg_echo('postbymail:settings:email') . ' ';
	echo elgg_view('input/text', array('name' => 'params[email]', 'style' => 'width:94%;', 'value' => $vars['entity']->email));
	echo '</label><p/>';

	// password
	echo '<p><label style="clear:left;">' . elgg_echo('postbymail:settings:password') . ' ';
	echo elgg_view('input/text', array('name' => 'params[password]', 'style' => 'width:94%;', 'value' => $vars['entity']->password));
	echo '</label><p/>';

	// password
	echo '<p><label style="clear:left;">' . elgg_echo('postbymail:settings:inboxfolder') . ' ';
	echo elgg_view('input/text', array('name' => 'params[inboxfolder]', 'style' => 'width:94%;', 'value' => $vars['entity']->inboxfolder));
	echo '</label><p/>';
	
	// @TODO ? Notification scope error|success|groupadmin
	
echo '</fieldset>';

/*
// markSeen
echo '<label style="clear:left;">' . elgg_echo('postbymail:settings:markSeen') . ' :</label> ';
echo elgg_view('input/text', array('name' => 'params[markSeen]', 'style' => 'width:94%;', 'value' => $vars['entity']->markSeen));
echo '<br /><br />';

// bodymaxlength
echo '<label style="clear:left;">' . elgg_echo('postbymail:settings:bodymaxlength') . ' :</label> ';
echo elgg_view('input/text', array('name' => 'params[bodymaxlength]', 'style' => 'width:94%;', 'value' => $vars['entity']->bodymaxlength));
echo '<br /><br />';
*/

echo '<fieldset style="border:1px solid grey; padding:1ex; margin:1ex 0;">';
	echo '<p><strong>' . elgg_echo('postbymail:settings:cron:url') . '&nbsp;:</strong> <a href="'.$CONFIG->url.'postbymail/check">'.$CONFIG->url.'postbymail/check</a></</p>';
	echo '<p><strong>' . elgg_echo('postbymail:settings:cron:test') . '&nbsp;:</strong> <a href="'.$CONFIG->url.'postbymail/check?display=yes">'.$CONFIG->url.'postbymail/check?display=yes</a></p>';
echo '</fieldset>';



