<?php

$entity = $vars["entity"];

$id = "newsletter-edit-content-" . $entity->getGUID();

echo elgg_view("tinymce/init");

echo elgg_view("output/text", array("value" => elgg_echo("newsletter:edit:content:description")));

echo "<div class='mvm'>";

echo elgg_view_menu('longtext', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
	'id' => $id,
));

echo elgg_view("input/plaintext", array("name" => "content", "value" => $entity->content, "id" => $id, "class" => "newsletter-input-plaintext"));
echo "</div>";

echo elgg_view("newsletter/placeholders");

echo "<div class='elgg-foot mtm'>";
echo elgg_view("input/hidden", array("name" => "guid", "value" => $entity->getGUID()));
echo elgg_view("input/submit", array("value" => elgg_echo("save")));
echo "</div>";

?>
<script type="text/javascript">
	elgg.provide('elgg.newsletter');
	
	// ESOPE note : we prefere to use custom TinyMCE editor, which is here customizable
	
</script>
