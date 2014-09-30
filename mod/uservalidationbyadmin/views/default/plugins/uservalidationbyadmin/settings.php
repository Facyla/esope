<?php

// Allow up to 5 admins being notified
// If none set (or none valid), will default to the first site admin
echo '<p>' . elgg_echo("uservalidationbyadmin:settings:usernames") . '</p>';
for ($i = 1; $i <= 5; $i++) {
	echo "<label>".elgg_echo('uservalidationbyadmin:user', array($i)) . ' <input type="text" size="60" name="params[user' . $i . ']" value="' . $vars['entity']->{'user' . $i} . '" /></label><br />';
}

