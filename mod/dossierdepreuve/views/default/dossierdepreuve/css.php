<?php
$urlicon = elgg_get_plugin_setting('urlicon', 'adf_public_platform');
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
#autopositionnement_quest_tabs div { float:left; padding:6px 0; text-align:center; font-weight:bold; text-shadow:1px 1px 1px #000; color:#FFF; background:<?php echo $defaultcolor ?>; }
#autopositionnement_quest_tabs div.elgg-state-selected { background:<?php echo $activecolor ?>; }
#autopositionnement_quest_tabs div.inactive { background:<?php echo $inactivecolor ?>; }
#autopositionnement_quest_tabs div a { color:white; }
#autopositionnement_quest_tab_content_wrapper { border:3px solid <?php echo $activecolor ?>; padding:3px 6px; }

.dossierdepreuve-submit { text-align:center; }
.dossierdepreuve-submit input { font-size:20px; }

/* Icône dossierdepreuve - on utilise l'icône "folder" classique */
.elgg-menu-item-dossierdepreuve a { padding-left:32px; background: url("<?php echo $urlicon; ?>folder.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-dossierdepreuve a:hover, .elgg-menu-item-dossierdepreuve a:focus, .elgg-menu-item-dossierdepreuve a:active { background: url("<?php echo $urlicon; ?>folder.png") no-repeat scroll 9px -19px <?php echo $activecolor; ?> !important; }


