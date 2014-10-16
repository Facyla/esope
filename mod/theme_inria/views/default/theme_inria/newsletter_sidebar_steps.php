<?php

$guid = $vars['entity']->guid;

if ($guid) {
	echo '<a target="_blank" href="' . $vars['url'] . 'newsletter/preview/' . $guid . '" class="elgg-button elgg-button-action">' . elgg_echo("preview") . '</a>';
}

