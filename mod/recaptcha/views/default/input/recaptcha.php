<?php

$site_key = elgg_get_plugin_setting('publickey', 'recaptcha');

echo '<div class="g-recaptcha" data-sitekey="' . $site_key . '"></div>';

