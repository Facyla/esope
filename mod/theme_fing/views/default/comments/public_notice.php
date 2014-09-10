<?php
// Copy and tweak in your custom theme depending on your exact needs and registration policy
if (!elgg_is_logged_in()) {
	echo '<div class="clearfloat"></div><br />';
	echo "<blockquote><i class=\"fa fa-info-circle\"></i> " . elgg_echo('theme_fing:comments:publicnotice') . " Veuillez vous <a href=\"" . $vars['url'] . "login\">connecter</a>, ou <a href=\"" . $vars['url'] . "register\">créer un compte</a>.</blockquote>";
}

