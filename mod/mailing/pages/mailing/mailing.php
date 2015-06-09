<?php
/* (c) facyla.net 2010-2014 */
/* Mailing plugin
 * Send HTML mails to external addresses
 * Configurable headers : From, Reply-To
 * TODO : fetch recipient with pre-selected (all users, groups, access lists) and saved lists
*/

admin_gatekeeper();
elgg_set_context('admin');

global $CONFIG;

$title = elgg_echo('mailing:form:title'); // Le titre doit rester sans HTML (titre page avant tout)

if ($subject = elgg_get_plugin_setting('subject', 'mailing') && !empty($subject)) $default_subject = $subject; else $default_subject = elgg_echo('mailing:form:default:subject');
$sender = elgg_get_plugin_setting('sender', 'mailing');
if (empty($sender)) $sender = elgg_echo('mailing:form:default:sender');
$sendername = elgg_get_plugin_setting('sendername', 'mailing');
if ($message = elgg_get_plugin_setting('message', 'mailing') && !empty($message)) $default_message = $message; else elgg_echo('mailing:form:default:message');

// Listes de mails auto
$self_mail = $_SESSION['user']->email;
$site_mails = $CONFIG->site->email . ',';
$site_mails .= "$sender,";
$all_mail = ""; $no_mail = "";

// Tous les membres du site courant
//$members = get_entities("user","","","time_created",99999,0,false,0); // 8e param = site_guid
$members = elgg_get_entities(array('types' => 'user', 'order_by' => 'time_created desc', 'limit' => false));
foreach($members as $member) {
 if($member->email && ($member->banned === "no")) $all_mail .= $member->email.','; else $no_mail .= $member->username.',';
}


// Si on a conservé qqch (erreur..), reprenons-le
if(isset($_SESSION['mailing'])) {
	$default_subject = $_SESSION['mailing']['subject'];
	$default_message = $_SESSION['mailing']['message'];
	$default_emailto = $_SESSION['mailing']['recipient'];
	$default_sender = $_SESSION['mailing']['sender'];
	$default_reply = $_SESSION['mailing']['replyto'];
}

// Valeurs des sélecteurs (from et reply-to) : at least site and loggedin user
$email_options = array(
		$CONFIG->site->email => $CONFIG->site->name . " (" . $CONFIG->site->email . ")",
		$self_mail => $_SESSION['user']->username . " (". $self_mail .")",
		$sender => $sendername . " (". $sender .")",
/*
		$CONFIG->site->name . ' <' . $CONFIG->site->email . '>' => $CONFIG->site->name . " (" . $CONFIG->site->email . ")",
		$_SESSION['user']->username.' <'.$self_mail.'>' => $_SESSION['user']->username . " (". $self_mail .")",
		$sendername . ' <'. $sender .'>' => $sendername . " (". $sender .")",
*/
	);
// Language-defined settings are replaced by real settings if set (otherwise strange behaviours would occur when using various language settings..)
$form_sender = elgg_view('input/dropdown', array('name' => 'emailsender', 'options_values' => $email_options));
$form_reply = elgg_view('input/dropdown', array('name' => 'emailreply', 'options_values' => $email_options));


$formbody = "<h3>$title</h3>" . elgg_echo('mailing:form:description');

$formbody .= '<div class="contentWrapper notitle">'
// Sujet du message / Subject
	. '<p style="float:left; margin-right:3ex;"><label>' . elgg_echo('mailing:subject') . ' </label><input type="text" name="emailsubject" width="30" value="'.$default_subject.'" /></p>'

// Expéditeur / From
	. '<p style="float:left; margin-right:3ex;"><label>' . elgg_echo('mailing:sender') . ' </label>' . $form_sender . '</p>'
//	. '<p><label>Expéditeur</label><input type="text" name="emailsender" value="'.$default_sender.'" /></p>'

// Adresse de réponse / Reply-To
	. '<p style="float:left; margin-right:3ex;"><label>' . elgg_echo('mailing:replyto') . ' </label>' . $form_reply . '</p>'
//	. '<p><label>Répondre à</label><input type="text" name="emailreply" value="'.$default_reply.'" /></p>'
	. '<div class="clearfloat"></div>'

// Destinataires (tous en copie cachée) / BCC
	. '<p><label>' . elgg_echo('mailing:emailto') . '&nbsp;: </label> '
	
	// Ajout d'adresses à la liste - @todo : filtrer et dédoublonner !
	. '<a href="javascript:void()" onClick="javascript:document.getElementById(\'mailing_emailto\').value+=\''.$self_mail.',\';">S\'ajouter à la liste</a> &nbsp;' // ajouter \n pour changer de ligne (après avoir filtré pour l'accepter)
	. '<a href="javascript:void()" onClick="javascript:document.getElementById(\'mailing_emailto\').value+=\''.$site_mails.'\';">Ajouter mails du site</a> &nbsp;'
	. '<a href="javascript:void()" onClick="javascript:document.getElementById(\'mailing_emailto\').value+=\''.$all_mail.'\';">Membres de ce site</a> &nbsp;';

// Empty list..
$formbody .= '<a href="javascript:void()" onClick="javascript:document.getElementById(\'mailing_emailto\').value=\'\';">Vider la liste</a> &nbsp;' 
	. '<br />' . elgg_echo('mailing:emailto:help') . '<br />' 
	. '<textarea class="input-textarea mceNoEditor" style="height:70px;" name="emailto" id="mailing_emailto" >'.$default_emailto.'</textarea></p>'
	
// Message content : use one of the following depending if you're having problem with text editor (wysiwyg editor might block JS mail addresses fetching)
	. '<p><label>' . elgg_echo('mailing:message') . ' </label> ' . elgg_echo('mailing:message:help') . ' ' . elgg_view('input/longtext', array('name' => 'emailmessage', 'value' => $default_message)) . '</p>'
//	. '<p><label>' . elgg_echo('mailing:message') . ' </label><textarea class="input-textarea" name="emailmessage" >' . $default_message . '</textarea></p>'
	. elgg_view('input/submit', array('value' => elgg_echo('mailing:send'))) . '</div>';


$body = elgg_view('input/form', array('action' => $CONFIG->url . 'action/mailing/send', 'body' => $formbody, 'method' => 'post') );

//$body = elgg_view_layout('one_column', '<div style="padding:10px;">' . $body . '</div>');
$body = elgg_view_layout('admin', array(
	'content' => $body,
	'title' => $title,
	'filter' => '',
));

//page_draw($title, $body);
echo elgg_view_page($title, $body);

