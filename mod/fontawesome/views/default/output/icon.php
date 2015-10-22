<?php
/**
* Display an icon from the elgg icons sprite.
*
* @package Elgg
* @subpackage Core
*
* @uses $vars['class'] Class of elgg-icon
*/

$class = (array) elgg_extract("class", $vars);
global $FONTAWESOME_ICON_NAME;
$FONTAWESOME_ICON_NAME = false;

foreach ($class as $classname) {
	if (strpos($classname, "elgg-icon-") !== false) {
		global $FONTAWESOME_ICON_NAME;
		$FONTAWESOME_ICON_NAME = str_ireplace("elgg-icon-", "", $classname);
	}
}

$class[] = "elgg-icon";
$class[] = "fa";

if (strpos($FONTAWESOME_ICON_NAME, "-hover") !== false) {
	$class[] = "fa-hover";
	$FONTAWESOME_ICON_NAME = str_ireplace("-hover", "", $FONTAWESOME_ICON_NAME);
}

$class[] = "fa-" . fontawesome_translate_icon($FONTAWESOME_ICON_NAME);

$vars["class"] = $class;

$attributes = elgg_format_attributes($vars);

echo "<span $attributes></span>";
