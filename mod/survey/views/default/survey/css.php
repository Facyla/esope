<?php
/**
 * Elgg Survey plugin
 * @package Elggsurvey
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @Original author John Mellberg
 * website http://www.syslogicinc.com
 * @Modified By Team Webgalli to work with ElggV1.5
 * www.webgalli.com or www.m4medicine.com
 */
?>

/* Edit form */
#survey-edit-form fieldset { border:1px solid; padding:1ex; margin:1ex 0 2ex 0; }
.question-help { font-size: 90%; font-style: italic; }
/*
.survey-input-question { width: 90%; }
*/
.survey-input-question .delete-question { font-size: 100%; padding: 0 1ex 0.5ex 0; color:darkred; }
.survey-input-question .delete-question:hover { font-size: 200%; padding: 0 0.5ex 0.25ex 0; color:red; }

.survey_post h3 { font-size: 150%; margin:0 0 10px 0; padding:0; }
.survey_post h3 a { text-decoration: none; }
.survey_post p { margin: 0 0 5px 0; }

.survey-progress { height: 12px; border: 1px #00B0E4 solid; margin: 5px 0; }
.survey-progress-filled { background-color: #00B0E4; height: 12px; }

.survey_widget-title { margin-bottom: 10px; }

.survey_closing-date-open { color: green; }
.survey_closing-date-closed { color: red; }


/* Edit form */
.survey-sort-highlight { border:1px dashed; background:#FAFAFA; height:50px; }
#survey-questions textarea { height: 60px; }


/* Response form */

.survey_response-label { cursor: pointer; }
.survey_response-label:hover { color: red; }
.survey-question-reply { padding:1ex 0 3ex 0; border-bottom:1px solid #fff; }



/* Results */

/* Members results */
.survey-result { margin: 3ex 0 1ex 0; }
.survey-result h3 { margin-bottom: 0; }
.survey-result q, .survey-result blockquote { background: #e5e7f5; margin: 0px 12px 2px 0px; padding: 1px 3px; }
.survey-result table th, .survey-result table td { padding:0.5ex 1ex; border-bottom:1px solid #CCC; border-right:1px solid #CCC; }
.survey-result table th:first-of-type, .survey-result table td:first-of-type { border-left:1px solid #CCC; vertical-align: middle; }

.survey-result svg {
  min-width: 200px;
  max-width: 100%;
}

/* Detailed results */
#survey-results { padding:3ex 0 1ex 0; }

#survey-results q, #survey-results-questions blockquote { background: #e5e7f5; margin: 0px 12px 2px 0px; padding: 1px 3px 3px 3px; display: inline-block; }
#survey-results table { border:1px solid #999; }
#survey-results table th, #survey-results table td { padding:0.5ex; border-bottom:1px solid #CCC; border-right:1px solid #CCC; }
#survey-results table th:first-of-type, #survey-results table td:first-of-type { border-left:1px solid #CCC; }
#survey-results table th, #survey-results table th:first-of-type { border-color:#999; }
#survey-results table .survey-progress { width: 50%; display: inline-block; margin:0; }


