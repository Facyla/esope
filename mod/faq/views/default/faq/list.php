<?php

elgg_require_js('faq/list');

$catId = (int)get_input("categoryId");
if(!empty($catId)) {
	$cats = getCategories();
	$cat = faq_get_metastring($catId);

	if(in_array($cat, $cats)) {

		$faqs = getFaqs($cat);

		if(!empty($faqs)) {
			$display = "<div class='mbm'><h3>" . elgg_echo("faq:list:category_title") . $cat . "</h3></div>";

			foreach($faqs as $faq) {
				$display .= elgg_view("object/faq", array("entity" => $faq));
			}
		} else {
			forward(elgg_get_site_url() . "faq/");
		}
	} else {
		register_error(elgg_echo("faq:list:no_category"));
		forward(elgg_get_site_url() . "faq/");
	}
} else {
	register_error(elgg_echo("faq:list:no_category"));
	forward(elgg_get_site_url() . "faq/");
}

echo "<div><div id='result'>" . $display . "</div></div>";

if(elgg_is_admin_logged_in() && !empty($catId)) {
	elgg_require_js('faq/list_admin');

	echo "<div id='beginEdit' class='listEditBegin mtm mbm'>";
	echo elgg_view('input/button', array("class" => "elgg-button elgg-button-submit", "name" => "beginEdit", "value" => elgg_echo("faq:list:edit:begin")));
	echo "</div>";
	echo "<div id='editOptions' class='listEditOptions'>";
	echo "<div class='mbm'>";
	echo elgg_view('input/button', array("class" => "elgg-button elgg-button-action", "name" => "all", "value" => elgg_echo("faq:list:edit:all")));
	echo elgg_view('input/button', array("class" => "elgg-button elgg-button-action", "name" => "none", "value" => elgg_echo("faq:list:edit:none")));
	echo "</div>";
	echo "<div>";
	echo "<div class='mbm'>";
	echo elgg_echo("faq:change_category:description");
	echo "</div>";
	echo "<div class='mbm'><label>" . elgg_echo("faq:change_category:new_category") . "</label><br>";
	$cats = getCategories();
	$category_option_values = array('' => elgg_echo("faq:list:edit:select:choice"));
	foreach($cats as $category) {
		if ($category != $cat) {
			$category_option_values[$category] = $category;
		}
	}
	$category_option_values['new'] = elgg_echo("faq:list:edit:select:new");
	echo elgg_view("input/select", array(
		'name' => 'newCategory',
		'id' => 'newCategory',
		'options_values' => $category_option_values,
	));
	echo "</div>";
	echo elgg_view('input/button', array("class" => "elgg-button elgg-button-cancel", "name" => "cancel", "value" => elgg_echo("cancel")));
	echo elgg_view("input/form", array("id" => "changeCategoryForm", "action" => elgg_get_site_url() . "action/faq/changeCategory"));
	echo "</div>";
	echo "<div class='clearFloat'></div>";
	echo "</div>";
}
