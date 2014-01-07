<?php
global $CONFIG;
$urlicon = $CONFIG->url . 'mod/dossierdepreuve/graphics/';
$activecolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
$defaultcolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
$inactivecolor = '#CCC';
?>

/* Autopositionnement : pour avoir un radio par ligne */
#autopositionnement .elgg-vertical label { float: left; clear: left; }


/* Rendu des dossiers de preuve */
.dossierdepreuve_title { max-width:520px; float:left; }
.dossierdepreuve-identitybox { max-width:180px; float:right; text-align:right; font-size:12px; font-weight:bold; }
.dossierdepreuve-list { padding:2px 6px 6px 6px; margin-bottom:12px; border-bottom:1px dotted #CCC; }


/* Autopositionnement */
#autopositionnement_quest_tabs { width:100%; margin:2px auto 0 auto; padding:0; }
#autopositionnement_quest_tabs div { float:left; padding:0; text-align:center; font-weight:bold; text-shadow:1px 1px 1px #000; color:#FFF; background:<?php echo $defaultcolor ?>; }
#autopositionnement_quest_tabs div.elgg-state-selected, #autopositionnement_quest_tabs div:hover, #autopositionnement_quest_tabs div:focus, #autopositionnement_quest_tabs div:focus { background:<?php echo $activecolor ?>; }
#autopositionnement_quest_tabs div.inactive { background:<?php echo $inactivecolor ?>; padding: 6px 0; }
#autopositionnement_quest_tabs div a { color:white; padding-top:6px; padding-bottom:6px; display:block; }
#autopositionnement_quest_tabs div a:hover, #autopositionnement_quest_tabs div a:active, #autopositionnement_quest_tabs div a:focus { text-decoration:none; }
#autopositionnement_quest_tab_content_wrapper { border:3px solid <?php echo $activecolor ?>; padding:3px 6px; }

.dossierdepreuve-question { width:80%; }
.dossierdepreuve-answer { width: 12%; float: right; min-width: 100px; }

/* Styles des boutons radio, si on veut... */
/*
input[type="checkbox"].question-0, input[type="radio"].question-0 { width: 16px; height: 16px; display: inline-block; content: url('<?php echo $urlicon; ?>smiley_ko_16nb.png); }
input[type="checkbox"].question-0:checked, input[type="radio"].question-0:checked { content: url('<?php echo $urlicon; ?>smiley_ko_16.png); }
input[type="checkbox"].question-50, input[type="radio"].question-50 { width: 16px; height: 16px; display: inline-block; content: url('<?php echo $urlicon; ?>smiley_medium_16nb.png); }
input[type="checkbox"].question-50:checked, input[type="radio"].question-50:checked { content: url('<?php echo $urlicon; ?>smiley_medium_16.png); }
input[type="checkbox"].question-100, input[type="radio"].question-100 { width: 16px; height: 16px; display: inline-block; content: url('<?php echo $urlicon; ?>smiley_ok_16nb.png); }
input[type="checkbox"].question-100:checked, input[type="radio"].question-100:checked { content: url('<?php echo $urlicon; ?>smiley_ok_16.png); }
*/
.autopositionnement-question-0 { width:16px; height:16px; display:inline-block; margin: 0 2px; background-image: url('<?php echo $urlicon; ?>smiley_ko_16.png); }
.autopositionnement-question-50 { width:16px; height:16px; display:inline-block; margin: 0 2px; background-image: url('<?php echo $urlicon; ?>smiley_medium_16.png); }
.autopositionnement-question-100 { width:16px; height:16px; display:inline-block; margin: 0 2px; background-image: url('<?php echo $urlicon; ?>smiley_ok_16.png); }

.dossierdepreuve-submit { text-align:center; }
.dossierdepreuve-submit input { font-size:20px; }

/* Icône dossierdepreuve */
.elgg-menu-item-dossierdepreuve a { padding-left:32px; background: url("<?php echo $urlicon; ?>dossierdepreuve.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-dossierdepreuve a:hover, .elgg-menu-item-dossierdepreuve a:focus, .elgg-menu-item-dossierdepreuve a:active { background: url("<?php echo $urlicon; ?>dossierdepreuve.png") no-repeat scroll 9px -19px <?php echo $activecolor; ?> !important; }

/* Validation question */
.dossierdepreuve-question { /* color:green; */ background: url('<?php echo $CONFIG->url; ?>mod/dossierdepreuve/graphics/check-ok16-green.png') left top no-repeat; padding: 0 0 0 22px; }
.dossierdepreuve-question.nodata { /* color:red; background: url('<?php echo $CONFIG->url; ?>mod/dossierdepreuve/graphics/point-interrogation-16.png') left top no-repeat; */ }

/* Validation compétence */
.dossierdepreuve-competence { /* color:green; */ background: url('<?php echo $CONFIG->url; ?>mod/dossierdepreuve/graphics/check-ok24-green.png') left top no-repeat; padding: 4px 0 0 28px; }
.dossierdepreuve-competence.nodata { /* color:red; background: url('<?php echo $CONFIG->url; ?>mod/dossierdepreuve/graphics/point-interrogation-24.png') left top no-repeat; */ }

/* Validation domaine */
.dossierdepreuve-domaine { /* color:green; */ background: url('<?php echo $CONFIG->url; ?>mod/dossierdepreuve/graphics/check-ok32-green.png') left top no-repeat; padding: 0px 0 0 36px; width:32px; }
.dossierdepreuve-domaine.nodata { /* color:red; background: url('<?php echo $CONFIG->url; ?>mod/dossierdepreuve/graphics/point-interrogation-32') left top no-repeat; */ }



