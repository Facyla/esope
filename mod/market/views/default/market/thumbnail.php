<?php
/**
 * Elgg Market Plugin
 * @package market
 */

$guid = $vars['guid'];
$size =  $vars['size'];
$class = $vars['class'];
$imagenum = $vars['imagenum'];
$tu = $vars['tu'];

echo elgg_view('output/img', array(
		'src' => elgg_get_site_url() . "market/image/{$guid}/{$imagenum}/{$size}/{$tu}",
		'class' => "elgg-photo $class",
		'alt' => $imagenum,
		));


