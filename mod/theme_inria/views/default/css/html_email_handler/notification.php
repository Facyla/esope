<?php
/**
 * The main CSS for all outgoing email notifications
 */

// Integrate theme CSS - default wrapper
$titlecolor = elgg_get_plugin_setting('titlecolor', 'esope');
$textcolor = elgg_get_plugin_setting('textcolor', 'esope');
$linkcolor = elgg_get_plugin_setting('linkcolor', 'esope');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'esope');
$color2 = elgg_get_plugin_setting('color2', 'esope');
$color3 = elgg_get_plugin_setting('color3', 'esope');
$font2 = elgg_get_plugin_setting('font2', 'esope'); // Title font
$font4 = elgg_get_plugin_setting('font4', 'esope'); // Main font
// Or use custom CSS
$notification_css = elgg_get_plugin_setting('notification_css', 'esope');

if (!empty($notification_css)) {
	// Custom CSS
	echo $notification_css;
	return;
}
// Default CSS (basic integration with theme colors)
?>
body {
	font: 12px/17px <?php echo $font4; ?>;
	color: #333333;
}
a {
	color: #6D2D4F;
}
h1, h2, h3, h4, h5, h6 { font-family: <?php echo $font2; ?>; }
a { color: <?php echo $linkcolor; ?>; }
a:hover, a:active, a:focus { color: <?php echo $linkhovercolor; ?>; }

#notification_container {
	padding: 20px 0;
	width: 600px;
	margin: 0 auto;
}
#notification_header {
	text-align: right;
	padding: 0 0 10px;
}
#notification_header a {
	text-decoration: none;
	font-weight: bold;
	color: #6D2D4F;
	font-size: 1.5em;
}
#notification_wrapper {
	background: none repeat scroll 0 0 #FFFFFF;
	padding: 10px;
}
#notification_wrapper h2 {
	margin: 5px 0 5px 10px;
	color: #6D2D4F;
	font-size: 1.35em;
	line-height: 1.2em;
}
#notification_content {
	background: #FFFFFF;
	padding: 10px;
}
#notification_footer {
	background: #FFFFFF;
	margin: 10px 0 0;
	padding: 10px;
	text-align: right;
}
#notification_footer a:hover, #notification_footer a:active, #notification_footer a:focus {
	color:white;
}
#notification_footer_logo {
	float: left;
}
#notification_footer_logo img {
	border: none;
}
.clearfloat {
	clear: both;
	height: 0;
	font-size: 1px;
	line-height: 0px;
}
