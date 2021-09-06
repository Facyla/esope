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
	top: calc(100vh - 10rem);
	left: 0px;
	max-width: 100%;
	z-index:9990; /* CKeditor is 9999 in fullscreen */
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
	border-radius: 0 8px 8px 0;;
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
	text-align: left;
	z-index: 11;
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
	-webkit-box-shadow: 0px 0px 3px 1px rgba(255, 255, 255, 0.8);
	-moz-box-shadow: 0px 0px 3px 1px rgba(255, 255, 255, 0.8);
	box-shadow: 0px 0px 3px 1px rgba(255, 255, 255, 0.8);
	padding: 0.5rem 1rem;
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

.feedback-item {
	margin-bottom: 0.5rem;
}

input#feedback_id { width: 100%; }

#feedBackText { padding-top: 0.25rem; }
#feedback_description { padding: 0.25rem; }

#feedBackSend { padding-top: 0.25rem; }

#feedbackError, #feedbackSuccess {
	font-weight: bold;
	color: black;
	padding: 0.25rem 0.5rem 0.125rem 0.5rem;
	margin: 0.25rem 0;
}
#feedbackError {
	background-color: #ff0000;
}
#feedbackSuccess {
	color: black;
	background-color: #00ff00;
	font-weight: bold;
	padding: 2px 4px;
}

#feedBackIntro { padding:2px 4px; font-size: 1rem; }

#feedBackFormInputs { padding:6px; font-size: 1rem;}
.feedbackLabel {}
#feedBackForm label { margin-right: 8px; }
#feedBackForm input[type="radio"] { margin: 0; }

.feedBackText { width:100%; }
.feedbackTextbox { width:100%; height: 5rem; }

#feedbackDisplay { padding-top:6px; font-size: 1rem; }
#feedbackDisplay a { color: black; }

#feedbackClose { padding-top:6px; }

.captcha { padding:6px; }
.captcha-left { float:none; }
.captcha-middle { float:none; }
.captcha-right { float:none; }
.captcha-input-text { width:100px; }

.submitted-feedback { padding:2px; margin-bottom:4px; background: white; }

#feedbackAccess { margin-bottom: 1rem; }

/* Feedbacks mood */
#feedback_mood { margin-bottom: 0.25rem; }
#feedback_mood input { vertical-align: text-bottom; }
.feedback-mood-angry { border:2px solid #A00; }
.feedback-mood-neutral { border:2px solid #666; }
.feedback-mood-happy { border:2px solid #070; }
.angry { color:#A00; }
.neutral { color:#666; }
.happy { color:#070; }

/* Feedbacks about */
#feedback_about { margin-bottom: 0.25rem; }
#feedback_about input { vertical-align: text-bottom; }
.feedback-about-content { border-left:12px solid #A00; }
.feedback-about-bug_report { border-left:12px solid #930; }
.feedback-about-suggestions { border-left:12px solid #066; }
.feedback-about-compliment { border-left:12px solid #070; }
.feedback-about-question { border-left:12px solid #00F; }
.feedback-about-other { border-left:12px solid #666; }
.feedback .content { color:#A00; }
.feedback .bug_report { color:#930; }
.feedback .suggestions { color:#066; }
.feedback .compliment { color:#070; }
.feedback .question { color:#00F; }
.feedback .other { color:#666; }

/* listings and full view */
.feedback-mood { float:left; max-width:25%; margin-right: 1em; }
.feedback-about { float:left; max-width:40%; margin-right: 1em; }

.elgg-feedback-responses { clear: both; }
.elgg-item-object.elgg-item-object-feedback .elgg-feedback-responses .elgg-item { min-height: initial; }
.elgg-item-object.elgg-item-object-feedback .elgg-feedback-responses .elgg-image-block { /* display: block; */ margin: 0; }
.elgg-item-object.elgg-item-object-feedback .elgg-feedback-responses .elgg-image-block .elgg-image { min-height: initial; box-shadow: none; flex: 0 1 auto; background: none; }
.elgg-item-object.elgg-item-object-feedback .elgg-feedback-responses .elgg-image-block .elgg-body { min-height: initial; }


/* Feedbacks status */
.feedback-status-open {  }
.feedback-status-closed { border:1px solid green; border-left:3px solid green; margin-left:20px; opacity:0.8; }

.closed_button { float:right; width: auto; padding: 4px; margin:12px 0 0 8px; -webkit-border-radius: 4px; -moz-border-radius: 4px; background:#FFFFFF; border: 1px solid #999999; font: 12px/100% Arial, Helvetica, sans-serif; font-weight: bold; color: #000000; }


.submitted-feedback {
	margin: 5px 0 0;
	padding: 5px 7px 3px 9px;
	border: 1px solid #666666;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.submitted-feedback .controls { float:right; }
.submitted-feedback .controls > a, .submitted-feedback .controls > span { margin-right: 0.5rem; margin-top:2px; }
.submitted-feedback .elgg-body { overflow: initial; }

.elgg-module-group-feedback { margin-top: 10px; }
.elgg-module-group-feedback .elgg-body { margin: 0; padding: 0; }
.elgg-module-group-feedback .elgg-list { border-top:0;}
.elgg-module-group-feedback .elgg-list li { border-bottom: 0; }

.feedback-side-menu {  }
.feedback-side-menu ul li a {  }



@media (max-width:700px) {
	#feedbackWrapper { position: initial; margin-top: 12px; }
	#feedBackToggler { position: initial; transform: rotate(90deg); margin-left: 70px; transform-origin: bottom right; height: 30px;  }
	#feedBackContentWrapper { background: white; left:0; }
	#feedBackContent { width: auto; max-width: 94%; margin-top: 1rem; }
	
	/* pour changer l'ordre des champs
	#feedBackForm { display: flex; flex-direction: column; }
	#feedBackText { order: -1; }
	*/
	
}


