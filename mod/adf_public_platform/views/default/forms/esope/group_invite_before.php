<?php
/**
 * Elgg groups invite form
 *
 * @package ElggGroups
 */

//$group = $vars['entity'];

$invite_metadata = elgg_get_plugin_setting('groups_invite_metadata', 'adf_public_platform');
if (empty($invite_metadata)) { return; }

echo '<h3>' . elgg_echo('esope:groupinvite:standard') . '</h3>';

