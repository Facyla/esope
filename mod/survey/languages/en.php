<?php

return array(
	'item:object:survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Surveys",
	
	/**
	 * Menu items and titles
	 */
	'survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Surveys",
	'survey:group_survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Group surveys",
	'survey:group_survey:listing:title' => "%s's surveys",
	'survey:add' => "New Survey",
	'survey:your' => "Your surveys",
	'survey:not_me' => "%s's surveys",
	'survey:friends' => "Friends' surveys",
	'survey:addpost' => "Create a survey",
	'survey:editpost' => "Edit a survey: %s",
	'survey:edit' => "Edit a survey",
	'item:object:survey_choice' => "Survey choices",
	'survey:question' => "Survey question",
	'survey:description' => "Description (optional)",
	'survey:responses' => "Response choices",
	'survey:result:label' => "%s (%s)",
	'survey:show_results' => "Show results",
	'survey:show_survey' => "Show survey",
	'survey:add_choice' => "Add choice",
	'survey:delete_choice' => "Delete this choice",
	'survey:close_date' => "Survey closing date (optional)",
	'survey:voting_ended' => "Voting for this survey ended on %s.",
	'survey:survey_closing_date' => "(Survey closing date: %s)",

	'survey:convert:description' => 'ATTENTION: there were %s existing surveys found that still have the old survey data structure. These surveys won\'t work correctly on this version of the survey plugin.',
	'survey:convert' => 'Update existing surveys now',
	'survey:convert:confirm' => 'The update is irreversible. Are you sure you want to convert the survey data structure?',

	'survey:settings:group:title' => "Allow group surveys?",
	'survey:settings:group_survey_default' => "yes, on by default",
	'survey:settings:group_survey_not_default' => "yes, off by default",
	'survey:settings:group_access:title' => "If group surveys are activated, who gets to create surveys?",
	'survey:settings:group_access:admins' => "group owners and admins only",
	'survey:settings:group_access:members' => "any group member",
	'survey:settings:front_page:title' => "Enable the site's \"Survey of the day\"?",
	'survey:settings:front_page:details' => "Admins can make a single survey at a time the site's \"Survey of the day\"? Widget Manager plugin required for adding the corresponding widget to the index page, or the corresponding view must be integrated into the theme plugin.",
	'survey:settings:allow_close_date:title' => "Allow setting a closing date for surveys?",
	'survey:settings:allow_close_date:details' => "Afterwards the results can still be viewed but voting is no longer permitted.",
	'survey:settings:allow_open_survey:title' => "Allow open surveys?",
	'survey:settings:allow_open_survey:details' => "Open surveys show which user responded for which survey choice; if this option is enabled, admins can see who responded what on any surveys.",
	'survey:none' => "No survey found.",
	'survey:not_found' => "The survey was not found.",
	'survey:permission_error' => "You do not have permission to edit this survey.",
	'survey:respond' => "Respond",
	'survey:login' => "Please login if you would like to respond to this survey.",
	'group:survey:empty' => "No survey",
	'survey:settings:site_access:title' => "Who can create site-wide surveys?",
	'survey:settings:site_access:admins' => "admins only",
	'survey:settings:site_access:all' => "any logged-in user",
	'survey:can_not_create' => "You do not have permission to create surveys.",
	'survey:front_page_label' => "Make this survey the site's new \"Survey of the day\"",
	'survey:open_survey_label' => "Show in results which members responded for which choice (open survey)",
	'survey:show_responders' => "Show responders",

	/**
	 * Survey widget
	 **/
	'survey:latest_widget_title' => "Latest community surveys",
	'survey:latest_widget_description' => "Displays the most recent surveys.",
	'survey:latestgroup_widget_title' => "Latest group surveys",
	'survey:latestgroup_widget_description' => "Displays the most recent group surveys.",
	'survey:my_widget_title' => "My surveys",
	'survey:my_widget_description' => "This widget will display your surveys.",
	'survey:widget:label:displaynum' => "How many surveys do you want to display?",
	'survey:individual' => "Survey of the day",
	'survey_individual:widget:description' => "Display the site's current \"Survey of the day\".",
	'survey:widget:no_survey' => "There are no surveys of %s yet.",
	'survey:widget:nonefound' => "No surveys found.",
	'survey:widget:think' => "Let %s know what you think!",
	'survey:enable_survey' => "Enable surveys",
	'survey:noun_response' => "response",
	'survey:noun_responses' => "responses",
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
	'survey:new' => 'A new survey',
	'survey:notify:summary' => 'New survey called %s',
	'survey:notify:subject' => 'New survey: %s',
	'survey:notify:body' =>
'
%s created a new survey:

%s

View and respond to the survey:
%s
',

	/**
	 * Survey river
	 **/
	'survey:settings:create_in_river:title' => "Show survey creation in activity river?",
	'survey:settings:response_in_river:title' => "Show survey response in activity river?",
	'survey:settings:send_notification:title' => "Send notification when a survey is created?",
	'survey:settings:send_notification:details' => "Members will only receive notifications if their are friend with the creator of the survey or a member of the group the survey was added to. Additionally, notifications will only be sent to members who configured Elgg's notification settings accordingly.",
	'river:create:object:survey' => '%s created a survey %s',
	'river:response:object:survey' => '%s responded on the survey %s',
	'river:comment:object:survey' => '%s commented on the survey %s',
	'survey:settings:notifications' => "Notifications",
	'survey:settings:access' => "Survey edition rights",
	'survey:settings:options' => "Survey options",

	/**
	 * Status messages
	 */
	'survey:added' => "Your survey was created.",
	'survey:edited' => "Your survey was saved.",
	'survey:responded' => "Thank you for responding, your response was recorded.",
	'survey:deleted' => "Your survey was successfully deleted.",
	'survey:totalresponses' => "Total number of responses: %s",
	'survey:responded' => "Your response has been cast for this survey. Thank you for voting on this survey.",

	/**
	 * Error messages
	 */
	'survey:blank' => "Sorry: you need to fill in both the question and add at least one response choice before you can create the survey.",
	'survey:noresponse' => "Sorry: you need to choose an option to respond in this survey.",
	'survey:alreadyresponded' => "You have responded to this survey.",
	'survey:notfound' => "Sorry: we could not find the specified survey.",
	'survey:notdeleted' => "Sorry: we could not delete this survey.",
	
	
	
	// ESOPE : New survey strings
	'survey:questions' => "Questions",
	'survey:add_question' => "Add a question",
	'survey:delete_question' => "Remove this question",
	'survey:title' => "Survey title",
	'survey:option:yes' => "yes",
	'survey:option:no' => "no",
	// Question fields
	'survey:question:title' => "Question title",
	'survey:question:title:placeholder' => "Title of the question",
	'survey:question:description' => "Help or details on this question (optional)",
	'survey:question:description:placeholder' => "This paragraph lets you provide additional information, or tips on how to answer the question.",
	'survey:question:input_type' => "Question type",
	'survey:question:options' => "Options",
	'survey:question:options:placeholder' => "One option per line \nOption 1 \nOption 2 \nOption 3 \netc.",
	'survey:question:empty_value' => "Add an empty option",
	'survey:question:required' => "Mandatory",
	'survey:question:toggle' => "<i class=\"fa fa-toggle-down\"></i> Show/hide",
	'survey:question:toggle:details' => "<i class=\"fa fa-eye-slash\"></i> Show/hide question options",
	// Input types
	'survey:type:text' => "Short text",
	'survey:type:text:details' => "For a very quick answer : one to a few words.",
	'survey:type:longtext' => "Long text",
	'survey:type:longtext:details' => "For a detailed answer : one or more paragraphs.",
	'survey:type:plaintext' => "Long text",
	'survey:type:plaintext:details' => "For a detailed answer : one or more paragraphs.",
	'survey:type:pulldown' => "Choice in a list",
	'survey:type:pulldown:details' => "Lets select one response from a closed list of pre-defined choices. See below for settings ; you may allow an empty option so people are not forced to choose a response.",
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
	'survey:results:export' => "Data export",
	'survey:result:label' => "\"%s\" (%s responses)",
	'survey:results:summary' => "Results summary",
	'survey:results:full' => "Detailed results",
	'survey:results:user_details' => "Show details for this responder",
	'survey:results:user_details:title' => "Detailed responses from this responder",
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
	'survey:results:nbresponses' => "Number of responses",
	'survey:results:percresponses' => "% responses",
	'survey:results:moredetails' => "More details",
	'survey:results:guid' => "GUID",
	'survey:results:name' => "Responder's name",
	'survey:results:value' => "Response value",
	'survey:results:count' => "Number of mentions",
	
	
	'survey:results:numquestions' => "Number of questions",
	'survey:results:numresponders' => "Number of responders",
	'survey:results:created' => "Creation date",
	'survey:results:updated' => "Latest update",
	'survey:results:featured' => "Featured survey",
	'survey:results:open' => "Survey state",
	'survey:results:closing' => "Closing date",
	'survey:results:access' => "Access",
	'survey:comments_on' => "Enable comments",
	'survey:question:comment_on' => "Comments",
	'survey:question:display_order' => "Display order",
	'survey:question:guid' => "GUID",
	'survey:response:notrequired' => "Optional question",
	'survey:response:required' => "Mandatory question",
	'survey:results:yourresponse' => "Your response",
	'survey:questions:reorder' => "<i class=\"fa fa-info-circle\"></i> You may reorder the questions by drag'n'dropping them on the page.",
	'survey:settings:show_active_only' => "Hide group surveys module if none active",
	
	'survey:results:export' => "Export the survey results",
	'survey:settings:results_export' => "Enable survey results CSV export",
	
	'survey:state:open' => "Open survey",
	'survey:state:closed' => "Survey is closed",
	
	
);

