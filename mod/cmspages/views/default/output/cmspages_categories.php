<?php
/**
 * CMSPages category
 * Categories can be a single string (for one category) or an array of strings
 *
 * @uses $vars['value']   Array of categories or a string
 * @uses $vars['type']    The entity type, optional
 * @uses $vars['subtype'] The entity subtype, optional
 * @uses $vars['entity']  Optional. Entity whose categories are being displayed (metadata ->categories)
 * @uses $vars['list_class'] Optional. Additional classes to be passed to <ul> element
 * @uses $vars['item_class'] Optional. Additional classes to be passed to <li> elements
 * @uses $vars['icon_class'] Optional. Additional classes to be passed to tags icon image
 */

if (isset($vars['entity'])) {
	$vars['categories'] = $vars['entity']->tags;
	unset($vars['entity']);
}

if (!empty($vars['subtype'])) {
	$subtype = "&subtype=" . urlencode($vars['subtype']);
} else {
	$subtype = "";
}
if (!empty($vars['object'])) {
	$object = "&object=" . urlencode($vars['object']);
} else {
	$object = "";
}

if (empty($vars['categories']) && !empty($vars['value'])) {
	$vars['categories'] = $vars['value'];
}

if (empty($vars['categories']) && isset($vars['entity'])) {
	$vars['categories'] = $vars['entity']->categories;
}

if (!empty($vars['categories'])) {
	if (!is_array($vars['categories'])) {
		$vars['categories'] = array($vars['categories']);
	}

	$list_class = "elgg-tags";
	if (isset($vars['list_class'])) {
		$list_class = "$list_class {$vars['list_class']}";
	}

	$item_class = "elgg-tag";
	if (isset($vars['item_class'])) {
		$item_class = "$item_class {$vars['item_class']}";
	}

	$icon_class = elgg_extract('icon_class', $vars);
	$list_items = '<li>' . elgg_view_icon('tag', $icon_class) . '</li>';

	foreach($vars['categories'] as $category) {
		if (!empty($vars['type'])) {
			$type = "&type={$vars['type']}";
		} else {
			$type = "";
		}
		$url = elgg_get_site_url() . 'r/' . urlencode($category);
		if (is_string($category)) {
			$list_items .= "<li class=\"$item_class\">";
			$list_items .= elgg_view('output/url', array('href' => $url, 'text' => $category, 'rel' => 'tag'));
			$list_items .= '</li>';
		}
	}

	$list = <<<___HTML
		<div class="clearfix">
			<ul class="$list_class">
				$list_items
			</ul>
		</div>
___HTML;

	echo $list;
}

