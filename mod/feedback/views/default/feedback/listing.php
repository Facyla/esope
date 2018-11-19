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

$url = elgg_get_site_url();

if (elgg_get_context() == 'view') {
	elgg_set_context('feedback');
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb('feedback', $url . 'feedback');
}

$feedback = elgg_extract('entity', $vars);

$about = $feedback->about; if (empty($about)) { $about = "feedback"; }
$status = $feedback->status; if (empty($status)) { $status = "open"; }
$mood = $feedback->mood; if (empty($mood)) { $mood = "neutral"; }
$full = false;
if ($vars['full'] === true) { $full = true; }
if (elgg_in_context('admin')) { $full = false; }

$status_mark = elgg_echo ( "feedback:status:" . $status );
$mood_mark = elgg_echo ( "feedback:mood:" . $mood );
$about_mark = elgg_echo ( "feedback:about:" . $about );
$access_mark = elgg_view('output/access', array('entity' => $feedback, 'hide_text' => !$full));

// Actions
$controls = '';
$controls .= $access_mark;
switch ($status) {
	case 'closed':
		// Only admins can reopen feedbacks
		if (elgg_is_admin_logged_in) {
			//$controls .= elgg_view("output/confirmlink",array('href' => $url . "action/feedback/reopen?guid=" . $feedback->guid, 'confirm' => elgg_echo('feedback:reopenconfirm'), 'class' => 'elgg-icon elgg-icon-redo'));
			$controls .= elgg_view("output/url", array('href' => $url . "action/feedback/reopen?guid=" . $feedback->guid, 'text' => elgg_echo('feedback:reopen'), 'confirm' => elgg_echo('feedback:reopenconfirm'), 'is_action' => true));
		} else {
			//$controls .= '<span class="elgg-icon elgg-icon-round-checkmark" title="' . $status_mark . '"></span>';
			$controls .= '<i class="fa fa-check-square-o" title="' . $status_mark . '"></i>&nbsp;';
		}
		break;
		
	default:
		// Only admins can close feedbacks
		if (elgg_is_admin_logged_in()) {
			//$controls .= elgg_view("output/confirmlink",array('href' => $url . "action/feedback/close?guid=" . $feedback->guid, 'confirm' => elgg_echo('feedback:closeconfirm'), 'class' => 'elgg-icon elgg-icon-checkmark'));
			$controls .= elgg_view("output/url", array('href' => $url . "action/feedback/close?guid=" . $feedback->guid, 'text' => elgg_echo('feedback:close'), 'confirm' => elgg_echo('feedback:closeconfirm'), 'is_action' => true));
		}
}
// Only admins can delete feedbacks
if (elgg_is_admin_logged_in()) {
	//$controls .= elgg_view("output/confirmlink",array('href' => $url . "action/feedback/delete?guid=" . $feedback->guid, 'confirm' => elgg_echo('deleteconfirm'), 'class' => 'elgg-icon elgg-icon-trash'));
	$controls .= elgg_view("output/url", array('href' => $url . "action/feedback/delete?guid=" . $feedback->guid, 'text' => elgg_echo('feedback:delete'), 'confirm' => elgg_echo('deleteconfirm'), 'is_action' => true));
}

// Classes for status-aware styles
$class = 'feedback-mood-' . $feedback->mood . ' feedback-about-' . $feedback->about . ' feedback-status-' . $status;

// Feedback subject URL
$page = elgg_echo('feedback:page:unknown');
if (!empty($feedback->page)) {
	$page = $feedback->page;
	$page = '<a href="' . $page . '" target="_blank">' . $page . '</a>';
}


// Render view
if (feedback_is_about_enabled()) {
	$info .= '<div class="feedback-about"><strong>' . elgg_echo('feedback:list:about') . '&nbsp;:</strong> ' . $about_mark . '</div>';
}
$info .= '<div class="controls">' . $controls . '</div>';
if (feedback_is_mood_enabled()) {
	$info .= '<div class="feedback-mood"><strong>' . elgg_echo('feedback:list:mood') . '&nbsp;:</strong> ' . $mood_mark . '</div>';
}
//$info .= '<div class="clearfloat"></div>';
$info .= '<p style="display:inline-block;">';
$info .= '<strong>' . elgg_echo('feedback:list:from') . '&nbsp;:</strong> ' . $feedback->id . ' ';
//$info .= '<span style="float:right;">' . elgg_view_friendly_time($feedback->time_created) . '</span><br />';
$info .= elgg_view_friendly_time($feedback->time_created) . '<br />';
$info .= '<strong>' . elgg_echo('feedback:list:page') . '&nbsp;:</strong> ' . $page;
$info .= '</p>';
$info .= '<blockquote>' . parse_urls(nl2br($feedback->txt)) . '</blockquote>';

// Commentaires
$comment = elgg_get_plugin_setting("comment", "feedback");
if ($comment == 'yes') {
	$ia = elgg_set_ignore_access(true);
	if (!$full) {
		$num_comments_feedback = $feedback->countComments();
		$info .= '<div class="clearfloat"></div>';
		$info .= '<a href="' . $feedback->getURL() . '">' . elgg_echo('feedback:viewfull') . '</a>';
		$info .= '<a href="javascript:void(0);" onClick="javascript:$(\'#feedback_' . $feedback->guid . '\').toggle()" style="float:right;">' . elgg_echo('feedback:commentsreply', array($num_comments_feedback)) . '</a>';
	}
	$hidden = '';
	if (!$full) { $hidden .= ' hidden'; }
	$info .= '<div id="feedback_' . $feedback->guid . '" class="elgg-feedback-responses ' . $hidden . '">' . elgg_view_comments($feedback) . '</div>';
	elgg_set_ignore_access($ia);
}


// On n'affiche l'icône que si on a qqch de joli, inutile pour le moment
//$icon = elgg_view('icon/default', array('entity' => $feedback, 'size' => 'small'));
$owner = $feedback->getOwnerEntity();
if (elgg_instanceof($owner, 'user')) {
	//$icon = elgg_view('icon/default', array('entity' => $owner, 'size' => 'small'));
	$icon = '<img src="' . $owner->getIconURL(array('size' => 'small')) . '" />';
} else {
	$icon = '<img src="' . $feedback->getIconURL(array('size' => 'small')) . '" />';
}
echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info, 'class' => 'submitted-feedback ' . $class));
//echo elgg_view('page/components/image_block', array('body' => $info, 'class' => 'submitted-feedback ' . $class));


// Search listing view
//if (!elgg_in_context('search')) {} else {}


