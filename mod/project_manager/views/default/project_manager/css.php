<?php global $CONFIG; ?>
/* Avoids debug tool bug (first declaration skipped) */
.void {}


/* Generic content boxes */

.infobox_encart {
	padding:6px 12px;
	box-shadow: 0 1px 3px #333333 inset;
	-o-box-shadow: 0 1px 3px #333333 inset;
	-moz-box-shadow: 0 1px 3px #333333 inset;
	-webkit-box-shadow: 0 1px 3px #333333 inset;
}
.infobox_info {
	padding:6px 12px;
	box-shadow: 0 1px 3px #333333;
	-o-box-shadow: 0 1px 3px #333333;
	-moz-box-shadow: 0 1px 3px #333333;
	-webkit-box-shadow: 0 1px 3px #333333;
}
.infobox_quote {
	padding:6px 12px;
	box-shadow: 10px 10px 5px #999999;
	-o-box-shadow: 10px 10px 5px #999999;
	-moz-box-shadow: 10px 10px 5px #999999;
	-webkit-box-shadow: 10px 10px 5px #999999;
}



/* Inputs and tables */

.elgg-input-text, .elgg-input-plaintext, .elgg-input-tags, .elgg-input-dropdown, .elgg-input-date, .elgg-input-percentage { background-color: #FFFF99; }

.elgg-main table.project_manager .result { font-weight:bold; background-color: #99DDFF; margin-right:1ex; }
.elgg-main table.project_manager .inner-result { background-color: #99DDFF; margin-right:1ex; }
.elgg-main table.project_manager .reference_data { text-align:center; background-color: #CCDDFF; }

.elgg-main table.project_manager tr, .elgg-main table.project_manager th, .elgg-main table.project_manager td { padding:1px 2px; }
.elgg-main table.project_manager tr {border: 1px solid #999999; }
.elgg-main table.project_manager th { border: 1px solid #999999; text-align: center; font-size: 13px; padding: 6px 2px; }
.elgg-main table.project_manager th[scope="col"] { background-color: #666666; color: white; font-size:11px; padding:3px 2px; }
.elgg-main table.project_manager th[scope="col"] a { color: white; }
.elgg-main table.project_manager th[scope=colgroup] { padding: 6px 2px; border: 1px solid #999999; font-size: 16px; text-align: center; }
.elgg-main table.project_manager th[scope=rowgroup] { padding: 6px 2px; border: 1px solid #999999; font-size: 14px; text-align: center; vertical-align:center; }

.elgg-main table.project_manager td { background-color:#EEEEFF; border:1px solid #999999; text-align:right; font-size: 11px; }
.elgg-main table.project_manager td[scope] { background-color: #CCCCCC; text-align: left; }



/* Overlay and loading animations */

#loading_overlay {
	background-color: transparent;
	position: fixed; top: 0; right: 0; bottom: 0; left: 0;
	padding:100px;
	overflow:hidden;
	z-index: 105;
}
#loading_fader {
	background: url("<?php echo $CONFIG->url; ?>mod/project_manager/graphics/ajax_loaders/barre_stries.gif") no-repeat scroll 50% 50% #FFF;
	width:250px; height:100px; margin:auto auto; border:2px solid #000;
	text-align: center; font-weight:bold; color:darkred;
	-webkit-border-radius: 12px; -moz-border-radius: 12px; border-radius: 12px;
}



/* Project manager CSS */
.project_managertype_prospect { border-left:12px solid blue; }
.project_managertype_unsigned { border-left:12px solid red; }
.project_managertype_current { border-left:12px solid green; }
.project_managertype_rejected { border-left:12px solid grey; }
.project_managertype_closed { border-left:12px solid black; }

/* Production CSS */
.project_manager_validated { color:darkgreen; }
.project_manager_notvalidated { color:darkred; }
.project_manager_nodata { color:grey; }
.elgg-main table.project_manager td.project_manager_validated { background-color: #CCFFCC; }
.elgg-main table.project_manager td.project_manager_notvalidated { background-color: #FFCCCC; }
.elgg-main table.project_manager td.project_manager_nodata { background-color: #DEDEDE; }


/* Time tracker CSS */
.time_tracker_input_comment { width:100% !important; height:24px !important; }

/* Déploiment boîte de saisie au focus et active, mais pas hover sinon flickering */
.time_tracker_input_comment, .time_tracker_input_notes {
	overflow:hidden;
	font-size:10px;
	width:100%;
}
textarea.time_tracker_input_comment:active, textarea.time_tracker_input_comment:focus {
	width: 300px !important;
	height: 200px !important;
	max-width: none !important;
	position:relative;
	overflow:auto;
	padding:0;
	z-index: 1001 !important;
}
.time_tracker_input_notes:active, .time_tracker_input_notes:focus {
	width: 300px !important;
	height: 200px !important;
	max-width: none !important;
	position:relative;
	overflow:auto;
	padding:0;
	z-index: 1001 !important;
}
.time_tracker_validation_status span { font-size:10px; font-weight:bold; }
input.elgg-input-text { background-color:#FFFF99; color:#000; }
input.time_tracker_notworkable { background-color:#DEDEDE; }
input.time_tracker_conge { background-color:#AAAAAA; }

.time_tracker_day_cell input { padding: 3px 1px; }
input.time_tracker_today { border: 2px solid black; padding: 1px; }
div.time_tracker_today, .time_tracker_today input { background-color: black !important; color: white; }

.time_tracker_month_form { padding:2px 1px 6px 1px; margin:0; }
.time_tracker_month_form.time_tracker_project { background-color:#EEFFEE; }
.time_tracker_month_form.time_tracker_other { background-color:#EEEEFF; }
.time_tracker_month_form.time_tracker_special { background-color:#FFA500; }
.time_tracker_month_form.time_tracker_notes { background-color:#FFFFFF; }
.time_tracker_project_newform { border-left:0; margin:0; padding:0; }
.time_tracker_project_form { border:1px solid #000; border-left:0; margin:0; padding:0; float:left; width:32px; }
.time_tracker_project_form_notes { border:1px solid #000; border-left:0; margin:0; padding:0; float:left; width:200px; font-size:11px; }
.time_tracker_remove_project { font-size:10px; height:20px;}
.time_tracker_day_cell { border-top:1px solid #000; height:24px; margin:0; padding:0; }


.elgg-input-dropdown[name="project_guid"] { max-width: 30ex; margin-right:3ex; }
#time_tracker_month_form label { font-size:10px; }

.time_tracker_datenav { font-weight:bold; padding: 3px 6px; margin: 0px 0.5ex; background: #eee; border-radius: 5px; border: 1px solid #ccc; color:#666; }

.time_tracker_innercontainer { width:954px; /* border-right: 5px dotted #CCC; */ overflow-x: auto; }

/* Time tracker headers */
.time-tracker-header { max-width:6ex; height:15ex; font-size:10px; }
.time-tracker-header span, .time-tracker-header a { text-align: right; display: inline-block; height: 32px; width: 15ex; margin: 15ex 0 0; transform: rotate(-90deg); transform-origin: left top 0; overflow:hidden; }


