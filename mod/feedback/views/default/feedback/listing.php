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

if (elgg_get_context() == 'view') {
	elgg_set_context('feedback');
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb('feedback', elgg_get_site_url() . 'feedback');
}

$about = $vars['entity']->about; if (empty($about)) { $about = "feedback"; }
$status = $vars['entity']->status; if (empty($status)) $status = "open";
$mood = $vars['entity']->mood; if (empty($mood)) $mood = "neutral";
if ($vars['full'] === true) $full = true; else $full = false;

$status_mark = elgg_echo ( "feedback:status:" . $status );
$mood_mark = elgg_echo ( "feedback:mood:" . $mood );
$about_mark = elgg_echo ( "feedback:about:" . $about );
if ($full) $access_mark = elgg_view('output/access', array('entity' => $vars['entity']));


$controls = '';
if ($full) $controls .= $access_mark;
switch ($status) {
	case 'closed':
		// Only admins can reopen feedbacks
		if (elgg_is_admin_logged_in) {
			//$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/reopen?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('feedback:reopenconfirm'), 'class' => 'elgg-icon elgg-icon-redo'));
			$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/reopen?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('feedback:reopenconfirm'), 'text' => '<i class="fa fa-check-square-o"></i>'));
		} else {
			//$controls .= '<span class="elgg-icon elgg-icon-round-checkmark" title="' . $status_mark . '"></span>';
			$controls .= '<i class="fa fa-check-square-o" title="' . $status_mark . '"></i>&nbsp;';
		}
		break;
		
	default:
		// Only admins can close feedbacks
		if (elgg_is_admin_logged_in) {
			//$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/close?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('feedback:closeconfirm'), 'class' => 'elgg-icon elgg-icon-checkmark'));
			$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/close?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('feedback:closeconfirm'), 'text' => '<i class="fa fa-square-o"></i>'));
		}
}
// Only admins can delete feedbacks
if (elgg_is_admin_logged_in) {
	//$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/delete?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('deleteconfirm'), 'class' => 'elgg-icon elgg-icon-trash'));
	$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/delete?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('deleteconfirm'), 'text' => '<i class="fa fa-trash-o"></i>'));
}

$class = 'feedback-mood-' . $vars['entity']->mood . ' feedback-about-' . $vars['entity']->about . ' feedback-status-' . $status;

$page = elgg_echo('feedback:page:unknown');
if (!empty($vars['entity']->page)) {
	$page = $vars['entity']->page;
	$page = "<a href='" . $page . "'>" . $page . "</a>";
}


// Render view
$info .= "<div style='float:left;width:25%'><strong>".elgg_echo('feedback:list:mood').": </strong>" . $mood_mark . "</div>";
$info .= "<div style='float:left;width:40%'><strong>".elgg_echo('feedback:list:about').": </strong>" . $about_mark . "</div>";
$info .= '<div class="controls">' . $controls . "</div>";
$info .= '<div class="clearfloat"></div>';
$info .= "<strong>".elgg_echo('feedback:list:from').": </strong>" . $vars['entity']->id . '<span style="float:right;">' . elgg_view_friendly_time($vars['entity']->time_created) . "</span><br />";
$info .= "<strong>".elgg_echo('feedback:list:page').": </strong>" . $page . "<br />";
$info .= '<br /><blockquote>' . nl2br($vars['entity']->txt) . '</blockquote>';

// Commentaires
$comment = elgg_get_plugin_setting("comment", "feedback");
if (elgg_in_context('admin')) $full = false;
if ($comment == 'yes') {
	$ia = elgg_set_ignore_access(true);
	if (!$full) {
		$num_comments_feedback = $vars['entity']->countComments();
		$info .= '<div class="clearfloat"></div>';
		$info .= '<a href="' . $vars['entity']->getURL() . '">' . elgg_echo('feedback:viewfull') . '</a>';
		$info .= '<a href="javascript:void(0);" onClick="javascript:$(\'#feedback_'.$vars['entity']->getGUID().'\').toggle()" style="float:right;">' . elgg_echo('feedback:commentsreply', array($num_comments_feedback)) . '</a>';
	}
	$info .= '<div id="feedback_' . $vars['entity']->guid . '"';
	if (!$full) $info .= ' style="display:none;"';
	$info .= '>' . elgg_view_comments($vars['entity']) . '</div>';
	elgg_set_ignore_access($ia);
}


// On n'affiche l'icône que si on n'a qqch de joli, inutile pour le moment
//$icon = elgg_view('icon/default', array('entity' => $vars['entity'], 'size' => 'small'));
$icon = elgg_view('icon/default', array('entity' => $vars['entity']->getOwnerEntity(), 'size' => 'small'));
echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info, 'class' => 'submitted-feedback ' . $class));
//echo elgg_view('page/components/image_block', array('body' => $info, 'class' => 'submitted-feedback ' . $class));


// Search listing view
//if (!elgg_in_context('search')) {} else {}


