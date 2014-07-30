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
?>

#feedbackWrapper {
	position: fixed;
	top: 150px;
	left: 0px;
	max-width: 100%;
	z-index:9999;
}

#feedBackToggler {
	float: left;
	z-index: 10;
	position: fixed;
}

#feedBackTogglerLink {
	float:left; 
	position:relative; 
	background: #eee;
	border: 1px outset;
	border-radius: 0 3px 3px 0;
	border-left: 0;
	box-shadow: 0 0 3px 0 white;
}

#feedBackContentWrapper {
	display: none;
	position: fixed;
	top: 0;
	bottom: 0;
	width: 100%;
	background-color: rgba(0,0,0,0.8);
}

#feedBackContent {
	width: 500px;
	min-width: 50%;
	max-width: 80%;
	overflow: hidden;
	margin-left:auto;
	margin-right:auto;
	color: black;
	margin-top: 5ex;
	background-color: white;
	/* Use default elgg module styles instead
	border: solid #fff 2px;
	*/
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	-webkit-box-shadow: 0px 0px 10px 3px rgba(255, 255, 255, 0.8);
	-moz-box-shadow: 0px 0px 10px 3px rgba(255, 255, 255, 0.8);
	box-shadow: 0px 0px 10px 3px rgba(255, 255, 255, 0.8);
	padding:0 0 6px 0;
}

#feedBackContent h1 {
	padding-top:6px;
	padding-left:6px;
	padding-bottom:6px;
	color: white;
	background-color: #4690D6;
	font-style: italic;
	font-family: Georgia, times, serif;
	text-shadow: 1px 2px 4px #333;
	text-decoration: none;
}

#feedBackText { padding-top:5px; }

#feedBackSend { padding-top:6px; }

#feedbackError {
	font-style: bold;
	color: black;
	background-color: #ff0000;
}

#feedbackSuccess {
	color: black;
	background-color: #00ff00;
	font-weight: bold;
	padding: 2px 4px;
}

#feedBackIntro { padding:2px 4px; font-size:13px; }

#feedBackFormInputs { padding:6px; font-size: 12px;}
.feedbackLabel {}
#feedBackForm label { margin-right: 8px; }
#feedBackForm input[type="radio"] { margin: 0; }

.feedBackText { width:100%; }
.feedbackTextbox { width:100%; height:75px; }

#feedbackDisplay { padding-top:6px; font-size:12px; }

#feedbackClose { padding-top:6px; }

.captcha { padding:6px; }
.captcha-left { float:none; }
.captcha-middle { float:none; }
.captcha-right { float:none; }
.captcha-input-text { width:100px; }

.submitted-feedback { padding:2px; margin-bottom:4px; }

/* Feedbacks mood */
.feedback-mood-angry { border:2px solid #A00; }
.feedback-mood-neutral { border:2px solid #666; }
.feedback-mood-happy { border:2px solid #070; }
.angry { color:#A00; }
.neutral { color:#666; }
.happy { color:#070; }

/* Feedbacks about */
.feedback-about-content { border-left:12px solid #A00; }
.feedback-about-bug_report { border-left:12px solid #930; }
.feedback-about-suggestions { border-left:12px solid #066; }
.feedback-about-compliment { border-left:12px solid #070; }
.feedback-about-question { border-left:12px solid #00F; }
.feedback-about-other { border-left:12px solid #666; }
.content { color:#A00; }
.bug_report { color:#930; }
.suggestions { color:#066; }
.compliment { color:#070; }
.question { color:#00F; }
.other { color:#666; }

/* Feedbacks status */
.feedback-status-open {  }
.feedback-status-closed { border:1px solid green; border-left:3px solid green; margin-left:20px; opacity:0.8; }

.closed_button { float:right; width: auto; padding: 4px; margin:12px 0 0 8px; -webkit-border-radius: 4px; -moz-border-radius: 4px; background:#FFFFFF; border: 1px solid #999999; font: 12px/100% Arial, Helvetica, sans-serif; font-weight: bold; color: #000000; }

.submitted-feedback .controls { float:right; }
.submitted-feedback .controls a { margin-right:8px; margin-top:2px; }

.elgg-module-group-feedback { margin-top: 10px; }
.elgg-module-group-feedback .elgg-body { margin: 0; padding: 0; }
.elgg-module-group-feedback .elgg-list { border-top:0;}
.elgg-module-group-feedback .elgg-list li { border-bottom: 0; }



