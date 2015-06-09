<?php
/**
* Profile Manager
*
* non editable
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

if (is_array($vars["value"])) {
	// probably tags, so change to text (fixes #51)
	$vars["value"] = implode(", ", $vars["value"]);
}

echo elgg_view("input/hidden", $vars);
	
echo "<div>";
echo elgg_view("output/text", $vars);
echo "</div>";

echo "<div>";
echo elgg_echo("profile_manager:non_editable:info");
echo "</div>";
