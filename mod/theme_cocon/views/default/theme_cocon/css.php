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
header nav ul li a { font-size: 18px; color:#2a7d9f; }
#transverse { box-shadow:none; border-bottom:0; background:white; }
#transverse nav ul li a { color:#2a7d9f; }
footer.footer-cocon { height: 30px; background:#2c8eb0; }
footer ul li { margin: 6px 7px 6px 0; font-size: 14px; font-weight: bold; font-family: Montserrat, sans-serif; }

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

