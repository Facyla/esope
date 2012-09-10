<?php
$urlfonts = $vars['url'] . 'mod/adf_public_platform/fonts/';
$urlicon = $vars['url'] . 'mod/adf_public_platform/img/theme/';
?>

header {
	background: #0050BF url("<?php echo $urlicon; ?>header.jpg") left 6px repeat-x scroll;
}
#transverse {
	background: #F6F6F6 url("<?php echo $urlicon; ?>fond-menu.jpg") left top repeat-x scroll;
}
#transverse form {
	width: 215px;
}
#transverse form input#search-input {
	padding-top: 6px;
	height: 19px;
}
footer {
	background: url("<?php echo $urlicon; ?>fond-footer.jpg") repeat-x scroll left top #626262;
}
footer ul {
	float: left;
	margin-left: 270px;
	width: 500px;
}

