<?php
/**
 * Elgg postbymail plugin language pack
 * 
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2012-2015
 */

$site_url = elgg_get_site_url();

$en = array(
	/* Main strings */
	'postbymail:title' => "Post by email",
	
	/* Settings */
	'postbymail:settings:admin' => "Global settings",
	'postbymail:settings:replybymail' => "Replies by email",
	'postbymail:settings:replybymail:details' => "This functionnality enables replying by email to site notifications.",
	'postbymail:settings:postbymail' => "Post by email (EXPERIMENTAL)",
	'postbymail:settings:postbymail:details' => "This functionnality enables posting new content by email. TO use it, a unique publication key can be generated for any group and/or member, and used to publish in its name. If the sender is recognized, its member name will be used in a group. The unknown sender emails also enable publication, but the author will be the container itself (group or member). The access will be the group members access, or the default. This functionnality settings are unfinished and handling of content types other than blog posts is very partially implemented. You may contact the author if you wish to fund this functionnality.",
	'postbymail:settings:cron' => "CRON frequency",
	'postbymail:settings:cron:help' => "Note: the cron must be configured on the server for this plugin to work properly, otherwise it will function erratically on manual triggers, or through the crontrigger plugin which partly replaces the cron.",
	'postbymail:settings:separator' => "Reply message separator",
	'postbymail:settings:separatordetails' => "Explanation text that appears right below the separator, and which limits the publicaiton of personnal or inappropriate content such as signatures and previous conversations threads, and also lowers the duplicates risk level.",
	'postbymail:settings:scope' => "Replies by email enabled content types", // forumonly, comments, allobjects
	'postbymail:settings:notifylist' => "List of GUIDs or usernames that should be warned when new publications succeed or fail (note: the admin is always warned of any new message, succeeded or failed. The author is warned only when an error occurs.", 
	'postbymail:settings:replymode' => "Default reply by email behaviour",
	'postbymail:settings:replymode:replybutton' => "Reply button (recommended)",
	'postbymail:settings:replymode:replyemail' => "Email sender modification",
	'postbymail:settings:replymode:details' => "The reply button adds a button that enable to reply by email to the received site notification. The sent message is cleaner, and limits the risks of sending personnal information (signature), but does not let users hit the Reply button of their own messaging service.<br />The other method replaces the sender email address used by the notifications with the parametered reply by email address. It enables a quick reply to the notification but increases the risk of being identified as spam (or blocked by manual email validation systems). It also adds the risk of publishing automatic email replies - even if there is an integrated filtering mechanism to avoid publishing these. When this choice is enabled, the separator text is integrated at the very top of the message to limit the risk of adding unwanted content to the message.",
	'postbymail:settings:addreplybutton' => "Add an email reply button",
	'postbymail:settings:addreplybutton:details' => "This setting is generally the opposite or the preceeding: it adds a email reply button at the top of the message.",
	'postbymail:settings:server' => "Server and port, in the form: localhost:143 or mail.domain.tld:995", 
	'postbymail:settings:protocol' => "Protocol to be used, if necessary (eg.: /notls or /imap/ssl, and also sometimes /novalidate-cert and /norsh)", 
	'postbymail:settings:mailbox' => "Mailbox to be used (usually INBOX, which is the generic name of IMAP inbox folder)", 
	'postbymail:settings:username' => "Mailbox username (eg.: user@domain.tld)", 
	'postbymail:settings:password' => "Mailbox password", 
	'postbymail:settings:inboxfolder' => "FOlder to be checked (default: INBOX)", 
	'postbymail:settings:markSeen' => "Mark the processed messages as read (whether they are published or not) ; YES except there is a good reason not to do this", 
	'postbymail:settings:bodyMaxLength' => "Maximal length of the published message (fixed by default to 65536, which is the default maximum 'description' field length in Elgg SQL database)", 
	'postbymail:settings:mailpost' => "Publication by email",
	'postbymail:settings:mailpost:help' => "Note: this functionnality enabled to publish by email into a group, or in the name of a site member. If the sender is recognized, its name will be used. Unknown sender email addresses are allowed to publish, but the author will by the container itself, group or member. The access will be the ones of the group or the member, except if it is explicitely defined otherwise.",
	'postbymail:settings:email:title' => "Email account parameters", 
	'postbymail:settings:email:details' => "Important: you have to create 2 folders into your mailbox account before using this plugin, named 'Published' and 'Errors'<br >Use the used mailbox account parameters to configure the plugin and enable it to retrieve messages.", 
	'postbymail:settings:cron:url' => "URL used by the CRON (manual trigger)",
	'postbymail:settings:cron:test' => "Plugin test URL (admin only)",
	
	
	/* Settings values */
	'postbymail:settings:disabled' => "Disabled",
	'postbymail:settings:enabled' => "Enabled",
	'postbymail:cron:minute' => "Every minute",
	'postbymail:cron:fiveminute' => "5 minutes (recommended)",
	'postbymail:cron:fifteenmin' => "15 minutes",
	'postbymail:cron:halfhour' => "30 minutes",
	'postbymail:cron:hourly' => "Every hour",
	'postbymail:cron:daily' => "Every day",
	'postbymail:cron:weekly' => "Every week",
	// Scope des publications par mail
	'postbymail:settings:mailpost:none' => "No post by email",
	'postbymail:settings:mailpost:grouponly' => "Groups only",
	'postbymail:settings:mailpost:useronly' => "Members only",
	'postbymail:settings:mailpost:groupanduser' => "Groups and members",
	// Scope des réponses par mail
	'postbymail:settings:scope:none' => "No reply by email",
	'postbymail:settings:scope:forumonly' => "Only forum topic replies",
	'postbymail:settings:scope:comments' => "All replies (forum and comments)",
	// Scope des notifications
	'postbymail:settings:notify_scope' => "Admins notifications",
	'postbymail:settings:notify_scope:all' => "All: errors and successful posts (for moderation)",
	'postbymail:settings:notify_scope:erroronly' => "Only errors (default)",
	'postbymail:settings:notify_scope:error_and_groupadmin' => "Only errors for admins, new publications for group owners",
	// Autres types de publications (non implémentées)
	'postbymail:settings:allowcreation' => "Enable new content creation by email (EXPERIMENTAL DEV - not functionnal)",
	'postbymail:settings:allowusermail' => "Enable a custom publication address for members (EXPERIMENTAL DEV - not functionnal)",
	'postbymail:settings:allowgroupmail' => "Enable a custom publication address for groups (EXPERIMENTAL DEV - not functionnal)",
	
	/* Usersettings */
	'postbymail:usersettings:accountemail' => "<strong>Your registration email address: %s</strong>",
	'postbymail:usersettings:alternatemail' => "Email addresses associated to your account",
	'postbymail:usersettings:alternatemail:list' => "Email addresses registered with your account.",
	'postbymail:usersettings:alternatemail:none' => "No alternative email address registered",
	'postbymail:usersettings:alternatemail:add' => "Add a new alternative email address to your account",
	'postbymail:usersettings:alternatemail:help' => "When you use the post by email functionnality, you can use any of the following email addresses.<br />You can add as many email addresses as you wish, until it is not used by another member.<br />Note: these alternative addresses work only for publication by email functionnality, and can not be used to login to the site, nor receive any notification from the site.<br />If you wish to use another email address to login and receive your notifications, please update it through your main account settings.",
	'postbymail:usersettings:error:alreadyregistered' => "You have already registered that email address.",
	'postbymail:usersettings:error:alreadyused' => "The email address %s is already associated to a member account on the site. It is not allowed to add it as an alternative email adress.",
	'postbymail:usersettings:error:invalidemeail' => "Error: invalid email address!",
	'postbymail:usersettings:success:emailadded' => "Your alternative email address %s has been registered.",
	'postbymail:usersettings:success:emailremoved' => "The alternative email address %s has been removed.",
	'postbymail:usersettings:publicationkey' => "Post by email key",
	'postbymail:usersettings:publicationkey:change' => "Create or update the key (a new random key will be generated)",
	'postbymail:usersettings:publicationkey:changed' => "Key updated: only the new email address is now allowed to publish in your name.",
	'postbymail:usersettings:publicationkey:delete' => "Remove publication key",
	'postbymail:usersettings:publicationkey:deleted' => "Publication key removed.",
	'postbymail:usersettings:publicationkey:email' => "Email address to use for publication",
	'postbymail:usersettings:publicationkey:nomail' => "No email address enabled for personnal publication",
	'postbymail:usersettings:publicationkey:tooshort' => "Key too short, please use a key of at least 20 caracters",
	'postbymail:usersettings:publicationkey:help' => "You can define a custom publication key, associated to your personnal member account. This lets you publish new personnal content from any email address. If you do not wish to use this functionnality any longer, just empty this field. If you suspect this key to have been compromised, you can change it at any time.<br />Usage: send an email to the specified email address to publish on the site in your name. The new publication will be in restricted access until your next login on the site: you will then be able to edit it, and to update its access level. The publication title will be the one of your email.<br />Advanced usage: you can choose the publication content type by adding the following text after the key <strong>&subtype={content type}</strong>, and the access level by adding <strong>&access={access level ID}</strong>.",
	
	/* Group settings */
	'postbymail:groupsettings:publicationkey' => "Post by email key",
	'postbymail:groupsettings:publicationkey:change' => "Create or update the key (a new random key will be generated)",
	'postbymail:groupsettings:publicationkey:changed' => "Key updated: only this new address is now allowed to publish in this group.",
	'postbymail:groupsettings:publicationkey:delete' => "Remove key",
	'postbymail:groupsettings:publicationkey:deleted' => "Post by email key removed.",
	'postbymail:groupsettings:publicationkey:email' => "Email address to use to publish in this group",
	'postbymail:groupsettings:publicationkey:nomail' => "No publication key enabled in this group",
	'postbymail:groupsettings:publicationkey:tooshort' => "Key is too short, please use a key that contains at least 20 caracters",
	'postbymail:groupsettings:publicationkey:help' => "You can define a custom email publication key for this group. This lets you -and others- publish new content into this group from any email address. If you do not wish to use this functionnality any longer, just empty this field. If you suspect this key to have been compromised, you can change it at any time.<br />Usage: send an email to the specified email address for this group. If your email address is recognized and associated to a member account, the publication will be made in the name of this member account. If it not recognized, it will be made in the name of the group itself. The new publication will be in restricted access to the group members until your next login on the site: you will then be able to edit it, and to update its access level. The publication title will be the one of your email.<br />Advanced usage: you can choose the publication content type by adding the following text after the key <strong>&subtype={content type}</strong>, and the access level by adding <strong>&access={access level ID}</strong>.",
	
	/* Default values */
	'postbymail:default:separator' => "PLEASE WRITE YOUR MESSAGE ABOVE THIS LINE",
	'postbymail:default:separatordetails' => "To protect your privacy and avoid publishing personnal information such as the ones in your email signature, only the part of the message above the previous line will be published. You can specify your contact information on your profile page on the site.",
	
	/* Interface, report and message content */
	'postbymail:notifiedadminslist' => "Plugin parameters: members notified while processing new publications by email (successful -for moderation-, or failed -for checking and debugging-) : %s<br />That is: ",
	'postbymail:connectionok' => "Successfully connected to the mailbox<br />",
	'postbymail:newmessagesfound' => "%s unread messages found<br />",
	'postbymail:processingmsgnumber' => "<hr /><h3>Processing message number %s (ID: %s)</h3><br />",
	'postbymail:validguid' => "<b>Valid GUID</b><br /><br />",
	'postbymail:invalidguid' => "<b style=\"color:red;\"Invalid GUID</b><br /><br />",
	
	/* Informations issues du mail */
	'postbymail:info:postfullmail' => "<strong>Full publication address:</strong> %s<br />",
	'postbymail:info:mailtitle' => "<strong>Mail title:</strong> %s<br />",
	'postbymail:info:maildate' => "<strong>Date:</strong> %s<br />",
	'postbymail:info:hash' => "<strong>MD5 Hash:</strong> %s<br />",
	'postbymail:info:parameters' => "<strong>Parameters associated to the message: </strong> %s<br />",
	'postbymail:info:paramwrap' => "<ul>%s</ul>",
	'postbymail:info:paramvalue' => "<li><strong>%s :</strong> %s</li>",
	'postbymail:info:objectok' => "<strong>Publication associated to the message:</strong> &laquo;&nbsp;<a href=\"%s\">%s</a>&nbsp;&raquo; (%s)<br />",
	'postbymail:info:badguid' => "<strong style=\"color:red;\"No GUID specified, or the associated publication is whether not valid or not accessible!</strong><br />",
	'postbymail:info:mailbox' => "<strong>Checked mailbox:</strong> %s<br />",
	'postbymail:info:usefulcontent' => "Useful content: &laquo;&nbsp;%s&nbsp;&raquo;",
	'postbymail:info:memberandmail' => "<strong>Member account associated with the announced sender email:</strong> %s (From email: %s)<br />",
	'postbymail:info:realmemberandmail' => "<strong>Member account associated with the real sender email:</strong> %s (real email: %s)<br />",
	'postbymail:info:alternativememberandmail' => "<strong>Member account associated with an alternative email address:</strong> %s (alternative email: %s)<br />",
	'postbymail:info:publicationmember' => "<strong>Selected member for publication:</strong> %s<br />",
	
	/* Pièces jointes */
	'postbymail:info:attachment' => "<strong>Attachments:</strong> %s<br />",
	'postbymail:attachment:elements' => "<br /><strong>Message elements: %s/%s %s</strong>", 
	'postbymail:attachment:multipart' => "<br />ATTACHED MESSAGE: %s", 
	'postbymail:attachment:image' => "[attached image: %s]<br />", 
	'postbymail:attachment:msgcontent' => "<br />Message content: %s<hr />", 
	'postbymail:attachment:other' => "[other attached content type: %s]<br />", 
	'postbymail:noattachment' => "This message does not have any attachment.", 
	
	/* Vérification des conditions de publication */
	// Entité : objet concerné
	'postbymail:validobject' => " - The publication exists and is valid: &laquo;&nbsp;%s&nbsp;&raquo;<br />", 
	'postbymail:error:badguid' => " - <b style=\"color:red;\">Error: no publication specified, or the publication does not exist: please check that the publication email address is valid, and that the publication is still online (it may have been removed).</b><br />", 
	// Membre auteur
	'postbymail:memberok' => " - Member found from sender email address: %s<br />", 
	//'postbymail:error:nomember' => " - <b style=\"color:red;\">Erreur : Compte du membre non trouvé à partir de l'adresse mail d'expédition : veuillez utilisez votre adresse d'inscription au site pour publier ce message (votre adresse d'expédition doit être reconnue par le site pour publier).</b><br />", 
	'postbymail:error:nomember' => " - <b style=\"color:red;\">Error: the sender email address does not match any known member account. You may have used an other email address than the one specified on the website (this is a typical case if you use GMail for sending, and another address for receiving emails). Here's how to handle this:<br />
-- re-send your email using the email address you are using on the site (registration address)<br />
-- add your email address to your list of allowed sender email addresses, on your settings page " . $site_url . "settings/plugins/</b><br />",


	// Lieu (container) de publication : groupe (à terme : user aussi ?)
	'postbymail:containerok' => " - This publication container exists and is valid (it can be either a group or a member if personnal publicaitons are enabled)<br />", 
	'postbymail:error:nocontainer' => " - <b style=\"color:red;\">Error: no container corresponds to the publication &laquo;&nbsp;%s&nbsp;&raquo; (container GUID: %s): the corresponding group or member has not been found. This is a technical error, please forward this message to a site administrator.</b><br />", 
	'postbymail:error:badcontainer' => " - <b style=\"color:red;\">Error: no container corresponds to the GUID %s: the corresponding group or member has not been found. Either this group does not exist, or you do not have access to it. If the group exists and you are a member of it, it is probably a technical error, si please forward this message to a site administrator.</b><br />", 
	'postbymail:error:unknowncontainer' => " - <b style=\"color:red;\">Error: no container corresponds to the GUID %s: the corresponding group or member has not been found. Either it does not exist, or you do not have access to it. If the group exists and you are a member of it, it is probably a technical error, si please forward this message to a site administrator.</b><br />", 
	// Conteneur : groupe
	'postbymail:groupok' => " - The group %s exists and is valid<br />", 
	'postbymail:error:notingroup' => " - <b style=\"color:red;\">Error: the publication to be commented is not into a group: currently only group publications can be commented. This is technical error, please forward this message to a site administrator.</b><br />", 
	// Appartenance au groupe ou autorisations de publication
	'postbymail:ismember' => " - %s is a valid member of group %s<br />", 
	'postbymail:error:nogroupmember' => " - <b style=\"color:red;\">Error: %s is not a member of group &laquo;&nbsp;%s&nbsp;&raquo;: your account (or at least the one corresponding to your sender email address) is not a member of the group where the publicaiton you want to reply to is published. To reply to this publication, please first join the corresponding group, or check that you use the proper sender email address.</b><br />", 
	// Message vide ou déjà publié
	'postbymail:error:emptymessage' => " - <b style=\"color:red;\">Error: empty message. Empty messages cannot be published. Please check that the separator used to separate your message from personnal information is not above your message.</b><br />", 
	'postbymail:error:alreadypublished' => " - <b style=\"color:red;\">Error: already published (= was already published by the same author at the same date). If you receive this error, it is probably caused by an error that happened while testing functionnality. It happens only if there is an attempt to publish again a message that has already been published (this message may have been moderated meanwhile, if it does not appear in the discussion page).</b><br />", 
	// Site & user container publishing messages
	'postbymail:error:noaccesstoentity' => " - <b style=\"color:red;\">The member does not have access to this entity</b><br />",
	'postbymail:hasaccesstoentity' => "The member does have access to the entity<br />",
	'postbymail:userok' => "The container is a valid member<br />",
	'postbymail:siteok' => "The container is a valid site<br />",
	'postbymail:error:automatic_reply' => " - <b style=\"color:red;\">The message is most probably an automatic email reply (Auto-submitted header found)</b><br />",
	'postbymail:error:probable_automatic_reply' => " - <b style=\"color:red;\">The message is probably an automatic email reply (no From nor Return-Path found)</b><br />",
	
	/* Messages communs d'info et de debug pour les expéditeurs et admins */
	'postbymail:error:lastminutedebug' => "<b style=\"color:red;\">Unable to publish while everything seemed to be OK: please check carefully to debug</b>\n\n%s", 
	'postbymail:admin:reportmessage:error' => "<br /><b style=\"color:red;\">Unable to publish: either for one of the above reasons (if any), or because the message is empty...</b>
			<br />Cut was made using the separator at %s caracters<br />
			<br /><b>Unpublished message:</b><br />%s
			<br /><b>Complete unpublished message:</b><br />%s",
	'postbymail:sender:reportmessage:error' => "<b>Your unpublished message:</b><br />%s<br />",
	'postbymail:published' => '<h3>PUBLISHED MESSAGE</h3>',
	'postbymail:admin:debuginfo' => "<b>%s :</b><br />%s<br /><hr /><b>Debug information:</b><br /><br />%s</hr>",
	'postbymail:sender:debuginfo' => "<b>%s :</b><br />%s<br /><hr />%s<br />",
	'postbymail:report:notificationmessages' => "<br /><br /><b>SENDER EMAIL:</b><br />%s<br /><br /><b>ADMIN EMAIL:</b><br />%s<hr />",
	'postbymail:nonewmail' => "No new message<br />",
	'postbymail:badpluginconfig' => "Wrong plugin configuration: missing or invalid parameters", 
	'postbymail:numpublished' => "<hr />%s published comments", 
	'postbymail:nonepublished' => "<hr />No message to publish", 
	
	/* Messages pour les expéditeurs */
	'postbymail:sender:notpublished' => "Your email publication has failed",
	'postbymail:sendermessage:error' => "The message could not be published:<br />\n\n%s",
	'postbymail:sender:error:forumonly' => "<b style=\"color:red;\">The site settings allow only replies to forum topics.</b><br />%s", 
	'postbymail:sender:notified' => "<br /><b>SENDER NOTIFIED (except if none valid email found)</b>",
	'postbymail:sender:notnotified' => "<br /><b>SENDER NOT NOTIFIED</b>",
	
	/* Messages pour les admins */
	'postbymail:admin:notpublished' => "Failed publication by email",
	'postbymail:adminsubject:newpublication' => "New publication by email to be checked",
	'postbymail:adminmessage:success' => "Successful publication by email: new content to be checked\n\n%s",
	'postbymail:adminmessage:newpublication' => "A new publication by email was sent by &laquo;&nbsp;%s&nbsp;&raquo; 
			(member identified through sender email &laquo;&nbsp;%s&nbsp;&raquo;), 
			on <a href=\"%s\">page &laquo;&nbsp;%s&nbsp;&raquo;</a> (%s)<br /><br />
			Published comment content :<br /><hr />%s<hr /><br />
			To moderate this publicaiton, please login on the site, then click on publication title above<br /><br />",
	'postbymail:admin:notified' => "<br /><b>ADMIN NOTIFIED</b>",
	'postbymail:admin:notnotified' => "<br /><b>ADMIN NOT NOTIFIED</b>",
	'postbymail:admin:error:forumonly' => "<b style=\"color:red;\">The chosen settings do not allow email reply besides for forum topics.</b><br />", 
	
	/* Publications par mail : message de vérification des pré-requis */
	'postbymail:validcontainer' => "<br />Valid container",
	'postbymail:container:isuser' => "<br />Container: Member",
	'postbymail:container:isgroup' => "<br />Container: Group",
	'postbymail:validkey' => "<br />Valid publication key",
	'postbymail:key' => "<br />Publication key",
	'postbymail:subtype' => "<br />Publication type",
	'postbymail:access' => "<br />Access level: %s",
	'postbymail:member' => "<br />Valid member",
	'postbymail:member:usedcontainerinstead' => "<br />The container was used as the author (unknown sender email)",
	'postbymail:newpost:posted' => "New publication successfully posted !",
	
	/* Messages privés */
	'postbymail:mailreply:success' => "Reply to private message processed.",
	
	/* Traitement du cron */
	'postbymail:mailprocessed' => "Processing email queue finished.", // Note : pas d'accent
	
	'postbymail:someone' => "Someone",
	'postbymail:mail:replyemail' => "or use this email to reply:\n%s",
	
	
	// Reply button
	'postbymail:replybutton:basicsubject' => "Reply by email",
	'postbymail:replybutton:subject' => "Reply by email (conversation %s)",
	'postbymail:replybutton:title' => "Click here to reply by email",
	'postbymail:replybutton:wrapperstyle' => "background-color:#F0F0F0; color:#000000; padding:0.5ex 1ex; margin-bottom:1ex;",
	'postbymail:replybutton:style' => "background-color:#FFFFFF; padding:2px 1ex; border:1px solid; box-shadow: 0 0 1px 2px; font-weight:bold; text-decoration:none; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;",
	
	'postbymail:replybutton:failsafe' => "Reply email address if the link does not work: 
	<b>%s</b><br />
	Please check that your email contains only your reply (no signature, personnal information, former messages, etc.)",
	
);

add_translation("en", $en);

