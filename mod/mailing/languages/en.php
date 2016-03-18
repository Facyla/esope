<?php
$site_email = elgg_get_site_entity()->email;

return array(
	
	// Form elements
	'mailing:menu:title' => "Send an HTML mailing",
	'mailing:form:title' => "Mailing preparation",
	'mailing:form:description' => "<br />BE CAREFUL, this functionnality should be used with much care and avoiding any abuses : you may use many other ways to tell the members of your network, which take care of their privacy and notification settings. Please also read carefully the following technical notice before using it !<br />
		<ul>
			<li>The messages must <strong>avoid containing images, or only images with a complete, publicly accessible URL</strong> : some texte editors strip the images URL and convert them to relative URL, so be very careful about that.. (please also note that most mail clients disable images dy default, so also provide alternate text content for your images)</li>
			<li>The messages are send immediately after you've clicked the Send button, without any further preview or warning : we strongly advise that you first start by sending a test email to yourself before sending it to anyone ! (and also copy-paste the message content and double-check the images URL before the real mailing)</li>
			<li>Set the sender and reply-to addresses that will appear in the mailing</li>
			<li>These emails can be sent to any email address, including external ones, please use with much care and avoid spammming !</li>
			<li>A mailing report will be sent to bioth the site email address + the sender email address, containing the full details of the sent email</li>
			<li>TODO : save mail lists</li>
			<li>TODO : load emails from various criteria (group membership, profile types, metadata, access lists)</li>
		</ul>",
	'mailing:subject' => "Email title",
	'mailing:sender' => "Sender",
	'mailing:replyto' => "Reply to",
	'mailing:emailto' => "Recipients",
	'mailing:emailto:help' => "Emails addresses must be added alone (no recipient name), without any surrounding caracter, and separated by commas, or one per line.",
	'mailing:message' => "Email content",
	'mailing:message:help' => "HTML message only (raw text would appear concatenated), only use images with a full and public URL",
	'mailing:send' => "Send the mailing !",
	
	// Form defaults values : note that these values are used only if plugin settings are not set, and that bad formatted values will break the sending process..
	'mailing:form:default:subject' => "Letter",
	'mailing:form:default:sender' => "$site_email", // Template : email@site.tld
	'mailing:action:default:replyto' => "$site_email", // Template : email@site.tld
	// Mail HTML template (HTML only ! no plain text)
	'mailing:form:default:message' => "Hi,<br /><br />...<br /><p>Please to meet you again online,</p><p>Team</p>",
	
	
	// Default actions values (leave blank to cancel sending and go back to form, if no value provided in form)
	'mailing:report' => "Mailing report",
	
	'mailing:send:success' => "The mailing was successfully sent",
	'mailing:send:error' => "The mailing could not be sent",
	'mailing:send:error:subject' => "Missing subject",
	'mailing:send:error:recipient' => "Missing recipient",
	'mailing:send:error:message' => "Missing message",
	'mailing:send:error:sender' => "Missing sender",
	
);

