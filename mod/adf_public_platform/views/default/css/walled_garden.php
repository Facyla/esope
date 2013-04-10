<?php
/**
 * Walled garden CSS
 */

$url = elgg_get_site_url();

?>

.elgg-body-walledgarden {
	margin: 100px auto 0 auto;
	position: relative;
	width: 530px;
}
.elgg-module-walledgarden {
	position: absolute;
	top: 0;
	left: 0;
}
.elgg-module-walledgarden > .elgg-head {
	height: 17px;
}
.elgg-module-walledgarden > .elgg-body {
	padding: 0 10px;
}
.elgg-module-walledgarden > .elgg-foot {
	height: 17px;
}
.elgg-walledgarden-double > .elgg-head {
	background: url(<?php echo $url; ?>_graphics/walled_garden/two_column_top.png) no-repeat left top;
}
.elgg-walledgarden-double > .elgg-body {
	background: url(<?php echo $url; ?>_graphics/walled_garden/two_column_middle.png) repeat-y left top;
}
.elgg-walledgarden-double > .elgg-foot {
	background: url(<?php echo $url; ?>_graphics/walled_garden/two_column_bottom.png) no-repeat left top;
}
.elgg-walledgarden-single > .elgg-head {
	background: url(<?php echo $url; ?>_graphics/walled_garden/one_column_top.png) no-repeat left top;
}
.elgg-walledgarden-single > .elgg-body {
	background: url(<?php echo $url; ?>_graphics/walled_garden/one_column_middle.png) repeat-y left top;
}
.elgg-walledgarden-single > .elgg-foot {
	background: url(<?php echo $url; ?>_graphics/walled_garden/one_column_bottom.png) no-repeat left top;
}

.elgg-col > .elgg-inner {
	margin: 0 0 0 5px;
}
.elgg-col:first-child > .elgg-inner {
	margin: 0 5px 0 0;
}
.elgg-col > .elgg-inner {
	padding: 0 8px;
}

.elgg-walledgarden-single > .elgg-body {
	padding: 0 18px;
}

.elgg-module-walledgarden-login {
	margin: 0;
}
.elgg-body-walledgarden h3 {
	font-size: 1.5em;
	line-height: 1.1em;
	padding-bottom: 5px;
}

.elgg-heading-walledgarden {
	margin-top: 60px;
	line-height: 1.1em;
}

h1, h2, h3, h4, h5, h6 {
	color: #666;
}

a {
	color: #999;
}





#elgg-walledgarden {
	margin: 100px auto 0 auto;
	width: 563px;
	min-height: 236px;
	background: url(<?php echo $url; ?>_graphics/walled_garden_background_top.gif) no-repeat left top;
	padding: 0;
	position: relative;
}

#elgg-walledgarden-bottom {
	margin:236px auto 0 auto;
	background: url(<?php echo $url; ?>_graphics/walled_garden_background_bottom.gif) no-repeat left bottom;
	width:563px;
	height:54px;
}

#elgg-walledgarden-intro {
	width: 230px;
	float: left;
	margin: 25px 15px 15px 35px;
}

#elgg-walledgarden-login {
	width: 230px;
	float: left;
	margin: 20px 15px 0px 19px;
}

.elgg-heading-walledgarden {
	color: #666666;
	margin-top: 60px;
	line-height: 1.1em;
}

#elgg-walledgarden-lostpassword,
#elgg-walledgarden-registration {
	position: relative;
	right: 0;
	top: 0;
	width: 563px;
	background-color: white;
	padding: 0;
	background: url(<?php echo $url; ?>_graphics/walled_garden_backgroundfull_top.gif) no-repeat left top;
	height: auto;
}

.elgg-hiddenform-body {
	padding: 30px 40px 0 40px;
	height: auto;
}
.elgg-hiddenform-bottom {
	margin: 0 auto;
	background: url(<?php echo $url; ?>_graphics/walled_garden_backgroundfull_bottom.gif) no-repeat left bottom;
	width: 563px;
	height: 54px;
	position: relative;
}
