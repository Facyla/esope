<?php
/**
 * Elgg pagination
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses int    $vars['offset']     The offset in the list
 * @uses int    $vars['limit']      Number of items per page
 * @uses int    $vars['count']      Number of items in list
 * @uses string $vars['base_url']   Base URL to use in links
 * @uses string $vars['offset_key'] The string to use for offset in the URL
 */

if (elgg_in_context('widget')) {
	// widgets do not show pagination
	return;
}

$count = (int) elgg_extract('count', $vars, 0);
if (!$count) {
	return;
}

$offset = abs((int) elgg_extract('offset', $vars, 0));
// because you can say $vars['limit'] = 0
if (!$limit = (int) elgg_extract('limit', $vars, elgg_get_config('default_limit'))) {
	$limit = 10;
}

$offset_key = elgg_extract('offset_key', $vars, 'offset');
// some views pass an empty string for base_url
if (isset($vars['base_url']) && $vars['base_url']) {
	$base_url = $vars['base_url'];
} else if (isset($vars['baseurl']) && $vars['baseurl']) {
	elgg_deprecated_notice("Use 'base_url' instead of 'baseurl' for the navigation/pagination view", 1.8);
	$base_url = $vars['baseurl'];
} elseif (elgg_is_xhr() && !empty($_SERVER['HTTP_REFERER'])) {
	$base_url = $_SERVER['HTTP_REFERER'];
} else {
	$base_url = current_page_url();
}

// ESOPE : improved navigation
$advanced_pagination = elgg_get_plugin_setting('advanced_pagination', 'esope');
if ($advanced_pagination != 'yes') { $advanced_pagination = false; }

$num_pages = elgg_extract('num_pages', $vars, 10);
$delta = ceil($num_pages / 2);

if ($count <= $limit && $offset == 0) {
	// no need for pagination
	return;
}

$total_pages = (int) ceil($count / $limit);
$current_page = (int) ceil($offset / $limit) + 1;

$pages = array();

// determine starting page
$start_page = max(min([$current_page - 2, $total_pages - 4]), 1);

// add previous
	$prev_offset = $offset - $limit;
if ($prev_offset < 1) {
	// don't include offset=0
	$prev_offset = null;
	}

$pages['prev'] = [
	'text' => elgg_echo('previous'),
	'href' => elgg_http_add_url_query_elements($base_url, array($offset_key => $prev_offset))
];

	$first_page = $current_page - $delta;
	if ($first_page < 1) {
		$first_page = 1;
	}

	$pages->items = range($first_page, $current_page - 1);
}


$pages->items[] = $current_page;


// add pages after the current one
if ($current_page < $total_pages) {
	$next_offset = $offset + $limit;
	if ($next_offset >= $count) {
		$next_offset--;
	}

	$pages->next['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $next_offset));

	$last_page = $current_page + $delta;
	if ($last_page > $total_pages) {
		$last_page = $total_pages;
	}

	$pages->items = array_merge($pages->items, range($current_page + 1, $last_page));
}


echo '<ul class="elgg-pagination">';

// Esope : Ajout "first" link
if ($advanced_pagination) {
	if ($pages->items[0] > 1) {
		$page_offset = 1;
		$url = elgg_http_add_url_query_elements($base_url, array($offset_key => 0));
		$link = elgg_view('output/url', array('href'=>$url, 'text'=>'1', 'is_trusted' => true));
		echo "<li>$link</li>";
	}
}

if ($pages->prev['href']) {
  $pages->prev['title'] = elgg_echo('previouspage');
	$link = elgg_view('output/url', $pages->prev);
	echo "<li>$link</li>";
} else {
	echo "<li class=\"elgg-state-disabled\"><span>{$pages->prev['text']}</span></li>";
}

foreach ($pages->items as $page) {
	if ($page == $current_page) {
		echo "<li class=\"elgg-state-selected\"><span>$page</span></li>";
	} else {
		$page_offset = (($page - 1) * $limit);
		$url = elgg_http_add_url_query_elements($base_url, array($offset_key => $page_offset));
		$link = elgg_view('output/url', array(
			'href' => $url,
			'text' => $page,
			'title' => elgg_echo('page') . ' ' . $page,
			'is_trusted' => true,
		));
		//echo "<li><a title=\"" . elgg_echo('page') . " $page\" href=\"$url\">$page</a></li>";
		echo "<li>$link</li>";

	}
}

if ($pages->next['href']) {
  $pages->next['title'] = elgg_echo('nextpage');
	$link = elgg_view('output/url', $pages->next);
	echo "<li>$link</li>";
} else {
	echo "<li class=\"elgg-state-disabled\"><span>{$pages->next['text']}</span></li>";
}

// Esope : Ajout "last" link
if ($advanced_pagination) {
	if (end($pages->items) < $total_pages) {
		$page_offset = ($total_pages - 1) * $limit;
		$url = elgg_http_add_url_query_elements($base_url, array($offset_key => $page_offset));
		$lasttext = elgg_echo('esope:advanced_pagination:last', array($total_pages));
		$link = elgg_view('output/url', array('href'=>$url, 'text'=>$lasttext, 'is_trusted' => true));
		echo "<li>$link</li>";
	}
}

echo elgg_format_element('ul', ['class' => 'elgg-pagination'], $list);

// Esope : limits selector
if ($advanced_pagination) {
	echo '<ul class="elgg-pagination elgg-pagination-limit">';
	$limits_opts = array(10, 30, 100);
	if (!in_array($limit, $limits_opts)) $limits_opts[] = $limit;
	sort($limits_opts);

	foreach ($limits_opts as $num) {
		$url = elgg_http_add_url_query_elements($base_url, array('limit' => $num));
		if ($limit == $num) {
			echo '<li class="elgg-state-selected"><span>' . $num . '</span></li>';
		} else {
			echo '<li>' . elgg_view('output/url', array('href'=>$url, 'text'=>$num, 'is_trusted' => true)) . '</li>';
		}
	}
	echo '<li class="elgg-state-disabled">' . elgg_echo('esope:advanced_pagination:perpage') . '</li>';
	echo '</ul>';
}

