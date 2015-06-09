<?php

$guid = $vars['entity']->guid;

if ($guid) {
	echo elgg_view('output/confirmlink', array('href' => $vars['url'] . 'newsletter/preview/' . $guid, 'text' => elgg_echo("preview"), 'target' => "_blank", 'class' => 'elgg-button elgg-button-action', 'confirm' => elgg_echo('theme_inria:newsletter:confirmlink')));
}

