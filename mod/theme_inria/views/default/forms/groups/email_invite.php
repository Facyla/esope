<?php
/**
 * Elgg groups email invite form extend
 * IMPORTANT : we're extending a view that will be embedded into a form, so take care to close and reopen "wrapper' HTML tags (<form><div>)
 *
 * @package ElggGroups
 */

/* Invite by email : if existing, proceed as usual
 * Otherwise : pass emails to external invite form
 */

$group = $vars['entity'];
$owner = $group->getOwnerEntity();
$forward_url = $group->getURL();

$own = elgg_get_logged_in_user_entity();
$ownguid = elgg_get_logged_in_user_guid();

$invite_anyone = elgg_get_plugin_setting('invite_anyone', 'esope');
$allowregister = elgg_get_plugin_setting('allowregister', 'esope');

// No email invite if we can NOT invite anyone
if ($invite_anyone != 'yes') { continue; }


$content = '';

// End normal invite form
//$content .= "</div>";
$content .= "</fieldset></form>";

// Use form as wrapper for better integration within existing form...
$content .= '<form id="esope-form-email-invite-groups" method="POST" class="elgg-form elgg-form-groups-email-invite" action="#esope-form-email-invite-groups"><fieldset>';
$content .= '<h3>' . elgg_echo('theme_inria:groupinvite:email') . '</h3>';
$content .= '<p><em>' . elgg_echo('theme_inria:groupinvite:email:details') . '</em></p>';

$content .= elgg_view('input/securitytoken');

$emails = get_input('email_invites');
$group_register = get_input('group_register');
$invited_emails = esope_get_input_array($emails, array("\n", "\r", "\t", ",", ";", "|", ' ')); // Add space to separators list
// Process emails : invite existing account, separate existing accounts from new emails
$invite_external_emails = array();
$existing_users = array();
if ($invited_emails) {
	foreach($invited_emails as $k => $email) {
		$existing_user = get_user_by_email($email);
		if (sizeof($existing_user) > 1) {
			register_error(elgg_echo("Cannot proceed : Several users exist with the same email."));
		} else if (sizeof($existing_user) < 1) {
			$invite_external_emails[] = $email;
			unset($invited_emails[$k]);
		} else {
			// User is already registered
			$existing_user = $existing_user[0];
			if (elgg_instanceof($existing_user, 'user')) {
				$existing_users[$email] = $existing_user;
				unset($invited_emails[$k]);
			}
		}
	}
}

// Invite existing users (using same setting as regular invite so we can join directly instead of inviting ?)
if ($invite_external_emails) {
	system_message(elgg_echo('theme_inria:invite:proceednext'));
	$content .= '<p>' . elgg_echo('theme_inria:invite:newemails') . '</p>';
	foreach($invite_external_emails as $email) {
		$content .= '<p><a href="' . elgg_get_site_url() . 'inria/invite?group_invite=yes&group_guid=' . $group->guid . '&email=' . $email . '" target="_blank" class="elgg-button elgg-button-action">' . elgg_echo('invite') . ' ' . $email . '</a></p>';
	}
	// Or all at once
	if (count($invite_external_emails) > 1) {
		$content .= '<p><a href="' . elgg_get_site_url() . 'inria/invite?group_invite=yes&group_guid=' . $group->guid . '&email=' . implode(',', $invite_external_emails) . '" target="_blank" class="elgg-button elgg-button-action">' . elgg_echo('theme_inria:invite:allemails') . '</a></p>';
	}
}

// Proceed to regular invites
// @TODO DEV function qui gère l'invitation d'un membre : avec inscription ou pas (et selon les droits de l'user connecté), et surtout si déjà invité ou les messages envoyés au membre et aux admins du groupe
if ($existing_users) {
	$content .= '<h4>' . elgg_echo('theme_inria:invite:existing_users') . '</h4>';
	$content .= '<ul>';
	foreach($existing_users as $ent) {
		$content .= '<li>' . $ent->email . ' => ' . $ent->name . ' : ';
		if (!$group->isMember($ent)) {
			// Join parent first if any
			if (elgg_is_active_plugin('au_subgroups')) {
				$parent = \AU\SubGroups\get_parent_group($group);
				if ($parent && !$parent->isMember($ent)) {
					if (($group_register == 'yes') && ($parent->canEdit() || $parent->isPublicMembership())) {
						// Join parent
						if ($parent->join($ent)) { $content .= 'adhésion groupe parent OK => '; }
					} else {
						// Add membership request
						// @TODO Notify group owner + operators
						add_entity_relationship($ent->guid, 'membership_request', $parent->guid);
						// X, resp. de l'EDT truc, souhaiterait inviter X dans son EDT, et que vous l'acceptiez sa demande d'adhésion dans le groupe principal. + lien vers profil resp de l'EDT et de l'invité
						$subject = elgg_echo('theme_inria:parentgroup:request:subject', array($group->name));
						$message = elgg_echo('theme_inria:parentgroup:request:subject', array($admin->name, $own->name, $group->name, $ent->name));
						notify_user($ent->guid, $own->guid, $subject, $message, array(), array('email'));
						// Message à l'invité
						$subject = elgg_echo('theme_inria:parentgroup:inviterequest:subject', array($group->name));
						$message = elgg_echo('theme_inria:parentgroup:inviterequest:subject', array($ent->name, $own->name, $group->name, $parent->name, $group->getUrl()));
						notify_user($ent->guid, $own->guid, $subject, $message, array(), array('email'));
					}
				}
			}
			// Join group (we have the rights because we're on this page ;)
			if (($group_register == 'yes') && $group->join($ent)) {
				$content .= 'adhésion OK';
				// Message à l'invité
				$subject = elgg_echo('groups:welcome:subject', array($group->name));
				$message = elgg_echo('groups:welcome:body', array($ent->name, $group->name, $group->getUrl()));
				notify_user($ent->guid, $own->guid, $subject, $message, array(), array('email'));
			} else {
				add_entity_relationship($ent->guid, 'membership_request', $group->guid);
				// Message à l'invité : pas pu entrer dans le groupe car doit entrer dans le groupe parent avant
				/* Note : message envoyé ci-dessus
				$subject = elgg_echo('groups:welcome:subject', array($group->name));
				$message = elgg_echo('groups:welcome:body', array($ent->name, $group->name, $group->getUrl()));
				notify_user($ent->guid, $own->guid, $subject, $message, array(), array('email'));
				*/
			}
		} else {
			$content .= 'déjà membre';
		}
		$content .= '</li>';
	}
	$content .= '</ul>';
}

// Invalid emails (invalid because email is not valid or is associated with multiple accounts)
if ($invited_emails) {
	$content .= '<h4>' . elgg_echo('theme_inria:invite:invalidemails') . '</h4>';
	$content .= '<ul>';
	foreach($invited_emails as $email) {
		$content .= '<li>' . $email . '</li>';
	}
	$content .= '</ul>';
}



// FORM CONTENT
if (!$invite_external_emails) {
	$content .= '<div class="clearfloat"></div><br />';
	$content .= elgg_view('input/plaintext', array('name' => 'email_invites', 'value' => $emails, 'placeholder' => elgg_echo('theme_inria:groupinvite:email:placeholder')));
	// Allow direct registration
	if ($allowregister == 'yes') {
		$content .= ' <p><label>' . elgg_echo('esope:groups:allowregister') . '</label> ' . elgg_view('input/select', array('name' => 'group_register', 'options_values' => array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')), 'value' => $group_register)) . '</p>';
	}
	$content .= '<div class="clearfloat"></div>';
	$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('invite'))) . '</p>';
} else {
	// back to invite main form
	$content .= '<div class="clearfloat"></div><br />';
	$content .= '<p>' . elgg_view('output/url', array('href' => 'groups/invite/' . $group->guid, 'text' => elgg_echo('cancel'), 'class' => "elgg-button elgg-button-cancel")) . '</p>';
}


// Note : closing </form> is rendered by forms/groups/invite view (inner extend)

$content .= '<div class="clearfloat"></div>';

echo $content;

