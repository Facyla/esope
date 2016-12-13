<?php
global $CONFIG;
?>

/* Settings */
#uhb_annonces-settings fieldset fieldset { border:1px solid; margin:2ex 0 2ex; padding:1ex; }
#uhb_annonces-settings fieldset legend { padding:0 1ex; }


/* Form hints */
.uhb_profile-label-example { display: inline-block; font-size: .8em; }


/* Formulaire d'édition */
#uhb_annonces-edit-form {}
#uhb_annonces-edit-form #uhb_annonces-edit-form-menu { margin-bottom:1ex; }
#uhb_annonces-edit-form label { font-weight: bold; }
#uhb_annonces-edit-form .elgg-input-checkboxes label, #uhb_annonces-edit-form .radio label { font-weight: normal; }
/*
#uhb_annonces-edit-form #uhb_annonces-edit-form-menu li { width: 22%; display: inline-block; text-align:center; border: 1px solid; opacity:0.8; border-bottom:0; padding:1ex 0; }
#uhb_annonces-edit-form #uhb_annonces-edit-form-menu li a { width: 22%; display: inline-block; text-align:center; border: 1px solid; opacity:0.8; border-bottom:0; padding:1ex 0; }
#uhb_annonces-edit-form #uhb_annonces-edit-form-menu a.active, #uhb_annonces-edit-form #uhb_annonces-edit-form-menu a:hover, #uhb_annonces-edit-form #uhb_annonces-edit-form-menu a:active, #uhb_annonces-edit-form #uhb_annonces-edit-form-menu a:focus { opacity:1; color:black; }
*/

#uhb_annonces-edit-form label span { display:inline-block; min-width:10ex; font-weight: bold; }
#uhb_annonces-edit-form input[type="submit"] { float:right; }
#uhb_annonces-edit-form input:not([type="submit"]) { margin-left:1ex; min-width:6ex; max-width:24ex; font-size:100%; padding: 1px 5px; }
#uhb_annonces-edit-form select { margin-left:1ex; /* max-width:30ex; */ }
#uhb_annonces-edit-form select[name='worktime'] { max-width:20ex; }
#uhb_annonces-edit-form .elgg-input-checkboxes.elgg-horizontal li { width: 48%; display: inline-block; margin: 0; padding: 0; }
#uhb_annonces-edit-form input[type='radio'], #uhb_annonces-edit-form input[type='checkbox'] { min-width:2ex; }
.uhb_annonces-disabled { opacity: 0.5; }
#uhb_annonces-edit-form textarea { height:8ex; }
#uhb_annonces-edit-form textarea[name='offertask'] { height:16ex; }
#uhb_annonces-edit-form input[name='structurepostalcode'] { width:7ex; }
#uhb_annonces-edit-form input[name='structurecity'] { width:18ex; }
#uhb_annonces-edit-form input[name='structuresiret'] { width:16ex; }
#uhb_annonces-edit-form input[name='structurenaf2008'] { width:6ex; }
#uhb_annonces-edit-form input[name='offerreference'] { width:12ex; }
#uhb_annonces-edit-form input[name='managerphone'] { width:20ex; }
#uhb_annonces-edit-form input[name='managername'] { width:30ex; }
#uhb_annonces-edit-form input[name='worklength'] { width:7ex; border-radius: 0; }
#uhb_annonces-edit-form .elgg-input-date { width:11ex; padding: 1px 5px; }
/* Dates : use timestamp + date picker (name AND id)*/
#uhb_annonces-edit-form input[name='followcreation'], #uhb_annonces-edit-form input[name='followvalidation'], #uhb_annonces-edit-form input[name='followend'], #uhb_annonces-edit-form input[name='workstart'], #uhb_annonces-edit-form input[id='followcreation'], #uhb_annonces-edit-form input[id='followvalidation'], #uhb_annonces-edit-form input[id='followend'], #uhb_annonces-edit-form input[id='workstart'] { width:12ex; }

#uhb_annonces-edit-form .uhb_annonces-form-buttons {  }
#uhb_annonces-edit-form .uhb_annonces-form-buttons .elgg-button { margin-left:0em; margin-right:0.5em; }
#uhb_annonces-edit-form .uhb_annonces-form-actions { float:right; }
#uhb_annonces-edit-form .uhb_annonces-form-actions .elgg-button { margin-left:0.5em; margin-right:0em; }

/*
#uhb_annonces-edit-form *[required]:after { content:"*"; color:red; }
#uhb_annonces-edit-form input[required='required']:after { content:"*"; color:red; }
*/
#uhb_annonces-edit-form span.required { color:red; min-width:1ex; padding-left:0.5ex; }


/* Affichage annonces */
/*
.uhb_annonces-view-menu { text-align: right; border-bottom: 1px solid; }
.uhb_annonces-view-menu a { width: 22%; display: inline-block; text-align:center; border: 1px solid; opacity:0.8; border-bottom:0; padding:1ex 0; }
.uhb_annonces-view-menu a.active, .uhb_annonces-view-menu a:hover, .uhb_annonces-view-menu a:active, .uhb_annonces-view-menu a:focus { opacity:1; color:black; }
*/
.uhb_annonces-view-step { padding: 2ex 1ex; }
.uhb_annonces-side-infos { float:right; max-width:40%; border: 1px solid; padding: 0.5ex 1ex; }
.uhb_annonces-side-infos-validated { float:right; margin-left:1ex; font-style:italic; }


/* Sidebar : besoin de comptacter un peu car bcp d'options parfois */
#uhb_annonces-sidebar .elgg-module-aside {  }
#uhb_annonces-sidebar .elgg-head { margin-bottom: 10px; }
#uhb_annonces-sidebar .elgg-head h3 { padding:10px 10px 10px 0; }
#uhb_annonces-sidebar .elgg-body p { padding:0.5em 2em; margin-bottom: 0.5em; }


/* Formulaire de recherche */
#uhb_annonces-search-form fieldset { border:1px solid; margin:2ex 0 2ex; padding:1ex; }
#uhb_annonces-search-form fieldset legend { padding:0 1ex; border:1px solid; }
#uhb_annonces-search-form label { font-weight:bold; font-size:100%; }
#uhb_annonces-search-form .elgg-input-checkboxes label, #uhb_annonces-search-form .radio label { font-weight: normal; }
#uhb_annonces-search-form label span { display:inline-block; min-width:10ex; font-weight:bold; }
#uhb_annonces-search-form input:not([type="submit"]) { margin-left:1ex; min-width:6ex; max-width:20ex; font-size:100%; padding: 1px 5px; }
#uhb_annonces-search-form .elgg-button-cancel { float:right; }
#uhb_annonces-search-form input[type="submit"] { float:right; margin-left: 10px; padding: 3px 6px;}
#uhb_annonces-search-form input[type="radio"], #uhb_annonces-search-form input[type="checkbox"] { min-width:2ex; }
#uhb_annonces-search-form .uhb_annonces-range input { width:6ex; }
#uhb_annonces-search-form select { margin-left:1ex; max-width:25ex; }
#uhb_annonces-search-form input[name='structurepostalcode'] { width:7ex; }
#uhb_annonces-search-form input[name='structurecity'] { width:18ex; }
#uhb_annonces-search-form input[name='structuresiret'] { width:16ex; }
#uhb_annonces-search-form input[name='structurenaf2008'] { width:6ex; }

#uhb_annonces-search-form .elgg-input-date { width:11ex; padding: 1px 5px; }
.ui-datepicker { z-index: 11 !important; }
#uhb_annonces-search-form .slider-range-input { display: inline-flex; width: 30ex; }


/* Résultats de recherche */
#uhb_annonces-search-results { display:block; /* overflow:auto; */ border-bottom:1px solid #B5BFD9; border-bottom: 1px solid transparent; }
#uhb_annonces-search-results tr { border-top:1px solid #B5BFD9; border-right:1px solid #B5BFD9; }
#uhb_annonces-search-results th, #uhb_annonces-search-results td { border-left:1px solid #B5BFD9; padding:2px 4px; min-width: 8ex; max-width: 30ex; }
#uhb_annonces-search-results th { text-align:center; vertical-align: middle; background-color:#B5BFD9; padding-right: 3ex; font-weight:bold; }
#uhb_annonces-search-results th.header.headerSortUp, #uhb_annonces-search-results th.header.headerSortDown { background-color:#2A7185; color:white; }

/* Caractères intéressants pour tris : ↕↑↓ ▲▼► */
/*
#uhb_annonces-search-results th.header.headerSortUp, #uhb_annonces-search-results th.header.headerSortDown { color: white; }
#uhb_annonces-search-results th.header:before { content: "►"; float:right; margin-left:0.5ex; color:white; }
#uhb_annonces-search-results th.header.headerSortUp:before { content: "▲"; float:right; margin-left:0.5ex; }
#uhb_annonces-search-results th.header.headerSortDown:before { content: "▼"; float:right; margin-left:0.5ex; }
*/

.uhb_annonces-result {}
.uhb_annonces-result {  }
.uhb_annonces-result:hover { transition-duration:0.3s; }
.uhb_annonces-result-stage td.uhb_annonces-result-field-typeoffer {}
.uhb_annonces-result-emploi td.uhb_annonces-result-field-typeoffer {}
.uhb_annonces-result-apprentissage td.uhb_annonces-result-field-typeoffer {}
.uhb_annonces-result-professionalisation td.uhb_annonces-result-field-typeoffer {}
/* Pour jouer sur les couleurs de fond selon l'état
.uhb_annonces-result-state-new td.uhb_annonces-result-field-followstate { background:#FEE; }
.uhb_annonces-result-state-confirmed td.uhb_annonces-result-field-followstate { background:#EEF; }
.uhb_annonces-result-state-published td.uhb_annonces-result-field-followstate { background:#FFF; }
.uhb_annonces-result-state-filled td.uhb_annonces-result-field-followstate { background:#EFE; }
.uhb_annonces-result-state-archive td.uhb_annonces-result-field-followstate { background:#EEE; }
*/

.uhb_annonces-result-field-offerposition { font-weight:bold; }

.uhb_annonces-morethanmax {  }

/* Tablesorter blue theme */
<?php $imgsrc = $CONFIG->url . 'mod/uhb_annonces/graphics/'; ?>
/* tables */
table.tablesorter {
	font-family:arial;
	background-color: transparent;
	margin:10px 0pt 15px;
	font-size: 8pt;
	width: 100%;
	text-align: left;
}
table.tablesorter thead tr th, table.tablesorter tfoot tr th {
	background-color: #e6EEEE;
	border: 1px solid #FFF;
	font-size: 8pt;
	padding: 4px;
	border-top: 1px solid #B5BFD9;
}
table.tablesorter thead tr th:last-child, table.tablesorter tfoot tr th:last-child {
	border-right: 1px solid #B5BFD9;
}
table.tablesorter thead tr .header:not(.nosort) {
	background-image: url(<?php echo $imgsrc; ?>bg.gif);
	background-repeat: no-repeat;
	background-position: center right;
	cursor: pointer;
}
table.tablesorter tbody td {
	color: #3D3D3D;
	padding: 4px;
	background-color: #FFF;
	vertical-align: top;
	border-bottom: 1px solid #B5BFD9;
}
table.tablesorter tbody tr.odd td {
	background-color:#F0F0F6;
}
table.tablesorter thead tr .headerSortUp {
	background-image: url(<?php echo $imgsrc; ?>asc.gif);
}
table.tablesorter thead tr .headerSortDown {
	background-image: url(<?php echo $imgsrc; ?>desc.gif);
}
table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
	background-color: #8dbdd8;
}


/* Formulaire de candidature */
.elgg-form-uhb-annonces-candidate input[type="submit"] { float:right; }
.elgg-form-uhb-annonces-candidate fieldset { border:1px solid; margin:2ex 0 2ex; padding:1ex; }
.elgg-form-uhb-annonces-candidate fieldset legend { padding:0 1ex; border:1px solid; }

.uhb_annonces-wait { position: fixed; z-index: 101; background: rgba(0,0,0,0.6); color: white; top: 0; bottom: 0; left: 0; right: 0; text-align: center; font-size: 45px; line-height: 1.5; padding: 5ex 20%; }



