<?php

$params = array(
	'delay' => $vars['entity']->delay ? $vars['entity']->delay : 1000,
	'positionmy' => $vars['entity']->positionmy ? $vars['entity']->positionmy : 'top right',
	'positionat' => $vars['entity']->positionat ? $vars['entity']->positionat : 'bottom left',
	'persistent' => $vars['entity']->persistent ? $vars['entity']->persistent : 'no'
);
echo elgg_view('forms/tooltip_editor/edit', $params);