<?php
/**
 * Elgg Web Services language pack.
 * 
 * @package Webservice
 * @author Saket Saurabh
 */

$english = array(
	'web_services:user' => "User", 
	'web_services:object' => "Object", 
	'web_services:blog' => "Blog", 
	'web_services:wire' => "Wire", 
	'web_services:core' => "Core", 
	'web_services:group' => "Group",
	'web_services:file' => "File",
	'web_services:messages' => "Messages",
	'web_services:settings_description' => "Select the web services below that you wish to be enabled:",
	'web_services:selectfeatures' => "Select the features to be enabled",
	'friends:alreadyadded' => "%s is already added as friend",
	'friends:remove:notfriend' => "%s is not your friend",
	'blog:message:notauthorized' => "Not authorized to carry this request",
	'blog:message:noposts' => "No blog posts by user",

	'admin:utilities:web_services' => 'Web Services Tests',
	'web_services:tests:instructions' => 'Run the unit tests for the web services plugin',
	'web_services:tests:run' => 'Run tests',
	'web_services:likes' => 'Likes',
	'likes:notallowed' => 'Not allowed to like',
	
	'web_services:settings:api_information' => "Any call to the web services can be made by calling the URL :<br />
		<pre>&lt;site URL&gt;/services/api/rest/&lt;outpput type&gt;/?method=&lt;method name&gt;</pre>
		Where <ul>
			<li>&lt;site URL&gt; : the path of root directory of Elgg website</li>
			<li>&lt;outpput type> : json or xml</li>
			<li>&lt;method name> : the name of the remote method you want to call</li>
		</ul>
		<p>Optional parameters are <strong>api_key=APIKEY</strong> and <strong>auth_token=USER_TOKEN</strong></p>
		<p>Les autres paramètres dépendent du webservice utilisé</p>",
	
	// A resolution to json convertion error (for river)
	'river:update:user:default' => ' updated their profile ',
	
	// Core webservice
	'web_services:core:site_test' => "Webservice test",
	'web_services:core:site_test:response' => "Hello",
	'web_services:core:getinfo' => "Get site information",
	'web_services:core:oauthok' => "running",
	'web_services:core:nooauth' => "no",
	'web_services:core:river_feed' => "Get river feed",
	'web_services:core:search' => "Perform a search",
	'web_services:core:auth_renewtoken' => "API user token renewal",
	'SecurityException:tokenrenewalfailed' => "Token renewal failed: connection is lost. If you had ongoing changes, you should copy-paste them before logging in again.",
	
	// Blog webservice
	'web_services:blog:get_posts' => "Get list of blog posts",
	'web_services:blog:save_post' => "Post a blog post",
	'web_services:blog:delete_post' => "Delete a blog post",
	'web_services:blog:get_post' => "Read a blog post",
	'web_services:blog:get_comments' => "Get comments for a blog post",
	'web_services:blog:post_comment' => "Post a comment on a blog post",
	
	// File webservice
	'web_services:file:get_files' => "Get file uploaded by all users",
	'web_services:file:get_info' => "Get file information",
	'web_services:file:get_content' => "Get file content",
	'web_services:file:not_found' => "File not found",
	
	// Group webservice
	'web_services:group:get_groups' => "Get groups user is a member of",
	'web_services:group:get' => "Get a group",
	'web_services:group:join' => "Join a group",
	'web_services:group:leave' => "Leave a group",
	'web_services:group:save' => "Save a group",
	'web_services:group:save_post' => "Post a topic to a group forum",
	'web_services:group:delete_post' => "Delete topic post from a group forum",
	'web_services:group:get_posts' => "Get posts from a group",
	'web_services:group:get_post' => "Get a single post from a group forum",
	'web_services:group:get_replies' => "Get replies from a group forum topic",
	'web_services:group:save_reply' => "Post a reply to a group forum topic",
	'web_services:group:delete_reply' => "Delete a reply from a group forum topic",
	'web_services:group:activity' => "Get the activity feed for a group",
	'web_services:group:notfound' => "Group not found or no access to group",
	'web_services:group:get_icon' => "Get group profile icon",
	
	// The Wire webservice
	'web_services:wire:save_post' => "Post a wire post",
	'web_services:wire:get_posts' => "Read latest wire posts",
	'web_services:wire:delete_posts' => "Delete a wire post",
	
	// User webservice
	'web_services:user:get_profile_fields' => "Get user profile labels",
	'web_services:user:get_profile' => "Get user profile information",
	'web_services:user:save_profile' => "Save user profile information",
	'web_services:user:get_user_by_email' => "Get username(s) by email",
	'web_services:user:check_username_availability' => "Check username availability",
	'web_services:user:register' => "Register user",
	'web_services:user:friend:add' => "Add a user as friend",
	'web_services:user:friend:remove' => "Remove friend",
	'web_services:user:get_friends' => "Get user friends",
	'web_services:user:friend:get_friends_of' => "Get users user if friend of",
	'web_services:user:get_messageboard' => "Get a users messageboard",
	'web_services:user:post_messageboard' => "Post a messageboard post",
	'web_services:user:activity' => "Get the activity feed for a user",
	'web_services:user:get_guid' => "Get the user GUID for a given username",
	'web_services:user:get_username' => "Get the user username for a given GUID",
	'web_services:user:group_join_request:remove' => "remove user join request",
	'web_services:user:group_join_request:accept' => "accept user join request",
	'web_services:user:friend_request:remove' => "remove user friend request",
	'web_services:user:friend_request:accept' => "accept user friend request",
	'web_services:user:requests:list' => "Get user friendship and groups requests",

	
	// Message webservice
	'web_services:message:read' => "Read a single message",
	'web_services:message:count' => "Get a count of the users unread messages",
	'web_services:message:inbox' => "Get inbox messages",
	'web_services:message:sent' => "Get sent messages",
	'web_services:message:send' => "Send a message",
	
	// Object
	'web_services:object:get_post' => "Read a content",
	'object:error:post_not_found' => "Content not found",
	
	
);

add_translation("en", $english);

