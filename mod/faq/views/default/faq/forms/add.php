<?php

elgg_require_js('faq/add');

$id = get_input("id");

if (!empty($id)) {
	$edit = true;
	$faq = get_entity($id);
	$cat_value = $faq->category;
	$access_value = $faq->access_id;
	$title = "<div class='mbm'><h3>" . elgg_echo("faq:edit:title") . "</h3></div>";
} else {
	$access_value = ACCESS_PUBLIC;
	$title = "<div class='mbm'><h3>" . elgg_echo("faq:add:title") . "</h3></div>";
}

// Category selector
$count = elgg_get_entities(array('type' => "object", 'subtype' => "faq", 'limit' => false, 'offset' => 0, 'count' => true));
$metadatas = elgg_get_metadata(array('annotation_name' => "category", 'type' => "object", 'subtype' => "faq", 'limit' => $count));
$cats = array();
foreach ($metadatas as $metadata) {
	$cat = $metadata['value'];
	if(!in_array($cat, $cats)) {
		$cats[] = $cat;
	}
}
if(!$edit) {
	$category_option_values = array('' => elgg_echo("faq:add:oldcat:please"));
	$cat_value = '';
}
foreach($cats as $cat) {
	$category_option_values[$cat] = $cat;
}
$category_option_values['newCat'] = elgg_echo("faq:add:oldcat:new");
$select = elgg_view("input/select", array(
	'name' => 'oldCat',
	'id' => 'oldCat',
	'options_values' => $category_option_values,
	'value' => $cat_value,
));

// Access selector
$accessSelector = elgg_view("input/select", array(
	'name' => 'access',
	'id' => 'access',
	'options_values' => array(ACCESS_PUBLIC => elgg_echo("PUBLIC"), ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN")),
	'value' => $access_value,
));

// Make form
$addBody = "<div class='mbm'><label>" . elgg_echo("faq:add:question") . "</label><br>";
if($edit) {
	$addBody .= elgg_view("input/text", array("name" => "question", "value" => $faq->question));
} else {
	$addBody .= elgg_view("input/text", array("name" => "question"));
}
$addBody .= "</div>";
$addBody .= "<div class='mbm'><label>" . elgg_echo("faq:add:category") . "</label><br>";
$addBody .= $select . "<br>";
$addBody .= elgg_view("input/text", array("name" => "newCat", "disabled" => "disabled"));
$addBody .= "</div>";
$addBody .= "<div class='mbm'><label>" . elgg_echo("faq:add:answer") . "</label>";
if($edit) {
	$addBody .= elgg_view("input/longtext", array("name" => "answer", "value" => $faq->answer));
} else {
	$addBody .= elgg_view("input/longtext", array("name" => "answer"));
}
$addBody .= "</div>";
$addBody .= "<div class='mbm'><label>" . elgg_echo("access") . "</label><br>";
$addBody .= $accessSelector;
$addBody .= "</div>";
$addBody .= elgg_view("input/submit", array("name" => "save", "value" => elgg_echo("save")));

if($edit) {
	$addBody .= elgg_view("input/hidden", array("name" => "guid", "value" => $faq->guid));

	$addForm = elgg_view("input/form", array(
		"name" => "editForm",
		"id" => "questionForm",
		"body" => $addBody,
		"action" => elgg_get_site_url() . "action/faq/edit"
	));
} else {
	$addForm = elgg_view("input/form", array(
		"name" => "addForm",
		"id" => "questionForm",
		"body" => $addBody,
		"action" => elgg_get_site_url() . "action/faq/add"
	));
}

echo $title . "<div>" . $addForm . "</div>";
