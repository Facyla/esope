<?php

/* ESOPE : replacement function for html_email_handler_send_email to address issue https://github.com/ColdTrick/html_email_handler/issues/36
 * 
 * The current plugin behaviour with plain text / HTML is:
 * - "plain text" version is sent only if it was explicitely defined in html_email_handler_send_email options
 * - "HTML version is sent only if it was explicitely defined in html_email_handler_send_email options
 * - if neither plain text nor HTML version is defined, html_email_handler_send_email defines will sent both versions based on 'body' option.
 *
 * This raises a few concerns :
 * - most plugins are not html_email_handler aware and will use only 'body' var, so most of the times messages will be sent using both HTML and plaintext versions, BUT the plain text version is not always HTML (HTML tags are not stripped off in the process)
 * - when HTML emails are sent, there is not always an alternate text-only version along
 * - there is no option for a user to decide whether he wants to receive HTML or TEXT or both versions.
 *
 * I would suggest the following additions / changes to the plugin :
 * - add a usersetting option, so users can set if they prefer to receive HTML or text only versions, or both ("both" would bethe default choice, to keep the current behaviour). Optionally the availability of this option itself could be controlled by an admin-setting, but i do not think it's worth it.
 * - automatically add a text-only version to email (except if HTML only is set as a user choice).
 * - systematically strip HTML tags from text-only version.
 * 
 * CHANGES :
 * 1. Always add a text version
 * 2. Systematically strip tags from text version
 * 3. Add user settings for prefered version(s) ?
 */


/**
 * Sends out a full HTML mail
 *
 * @param array $options In the format:
 *     to => STR|ARR of recipients in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
 *     from => STR of senden in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
 *     subject => STR with the subject of the message
 *     body => STR with the message body
 *     plaintext_message STR with the plaintext version of the message
 *     html_message => STR with the HTML version of the message
 *     cc => NULL|STR|ARR of CC recipients in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
 *     bcc => NULL|STR|ARR of BCC recipients in RFC-2822 format (http://www.faqs.org/rfcs/rfc2822.html)
 *     date => NULL|UNIX timestamp with the date the message was created
 *     attachments => NULL|ARR of array(array('mimetype', 'filename', 'content'))
 *
 * @return bool
 */
function esope_html_email_handler_send_email(array $options = null) {
	static $limit_subject;
	
	$site = elgg_get_site_entity();
	
	// make site email
	$site_from = html_email_handler_make_rfc822_address($site);
	
	// get sendmail options
	$sendmail_options = html_email_handler_get_sendmail_options();
	
	if (!isset($limit_subject)) {
		$limit_subject = false;
		
		if (elgg_get_plugin_setting("limit_subject", "html_email_handler") == "yes") {
			$limit_subject = true;
		}
	}
	
	// set default options
	$default_options = array(
		"to" => array(),
		"from" => $site_from,
		"subject" => "",
		"html_message" => "",
		"plaintext_message" => "",
		"cc" => array(),
		"bcc" => array(),
		"date" => null,
	);
	
	// merge options
	$options = array_merge($default_options, $options);
	
	// redo to/from for notifications
	$notification = elgg_extract('notification', $options);
	if (!empty($notification) && ($notification instanceof \Elgg\Notifications\Notification)) {
		$recipient = $notification->getRecipient();
		$sender = $notification->getSender();
		
		$options['to'] = html_email_handler_make_rfc822_address($recipient);
		if (!isset($options['recipient'])) {
			$options['recipient'] = $recipient;
		}
		
		if (!($sender instanceof \ElggUser) && $sender->email) {
			$options['from'] = html_email_handler_make_rfc822_address($sender);
		} else {
			$options['from'] = $site_from;
		}
	}
	
	// check options
	if (!empty($options["to"]) && !is_array($options["to"])) {
		$options["to"] = array($options["to"]);
	}
	if (!empty($options["cc"]) && !is_array($options["cc"])) {
		$options["cc"] = array($options["cc"]);
	}
	if (!empty($options["bcc"]) && !is_array($options["bcc"])) {
		$options["bcc"] = array($options["bcc"]);
	}
	
	// ESOPE : with this we will end up with HTML in text-only message
	if (empty($options['html_message']) && empty($options['plaintext_message'])) {
		//$options['html_message'] = html_email_handler_make_html_body($options);
		//$options['plaintext_message'] = $options['body'];
		$options['html_message'] = html_email_handler_make_html_body($options);
		$options['plaintext_message'] = $options['body'];
	}
	
	// ESOPE : add an alternate text version if missing
	if (empty($options['plaintext_message'])) {
		$options['plaintext_message'] = $options['html_message'];
	}
	// ESOPE : ensure text version does not contain any HTML
	// @TODO : should we add line breaks ?
	if (!empty($options['plaintext_message'])) {
		$options['plaintext_message'] = strip_tags($options['plaintext_message']);
	}
	
	
	// can we send a message
	if (empty($options["to"]) || (empty($options["html_message"]) && empty($options["plaintext_message"]))) {
		return false;
	}
	
	// start preparing
	// Facyla : better without spaces and special chars
	//$boundary = uniqid($site->name);
	$boundary = uniqid(elgg_get_friendly_title($site->name));
	
	$headers = $options['headers'];
	
	// start building headers
	if (!empty($options["from"])) {
		$headers['From'] = $options['from'];
	} else {
		$headers['From'] = $site_from;
	}
	
	// check CC mail
	if (!empty($options["cc"])) {
		$headers['Cc'] = implode(', ', $options['cc']);
	}
	
	// check BCC mail
	if (!empty($options["bcc"])) {
		$headers['Bcc'] = implode(', ', $options['bcc']);
	}
	
	// add a date header
	if (!empty($options["date"])) {
		$headers['Date'] = date('r', $options['date']);
	}
	
	$headers['X-Mailer'] = ' PHP/' . phpversion();
	$headers['MIME-Version'] = '1.0';
	
	// Facyla : try to add attchments if set
	$attachments = "";
	// Allow to add single or multiple attachments
	if (!empty($options["attachments"])) {
		
		$attachment_counter = 0;
		foreach ($options["attachments"] as $attachment) {
			
			// Alternatively fetch content based on an absolute path to a file on server:
			if (empty($attachment["content"]) && !empty($attachment["filepath"])) {
				if (is_file($attachment["filepath"])) {
					$attachment["content"] = chunk_split(base64_encode(file_get_contents($attachment["filepath"])));
				}
			}
			
			// Cannot attach an empty file in any case..
			if (!elgg_extract('content', $attachment)) {
				continue;
			}
			
			// Count valid attachments
			$attachment_counter++;
			
			// Use defaults for other less critical settings
			if (empty($attachment["mimetype"])) {
				$attachment["mimetype"] = "application/octet-stream";
			}
			if (empty($attachment["filename"])) {
				$attachment["filename"] = "file_" . $attachment_counter;
			}
			
			$attachments .= "Content-Type: {" . $attachment["mimetype"] . "};" . PHP_EOL . " name=\"" . $attachment["filename"] . "\"" . PHP_EOL;
			$attachments .= "Content-Disposition: attachment;" . PHP_EOL . " filename=\"" . $attachment["filename"] . "\"" . PHP_EOL;
			$attachments .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;
			$attachments .= $attachment["content"] . PHP_EOL . PHP_EOL;
			$attachments .= "--mixed--" . $boundary . PHP_EOL;
		}
	}
	
	// Use attachments headers for real only if they are valid
	if (!empty($attachments)) {
		$headers['Content-Type'] = "multipart/mixed; boundary=\"mixed--{$boundary}\"";
	} else {
		$headers['Content-Type'] = "multipart/alternative; boundary=\"{$boundary}\"";
	}
	
	$header_eol = "\r\n";
	if (elgg_get_config('broken_mta')) {
		// Allow non-RFC 2822 mail headers to support some broken MTAs
		$header_eol = "\n";
	}
	
	// stringify headers
	$headers_string = '';
	foreach ($headers as $key => $value) {
		$headers_string .= "$key: $value{$header_eol}";
	}
	
	// start building the message
	$message = "";
	
	// TEXT part of message
	$plaintext_message = elgg_extract("plaintext_message", $options);
	if (!empty($plaintext_message)) {
		// normalize URL's in the text
		$plaintext_message = html_email_handler_normalize_urls($plaintext_message);
		
		// add boundry / content type
		$message .= "--" . $boundary . PHP_EOL;
		$message .= "Content-Type: text/plain; charset=\"utf-8\"" . PHP_EOL;
		$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;
		
		// add content
		$message .= chunk_split(base64_encode($plaintext_message)) . PHP_EOL . PHP_EOL;
	}
	
	// HTML part of message
	$html_message = elgg_extract("html_message", $options);
	if (!empty($html_message)) {
		$html_boundary = $boundary;
		
		// normalize URL's in the text
		$html_message = html_email_handler_normalize_urls($html_message);
		$html_message = html_email_handler_base64_encode_images($html_message);
		
		$image_attachments = html_email_handler_attach_images($html_message);
		if (is_array($image_attachments)) {
			$html_boundary .= "-alt";
			$html_message = elgg_extract("text", $image_attachments);
			
			$message .= "--" . $boundary . PHP_EOL;
			$message .= "Content-Type: multipart/related; boundary=\"$html_boundary\"" . PHP_EOL . PHP_EOL;
		}
		
		// add boundry / content type
		$message .= "--" . $html_boundary . PHP_EOL;
		$message .= "Content-Type: text/html; charset=\"utf-8\"" . PHP_EOL;
		$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;
		
		// add content
		$message .= chunk_split(base64_encode($html_message)) . PHP_EOL;
		
		if (is_array($image_attachments)) {
			$images = elgg_extract("images", $image_attachments);
			
			foreach ($images as $image_info) {
				$message .= "--" . $html_boundary . PHP_EOL;
				$message .= "Content-Type: " . elgg_extract("content_type", $image_info) . "; charset=\"utf-8\"" . PHP_EOL;
				$message .= "Content-Disposition: inline; filename=\"" . elgg_extract("name", $image_info) . "\"" . PHP_EOL;
				$message .= "Content-ID: <" . elgg_extract("uid", $image_info) . ">" . PHP_EOL;
				$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;
				
				// add content
				$message .= chunk_split(elgg_extract("data", $image_info)) . PHP_EOL;
			}
			
			$message .= "--" . $html_boundary . "--" . PHP_EOL;
		}
	}
	
	// Final boundry
	$message .= "--" . $boundary . "--" . PHP_EOL;
	
	// Facyla : FILE part of message
	if (!empty($attachments)) {
		// Build strings that will be added before TEXT/HTML message
		$before_message = "--mixed--" . $boundary . PHP_EOL;
		$before_message .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"" . PHP_EOL . PHP_EOL;
		
		// Build strings that will be added after TEXT/HTML message
		$after_message = PHP_EOL;
		$after_message .= "--mixed--" . $boundary . PHP_EOL;
		$after_message .= $attachments;
		
		// Wrap TEXT/HTML message into mixed message content
		$message = $before_message . PHP_EOL . $message . PHP_EOL . $after_message;
	}
	
	// convert to to correct format
	$to = implode(", ", $options["to"]);
	
	// encode subject to handle special chars
	$subject = $options["subject"];
	$subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8'); // Decode any html entities
	if ($limit_subject) {
		$subject = elgg_get_excerpt($subject, 175);
	}
	$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
	
	return mail($to, $subject, $message, $headers_string, $sendmail_options);
}


