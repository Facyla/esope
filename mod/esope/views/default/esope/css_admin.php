<?php
/* CSS backoffice administration (ne s'applique pas au site public) */
?>

/* OVERRIDE SOME ELGG DEFAULT STYLES */
.elgg-form-settings { max-width: none; }

.elgg-page-admin header h2 { display:inline; }
.elgg-page-admin header ul { display:inline; float:right; }
.elgg-page-admin header ul li { marginl-left:6px; }



/* ESOPE THEME ADDITIONS */

/* Border on second level fieldset (1st level is added to every form) */
.elgg-form fieldset fieldset { border:1px solid #999; padding:1ex; margin:2ex 0ex; }
.elgg-form fieldset fieldset legend { padding:0 0.5ex; }

.elgg-color-picker { max-width:45%; }


/* Champs longtext avec éditeur désactivé par défaut */
textarea, .elgg-input-rawtext { width:100%; }

/* Interface admin */
#esope-settings .miniColors-trigger { float: right; height: 3ex; width: 3ex; }
#esope-settings input { max-width:40%; }
#esope-settings label { font-size:90%; }

.ui-accordion-header { padding: 0.2em; border: 1px solid grey; border-radius: 3px; margin: 0.5em 0 0 0; opacity: 0.5; }
.ui-accordion-header.ui-accordion-header-active { margin-bottom: 0; border-radius: 3px 3px 0 0; opacity: 1; }
.ui-accordion-content { padding: 0.2em 0.5em; border: 1px solid grey; border-top: 0; border-radius: 0 0 3px 3px; }

