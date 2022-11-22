<?php

return [
	// general
	'group_tools:add_users' => "Add users",
	'group_tools:delete_selected' => "Delete selected",
	'group_tools:clear_selection' => "Clear selection",
	'group_tools:all_members' => "All members (%d)",
	
	'group_tools:profile:field:group_tools_preset' => "Group Tools Preset",
	
	'group_tools:joinrequest:already' => "Supprimer la demande d'adhésion du membre",
	'group_tools:joinrequest:already:tooltip' => "You already requested to join this group, click here to revoke this request",
	'group_tools:join:already:tooltip' => "You were invited to this group so you can join right now.",
	
	'item:object:group_tools_group_mail' => "Group mail",
	'collection:annotation:email_invitation:group' => "Manage e-mail invitations",
	'collection:annotation:email_invitation:user' => "E-mail group invitations",
	
	// menu
	'group_tools:menu:mail' => "Mail Members",
	
	'group_tools:menu:title:add:preset' => "Create a %s group",
	'group_tools:menu:group_members:email_invitations' => "E-mail invitations",
	
	'group_tools:menu:group:invitations:invitations' => "Invitations",
	'group_tools:menu:group:invitations:email_invitations' => "E-mail invitations",
	
	'admin:groups:bulk_delete' => "Group bulk delete",
	'admin:groups:admin_approval' => "Approval needed",
	'admin:groups:tool_presets' => "Group tool presets",
	'admin:groups:auto_join' => "Auto join",
	'admin:groups:featured' => "Featured",
	'admin:groups:suggested' => "Suggested",
	'admin:groups:repair' => "Repair",
	
	// plugin settings
	'group_tools:settings:default_off' => "Oui, désactivé par défaut",
	'group_tools:settings:default_on' => "Oui, activé par défaut",
	'group_tools:settings:required' => "Oui, obligatoire",
	'group_tools:settings:admin_only' => "Admin seulement",
	
	'group_tools:settings:edit:title' => "Paramètres d'édition du groupe",
	'group_tools:settings:simple_access_tab' => "Simplified group access selection",
	'group_tools:settings:simple_access_tab:help' => "Replaces group access options when creating groups with a simplified choice between 'Open' and 'Closed'",

	'group_tools:settings:simple_tool_presets' => "Pré-sélection des outils du groupe",
	'group_tools:settings:simple_tool_presets:help' => "Simplifies the group tool preset selection. It uses the group tool preset title and description. The individual tools will not be shown. There are also no options to configure individual tools in the simplified mode.",

	'group_tools:settings:simple_create_form' => "Formulaire simplifié de création de groupe",
	'group_tools:settings:simple_create_form:help' => "Enabling this will change the way how the 'New Group' form is displayed",
	
	'group_tools:settings:create_based_on_preset' => "Add tool presets to 'Create group' button",
	'group_tools:settings:create_based_on_preset:help' => "If group tool presets are configured add a quick selector to the create group button to
use that preset on the group creation form. This will also hide the tool selection on the creation form.",
	
	'group_tools:settings:allow_hidden_groups:help' => "Who can create hidden groups. This setting will overrule the groups plugin setting.",
	
	'group_tools:settings:invite:title' => "Options d'invitation du groupe",
	'group_tools:settings:management:title' => "Options générales du groupe",
	
	'group_tools:settings:admin_transfer' => "Allow group owner transfer",
	'group_tools:settings:admin_transfer:admin' => "Site admin only",
	'group_tools:settings:admin_transfer:owner' => "Group owners and site admins",

	'group_tools:settings:multiple_admin' => "Allow multiple group admins",
	'group_tools:settings:auto_suggest_groups' => "Auto suggest groups on the 'Suggested' groups page based on profile information",
	'group_tools:settings:auto_suggest_groups:help' => "Will be completed with the predefined suggested groups. Setting this to 'No' will only show the predefined suggested groups (if there are any).",
	
	'group_tools:settings:notifications:title' => "Group notification settings",
	'group_tools:settings:notifications:notification_toggle' => "Show notification settings on group join",
	'group_tools:settings:notifications:notification_toggle:description' => "This will show a system message where to user can toggle the notification settings, and add a link in the e-mail notification to the group notification settings.",
	
	'group_tools:settings:invite' => "Allow all users to be invited (not just friends)",
	'group_tools:settings:invite_friends' => "Allow friends to be invited",
	'group_tools:settings:invite_email' => "Allow all users to be invited by e-mail address",
	'group_tools:settings:invite_csv' => "Allow all users to be invited by CSV-file",
	'group_tools:settings:invite_members' => "Allow group members to invite new users",
	'group_tools:settings:invite_members:description' => "Group owners/admins can enable/disable this for their group",
	'group_tools:settings:domain_based' => "Enable domain based groups",
	'group_tools:settings:domain_based:description' => "Users can join a group based on their e-mail domain. During registration they will auto join groups based on their e-mail domain.",
	'group_tools:settings:join_motivation' => "Joining closed groups requires a motivation",
	'group_tools:settings:join_motivation:description' => "When a user wants to join a closed group, a motivation is required. Group owners can change this setting, if not set to 'no' or 'required'.",

	'group_tools:settings:mail' => "Allow group mail (allows group admins to send a message to all members)",
	
	'group_tools:settings:mail:members' => "Allow group admins to enable group mail for their members",
	'group_tools:settings:mail:members:description' => "This requires group mail to be enabled",
	
	'group_tools:settings:related_groups' => "Allow related groups",
	'group_tools:settings:related_groups:help' => "Group admins can configure groups that are similar/related to their group.",

	'group_tools:settings:listing:title' => "Group listing settings",
	'group_tools:settings:listing:description' => "Here you can configure which tabs will be visible on the group listing page, which tab will be the default landing page and what the default sorting will be per tab.",
	'group_tools:settings:listing:enabled' => "Enabled",
	'group_tools:settings:listing:default_short' => "Default tab",
	'group_tools:settings:listing:default' => "Default group listing tab",
	'group_tools:settings:listing:available' => "Available group listing tabs",

	'group_tools:settings:content:title' => "Group content settings",
	'group_tools:settings:stale_timeout' => "Groups become stale if no content is created within a number of days",
	'group_tools:settings:stale_timeout:help' => "If no new content is created in a group within the given number of days, the group is shown as stale. The group owner will receive a notification on the day the group becomes stale. A group owner/admin can tell the group is still relevant. 0 or empty to not enable this feature.",
	
	'group_tools:settings:search_index' => "Allow closed groups to be indexed by search engines",
	'group_tools:settings:auto_notification' => "Automatically enable group notification on group join",
	
	'group_tools:settings:special_states:featured:description' => "The site administrators have chosen to feature the following groups.",
	
	'group_tools:settings:fix:title' => "Fix group access problems",
	'group_tools:settings:fix:missing' => "There are %d users who are a member of a group but don't have access to the content shared with the group.",
	'group_tools:settings:fix:excess' => "There are %d users who have access to group content of groups where they are no longer a member off.",
	'group_tools:settings:fix:without' => "There are %d groups without the possibility to share content with their members.",
	'group_tools:settings:fix:all:description' => "Fix all off the above problems at once.",
	'group_tools:settings:fix_it' => "Fix this",
	'group_tools:settings:fix:all' => "Fix all problems",
	
	'group_tools:settings:member_export' => "Allow group admins to export member information",
	'group_tools:settings:member_export:description' => "This includes the name, username and email address of the user.",
	
	'group_tools:settings:admin_approve' => "Site administrators need to approve new groups",
	'group_tools:settings:admin_approve:description' => "Any user can create a group, but a site administrator has to approve the new group",
	
	'group_tools:settings:creation_reason' => "Demander un motif d'approbation du groupe",
	'group_tools:settings:creation_reason:description' => "During the group creation proccess, the user is asked why the group should be approved by a site administrator",
	
	'group_tools:settings:concept_groups' => "Permettre la création de concepts de groupes",
	'group_tools:settings:concept_groups:description' => "Concept groups are private groups which the owner isn't ready to present to the rest of the community. For example when more content needs to be added first. The owner will get a weekly reminder to 'publish' the group.",
	'group_tools:settings:concept_groups_retention' => "How long are 'concept' group allowed to remain in 'concept'",
	'group_tools:settings:concept_groups_retention:description' => "The number of days 'concept' groups are allowed to remain in 'concept' before being removed. Leave empty to not remove the 'concept' groups.",
	
	'group_tools:settings:auto_accept_membership_requests' => "Automatically accept pending membership requests after opening the group",
	'group_tools:settings:auto_accept_membership_requests:help' => "When the membership of a group changes to 'open', automatically accept all pending membership requests.",
	
	// user settings
	'group_tools:usersettings:admin:notify_approval' => "Notify me when a group needs approval",
	
	// auto join
	'group_tools:admin:auto_join:default' => "Auto join",
	'group_tools:admin:auto_join:default:description' => "New users will automatically join the following groups.",
	'group_tools:admin:auto_join:default:none' => "No auto join groups configured yet.",
	
	'group_tools:form:admin:auto_join:group' => "Add a group to the auto join groups",
	'group_tools:form:admin:auto_join:group:help' => "Search for a group by name and select it from the list.",
	
	'group_tools:form:admin:auto_join:additional:group' => "Select the group(s) to join",
	'group_tools:form:admin:auto_join:additional:group:help' => "Search for a group by name and select it from the list.",
	
	'group_tools:admin:auto_join:additional' => "Additional auto join groups",
	'group_tools:admin:auto_join:additional:description' => "Here you can configure additional groups a user should join, based on properties of the user.",
	'group_tools:admin:auto_join:additional:none' => "No additional groups configured yet",
	
	'group_tools:admin:auto_join:exclusive' => "Exclusive auto join groups",
	'group_tools:admin:auto_join:exclusive:description' => "Here you can configure exclusive groups a user should join, based on properties of the user. If a match is found for a user they will NOT be added to any of the groups defined above.",
	'group_tools:admin:auto_join:exclusive:none' => "No exclusive groups configured yet",
	
	'group_tools:form:admin:auto_join:additional:pattern' => "User property matching",
	'group_tools:form:admin:auto_join:additional:pattern:add' => "Add property",
	'group_tools:form:admin:auto_join:additional:pattern:help' => "Users will be matched on all configured properties. To remove a property leave the value empty.",

	'group_tools:auto_join:pattern:operand:equals' => "Identique",
	'group_tools:auto_join:pattern:operand:not_equals' => "Différent",
	'group_tools:auto_join:pattern:operand:contains' => "Contient",
	'group_tools:auto_join:pattern:operand:not_contains' => "Ne contient pas",
	'group_tools:auto_join:pattern:operand:pregmatch' => "Correspondance par expression régulière",
	'group_tools:auto_join:pattern:value:placeholder' => "Entrer une valeur correspondante",
	
	'group_tools:action:admin:auto_join:additional:error:pregmatch' => "The provided preg match pattern was invalid",
	
	// simplified access
	'group_tools:edit:access_simplified:open' => 'Open Group',
	'group_tools:edit:access_simplified:open:description' => '<ul><li>Any user may join</li><li>Content can be shared with anyone</li></ul>',
	'group_tools:edit:access_simplified:closed' => 'Closed Group',
	'group_tools:edit:access_simplified:closed:description' => '<ul><li>Membership needs to be approved</li><li>Content can only be shared with group members</li></ul>',
	
	// group tool presets
	'group_tools:admin:group_tool_presets:description' => "Here you can configure group tool presets.
When a user creates a group he/she gets to choose one of the presets in order to quickly get the correct tools. A blank option is also offered to the user to allow his/her own choices.",
	'group_tools:admin:group_tool_presets:header' => "Existing presets",
	'group_tools:create_group:tool_presets:description' => "You can select a group tool preset here. If you do so, you will get a set of tools which are configured for the selected preset. You can always chose to add additional tools to a preset, or remove the ones you do not like.",
	'group_tools:create_group:tool_presets:active_header' => "Tools for this preset",
	'group_tools:create_group:tool_presets:more_header' => "Extra tools",
	'group_tools:create_group:tool_presets:select' => "Select a group type",
	'group_tools:create_group:tool_presets:show_more' => "More tools",
	'group_tools:create_group:tool_presets:blank:title' => "Blank group",
	'group_tools:create_group:tool_presets:blank:description' => "Choose this group to select your own tools.",
	
	
	// group invite message
	'group_tools:groups:invite:body' => "Bonjour %s,

%s vous a invité à rejoindre le groupe \"%s\".
%s

Cliquez ci dessous pour voir votre invitation.
%s
",

	// group add message
	'group_tools:groups:invite:add:subject' => "Vous avez été ajouté au groupe %s",
	'group_tools:groups:invite:add:body' => "Bonjour %s,

%s vous a ajouté au groupe %s
%s

Pour accéder au groupe, cliquez sur le lien
%s
	",
	// group invite by email
	'group_tools:groups:invite:email:subject' => "You've been invited for the group %s",
	'group_tools:groups:invite:email:body' => "Hi,

%s invited you to join the group %s on %s.
%s

If you don't have an account on %s please register here
%s

You can also go to All site groups -> Group invitations and enter the following code:
%s",
	// group transfer notification
	'group_tools:notify:transfer:subject' => "Administration of the group %s has been appointed to you",
	'group_tools:notify:transfer:message' => "Bonjour %s,

%s vous a désigné comme le nouveau responsable du groupe %s.

Pour accéder au groupe, cliquez sur le lien suivant :
%s
",
	
	// decline membership request notification
	'group_tools:notify:membership:declined:subject' => "Your membership request for '%s' was declined",
	'group_tools:notify:membership:declined:message' => "Hi %s,

Your membership request for the group '%s' was declined.

You can find the group here:
%s",
	'group_tools:notify:membership:declined:message:reason' => "Hi %s,

Your membership request for the group '%s' was declined, because of:

%s

You can find the group here:
%s",

	// group edit tabbed
	'group_tools:group:edit:profile' => "Présentation",
	'group_tools:group:edit:reason' => "Motif",
	'group_tools:group:edit:access' => "Droits d'accès",
	'group_tools:group:edit:tools' => "Choix des outils",
	'group_tools:group:edit:other' => "Options avancées",
	'group_tools:group:edit:suggested' => "Groupes suggérés",

	// group approval reason
	'group_tools:group:edit:reason:description' => "Please explain to the site administrator why your group should be approved by answering the questions below.",
	'group_tools:group:edit:reason:question' => "Why do you need this group",
	'group_tools:group:admin_approve:reasons' => "Motifs",
	'group_tools:group:admin_approve:reasons:details' => "The reasons the owner wants to get this group approved",
	'group_tools:group:admin_approve:menu' => "Motifs d'approbation",
	
	// concept groups
	'group_tools:group:edit:save:approve' => "Save & await approval",
	'group_tools:group:edit:save:concept' => "Enregistrer comme brouillon",
	'group_tools:group:concept:remaining' => "Will be removed %s",
	'group_tools:group:concept:profile:approve' => "Demande d'approbation",
	'group_tools:group:concept:profile:approve:confirm' => "Are you sure your group is ready to be reviewed by a site administrator?",
	'group_tools:group:concept:profile:publish' => "Remove draft status",
	'group_tools:group:concept:profile:publish:confirm' => "Are you sure your group is ready to be used by the community?",
	'group_tools:group:concept:profile:description' => "This group is still in concept, when you're ready click the button at the top of the profile.",
	'group_tools:group:concept:profile:retention' => "This group will be removed %s",
	'group_tools:action:remove_concept_status:success:approval' => "The group is now awaiting approval by a site administrator",
	'group_tools:action:remove_concept_status:success:published' => "The group is now available on the community",
	
	'group_tools:notification:concept_group:expires:subject' => "Your group '%s' is still in concept",
	'group_tools:notification:concept_group:expires:message' => "Hi %s,

Your group '%s' is still in concept, are you ready yet to share the group with the community?

If you don't publish your group it will be removed %s.

To view the group, click here:
%s",
	
	'group_tools:notification:concept_group:subject' => "Your group '%s' is still in concept",
	'group_tools:notification:concept_group:message' => "Hi %s,

Your group '%s' is still in concept, are you ready yet to share the group with the community?

To view the group, click here:
%s",
	
	// admin transfer - form
	'group_tools:admin_transfer:remain_admin' => "Remain a group admin after owner transfer",
	'group_tools:admin_transfer:remain_admin:help' => "After changing the owner, remain a group admin.",
	
	'group_tools:suggested:set' => "Suggest this group to users",
	'group_tools:suggested:remove' => "Remove group from suggested list",
	
	// group admins
	'group_tools:multiple_admin:group_admins' => "Group admins",
	'group_tools:multiple_admin:status:group_admin' => "Group admin",
	'group_tools:multiple_admin:profile_actions:remove' => "Remove group admin",
	'group_tools:multiple_admin:profile_actions:add' => "Add group admin",

	'group_tools:multiple_admin:group_tool_option' => "Permettre aux responsables du groupe de nommer d'autres responsables du groupe",
	
	// group admin approve
	'group_tools:group:admin_approve:notice' => "New groups need to be approved by a site administrator. You can make/edit the group, but it won't be visible to other users until approved by a site administrator.",
	'group_tools:group:admin_approve:notice:profile' => "This group is awaiting approval by a site administrator. You can edit the group, but it won't be visible to other users until approved by a site administrator.",
	'group_tools:group:admin_approve:decline:title' => "Decline the group approval request",
	'group_tools:group:admin_approve:decline:description' => "Here you can give a reason why the group '%s' isn't being approved. The group owner will receive a notification that the group was declined and the reason why. After the group is declined it'll be removed.",
	'group_tools:group:admin_approve:decline:reason' => "Reason for declining the group",
	'group_tools:group:admin_approve:decline:confirm' => "Are you sure you wish to decline this group? This will delete the group.",
	'group_tools:group:admin_approve:admin:description' => "Here is a list of groups which need to be approved by the site administrators before they can be used.

When you approve a group the owner will receive a notification that his/her group is now ready for use.
If you decline a group, the owner will receive a notification that his/her group was removed and the group will be removed.",
	
	'group_tools:group:admin_approve:approve:success' => "The group can now be used on the site",
	'group_tools:group:admin_approve:decline:success' => "The group was removed",
	
	'group_tools:group:admin_approve:approve:subject' => "Your group '%s' was approved",
	'group_tools:group:admin_approve:approve:summary' => "Your group '%s' was approved",
	'group_tools:group:admin_approve:approve:message' => "Hi %s,

your group '%s' was approved by a site administrator. You can now use it.

To visit the group click here:
%s",
	'group_tools:group:admin_approve:admin:subject' => "A new group '%s' was created which requires approval",
	'group_tools:group:admin_approve:admin:summary' => "A new group '%s' was created which requires approval",
	'group_tools:group:admin_approve:admin:message' => "Hi %s,

%s created a group '%s' which need to be approved by a site administrator.

To visit the group click here:
%s

To view all groups which need action click here:
%s",
	
	'group_tools:group:admin_approve:owner:subject' => "Your group '%s' is now awaiting approval",
	'group_tools:group:admin_approve:owner:message' => "Hi %s,

Your group '%s' is now awaiting approval by a site administrator.

To visit the group click here:
%s",
	
	'group_tools:group:admin_approve:decline:subject' => "Your group '%s' was declined",
	'group_tools:group:admin_approve:decline:summary' => "Your group '%s' was declined",
	'group_tools:group:admin_approve:decline:message' => "Bonjour %s,

	Votre groupe \"%s\" a été refusé. 
	
	La raison était:
	%s",
	
	// group notification
	'group_tools:notifications:title' => "Notifications du groupe",
	'group_tools:notifications:disclaimer' => "Cela peut prendre un certain temps pour les groupes importants !.",
	'group_tools:notifications:enable' => "Enregistrer et Activer les notifications pour tous les membres",
	'group_tools:notifications:disable' => "Désactiver les notifications pour tous les membres",
	
	'group_tools:edit:group:notifications:no_methods' => "No notification methods available.",
	'group_tools:edit:group:notifications:counter' => "(%d of %d)",
	'group_tools:edit:group:notifications:defaults' => "Default notification settings for new members",
	'group_tools:edit:group:notifications:defaults:help' => "When a new member joins the group, this will be their group notification settings.",

	'group_tools:notifications:toggle:email:enabled' => "Currently you are receiving notifications about activity in this group. If you don't want to receive notifications, change the settings here %s",
	'group_tools:notifications:toggle:email:disabled' => "Currently you are not receiving notifications about activity in this group. If you want to receive notifications, change the settings here %s",
	
	'group_tools:notifications:toggle:site:enabled' => "Currently you are receiving notifications about activity in this group. If you don't want to receive notifications, click here %s",
	'group_tools:notifications:toggle:site:enabled:link' => "disable notifications",
	'group_tools:notifications:toggle:site:disabled' => "Currently you are not receiving notifications about activity in this group. If you want to receive notifications, click here %s",
	'group_tools:notifications:toggle:site:disabled:link' => "enable notifications",
	
	// group mail
	'group_tools:tools:mail_members' => "Allow group members to mail other group members",
	'mail_members:group_tool_option:description' => "This will allow normal group members to send an e-mail to other group members. By default this is limited to group admins.",
	
	'group_tools:mail:message:from' => "From group",

	'group_tools:mail:title' => "Send a mail to the group members",
	'group_tools:mail:form:recipients' => "Select individual recipients",

	'group_tools:mail:form:title' => "Subject",
	'group_tools:mail:form:description' => "Body",

	'group_tools:mail:form:js:members' => "Please select at least one member to send the message to",
	'group_tools:mail:form:js:description' => "Please enter a message",

	// group invite
	'group_tools:groups:invite:error' => "No invitation options are available",
	'group_tools:groups:invite:title' => "Inviter des membres à rejoindre ce groupe",
	'group_tools:groups:invite' => "Inviter des membres",
	'group_tools:groups:invite:member' => "Déjà membre du groupe",
	
	'group_tools:group:invite:users' => "Trouver des membres",
	'group_tools:group:invite:users:description' => "Enter a name or username of a site member and select him/her from the list",
	'group_tools:group:invite:users:all' => "Invite all site members to this group",

	'group_tools:group:invite:email' => "Using e-mail address",
	'group_tools:group:invite:email:description' => "Enter a valid e-mail address and add it to the list",

	'group_tools:group:invite:csv' => "Using CSV upload",
	'group_tools:group:invite:csv:description' => "You can upload a CSV file with users to invite.
The first column must contain the e-mail addresses of the new members. There shouldn't be a header line.",

	'group_tools:group:invite:text' => "Personal note (optional)",
	'group_tools:group:invite:add:confirm' => "Are you sure you wish to add these users directly?",

	'group_tools:group:invite:resend' => "Resend invitations to users who already have been invited",

	'group_tools:groups:invitation:code:title' => "Group invitation by e-mail",
	'group_tools:groups:invitation:code:description' => "If you have received an invitation to join a group by e-mail, you can enter the invitation code here to accept the invitation. If you click on the link in the invitation e-mail the code will be entered for you.",

	// group membership requests
	'group_tools:groups:membershipreq:email_invitations:none' => "No pending e-mail invitations",
	'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Are you sure you wish to revoke this invitation",
	'group_tools:groups:membershipreq:kill_request:prompt' => "Optionally you can tell the user why you declined the request.",

	// group listing
	'group_tools:groups:sorting:open' => "Open",
	'group_tools:groups:sorting:closed' => "Closed",
	'group_tools:groups:sorting:suggested' => "Suggested",
	'group_tools:groups:sorting:member' => "Member",
	'group_tools:groups:sorting:managed' => "Managed",
	
	// allow group members to invite
	'group_tools:invite_members:title' => "Group members can invite",
	'group_tools:invite_members:description' => "Allow the members of this group to invite new members",
	'group_tools:invite_members:disclaimer' => "Please note that for closed groups allowing your users to invite new members means they don't require approval by the group owner/admin(s).",

	// group tool option descriptions
	'activity:group_tool_option:description' => "Show an activity feed about group related content.",
	
	// actions
	// group admins - action
	'group_tools:action:toggle_admin:error:group' => "The given input doesn't result in a group or you can't edit this group or the user is not a member",
	'group_tools:action:toggle_admin:error:remove' => "An unknown error occurred while removing the user as a group admin",
	'group_tools:action:toggle_admin:error:add' => "An unknown error occurred while adding the user as a group admin",
	'group_tools:action:toggle_admin:success:remove' => "Le membre a bien été retiré des responsables du groupe",
	'group_tools:action:toggle_admin:success:add' => "Le membre a bien été ajouté aux responsables du groupe",

	// group mail - action
	'group_tools:action:mail:success' => "Les message ab ien été envoyé",

	// group - invite - action
	'group_tools:action:invite:error:invite'=> "No users were invited (%s already invited, %s already a member)",
	'group_tools:action:invite:error:add'=> "No users were invited (%s already invited, %s already a member)",
	'group_tools:action:invite:success:invite'=> "Successfully invited %s users (%s already invited and %s already a member)",
	'group_tools:action:invite:success:add'=> "Successfully added %s users (%s already invited and %s already a member)",

	// group - invite - accept e-mail
	'group_tools:action:groups:email_invitation:error:code' => "The entered invitation code is no longer valid",
	'group_tools:action:groups:email_invitation:error:join' => "An unknown error occurred while joining the group %s, maybe you're already a member",
	'group_tools:action:groups:email_invitation:success' => "You've successfully joined the group",

	// group - invite - decline e-mail
	'group_tools:action:groups:decline_email_invitation:error:delete' => "An error occured while deleting the invitation",

	// suggested groups
	'group_tools:suggested_groups:info' => "The following groups might be interesting for you. Click the join buttons to join them immediately or click the title to view more information about the group.",
	'group_tools:suggested_groups:none' => "We can't suggest a group for you. This can happen if we have to little information about you, or that you are already a member of the groups we like you to join. Use the search to find more groups.",
		
	// group toggle auto join
	'group_tools:action:toggle_special_state:error:suggested' => "An error occurred while saving the new suggested settings",
	'group_tools:action:toggle_special_state:error:state' => "Invalid state provided",
	'group_tools:action:toggle_special_state:suggested' => "The new suggested settings were saved successfully",
	
	// fix group problems
	'group_tools:action:fix_acl:error:input' => "Invalid option you can't fix: %s",
	'group_tools:action:fix_acl:error:missing:nothing' => "No missing users found in the group ACLs",
	'group_tools:action:fix_acl:error:excess:nothing' => "No excess users found in the groups ACLs",
	'group_tools:action:fix_acl:error:without:nothing' => "No groups found without an ACL",

	'group_tools:action:fix_acl:success:missing' => "Successfully added %d users to group ACLs",
	'group_tools:action:fix_acl:success:excess' => "Successfully removed %d users from group ACLs",
	'group_tools:action:fix_acl:success:without' => "Successfully created %d group ACLs",

	// Widgets
	// Group River Widget
	'widgets:group_river_widget:name' => "Group activity",
	'widgets:group_river_widget:description' => "Shows the activity of a group in a widget",

	'widgets:group_river_widget:edit:group' => "Sélectionner un groupe",
	'widgets:group_river_widget:view:noactivity' => "We could not find any activity.",

	// Group Members
	'widgets:group_members:name' => "Membres du groupe",
	'widgets:group_members:description' => "Shows the members of this group",

	'widgets:group_members:view:no_members' => "Aucun membre de groupe trouvé",

  	// Group Invitations
	'widgets:group_invitations:name' => "Invitations à des groupes",
  	'widgets:group_invitations:description' => "Shows the outstanding group invitations for the current user",

	// index_groups
	'widgets:index_groups:name' => "Groups",
	'widgets:index_groups:description' => "List groups from your community",
	'widgets:index_groups:featured' => "Show only featured groups",
	'widgets:index_groups:sorting' => "How to sort the groups",

	'widgets:index_groups:filter:field' => "Filter groups based on group field",
	'widgets:index_groups:filter:value' => "with value",
	'widgets:index_groups:filter:no_filter' => "No filter",

	// Featured Groups
	'widgets:featured_groups:name' => "Featured groups",
	'widgets:featured_groups:description' => "Shows a random list of featured groups",
  	'widgets:featured_groups:edit:show_random_group' => "Show a random non-featured group",
	
	// related groups
	'widgets:group_related:name' => "Related groups",
  	'widgets:group_related:description' => "Show a list of related groups",
	
	// welcome message
	'group_tools:welcome_message:title' => "Group welcome message",
	'group_tools:welcome_message:description' => "You can configure a welcome message for new users who join this group. If you don't want to send a welcome message leave this field blank.",
	'group_tools:welcome_message:explain' => "Afin de personnaliser ce message, vous pouvez utiliser les balises suivantes : 
[name]: le nom du nouvel utilisateur (par ex. %s)
[group_name]: le nom du groupe (par ex. %s)
[group_url]: l'URL du groupe (par ex. %s)",
	
	'group_tools:action:welcome_message:success' => "Le message d'accueil a bien été enregistré",
	
	'group_tools:welcome_message:subject' => "Bienvenue dans %s",
	
	// email invitations
	'group_tools:action:revoke_email_invitation:error' => "An error occurred while revoking the invitation, please try again",
	'group_tools:action:revoke_email_invitation:success' => "The invitation was revoked",
	
	// domain based groups
	'group_tools:join:domain_based:tooltip' => "Because of a matching e-mail domain, you can join this group.",
	
	'group_tools:domain_based:title' => "Configure e-mail domains",
	'group_tools:domain_based:description' => "When you configure one (or more) e-mail domains, users with that e-mail domain will automatically join your group upon registration. Also if you have a closed group user with a matching e-mail domain can join without requesting membership. You can configure multiple domains by using a comma. Don't include the @ sign",
	
	'group_tools:action:domain_based:success' => "The new e-mail domains were saved",
	
	// related groups
	'groups_tools:related_groups:tool_option' => "Afficher les groupes suggérés",
	
	'groups_tools:related_groups:none' => "Aucun groupe associé.",
	'group_tools:related_groups:title' => "Groupes suggérés",
	
	'group_tools:related_groups:form:placeholder' => "Search for a new related group",
	'group_tools:related_groups:form:description' => "Vous pouvez chercher dans les suggestions de groupes, en sélectionnez, et cliquez sur Ajouter.",
	
	'group_tools:action:related_groups:error:same' => "You can't related this group to itself",
	'group_tools:action:related_groups:error:already' => "The selected group is already related",
	'group_tools:action:related_groups:error:add' => "An unknown error occurred while adding the relationship, please try again",
	'group_tools:action:related_groups:success' => "The group is now related",
	
	'group_tools:related_groups:notify:owner:subject' => "A new related group was added",
	'group_tools:related_groups:notify:owner:message' => "Bonjour %s,

%s a ajouté votre groupe \"%s\" comme groupe associé au groupe \"%s\".
",
	
	'group_tools:related_groups:entity:remove' => "Remove related group",
	
	'group_tools:action:remove_related_groups:error:not_related' => "The group is not related",
	'group_tools:action:remove_related_groups:error:remove' => "An unknown error occurred while removing the relationship, please try again",
	'group_tools:action:remove_related_groups:success' => "The group is no longer related",
	
	'group_tools:action:group_tool:presets:saved' => "New group tool presets saved",
	
	'group_tools:forms:members_search:members_search:placeholder' => "Enter the name or username of the user to search for",
	
	// group member export
	'group_tools:member_export:title_button' => "Export members",
	
	// csv exporter
	'group_tools:csv_exporter:group_admin:name' => "Group admin(s) name",
	'group_tools:csv_exporter:group_admin:email' => "Group admin(s) e-mail address",
	'group_tools:csv_exporter:group_admin:url' => "Group admin(s) profile url",
	
	'group_tools:csv_exporter:user:group_admin:name' => "Groups administrated name",
	'group_tools:csv_exporter:user:group_admin:url' => "Groups administrated url",
	
	// group bulk delete
	'group_tools:action:bulk_delete:success' => "The selected groups were deleted",
	'group_tools:action:bulk_delete:error' => "An error occured while deleting the groups, please try again",
	
	// group toggle notifications
	'group_tools:action:toggle_notifications:disabled' => "The notifications for the group '%s' have been disabled",
	'group_tools:action:toggle_notifications:enabled' => "The notifications for the group '%s' have been enabled",
	
	// disable notifications
	'group_tools:action:notifications:success:disable' => "All notifcations have been disabled",
	
	// group join motivation
	'group_tools:join_motivation:edit:option:label' => "Joining this closed group requires motivation",
	'group_tools:join_motivation:edit:option:description' => "Closed groups can require that new users supply a motivation why they want to join.",
	
	'group_tools:join_motivation:title' => "Why do you wish to join '%s'?",
	'group_tools:join_motivation:description' => "The owner of '%s' has indicated that a motivation is required to join this group. Please provide a motivation below so the owner can judge your membership request.",
	'group_tools:join_motivation:label' => "My motivation for joining this group",
	
	'group_tools:join_motivation:notification:subject' => "%s has requested to join %s",
	'group_tools:join_motivation:notification:summary' => "%s has requested to join %s",
	'group_tools:join_motivation:notification:body' => "Hi %s,

%s has requested to join the '%s' group.

Their motivation for joining is:
%s

Click below to view their profile:
%s

Click below to view the group's join requests:
%s",
	'group_tools:join_motivation:listing' => "Reason for joining:",
	
	// stale groups
	'group_tools:stale_info:description' => "This group has been inactive for a while. The content may no longer be relevant.",
	'group_tools:stale_info:link' => "This group is still relevant",
	
	'group_tools:csv_exporter:stale_info:is_stale' => "Stale group",
	'group_tools:csv_exporter:stale_info:timestamp' => "Stale timestamp",
	'group_tools:csv_exporter:stale_info:timestamp:readable' => "Stale timestamp (readable)",
	
	'groups_tools:state_info:notification:subject' => "Your group '%s' has been inactive for a while",
	'groups_tools:state_info:notification:summary' => "Your group '%s' has been inactive for a while",
	'groups_tools:state_info:notification:message' => "Hi %s,

Your group '%s' has been inactive for a while.

Please check on the group here:
%s",
	
	// upgrades
	'group_tools:upgrade:2019051000:title' => "Fix group access",
	'group_tools:upgrade:2019051000:description' => "Some group could have been created with the access level 'Private', this will prevent members from accessing the group.",
	
	'group_tools:upgrade:2019102501:title' => "Migrate group default content access",
	'group_tools:upgrade:2019102501:description' => "As of Elgg 3.2 group default content access is part of Elgg. This will migrate the group tools settings to the correct place in Elgg.",





// @TODO TRADUCTIONS FAITES A REINTEGRER
// Note : ces traductions prennent le pas sur les précédentes tant qu'elles sont définies plus tard dans ce fichier
  'group_tools:welcome_message:title' => "Message d'accueil du groupe",
	'group_tools:welcome_message:description' => "Vous pouvez configurer un message d'accueil pour les nouveaux utilisateurs qui rejoindront ce groupe. Si vous ne voulez pas envoyer un message d'accueil, ne pas remplir ci-dessous.",
	'group_tools:add_users' => "Ajouter des utilisateurs",
	'group_tools:delete_selected' => "Supprimer la sélection",
	'group_tools:clear_selection' => "Réinitialiser la sélection",
	'group_tools:all_members' => "Tous les membres (%d)",
	'group_tools:joinrequest:already:tooltip' => "Vous avez déjà demandé à rejoindre ce groupe. Cliquez ici pour annuler votre demande.",
	'group_tools:join:already:tooltip' => "Vous avez été invité à rejoindre ce groupe et pouvez l'intégrer dès à présent.",
	'group_tools:menu:mail' => "Envoyer un e-mail aux membres",
	'group_tools:settings:invite:title' => "Gestion des options d'invitation du groupe",
	'group_tools:settings:management:title' => "Gestion des options générales du groupe",
	'group_tools:settings:admin_transfer' => "Autoriser le transfert d'animateur de groupe",
	'group_tools:settings:admin_transfer:admin' => "Administrateurs du site uniquement",
	'group_tools:settings:admin_transfer:owner' => "Animateurs de groupes et administrateurs du site",
	'group_tools:settings:multiple_admin' => "Autoriser plusieurs administrateurs de groupe",
	'group_tools:groups:invitation:code:title' => "Invitations aux groupes de discussions reçues par e-mail",
	'group_tools:groups:invitation:code:description' => "Si vous avez reçu une invitation pour rejoindre un groupe par e-mail, vous pouvez entrer le code d'invitation ici, ou cliquez directement sur le lien de l'e-mail.",
	
  'group_tools:group:invite:users' => "Trouver des membres",
	'group_tools:group:invite:email' => "Utiliser des e-mails",
	'group_tools:group:invite:csv' => "Utiliser un fichier CSV",
	'group_tools:group:invite:users:description' => "Entrer le nom d'un membre et le sélectionner dans la liste",
	'group_tools:group:invite:users:all' => "Inviter tous les membres du site à ce groupe",
	'group_tools:group:invite:text' => "Message personnel (optionnel)",
	'group_tools:group:invite:resend' => "Renvoyer l'invitation aux membres qui ont déjà été invités",
	'group_tools:group:invite:add:confirm' => "Confirmez-vous vouloir ajouter ces utilisateurs directement ?",
	'group_tools:groups:invite' => "Inviter des membres",
	'group_tools:groups:invite:email:subject' => "Vous avez été invité à rejoindre le Groupe %s",
	'group_tools:suggested_groups:none' => "Nous ne pouvons vous suggérer de groupe. Nous n'avons pas assez d'information sur vous pour vous conseiller ou vous avez déjà rejoint les groupes que nous souhaitions vous suggérer. Utilisez le moteur de recherche pour trouvez de nouveaux groupes.",
	'widgets:group_river_widget:name' => "Activité du groupe",
	'group_tools:welcome_message:subject' => "Bienvenue dans le groupe %s !",
	'widgets:group_river_widget:description' => "Affiche l'activité d'un groupe",
	'item:object:group_tools_group_mail' => "Email du groupe",
	'admin:groups:bulk_delete' => "Suppression en masse",
	'admin:groups:admin_approval' => "Approbation nécessaire",
	'group_tools:settings:admin_only' => "Admin seulement",
	'group_tools:settings:edit:title' => "Paramètres de l'édition de groupe",
	'group_tools:settings:auto_suggest_groups' => "Suggérer automatiquement des groupes sur la page \"Groupes suggérés\", sur la base des informations du profil",
	'group_tools:settings:auto_suggest_groups:help' => "Sera complété par les groupes suggérés prédéfinis. Ne pas sélectionner cette option conduira à n'afficher que les groupes suggérés prédéfinis (s'il y en a)",
	'group_tools:settings:notifications:title' => "Paramètres de notification de groupe",
	'group_tools:settings:notifications:notification_toggle' => "Afficher les paramètres de notification lors de l'adhésion au groupe.",
	'group_tools:settings:invite_friends' => "Permettre d'inviter des amis",
	'group_tools:settings:invite' => "Permettre d'inviter tout le monde (et pas seulement les amis)",
	'group_tools:settings:notifications:notification_toggle:description' => "Ceci affichera un message système, où l'utilisateur pourra basculer les paramètres de notification, et ajoutera un lien vers les paramètres de notification en bas du mail de notification.",
	'group_tools:settings:invite_email' => "Permettre d'inviter tout le monde via les adresses mail",
	'group_tools:settings:invite_csv' => "Permettre d'inviter tout le monde via un fichier CSV",
	'group_tools:settings:invite_members' => "Autoriser les membres de groupe à inviter de nouveaux membres",
	'group_tools:settings:invite_members:description' => "Propriétaires de groupes / admins peuvent activer/désactiver ceci pour leur groupe",
	'group_tools:settings:domain_based' => "Activer les groupes basés sur les domaines",
	'group_tools:settings:domain_based:description' => "Les utilisateurs peuvent rejoindre un groupe basé sur leur adresse mail. Ils seront automatiquement inscrit à un groupe sur la base du nom de domaine de leur mail pendant leur enregistrement",
	'group_tools:settings:join_motivation' => "Demander une raison lorsqu'un utilisateur veut rejoindre un groupe fermé",
	'group_tools:settings:join_motivation:description' => "Lorsqu'un utilisateur veut rejoindre un groupe fermé, une raison lui est demandé. Les propriétaires du groupe peuvent changer ce paramètre  ( 'non' ou 'requis' le cas échéant)",
	'group_tools:settings:mail' => "Autoriser l'envoi de message de groupe (autorise les administrateurs de groupe à envoyer des messages à tous les membres du groupe)",
	'group_tools:settings:mail:members' => "Autoriser les administrateurs de groupes d'activer les mail de groupe pour leurs membres",
	'group_tools:settings:mail:members:description' => "L'autorisation des mails de groupe est requise",
	'group_tools:settings:listing:title' => "Paramètres d'affichage de la liste des groupes",
	'group_tools:settings:listing:description' => "Vous pouvez ici configurer quels sont les onglets visibles sur la page de liste des groupes, quelle onglet sera actif par défaut, et quel tri appliqué par défaut",
	'group_tools:settings:listing:enabled' => "Activé",
	'group_tools:settings:listing:default_short' => "Onglet par défaut",
	'group_tools:settings:listing:default' => "Onglet par défaut pour la liste des groupes",
	'group_tools:settings:listing:available' => "Onglets disponibles pour la liste des groupes",
	'group_tools:settings:content:title' => "Paramètres de contenu des groupes",
	'group_tools:settings:stale_timeout' => "Un groupe devient \"Périmé\" si aucun contenu n'a été créé depuis un certain nombre de jours",
	'group_tools:settings:search_index' => "Autoriser les groupes fermés à être indexé par les moteurs de recherche.",
	'group_tools:settings:stale_timeout:help' => "Si aucun contenu n'a été créé depuis un certain nombre de jours, le groupe est affiché comme \"Périmé\". Le propriétaire du groupe recevra une notification le jour où le groupe devient \"Périmé\". Un propriétaire de groupe/admin peut dire si un groupe est malgré tout toujours d'actualité. 0 ou vide pour désactiver cette option.",
	'group_tools:settings:auto_notification' => "Activer automatiquement les notifications lors de l'adhésion au groupe",
	'group_tools:settings:special_states:featured:description' => "Les administrateurs du site ont choisi de mettre en avant les groupes suivants",
	'group_tools:settings:fix:title' => "Réparer les problèmes d'accés aux groupes",
	'group_tools:settings:fix:missing' => "Il y a %d utilisateurs qui sont membres d'un groupe, mais qui n'ont pas accés au contenu partagé par ce groupe.",
	'group_tools:settings:fix:excess' => "Il y a %d utilisateurs qui ont accés au contenu d'un groupe alors qu'ils n'en sont plus membre.",
	'group_tools:settings:fix:without' => "Il y a %d groupes qui ne peuvent pas partager de contenu avec leurs membres",
	'group_tools:settings:fix:all:description' => "Réparer tout les problèmes ci-dessus en une seule fois",
	'group_tools:settings:fix_it' => "Réparer ceci",
	'group_tools:settings:fix:all' => "Réparer tous les problèmes",
	'group_tools:settings:member_export' => "Autoriser les administrateurs de groupe à exporter des informations sur les membres",
	'group_tools:settings:member_export:description' => "Ceci comprend le nom, le nom d'utilisateur et l'email de l'utilisateur",
	'group_tools:settings:admin_approve' => "Les nouveaux groupes doivent être validés par les administrateurs",
	'group_tools:settings:admin_approve:description' => "Tout utilisateur peut crééer un groupe, mais les administrateurs doivent valider la demande",
	'group_tools:admin:auto_join:default' => "Auto adhésion",
	'group_tools:admin:auto_join:default:description' => "Les nouveaux utilisateur seront automatiquement inscrits aux groupes suivants",
	'group_tools:admin:auto_join:default:none' => "Aucune auto adhésion de groupes n'est configurée",
	'group_tools:form:admin:auto_join:group' => "Ajouter un groupe à liste d'auto adhésion",
	'group_tools:form:admin:auto_join:group:help' => "Chercher un groupe par son nom, et le sélectionner dans la liste",
	'group_tools:form:admin:auto_join:additional:group' => "Sélectionner le groupe à rejoindre",
	'group_tools:form:admin:auto_join:additional:group:help' => "Chercher un groupe par son nom, et le sélectionner dans la liste",
	'group_tools:admin:auto_join:additional' => "Autres groupes pour l'auto adhésion",
	'group_tools:admin:auto_join:additional:description' => "Vous pouvez configurer ici les groupes additionnels auxquels un utilisateur devrait s'inscrire, basé sur les caractéristiques de l'utilisateur",
	'group_tools:admin:auto_join:additional:none' => "Aucun groupe additionnel n'est configuré",
	'group_tools:admin:auto_join:exclusive' => "Exclusion d'auto adhésion",
	'group_tools:admin:auto_join:exclusive:description' => "Vous pouvez configure ici les groupes additionnels auxquels un utilisateur devrait s'inscrire, basé sur les caractéristiques de l'utilisateur. Si une relation est trouvée pour un utilisateur, ils ne seront pas ajoutés à aucun des groupes définis ci-dessus.",
	'group_tools:admin:auto_join:exclusive:none' => "Aucun exclusion d'auto adhésion n'est configurée",
	'group_tools:form:admin:auto_join:additional:pattern' => "Caractéristique utilisateur à faire correspondre",
	'group_tools:form:admin:auto_join:additional:pattern:add' => "Ajouter une caractéristique",
	'group_tools:form:admin:auto_join:additional:pattern:help' => "Les utilisateurs seront mis en correspondance avec chacune des caractéristiques configurées. Pour enlever une caractéristique, laisser la valeur vide",
 
  'group_tools:action:admin:auto_join:additional:error:pregmatch' => "L'expression régulière saisie n'est pas valide",
	'group_tools:edit:access_simplified:open' => "Groupe ouvert",
	'group_tools:edit:access_simplified:open:description' => "<ul><li>Tout utilisateur peut s'inscrire </li><li>Le contenu peut être partagé avec tous le monde</li></ul>",
	'group_tools:edit:access_simplified:closed' => "Groupe fermé",
	'group_tools:edit:access_simplified:closed:description' => "<ul><li>L'adhésion a besoin d'être validée</li><li>Le contenu ne peut être partagé que par les membres du groupe</li></ul>",
	'groups_tools:state_info:notification:message' => "Bonjour %s,

Votre groupe '%s' est inactif depuis un bon moment

Nous vous remercions de vérifier votre groupe ici:
%s",
	'groups_tools:state_info:notification:summary' => "Votre groupe '%s' est inactif depuis un bon moment",
	'groups_tools:state_info:notification:subject' => "Votre groupe '%s' est inactif depuis un bon moment",
	'group_tools:csv_exporter:stale_info:is_stale' => "Groupe périmé",
	'group_tools:csv_exporter:stale_info:timestamp' => "Date de peremption",
	'group_tools:csv_exporter:stale_info:timestamp:readable' => "Date de péremption (lecture)",
	'group_tools:stale_info:link' => "Ce groupe est toujours d'actualité",
	'group_tools:create_group:tool_presets:show_more' => "Plus d'outils",
	'group_tools:create_group:tool_presets:blank:title' => "Groupe vide",
	'group_tools:multiple_admin:group_admins' => "Responsables du groupe",
	'group_tools:multiple_admin:profile_actions:remove' => "Retirer un responsable de groupe",
	'group_tools:multiple_admin:profile_actions:add' => "Ajouter un responsable de groupe",
	'group_tools:group:admin_approve:approve:summary' => "Votre groupe \"%s\" a été validé",
	'group_tools:group:admin_approve:approve:subject' => "Votre groupe \"%s\" a été validé",
	'group_tools:group:admin_approve:approve:message' => "Bonjour %s,

Votre groupe \"%s\" a été validé par les administrateurs du site. Vous pouvez dorénavant l'utiliser

Pour voir votre groupe, cliquez ici:
%s",
	'group_tools:group:admin_approve:decline:success' => "Le groupe a été retiré",
	'group_tools:group:admin_approve:approve:success' => "Le groupe peut être utilisé sur le site",
	'group_tools:group:admin_approve:decline:subject' => "Votre groupe '%s' a été refusé",
	'group_tools:group:admin_approve:decline:summary' => "Votre groupe '%s' a été refusé",

  'group_tools:notifications:toggle:site:enabled:link' => "desactive les notifications",
	'group_tools:notifications:toggle:site:disabled:link' => "active les notifications",
	'group_tools:mail:message:from' => "Depuis le groupe",
	'group_tools:mail:form:recipients' => "Nombre de destinataires",
	'group_tools:mail:title' => "Envoyer un mail a tous les membres du groupe",
	'group_tools:mail:form:members:selection' => "Sélectionner les membres individuellement",
	'group_tools:mail:form:title' => "Sujet",
	'group_tools:mail:form:description' => "Corps",
	'group_tools:mail:form:js:members' => "Merci de sélectionner au moins un membre à qui envoyer un message",
	'group_tools:mail:form:js:description' => "Merci de saisir votre message",
	'group_tools:groups:invite:error' => "Aucune option d’invitation disponible",
	'group_tools:groups:sorting:open' => "Accès libre",
	'group_tools:groups:sorting:closed' => "Accès restreint",
	'group_tools:groups:sorting:suggested' => "Suggéré",
	'group_tools:action:fix_acl:error:without:nothing' => "Aucun groupe trouvé sans ACL",
	'widgets:index_groups:featured' => "N'afficher que les groupes mis en avant",
	'widgets:index_groups:sorting' => "Comment trier les groupes",
	'group_tools:member_export:title_button' => "Exporter les membres",
	'group_tools:join_motivation:listing' => "Raison de l'adhésion",
	'group_tools:stale_info:description' => "Ce groupe n'est plus actif depuis un moment. Le contenu n'est peut être plus d'actualité",
	'admin:groups:auto_join' => "Auto adhésion",
	'group_tools:create_group:tool_presets:more_header' => "Outils additionnels",
	'group_tools:create_group:tool_presets:select' => "Sélectionnez un type de groupe",
];
