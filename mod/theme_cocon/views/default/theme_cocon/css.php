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
@font-face {
	font-family: 'MontserratBold';
	src: url('<?php echo $fonturl; ?>Montserrat/Montserrat-Bold.ttf') format('truetype');
}


/* Interface */
html, body { background: url(<?php echo $imgurl; ?>background.jpg) top left no-repeat; background-size: cover; background-attachment:fixed; border-top:0; }
header { background: transparent; border-top:0; height:120px; }
header h1 { margin-top: 17px; }
header h1:hover { text-decoration:none; }
header nav ul li { margin-left:7px; margin-right:0px; }
header nav ul li a { width: 30px; height: 30px; background: white !important; border-radius: 16px; line-height: 30px; text-align: center; font-size: 18px; color:#2a7d9f; text-shadow:none; padding: 0 !important; display: inline-block; }
header nav a .fa { margin-right: 0; }
#user img { border-radius: 14px; width: 28px; padding-top: 1px; }
#transverse { box-shadow:none; border-bottom:0; background:white; height:40px; }
#transverse nav ul li { border-right:0; }
#transverse nav ul li:first-child { border-left:0; }
#transverse nav ul li a { color:#2a7d9f; line-height: 40px; padding: 0 10px; font-size: 17px; }
#transverse nav ul li li a { font-weight:normal; }
/* Search form */
#transverse form { border: 0; }
::-webkit-input-placeholder { color:#2a7d9f; }
:-moz-placeholder { color:#2a7d9f; }
::-moz-placeholder { color:#2a7d9f; }
:-ms-input-placeholder { color:#2a7d9f; }
form input#adf-search-input, form input#adf-search-input:active, form input#adf-search-input:focus { color:#2a7d9f; }
form input#adf-search-submit-button, form input#adf-search-submit-button:active, form input#adf-search-submit-button:focus { background:white !important; border:0 !important; }

/* Footer */
footer.footer-cocon { height: 37px; background:#2a7d9f; }
footer.footer-cocon ul { width:auto; }
footer.footer-cocon ul li { margin: 10px 7px 6px 0; }
footer.footer-cocon ul li:first-child { padding-left:0; }
footer.footer-cocon ul li a { font-size: 14px; font-family: Montserrat, sans-serif; }
footer.footer-cocon ul li { background: transparent url("<?php echo $imgurl; ?>puce_footer.png") left 5px no-repeat; }

.elgg-sidebar { background: rgba(255,255,255,0.9); }


/* Boutons @TODO */
.elgg-button {
border: 1px solid white !important;
/* background: transparent !important; */
box-shadow: 0 1px 3px #000 !important;
border-radius: 16px !important;
}
span.groups-widget-viewall { border: 1px solid white; border-radius: 16px; display: inline-block; padding: 4px; max-width: 5ex; text-align: center; text-transform: uppercase; font-size: 9px; margin: 3px 3px 0 0; }
.elgg-module span.groups-widget-viewall a { font-size: 8px; }

/* Accueil déconnecté */
#adf-loginbox { padding-top:6px; }

/* Accueil */
.elgg-context-dashboard .anythingSlider { min-height: 300px; background: #397188; font-family: Montserrat; }
.elgg-context-dashboard .anythingSlider * { color: white; }
.anythingSlider h3, .anythingSlider p { padding: 12px 0 0 10px; }
.anythingSlider ul ul, .anythingSlider li li { padding-left: 10px; font-size:14px; }
#adf-homepage .anythingSlider li li { /* list-style-type: circle; */ }
.elgg-context-dashboard .anythingControls { position: absolute; bottom: 20px; left: 20px; display: none; }
.elgg-context-dashboard .anythingControls li { width: 40px; border-radius: 20px; border: 1px solid white; height: 40px; text-align: center; line-height: 40px; color: white; }
.elgg-context-dashboard .anythingSlider .arrow span { visibility:initial; }
.elgg-context-dashboard span.arrow { position: absolute; bottom: 20px; width: 40px; border-radius: 20px; border: 1px solid white; height: 40px; text-align: center; line-height: 40px; color: white; z-index: 11; background:rgba(0,0,0,0.5); }
.elgg-context-dashboard span.back { left: 20px; content: "<"; }
.elgg-context-dashboard span.forward { right: 20px; content: ">"; }

.elgg-context-dashboard .elgg-main, .elgg-context-dashboard #slider1 { background: transparent; }
.home-box .sidebarBox, .home-box #sidebar-featured-groups { margin: 0 0 30px 0; }
.home-box h2 a, .home-box h3 a { color: white; text-decoration:none; font-family: Montserrat; font-weight: normal; font-size: 17px; }
.sidebarBox h3 { background: #c5dc1c; min-height: 40px; padding: 12px 4px 0 10px; }
.home-box h2 img { float:left; margin-right:15px; }
/* Activity */
.home-box.home-activity { background:white; }
.home-box.home-activity h2 { padding: 12px 10px; line-height:45px; background:#bc9a33; }
.home-box.home-activity .elgg-river-item { padding: 12px 10px; }
.elgg-context-dashboard .elgg-list-river > li:hover { background-color: transparent; }

/* The Wire */
.home-box.home-wire { background:white; }
.home-box.home-wire h2 { background: #e45833; padding: 12px 0 0 10px; width: 100%; }

/* Widgets */
section .elgg-layout-one-column div.module { border-radius:0; border:0; }
section .elgg-layout-one-column div.module header { border-radius:0; }

/* Boutons */
a.elgg-button { border-width: 2px; border-radius: 12px; }

/* More button */
.elgg-widget-more { line-height: 40px; color: white; background: transparent; }
.elgg-widget-more:before { text-shadow: none; border: 1px solid white; border-radius: 20px; text-align: center; width: 40px; height: 40px; line-height: 40px;
color: white; display: inline-block; margin: 2px 6px; }

/* Users and avatars */
.elgg-avatar-tiny > a > img { border-radius: 10px; border: 1px solid white; }
.elgg-avatar-small > a > img { border-radius: 20px; border: 1px solid white; }

/* Chat */
#groupchat-sitelink { font-size: 20px; height: 24px; border: 0; }


