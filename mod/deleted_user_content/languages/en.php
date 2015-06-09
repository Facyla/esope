<?php

$english = array(
	/* magic strings */
	'admin:user' => "User",
	'admin:user:delete:content_policy' => "Content Deletion Policy",
	
	
	'duc:error:content_owner' => "Invalid ID for new content owner",
	'duc:error:invalid_guid' => "Invalid user ID",
	'duc:delete:user' => "You are about to delete the user '%s'.  Please select what should happen to all content created by this user.",
	'duc:error:select_policy' => "You must select a course of action with regard to the users content",
	'duc:label:content_policy' => "Content Policy",
	'duc:label:content_policy:help' => "If reassigning to another user, search for that user below",
	'duc:option:delete' => "Delete all content owned by this user",
	'duc:option:reassign' => "Reassign the content to another user",
	'duc:label:reassign_member' => "New Owner",
	'duc:label:reassign_member:help' => 'If reassigning content, type the name of the member you want to be the new owner and select them from the list.  You can only select one owner, any additional selections will be ignored.',
	'duc:error:reassign_deleted_user' => "You cannot reassign content to the user you are deleting",
	'duc:title:stats' => "Content owned by this user",
);

add_translation('en', $english);