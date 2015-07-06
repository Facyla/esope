<?php
$url = elgg_get_site_url();
$imgurl = $url . 'mod/theme_transitions2/graphics/';
?>


/* Generic styles */
a { color: #223300; }
img { max-width: 100%; }

/* Header */
.elgg-page-header { background: url(<?php echo $imgurl; ?>flickr/miuenski_miuenski_2311617707_33a63b3928_o.jpg) #223300 50% 50% no-repeat; background-size:cover; height:200px; }
.elgg-page-header h1 img { max-width:100%; }

/* Menu */
.elgg-page-navbar { background: #223300; }
.elgg-menu-site > .elgg-state-selected > a, .elgg-menu-site > li:hover > a { background-color: #669900; }
.elgg-button-dropdown:hover, .elgg-button-dropdown:focus, .elgg-button-dropdown.elgg-state-active { background: #669900; }
.elgg-button-nav:hover { background-color: #669900; }


