<?php
global $CONFIG;
$imgurl = $CONFIG->url . 'mod/theme_cocon/graphics/';
$fonturl = $CONFIG->url . 'mod/theme_cocon/fonts/';
?>

/* Add some fonts */
@font-face {
	font-family: 'Montserrat';
	src: url('<?php echo $fonturl; ?>Montserrat/Montserrat-Regular.ttf') format('truetype');
}
@font-face {
	font-family: 'Montserrat';
	font-weight: bold;
	src: url('<?php echo $fonturl; ?>Montserrat/Montserrat-Bold.ttf') format('truetype');
}


/* Interface */
html, body { background: url(<?php echo $imgurl; ?>background.jpg) top left no-repeat; background-size: cover; }
header { background: transparent; }
header h1 { margin-top: 16px; }
header h1:hover { text-decoration:none; }
header nav ul li { width: 30px; height: 30px; background: white; border-radius: 16px; line-height: 30px; text-align: center; }
header nav ul li a { font-size: 18px; color:#2a7d9f; text-shadow:none; }
header nav .fa { margin-right: 0; }
#transverse { box-shadow:none; border-bottom:0; background:white; height:40px; }
#transverse nav ul li a { color:#2a7d9f; font-weight:bold; padding: 12px 10px 9px 10px; font-size: 14px; }
#transverse nav ul li:first-child { border-left:0; }
#transverse nav ul li li { border-right:0; }
/* Search form */
#transverse form { border: 0; }
form input#adf-search-input, form input#adf-search-input:active, form input#adf-search-input:focus { color:#2a7d9f; }
form input#adf-search-submit-button, form input#adf-search-submit-button:active, form input#adf-search-submit-button:focus { background:white; }

/* Footer */
footer.footer-cocon { height: 37px; background:#2c8eb0; }
footer.footer-cocon ul li { margin: 8px 7px 6px 0; }
footer.footer-cocon ul li a { font-size: 14px; font-weight: bold; font-family: Montserrat, sans-serif; }
footer.footer-cocon ul li { background: transparent url("<?php echo $imgurl; ?>puce_footer.png") left 7px no-repeat; }

.elgg-sidebar { background: rgba(255,255,255,0.9); }


/* Boutons @TODO */
.elgg-button {
border: 1px solid white !important;
/* background: transparent !important; */
box-shadow: 0 1px 3px #000 !important;
border-radius: 16px !important;
}

.groups-widget-viewall { border: 1px solid white; border-radius: 16px; display: inline-block; padding: 4px; max-width: 5ex; text-align: center; text-transform: uppercase; font-size: 9px; margin: 3px 3px 0 0; }


/* Accueil */
.anythingSlider { min-height: 300px; }
.elgg-context-dashboard .elgg-main, .elgg-context-dashboard #slider1 { background: transparent; }
.home-box .sidebarBox, .home-box #sidebar-featured-groups { margin: 0 0 30px 0; }
.home-box .sidebarBox h3 a { color:white; font-family:Montserrat, sans-serif; font-size }
.home-box h2 a, .home-box h3 a { color: white; text-decoration:none; }
.home-box.home-activity { background:#bc9a33; }
.home-box.home-wire { background:#e45833; }
.home-box.home-activity {}


/* Boutons */
a.elgg-button { border-width: 2px; border-radius: 12px; }

