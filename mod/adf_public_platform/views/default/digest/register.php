<?php

$setting = digest_get_default_site_interval();
if (!empty($setting) && ($setting != DIGEST_INTERVAL_NONE)) {
	echo '<div class="register-fullwidth">';
	echo '<label for="digest-register">';
	echo elgg_view("input/checkbox", array("name" => "digest_site", "value" => "yes", "default" => false, "id" => "digest-register"));
	echo ' ' . elgg_echo("digest:register:enable") . '</label>';
	echo '</div>';
}

