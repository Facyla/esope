<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 *
 * for Elgg 1.8 by iionly
 * iionly@gmx.de
 */

$english = array(
	'feedback' => 'Feedbacks',
	'admin:administer_utilities:feedback' => 'Site Feedback',
	'item:object:feedback' => 'Feedback',
	'feedback:label' => 'Feedback',
	'feedback:title' => 'Feedback',

	'feedback:admin:title' => 'Site Feedback',
	'feedback:widget:description' => 'Display feedback made by site members.',
	'feedback:numbertodisplay' => 'Number of feedback entries to display',

	'feedback:message' => 'Love it? Hate it? Want to suggest new features or report a bug? We would love to hear from you.',

	'feedback:default:id' => 'Name and/or Email',
	'feedback:default:txt' => 'Let us know what you think!',
	'feedback:default:txt:err' => 'No feedback message has been provided.\nWe value your suggestions and criticisms.\nPlease enter your message and press Send.',

	'feedback:captcha:blank' => 'No captcha input provided!',

	'feedback:submit_msg' => 'Submitting...',
	'feedback:submit_err' => 'Could not submit feedback!',

	'feedback:submit:error' => 'Could not submit feedback!',
	'feedback:submit:success' => 'Feedback submitted successfully. Thank you!',

	'feedback:delete:success' => 'Feedback was deleted successfully.',

	'feedback:mood:' => 'None',
	'feedback:mood:angry' => 'Angry',
	'feedback:mood:neutral' => 'Neutral',
	'feedback:mood:happy' => 'Happy',

	'feedback:about:' => 'None',
	'feedback:about:bug_report' => 'Bug Report',
	'feedback:about:content' => 'Content',
	'feedback:about:suggestions' => 'Suggestions',
	'feedback:about:compliment' => 'Compliment',
	'feedback:about:other' => 'Other',

	'feedback:list:mood' => 'Mood',
	'feedback:list:about' => 'About',
	'feedback:list:page' => 'Submit Page',
	'feedback:list:from' => 'From',
	'feedback:list:nofeedback' => "No feedback yet.",
	'feedback:list:noopenfeedback' => "No open feedback at this time.",

	'feedback:user_1' => "User Name 1: ",
	'feedback:user_2' => "User Name 2: ",
	'feedback:user_3' => "User Name 3: ",
	'feedback:user_4' => "User Name 4: ",
	'feedback:user_5' => "User Name 5: ",
	'feedback:settings:public' => "Should logged-out site visitors be allowed to give feedback? ",
	'feedback:settings:usernames' => "You can enter up to 5 users who should receive notifications if new feedback has been given. Enter the usernames in the following: ",

	'feedback:email:subject' => '[Feedback] %s',
	'feedback:email:body' => "%s has made a feedback: \"%s\" 
	
	%s
	
	View online: %s
	",


	// Added by Facyla
	
	'feedback:group' => "Feedbacks",
	'feedback:option:grouptool' => "Leave choice to each group admin(s)",
	'feedback:enablefeedback' => "Enable feedback in this group",
	'feedback:page:unknown' => "Unknown URL",
	'feedback:viewfull' => "Display discussion in a full page",
	'feedback:commentsreply' => "%s comment(s) &nbsp; &raquo;&nbsp;Reply",
	
	// Settings
	'feedback:settings:memberview' => "Are site members allowed to view feedbacks ?",
	'feedback:settings:comment' => "Enable commenting on / replying to feedbacks ?",
	'feedback:settings:feedbackgroup' => "Associate feedbacks to one or multiple groups ?",
	
	// Feedback status
	'feedback:status' => "Feedbacks status",
	'feedback:list:status:open' => "Open",
	'feedback:status:open' => "Open feedbacks",
	'feedback:list:status:closed' => "Closed",
	'feedback:status:closed' => "Closed feedbacks",
	'feedback:closeconfirm' => "A closed feedback is considered as solved, confirm closing feedback ?",
	'feedback:close:success' => "Feedback marked as closed.",
	'feedback:close:error' => "Unable to close this feedback",
	'feedback:reopenconfirm' => "This feedback is marked as closed. Do you want to mark it as active and confirm re-opening ?",
	'feedback:reopen:success' => "Feedback marked as open.",
	'feedback:reopen:error' => "Unable to re-open this feedback",
	
	// Feedbacks menu
	'feedback:menu:total' => "%s feedbacks",
	'feedback:menu:open' => "%s opened",
	'feedback:menu:closed' => "%s closed",
	'feedback:menu:content' => "%s reports",
	'feedback:menu:bug' => "%s bugs",
	'feedback:menu:suggestion' => "%s suggestions",
	'feedback:menu:question' => "%s questions",
	'feedback:menu:compliment' => "%s compliments",
	'feedback:menu:other' => "%s other / unsorted",
	
	// About - feedback types
	'feedback:about' => "of type",
	'feedback:about:question' => "Question",
	'feedback:access:admin' => "Admin only",
	'feedback:access:sitemembers' => "Site members",
	'feedback:access:group' => "Group members",

	'feedback:email:reply:subject' => '[Feedback] %s',
	'feedback:email:reply:body' => "%s has replied on \"%s\" :
	
	%s
	
	View online: %s
	",
	
	'feedback:linktofeedbacks' => "&raquo;&nbsp;View all previous feedbacks",
	
);

add_translation("en", $english);

