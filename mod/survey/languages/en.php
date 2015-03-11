<?php

$en = array(

	/**
	 * Menu items and titles
	 */
	'poll' => "Polls",
	'survey:add' => "New Poll",
	'survey:group_poll' => "Group polls",
	'survey:group_poll:listing:title' => "%s's polls",
	'survey:your' => "Your polls",
	'survey:not_me' => "%s's polls",
	'survey:friends' => "Friends' polls",
	'survey:addpost' => "Create a poll",
	'survey:editpost' => "Edit a poll: %s",
	'survey:edit' => "Edit a poll",
	'item:object:poll' => 'Polls',
	'item:object:poll_choice' => "Poll choices",
	'survey:question' => "Poll question",
	'survey:description' => "Description (optional)",
	'survey:responses' => "Vote choices",
	'survey:result:label' => "%s (%s)",
	'survey:show_results' => "Show results",
	'survey:show_poll' => "Show poll",
	'survey:add_choice' => "Add vote choice",
	'survey:delete_choice' => "Delete this choice",
	'survey:close_date' => "Poll closing date (optional)",
	'survey:voting_ended' => "Voting for this poll ended on %s.",
	'survey:poll_closing_date' => "(Poll closing date: %s)",

	'survey:convert:description' => 'ATTENTION: there were %s existing polls found that still have the old vote choices data structure. These polls won\'t work correctly on this version of the poll plugin.',
	'survey:convert' => 'Update existing polls now',
	'survey:convert:confirm' => 'The update is irreversible. Are you sure you want to convert the poll vote choices data structure?',

	'survey:settings:group:title' => "Allow group polls?",
	'survey:settings:group_poll_default' => "yes, on by default",
	'survey:settings:group_poll_not_default' => "yes, off by default",
	'survey:settings:no' => "no",
	'survey:settings:group_access:title' => "If group polls are activated, who gets to create polls?",
	'survey:settings:group_access:admins' => "group owners and admins only",
	'survey:settings:group_access:members' => "any group member",
	'survey:settings:front_page:title' => "Admins can make a single poll at a time the site's \"Poll of the day\"? (Widget Manager plugin required for adding the corresponding widget to the index page)",
	'survey:settings:allow_close_date:title' => "Allow setting a closing date for polls? (afterwards the results can still be viewed but voting is no longer permitted)",
	'survey:settings:allow_open_poll:title' => "Allow open polls? (open polls show which user voted for which poll choice; if this option is enabled, admins can see who voted what on any polls)",
	'survey:none' => "No polls found.",
	'survey:not_found' => "The poll was not found.",
	'survey:permission_error' => "You do not have permission to edit this poll.",
	'survey:vote' => "Vote",
	'survey:login' => "Please login if you would like to vote in this poll.",
	'group:poll:empty' => "No polls",
	'survey:settings:site_access:title' => "Who can create site-wide polls?",
	'survey:settings:site_access:admins' => "admins only",
	'survey:settings:site_access:all' => "any logged-in user",
	'survey:can_not_create' => "You do not have permission to create polls.",
	'survey:front_page_label' => "Make this poll the site's new \"Poll of the day\"",
	'survey:open_poll_label' => "Show in results which members voted for which choice (open poll)",
	'survey:show_voters' => "Show voters",

	/**
	 * Poll widget
	 **/
	'survey:latest_widget_title' => "Latest community polls",
	'survey:latest_widget_description' => "Displays the most recent polls.",
	'survey:latestgroup_widget_title' => "Latest group polls",
	'survey:latestgroup_widget_description' => "Displays the most recent group polls.",
	'survey:my_widget_title' => "My polls",
	'survey:my_widget_description' => "This widget will display your polls.",
	'survey:widget:label:displaynum' => "How many polls do you want to display?",
	'survey:individual' => "Poll of the day",
	'poll_individual:widget:description' => "Display the site's current \"Poll of the day\".",
	'survey:widget:no_poll' => "There are no polls of %s yet.",
	'survey:widget:nonefound' => "No polls found.",
	'survey:widget:think' => "Let %s know what you think!",
	'survey:enable_poll' => "Enable polls",
	'survey:noun_response' => "vote",
	'survey:noun_responses' => "votes",
	'survey:settings:yes' => "yes",
	'survey:settings:no' => "no",

	'survey:month:01' => 'January',
	'survey:month:02' => 'February',
	'survey:month:03' => 'March',
	'survey:month:04' => 'April',
	'survey:month:05' => 'May',
	'survey:month:06' => 'June',
	'survey:month:07' => 'July',
	'survey:month:08' => 'August',
	'survey:month:09' => 'September',
	'survey:month:10' => 'October',
	'survey:month:11' => 'November',
	'survey:month:12' => 'December',

	/**
	 * Notifications
	 **/
	'survey:new' => 'A new poll',
	'survey:notify:summary' => 'New poll called %s',
	'survey:notify:subject' => 'New poll: %s',
	'survey:notify:body' =>
'
%s created a new poll:

%s

View and vote on the poll:
%s
',

	/**
	 * Poll river
	 **/
	'survey:settings:create_in_river:title' => "Show poll creation in activity river?",
	'survey:settings:vote_in_river:title' => "Show poll voting in activity river?",
	'survey:settings:send_notification:title' => "Send notification when a poll is created? (Members will only receive notifications if their are friend with the creator of the poll or a member of the group the poll was added to. Additionally, notifications will only be sent to members who configured Elgg's notification settings accordingly)",
	'river:create:object:poll' => '%s created a poll %s',
	'river:vote:object:poll' => '%s voted on the poll %s',
	'river:comment:object:poll' => '%s commented on the poll %s',

	/**
	 * Status messages
	 */
	'survey:added' => "Your poll was created.",
	'survey:edited' => "Your poll was saved.",
	'survey:responded' => "Thank you for responding, your vote was recorded.",
	'survey:deleted' => "Your poll was successfully deleted.",
	'survey:totalvotes' => "Total number of votes: %s",
	'survey:voted' => "Your vote has been cast for this poll. Thank you for voting on this poll.",

	/**
	 * Error messages
	 */
	'survey:blank' => "Sorry: you need to fill in both the question and add at least one vote choice before you can create the poll.",
	'survey:novote' => "Sorry: you need to choose an option to vote in this poll.",
	'survey:alreadyvoted' => "Sorry: you can vote only once.",
	'survey:notfound' => "Sorry: we could not find the specified poll.",
	'survey:notdeleted' => "Sorry: we could not delete this poll.",
	
	
	
	// ESOPE : New survey strings
	'survey:questions' => "Questions",
	'survey:add_question' => "Add a question",
	'survey:delete_question' => "Remove this question",
	'survey:title' => "Survey title",
	'survey:option:yes' => "yes",
	'survey:option:no' => "no",
	// Question fields
	'survey:question:title' => "Question title",
	'survey:question:description' => "Help or details on this question (optional)",
	'survey:question:input_type' => "Question type",
	'survey:question:options' => "Options",
	'survey:question:empty_value' => "Add an empty option",
	'survey:question:required' => "Mandatory",
	'survey:question:toggle' => "Show/hide",
	// Input types
	'survey:type:text' => "Short text",
	'survey:type:text:details' => "For a very quick answer : one to a few words.",
	'survey:type:longtext' => "Long text",
	'survey:type:longtext:details' => "For a detailed answer : one or more paragraphs.",
	'survey:type:plaintext' => "Long text",
	'survey:type:plaintext:details' => "For a detailed answer : one or more paragraphs.",
	'survey:type:pulldown' => "Choice in a list",
	'survey:type:pulldown:details' => "Lets select one response from a closed list of pre-defined choices. See below for settings ; you may allow an empty option so people are not forced to chosse a response.",
	'survey:type:checkboxes' => "Check boxes",
	'survey:type:checkboxes:details' => "Lets select several responses from a closed list of pre-defined choices.",
	'survey:type:multiselect' => "Multiple selection",
	'survey:type:multiselect:details' => "Lets select several responses from a closed list of pre-defined choices.",
	'survey:type:rating' => "Rating",
	'survey:type:rating:details' => "For a single responses between a closed list of choices. This option is appropriate for notations and ratings, with options ranging from 0 to 5, or using qualitative appreciations. You may also add an empty option.",
	'survey:type:date' => "Date",
	'survey:type:date:details' => "Lets responders select a date in a calendar.",
	// Responses
	'survey:results' => "Survey results",
	'survey:results:question' => "Question",
	'survey:results:user' => "Responder",
	'survey:result:label' => "\"%s\" (%s responses)",
	'survey:results:summary' => "Results summary",
	'survey:results:full' => "Detailed results",
	'survey:results:user_details' => "Show details from this responder",
	'survey:results:user_details:title' => "Detailed responses from this répondant",
	'survey:results:question_details' => "Show responses",
	'survey:results:question_details:title' => "Detailed responses for this question",
	'survey:results:question_details:responses' => "Response(s) by responder",
	'survey:results:question_details:values' => "Number of mentions for each response value",
	'survey:results:questions' => "Questions list",
	'survey:results:users' => "Responders list",
	'survey:results:values' => "Responses list",
	'survey:results:questionscount' => "<strong>%s</strong> questions",
	'survey:results:responderscount' => "<strong>%s</strong> responders",
	'survey:results:stats' => "Survey statistics",
	'survey:results:responsesbyquestion' => "Number of responses by question",
	'survey:results:userdetails' => "Detailed responses from &laquo;&nbsp;%s&nbsp;&raquo;",
	'survey:results:questiondetails' => "Detailed responses for &laquo;&nbsp;%s&nbsp;&raquo;",
	'survey:results:question:counts' => "%s responders on %s have replied to this question (%s%%)",
	'survey:results:responders' => "Responders",
	'survey:results:inputtype' => "Field type",
	'survey:results:nbresponses' => "Nb responses",
	'survey:results:percresponses' => "% responses",
	'survey:results:moredetails' => "More details",
	'survey:results:guid' => "GUID",
	'survey:results:name' => "Responder's name",
	'survey:results:value' => "Response value",
	'survey:results:count' => "Number of mentions",
	
);

add_translation("en",$en);

