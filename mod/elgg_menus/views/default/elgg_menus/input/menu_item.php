<?php

$yn_opt = array('yes' => elgg_echo('survey:option:yes'), 'no' => elgg_echo('survey:option:no'));
$ny_opt = array('no' => elgg_echo('survey:option:no'), 'yes' => elgg_echo('survey:option:yes'));

$menu_item = elgg_extract('menu_item', $vars);

$name = $text = $href = $section = $link_class = $item_class = $parent_name = $contexts = $title = $selected = $confirm = $data = $priority = '';
if ($menu_item instanceof ElggMenuItem) {
	$name = $menu_item->getName();
	$text = $menu_item->getText();
	$href = $menu_item->getHref();
	$section = $menu_item->getSection();
	$link_class = $menu_item->getLinkClass();
	$item_class = $menu_item->getItemClass();
	$parent_name = $menu_item->getParentName();
	$contexts = $menu_item->getContext();
	$title = $menu_item->getTooltip();
	$selected = $menu_item->getSelected();
	$confirm = $menu_item->getConfirmText();
	$data = '';
	$priority = $menu_item->getPriority();
}

$content .= '<div class="menu-editor-item">';
	
	$content .= '<a href="javascript:void(0);" class="menu-editor-delete-item" title="' . elgg_echo('elgg_menus:delete') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';
	
	$content .= '<a href="javascript:void(0);" class="menu-editor-toggle-options" style="float:right; margin-left: 2ex;"><i class="fa fa-cog"></i>' . elgg_echo('elgg_menus:item:edit') . '</a>';
	if ($menu_item) {
		//$content .= '<pre>' . print_r($menu_item, true) . '</pre>' . '</label>';
		$content .= '<strong>' . $priority . ' - ' . $name . ' : ' . $text . ' => ' . $href . '</strong>';
		//$content .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
		$content .= '<div class="menu-editor-item-content hidden">';
	} else {
		$content .= '<div class="menu-editor-item-content">';
	}
	
	// Nommage des entrées : permettre de récupérer toute la liste sans devoir compter => variable[]
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:name')) . '<label>' . elgg_echo('elgg_menus:item:name') . ' ' . elgg_view('input/text', array('name' => "name[]", 'value' => $name, 'style' => "width:20ex;", 'required' => 'required')) . '</label>';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:text')) . '<label>' . elgg_echo('elgg_menus:item:text') . ' ' . elgg_view('input/text', array('name' => "text[]", 'value' => $text, 'style' => "width:30ex;")) . '</label>';
	$content .= '<br />';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:title')) . '<label>' . elgg_echo('elgg_menus:item:title') . ' ' . elgg_view('input/text', array('name' => "title[]", 'value' => $title, 'style' => "width:60ex;")) . '</label>';
	$content .= '<br />';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:href')) . '<label>' . elgg_echo('elgg_menus:item:href') . ' ' . elgg_view('input/text', array('name' => "href[]", 'value' => $href, 'style' => "width:60ex;")) . '</label>';
	$content .= '<br />';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:confirm')) . '<label>' . elgg_echo('elgg_menus:item:confirm') . ' ' . elgg_view('input/text', array('name' => "confirm[]", 'value' => $confirm, 'style' => "width:60ex;")) . '</label>';
	$content .= '<br />';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:contexts')) . '<label>' . elgg_echo('elgg_menus:item:contexts') . ' ' . elgg_view('input/text', array('name' => "contexts[]", 'value' => $contexts, 'style' => "width:40ex;")) . '</label>';
	$content .= '<br />';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:item_class')) . '<label>' . elgg_echo('elgg_menus:item:item_class') . ' ' . elgg_view('input/text', array('name' => "item_class[]", 'value' => $item_class, 'style' => "width:30ex;")) . '</label>';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:link_class')) . '<label>' . elgg_echo('elgg_menus:item:link_class') . ' ' . elgg_view('input/text', array('name' => "link_class[]", 'value' => $link_class, 'style' => "width:30ex;")) . '</label>';
	$content .= '<br />';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:section')) . '<label>' . elgg_echo('elgg_menus:item:section') . ' ' . elgg_view('input/text', array('name' => "section[]", 'value' => $section, 'style' => "width:12ex;")) . '</label>';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:parent_name')) . '<label>' . elgg_echo('elgg_menus:item:parent_name') . ' ' . elgg_view('input/text', array('name' => "parent_name[]", 'value' => $parent_name, 'style' => "width:20ex;")) . '</label>';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:priority')) . '<label>' . elgg_echo('elgg_menus:item:priority') . ' ' . elgg_view('input/text', array('name' => "priority[]", 'value' => $priority, 'style' => "width:6ex;")) . '</label>';
	$content .= elgg_view('elgg_menus/help_popup', array('key' => 'item:selected')) . '<label>' . elgg_echo('elgg_menus:item:selected') . ' ' . elgg_view('input/dropdown', array('name' => "selected[]", 'value' => $selected, 'options_values' => $ny_opt)) . '</label>';
	
	$content .= '</div>';
$content .= '</div>';

echo $content;

/*
$question_content .= '<p class="question_title_' . $i . '"><label>' . elgg_echo('survey:question:title') . ' ' . elgg_view('input/text', array('name' => "question_title[]", 'value' => $title, 'class' => 'survey-input-question-title', 'placeholder' => elgg_echo('survey:question:title:placeholder'))) . '</label></p>';

// Group all other input elements to we can hide them on-demand
$question_content .= '<div class="survey-input-question-details">';
	
	$question_content .= '<p class="question_required_' . $i . '" style="float:right;"><label>' . elgg_echo('survey:question:required') . ' ' . elgg_view('input/pulldown', array('name' => "question_required[]", 'value' => $required, 'options_values' => $yn_opt, 'class' => 'survey-input-question-required')) . '</label></p>';

	$question_content .= '<p class="question_input_type_' . $i . '"><label>' . elgg_echo('survey:question:input_type') . ' ' . elgg_view('input/pulldown', array('name' => "question_input_type[]", 'value' => $input_type, 'options_values' => $question_types_opt, 'class' => 'survey-input-question-input-type', 'data-id' => $i)) . '</label>';
	// Add some help for each input type
	$question_content .= elgg_view('survey/input/question_type_help', array('input_type' => $input_type));
	$question_content .= '</p>';

	// Hide conditionnal elements
	if (!in_array($input_type, array('dropdown', 'pulldown', 'checkboxes', 'multiselect', 'rating'))) { $hide = 'display:none;'; } else { $hide = ''; }
	$question_content .= '<p class="question_options_' . $i . '" style="' . $hide . '"><label>' . elgg_echo('survey:question:options') . ' ' . elgg_view('input/plaintext', array('name' => "question_options[]", 'value' => $options, 'class' => 'survey-input-question-options', 'placeholder' => elgg_echo('survey:question:options:placeholder'))) . '</label></p>';

	// Hide conditionnal elements
	if (!in_array($input_type, array('dropdown', 'pulldown', 'rating'))) { $hide = 'display:none;'; } else { $hide = ''; }
	$question_content .= '<p class="question_empty_value_' . $i . '" style="' . $hide . '"><label>' . elgg_echo('survey:question:empty_value') . ' ' . elgg_view('input/pulldown', array('name' => "question_empty_value[]", 'value' => $empty_value, 'options_values' => $no_yes_opt, 'class' => 'survey-input-question-empty-value')) . '</label></p>';

	// @TODO later : allow to define questions dependencies : based on non-empty, or specific value(s) ?
	//$question_content .= '<p><label>Dépendances ' . elgg_view('input/text', array('name' => "question_dependency[]", 'value' => $question->dependency, 'class' => 'survey-input-question-dependency')) . '</label></p>';
	
	$question_content .= '<p class="question_description_' . $i . '"><label>' . elgg_echo('survey:question:description') . ' ' . elgg_view('input/plaintext', array('name' => "question_description[]", 'value' => $description, 'class' => 'survey-input-question-description', 'placeholder' => elgg_echo('survey:question:description:placeholder'))) . '</label></p>';
	
$question_content .= '</div>';


//$delete_icon = elgg_view('output/img', array('src' => 'mod/survey/graphics/16-em-cross.png'));
$delete_link = elgg_view('output/url', array(
	'href' => '#',
	'text' => '<i class="fa fa-trash"></i>', // $delete_icon
	'title' => elgg_echo('survey:delete_question'),
	'class' => 'delete-question',
	'data-id' => $i,
));



$body .= "<div id=\"question-container-{$i}\">
		<fieldset class=\"survey-input-question\">
			<span style=\"float:right\">{$delete_link}</span>
			{$question_content}
		</fieldset>
	</div>";


echo $body;
*/




