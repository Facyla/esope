<?php

if(elgg_get_plugin_setting("userQuestions", "faq") == "yes") {
	$allow = true;
} else {
	$allow = false;
}

$title = "<div class='mbm'><h3>" . elgg_echo("faq:asked:title") . "</h3></div>";

$content = '';

if($allow) {
	$count = elgg_get_entities_from_metadata(array(
		'metadata_name' => "userQuestion",
		'metadata_value' => true,
		'type' => "object",
		'subtype' => "faq",
		'limit' => false,
		'count' => true
	));

	if ($count > 0) {

		elgg_require_js('faq/asked');

		$open = elgg_get_entities_from_metadata(array(
			'metadata_name' => "userQuestion",
			'metadata_value' => true,
			'type' => "object",
			'subtype' => "faq",
			'limit' => $count
		));

		// Category selector
		$categories = getCategories();

		foreach($open as $faq) {
			$content .= "<div class='askedQuestion mbm' id='question" . $faq->guid . "'><table><tr><td class='askedLink'><a href='#' data-faqguid='" . $faq->guid . "'>" . $faq->question . "</a></td><td class='askedSince'>" . elgg_echo("faq:asked:added") . " " . elgg_view_friendly_time($faq->time_created) . "</td></tr></table></div>\n";
			$content .= "<div class='clearfloat'></div>";

			// Category selector
			$category_option_values = array('' => elgg_echo("faq:add:oldcat:please"));
			foreach($categories as $cat) {
				$category_option_values[$cat] = $cat;
			}
			$category_option_values['newCat'] = elgg_echo("faq:add:oldcat:new");
			$select = elgg_view("input/select", array(
				'name' => 'oldCat',
				'id' => 'oldCat',
				'options_values' => $category_option_values,
				'disabled' => 'disabled',
				'data-faqguid' => $faq->guid
			));

			// Access selector
			$accessSelector = elgg_view("input/select", array(
				'name' => 'access',
				'id' => 'access',
				'options_values' => array(ACCESS_PUBLIC => elgg_echo("PUBLIC"), ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN")),
				'value' => ACCESS_PUBLIC,
				'disabled' => 'disabled'
			));

			// User who asked the question
			$user = get_user($faq->owner_guid);

			// Create elements
			$formElements = "<div class='mbm'><label>" . elgg_echo("faq:add:question") . "</label>" . " (" . elgg_echo("faq:asked:by") . "<a href=\"{$user->getURL()}\">{$user->name}</a>" . ")" . "<br>";
			$formElements .= elgg_view("input/hidden", array("name" => "guid", "value" => $faq->guid));
			$formElements .= elgg_view("input/hidden", array("name" => "originalQuestion", "value" => $faq->question));
			$formElements .= elgg_view("input/text", array("name" => "question", "value" => $faq->question));
			$formElements .= "</div>";
			$formElements .= "<div class='mbm'><label>" . elgg_echo("faq:asked:add") . "</label><br>";
			$formElements .= elgg_view("input/radio", array(
				'name' => 'add',
				'options' => array(
					elgg_echo("option:yes") => 'yes',
					elgg_echo("option:no") => 'no'),
				'value' => 'no',
				'align' => 'horizontal',
				'data-faqguid' => $faq->guid
			));
			$formElements .= "</div>";
			$formElements .= "<div class='mbm'><label>" . elgg_echo("faq:add:category") . "</label><br>";
			$formElements .= $select . "<br>";
			$formElements .= elgg_view("input/text", array("name" => "newCat", "disabled" => "disabled"));
			$formElements .= "</div>";
			$formElements .= "<div class='mbm'><label>" . elgg_echo("faq:add:answer") . "</label>";
			$formElements .= elgg_view("input/longtext", array("name" => "textanswer".$faq->guid));
			$formElements .= "</div>";
			$formElements .= "<div class='mbm'><label>" . elgg_echo("access") . "</label><br>";
			$formElements .= $accessSelector;
			$formElements .= "</div>";
			$formElements .= elgg_view("input/submit", array("name" => "save", "value" => elgg_echo("save"), 'data-faqguid' => $faq->guid)) . "&nbsp;";
			$formElements .= elgg_view("input/reset", array("name" => "cancel", "value" => elgg_echo("cancel"), "type" => "reset", "data-faqguid" => $faq->guid));

			$form = elgg_view("input/form", array(
				"name" => "answer",
				"class" => "answerform",
				"data-faqguid" => $faq->guid,
				"id" => "answer" . $faq->guid,
				"body" => $formElements,
				"action" => elgg_get_site_url() . "action/faq/answer"
			));

			$content .= "<div class='askedAnswer' id='formDiv" . $faq->guid . "'>\n";
			$content .= $form;
			$content .= "</div>\n";
		}
	} else {
		$content .= elgg_echo("faq:asked:no_questions");
	}
} else {
	$content .= elgg_echo("faq:asked:not_allowed");
}

echo $title . "<div>" . $content . "</div>";
