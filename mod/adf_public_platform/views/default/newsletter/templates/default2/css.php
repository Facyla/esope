<?php
// Integrate theme CSS - default wrapper
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
$textcolor = elgg_get_plugin_setting('textcolor', 'adf_public_platform');
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');
$font2 = elgg_get_plugin_setting('font2', 'adf_public_platform'); // Title font
$font4 = elgg_get_plugin_setting('font4', 'adf_public_platform'); // Main font
?>
body {
	background: #f6f6f6;
	color: #333333;
	font: 80%/1.4 <?php echo $font4; ?>;
}

a {
	color: <?php echo $linkcolor; ?>;
	text-decoration: none;
}

a:hover {
	text-decoration: underline;
	color: <?php echo $linkhovercolor; ?>;
}

img {
	border: none;
}

h1,
h2,
h3,
h4 {
	color: <?php echo $titlecolor; ?>;
	margin: 0;
	font-family: <?php echo $font2; ?>;
}

h1 {
	font-size: 18px;
}

h2 {
	font-size: 16px;
}

h3 {
	font-size: 16px;
}

h4 {
	font-size: 14px;
}

#newsletter_online {
	font-size: 11px;
	color: <?php echo $linkcolor; ?>;
	text-align: center;
	padding: 10px 20px 0px;
	margin: 0 auto;
	width: 800px;
}

#newsletter_header {
	padding: 10px 30px;
	min-height: 20px;
	
	background: <?php echo $color3; ?>;
	
	border-top: 1px solid #dbdbdb;
	border-left: 1px solid #dbdbdb;
	border-bottom: 1px solid #dbdbdb;
	border-right: 1px solid #dbdbdb;
	
	-webkit-border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
	border-radius: 5px 5px 0 0;
}

#newsletter_header h1{
	color: #FFFFFF;
}

#newsletter_container {
	padding: 20px 0;
	width: 800px;
	margin: 0 auto;
}

#newsletter_content_wrapper {
	display: inline-block;
	border-left: 1px solid #dbdbdb;
	border-bottom: 1px solid #dbdbdb;
}

#newsletter_sidebar {
	width: 179px;
	float: left;
	padding: 30px 10px;
}

#newsletter_content {
	width: 600px;
	float: right;
}

#newsletter_unsubscribe {
	font-size: 11px;
	color: <?php echo $linkcolor; ?>;
	padding: 20px;
	text-align: center;
}

#newsletter_footer {
	padding: 30px;
	background: #F0F0F0;
	
	border-top: 1px solid #FFFFFF;
	border-left: 1px solid #dbdbdb;
	border-bottom: 1px solid #dbdbdb;
	border-right: 1px solid #dbdbdb;
	
	-webkit-border-radius: 0 0 5px 5px;
	-moz-border-radius: 0 0 5px 5px;
	border-radius: 0 0 5px 5px;
}

.elgg-module-newsletter {
	background: #FFFFFF;
	padding: 30px;
	
	border-top: 1px solid #FFFFFF;
	border-left: 1px solid #dbdbdb;
	border-bottom: 1px solid #dbdbdb;
	border-right: 1px solid #dbdbdb;
}

.elgg-module-newsletter .elgg-head {
	padding-bottom: 5px;
	border-bottom: 1px solid #dbdbdb;
}

.elgg-module-newsletter h1 a,
.elgg-module-newsletter h2 a,
.elgg-module-newsletter h3 a {
	text-decoration: none;
}
