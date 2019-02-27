<?php
/* CSS communes site, administration et éditeur wysiwyg */

$url = elgg_get_site_url();

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth != 'yes') { $fixedwidth = false; } else { $fixedwidth = true; }

?>


/* ***************************************
 * ESOPE COMMON CSS
 ************************************** */

html { -webkit-font-smoothing: antialiased; }

/* https://css-tricks.com/box-sizing/ */
/* @TODO : use later, as it requires to rewrite most of the menus and main blocks
html {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	-webkit-font-smoothing: antialiased;
}
*, *:before, *:after {
	-webkit-box-sizing: inherit;
	-moz-box-sizing: inherit;
	box-sizing: inherit;
}
*/

/* Word break in image alt text (requires carriage return in source) */
img { white-space: pre-line; }

/* Accordion styles */
.ui-icon.ui-icon-triangle-1-s, .ui-icon.ui-icon-triangle-1-e { float: left; margin-right: 6px; }

/* Class to create a new stacking context for z-index positionning */
.new-stacking-context { position: relative; z-index: 0; }



<?php if (!$fixedwidth) { ?>
/* RESPONSIVE */

@media (max-width:1225px) {
	
}

@media (max-width:980px) {
	
}

@media (max-width:600px) {
	
}
<?php } ?>

