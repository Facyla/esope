<?php
return array(
	'transitions' => 'Contributions',
	'transitions:transitions' => 'Contributions',
	'transitions:revisions' => 'Revisions',
	'transitions:archives' => 'Archives',
	'transitions:transitions' => 'Contribution',
	'item:object:transitions' => 'Contributions',

	'transitions:title:user_transitions' => '%s\'s contributions',
	'transitions:title:all_transitions' => 'All site contributions',
	'transitions:title:friends' => 'Friends\' contributions',

	'transitions:group' => 'Group contributions',
	'transitions:enabletransitions' => 'Enable group contributions',
	'transitions:write' => 'Write a contribution',

	// Editing
	'transitions:add' => 'Add a contribution',
	'transitions:edit' => 'Edit contribution',
	'transitions:excerpt' => 'Excerpt',
	'transitions:body' => 'Body',
	'transitions:save_status' => 'Last saved: ',
	
	'transitions:revision' => 'Revision',
	'transitions:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'transitions:message:saved' => 'Contribution saved.',
	'transitions:error:cannot_save' => 'Cannot save contribution.',
	'transitions:error:cannot_auto_save' => 'Cannot automatically save contribution.',
	'transitions:error:cannot_write_to_container' => 'Insufficient access to save contribution to group.',
	'transitions:messages:warning:draft' => 'There is an unsaved draft of this contribution!',
	'transitions:edit_revision_notice' => '(Old version)',
	'transitions:message:deleted_post' => 'Contribution deleted.',
	'transitions:error:cannot_delete_post' => 'Cannot delete contribution.',
	'transitions:none' => 'No contribution',
	'transitions:error:missing:title' => 'Please enter a contribution title!',
	'transitions:error:missing:description' => 'Please enter the body of your contributions!',
	'transitions:error:cannot_edit_post' => 'This contribution may not exist or you may not have permissions to edit it.',
	'transitions:error:post_not_found' => 'Cannot find specified contribution.',
	'transitions:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:create:object:transitions' => '%s published a contribution %s',
	'river:comment:object:transitions' => '%s commented on the contribution %s',

	// notifications
	'transitions:notify:summary' => 'New contribution called %s',
	'transitions:notify:subject' => 'New contribution: %s',
	'transitions:notify:body' =>
'
%s published a new contribution: %s

%s

View and comment on the contribution:
%s
',

	// widget
	'transitions:widget:description' => 'Display your latest contributions',
	'transitions:moretransitions' => 'More contributions',
	'transitions:numbertodisplay' => 'Number of contributions to display',
	'transitions:notransitions' => 'No contribution',
	
	
);
