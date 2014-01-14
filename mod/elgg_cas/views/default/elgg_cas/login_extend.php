<?php
global $CONFIG;

echo '<p>' . elgg_echo('elgg_cas:login:details') . '</p>';
?>

<div class="elgg-cas-login">
	<a href="<?php echo $CONFIG->url; ?>cas_auth" class="elgg-button elgg-button-action cas-login"><?php echo elgg_echo('elgg_cas:loginbutton'); ?></a>
</div>


