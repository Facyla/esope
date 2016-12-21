<?php
/**
 * Elgg Search css
 * 
 */
?>

/**********************************
Search plugin
***********************************/
.elgg-page-header .elgg-search {
        margin-top: -28px;
	margin-bottom: 2px;
        margin-right:5px;
	height: 23px;
	position: absolute;
	right: 0;
       
}
.elgg-page-header .elgg-search input[type=text] {
	width: 220px;
}
.elgg-page-header .elgg-search input[type=submit] {
	display: none;
}
.elgg-search input[type=text] {
	border: 1px solid #D2D2D2;
	color: #333;
	font-size: 12px;
	font-weight: bold;
	padding: 2px 4px 2px 26px;
	background: white url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat 2px -934px;
}
.elgg-search input[type=text]:focus, .elgg-search input[type=text]:active {
	background-color: white;
	background-position: 2px -916px;
	border: 1px solid white;
	color: #000;
}

.search-list li {
	padding: 5px 0 0;
}
.search-heading-category {
	margin-top: 20px;
	color: #666666;
}

.search-highlight {
	background-color: #bbdaf7;
}
.search-highlight-color1 {
	background-color: #bbdaf7;
}
.search-highlight-color2 {
	background-color: #A0FFFF;
}
.search-highlight-color3 {
	background-color: #FDFFC3;
}
.search-highlight-color4 {
	background-color: #ccc;
}
.search-highlight-color5 {
	background-color: #4690d6;
}
