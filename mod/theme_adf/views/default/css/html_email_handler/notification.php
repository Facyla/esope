<?php
/**
 * The main CSS for all outgoing email notifications
 */
?>
body {
	font: 12px/17px "Lucida Grande", Verdana, sans-serif;
	color: #333333;
}

a {
	color: #0b2d51;
}

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
	color: #0b2d51;
	font-size: 18px;
}

#notification_wrapper {
	background: #0b2d51;
	padding: 10px 1px;
}

#notification_wrapper img {
	height: 2rem;
	width: auto;
	display: inline-block;
	line-height: calc(2rem + 10px);
	margin: 0 10px 10px 1rem;
}

#notification_wrapper h2 {
	margin: 0 0 10px 10px;
	color: #FFFFFF;
	font-size: 16px;
	line-height: 2rem;
	display: inline-block;
	vertical-align: top;
}

#notification_content {
	background: #FFFFFF;
	padding: 10px;
}

#notification_footer {
	
	margin: 10px 0 0;
	background: #FFFFFF;
	padding: 10px;
	text-align: right;
}

.clearfloat {
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
