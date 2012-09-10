<?php
if (strlen($vars['entity']->whitelist) == 0) { $vars['entity']->whitelist = elgg_echo('registration_filter:whitelist:default'); } // Default valid domain list
?>

<p>
	<label>
    <?php // un nom de domaine par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
    echo elgg_echo('registration_filter:whitelist');
    echo elgg_view('input/plaintext', array( 'name' => 'params[whitelist]', 'value' => $vars['entity']->whitelist ));
    ?>
	</label>
</p>
