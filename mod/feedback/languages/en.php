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

// Failsafe translations depending on icon availability
if (elgg_is_active_plugin('fontawesome')) {
	$mood_angry = '<i class="fa fa-frown-o"></i>';
	$mood_neutral = '<i class="fa fa-meh-o"></i>';
	$mood_happy = '<i class="fa fa-smile-o"></i>';
	$close = '<i class="fa fa-square-o"></i>';
	$open = '<i class="fa fa-check-square-o"></i>';
	$delete = '<i class="fa fa-trash"></i>';
} else {
	$mood_angry = ':-(';
	$mood_neutral = ':-|';
	$mood_happy = ':-)';
	$close = 'close';
	$open = 'open';
	$delete = 'delete';
}

return array(
	'feedback' => 'Feedbacks',
	'admin:administer_utilities:feedback' => 'Site Feedback',
	'item:object:feedback' => 'Feedback',
	'feedback:label' => 'Feedback',
	'feedback:title' => 'Feedback',

	'feedback:admin:title' => 'Site Feedback',
	'feedback:widget:description' => 'Display feedback made by site members.',
	'feedback:numbertodisplay' => 'Number of feedback entries to display',

	'feedback:message' => 'Love it? Hate it? Want to suggest new features or report a bug? We would love to hear from you.',
	'feedback:message:adminonly' => "<p><strong>Warning: this is not a discussion tool, please use the forum to discuss with other members!</strong></p>",

	'feedback:default:id' => 'Name and/or Email',
	'feedback:default:txt' => 'Let us know what you think!',
	'feedback:default:txt:err' => 'No feedback message has been provided.\nWe value your suggestions and criticisms.\nPlease enter your message and press Send.',

	'feedback:captcha:blank' => 'No captcha input provided!',

	'feedback:submit_msg' => 'Submitting...',
	'feedback:submit_err' => 'Could not submit feedback!',

	'feedback:submit:error' => 'Could not submit feedback!',
	'feedback:submit:success' => 'Feedback submitted successfully. Thank you!',

	'feedback:delete:success' => 'Feedback was deleted successfully.',

	'feedback:mood:' => '(none)',
	'feedback:mood:undefined' => '(undefined)',
	'feedback:mood:angry' => $mood_angry,
	'feedback:mood:neutral' => $mood_neutral,
	'feedback:mood:happy' => $mood_happy,

	'feedback:about:' => '(undefined)',
	'feedback:about:bug_report' => '<i class="fa fa-exclamation-circle"></i> Bug Report',
	'feedback:about:content' => '<i class="fa fa-exclamation-triangle"></i> Content',
	'feedback:about:suggestions' => '<i class="fa fa-info-circle"></i> Suggestions',
	'feedback:about:compliment' => '<i class="fa fa-thumbs-o-up"></i> Compliment',
	'feedback:about:other' => 'Other ',
	'feedback:about:feedback' => 'Other',
	'feedback:about:undefined' => '(undefined)',

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
	'feedback:email:body' => "New feedback from %1\$s about page %5\$s: \"%2\$s\"
	
	%3\$s
	
	View online: %4\$s
	",


	// Groups
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
	'feedback:settings:enablemood' => "Enable mood in feedbacks",
	'feedback:settings:enableabout' => "Enable feedback categories",
	'feedback:settings:about_values' => "Feedback categories (if enabled)",
	
	// Feedback status
	'feedback:status' => "Feedbacks status",
	'feedback:status:open' => "Open",
	'feedback:status:closed' => "Closed",
	'feedback:status:total' => "",
	'feedback:list:status:open' => "Open",
	'feedback:list:status:closed' => "Closed",
	'feedback:close' => $close,
	'feedback:closeconfirm' => "A closed feedback is considered as solved, confirm closing feedback ?",
	'feedback:close:success' => "Feedback marked as closed.",
	'feedback:close:error' => "Unable to close this feedback",
	'feedback:reopen' => $open,
	'feedback:reopenconfirm' => "This feedback is marked as closed. Do you want to mark it as active and confirm re-opening ?",
	'feedback:reopen:success' => "Feedback marked as open.",
	'feedback:reopen:error' => "Unable to re-open this feedback",
	'feedback:delete' => $delete,
	
	// Feedbacks menu
	'feedback:menu:total' => "%s feedbacks",
	'feedback:menu:total:singular' => "%s feedback",
	'feedback:menu:open' => "%s opened",
	'feedback:menu:open:singular' => "%s opened",
	'feedback:menu:closed' => "%s closed",
	'feedback:menu:closed:singular' => "%s closed",
	'feedback:menu:content' => "%s reports",
	'feedback:menu:content:singular' => "%s report",
	'feedback:menu:bug_report' => "%s bugs",
	'feedback:menu:bug_report:singular' => "%s bug",
	'feedback:menu:suggestions' => "%s suggestions",
	'feedback:menu:suggestions:singular' => "%s suggestion",
	'feedback:menu:question' => "%s questions",
	'feedback:menu:question:singular' => "%s question",
	'feedback:menu:compliment' => "%s compliments",
	'feedback:menu:compliment:singular' => "%s compliment",
	'feedback:menu:other' => "%s other / unsorted",
	'feedback:menu:other:singular' => "%s other / unsorted",
	
	
	// About - feedback types
	//'feedback:about' => "of type",
	'feedback:about' => ":",
	'feedback:about:question' => '<i class="fa fa-question-circle"></i> Question',
	'feedback:access:admin' => "Admin only",
	'feedback:access:sitemembers' => "Site members",
	'feedback:access:group' => "Group members",

	'feedback:email:reply:subject' => '[Feedback] %s',
	'feedback:email:reply:summary' => "%s has replied on \"%s\"",
	'feedback:email:reply:body' => "%s has replied on \"%s\" :
	
	%s
	
	View online: %s
	",
	
	'feedback:linktofeedbacks' => "&raquo;&nbsp;View all previous feedbacks",
	
);

