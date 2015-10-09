<?php
/* CSS communes site et backoffice administration */

$url = elgg_get_site_url();
$urlfonts = $url . 'mod/esope/fonts/';
$urlicon = $url . 'mod/esope/img/theme/';

// Configurable elements and default values

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth != 'yes') $fixedwidth = false; else $fixedwidth = true;

// Image de fond configurable
$headbackground = elgg_get_plugin_setting('headbackground', 'esope');
if (empty($headbackground)) { $headbackground = $url . 'mod/esope/img/headimg.jpg'; }
/* Toutes les couleurs de l'interface
#000000 // noir
#2a2a2a // gris quasi-noir
#333333 // gris très sombre
#4c4c4c // gris sombre
#666666 // gris moyen sombre
#888888 // gris moyen
#999999 // gris moyen
#b0b0b0 // gris moyen clair
#cccccc // gris clair
#dedede // gris très clair
#f6f6f6 // gris très pâle
#f9f9f9 // gris quasi-blanc

#e5e3e1 // gris légèrement violet
#ebf5ff // bleu très pâle
#f2f1ef // gris très pâle légèrement violet
#f2f1f0 // gris très pâle légèrement rouge

#ffffff // blanc

#002e3e // bleu marine (tire sur le vert)
#002e6e // bleu marine
#0050bf // bleu roi
#0066cc // bleu clair
#c61b15 // rouge vif
*/

// Couleur des titres : #0A2C83
$titlecolor = elgg_get_plugin_setting('titlecolor', 'esope');
// Couleur du texte : #333333
$textcolor = elgg_get_plugin_setting('textcolor', 'esope');
// Couleur des liens : #002e6e
$linkcolor = elgg_get_plugin_setting('linkcolor', 'esope');
// #0A2C83 - lien actif/au survol
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'esope');

// Dégradés
// Couleur 1 : #0050BF - haut du dégradé header et pied de page
$color1 = elgg_get_plugin_setting('color1', 'esope');
// Couleur 4 : #002E6E - bas du dégradé header et pied de page
$color4 = elgg_get_plugin_setting('color4', 'esope');
// Couleur 2 : #F75C5C - haut du dégradé des modules
$color2 = elgg_get_plugin_setting('color2', 'esope');
// Couleur 3 : #C61B15 - bas du dégradé des modules
$color3 = elgg_get_plugin_setting('color3', 'esope');

// Boutons
$color5 = elgg_get_plugin_setting('color5', 'esope'); // #014FBC
$color6 = elgg_get_plugin_setting('color6', 'esope'); // #033074
$color7 = elgg_get_plugin_setting('color7', 'esope'); // #FF0000
$color8 = elgg_get_plugin_setting('color8', 'esope'); // #990000

// Non configurable : éléments bas niveaux de l'interface : fonds et bordures (les gris clairs et foncés)
$color9 = elgg_get_plugin_setting('color9', 'esope'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'esope'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'esope'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'esope'); // #DEDEDE
// Couleur de fond du sous-menu
$color13 = elgg_get_plugin_setting('color13', 'esope'); // #DEDEDE
$color14 = elgg_get_plugin_setting('color14', 'esope'); // Titre modules
$color15 = elgg_get_plugin_setting('color15', 'esope'); // Titre boutons

// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'esope');

$font1 = elgg_get_plugin_setting('font1', 'esope');
$font2 = elgg_get_plugin_setting('font2', 'esope');
$font3 = elgg_get_plugin_setting('font3', 'esope');
$font4 = elgg_get_plugin_setting('font4', 'esope'); // Main font
$font5 = elgg_get_plugin_setting('font5', 'esope');
$font6 = elgg_get_plugin_setting('font6', 'esope');
?>

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

/* Accordion styles */
.ui-icon.ui-icon-triangle-1-s, .ui-icon.ui-icon-triangle-1-e { float: left; margin-right: 6px; }



<?php if (!$fixedwidth) { ?>
/* SECTION RESPONSIVE DESIGN */


@media (max-width:1225px) {
	
}

@media (max-width:980px) {
	
}

/*
@media (max-width:600px) {
	
}
*/
<?php } 
