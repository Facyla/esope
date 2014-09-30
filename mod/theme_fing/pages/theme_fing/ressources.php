<?php
/**
 * Create a new page
 *
 * @package ElggPages
 */

$group_guid = strtolower(get_input('group_guid'));

$title = elgg_echo('theme_fing:ressources');
$content = '';
$sidebar = '';

//elgg_pop_breadcrumb();
//elgg_push_breadcrumb($title);


// Add custom intro block
$content .= elgg_view('cmspages/view', array('pagetype' => "group-ressources-$group_guid"));
$content .= '<div class="clearfloat"></div>';

// Get and list ressources
if ($group = get_entity($group_guid)) {
	elgg_set_page_owner_guid($group_guid);
	
	$subtypes = array();
	$comments_subtypes = array();
	
	// MAIN PAGE
	if ($group->pages_enable == 'yes') {
		$comments_subtypes[] = 'page_top';
		$comments_subtypes[] = 'page';
		$pages_content = '<h3>' . elgg_echo('pages') . '</h3>' . elgg_view('theme_fing/pages_summary');
	}
	
	if ($group->bookmarks_enable == 'yes') {
		$subtypes[] = 'bookmarks';
		$comments_subtypes[] = 'bookmarks';
	}
	if ($group->file_enable == 'yes') {
		$subtypes[] = 'file';
		$comments_subtypes[] = 'file';
	}
	// List ressources (files and bookmarks)
	if (!empty($subtypes)) {
		$params = array('types' => 'object', 'subtypes' => $subtypes, 'container_guid' => $group->guid, 'limit' => 0);
		$ressources = elgg_get_entities($params);
		$ressources_content = '';
		foreach ($ressources as $ent) {
			$excerpt = $ent->excerpt;
			if (empty($excerpt)) $excerpt = elgg_get_excerpt($ent->description, 250);
			$ressources_content .= '<div style="clear:both; margin:1ex 0 2ex 0;"><a href="' . $ent->getURL() . '">' . $ent->title . '</a> (' . elgg_echo('esope:subtype:'.$ent->getSubtype()) . ') ';
			//$ressources_content .= elgg_get_friendly_time($ent->time_created);
			$ressources_content .= '<span style="float:right; margin-left:2ex;">' . elgg_view('output/access', array('entity' => $ent)) . '</span>';
			//$ressources_content .= '<br />' . $excerpt;
			$ressources_content .= '<div class="clearfloat"></div></div>';
		}
	}
	
	
	// Compose main page content
	if ($pages_content && $ressources_content) {
		$content .= '<div style="width:66%; float:left;">' . $ressources_content . '</div><div style="width:30%; float:right;">' . $pages_content . '</div>';
	} else if ($pages_content) {
		$content .= $pages_content;
	} else if ($ressources_content) {
		$content .= $ressources_content;
	}
	
	
	// SIDEBAR
	// Add latest comments in sidebar
	$options = array(
		"list_class" => "elgg-list-river elgg-river",
		"pagination" => false,
		'action_types' => 'comment',
		'limit' => 4,
		'container_guid' => $group->guid,
		'subtypes' => $comments_subtypes,
	);
	$sidebar .= '<h3>' . elgg_echo('comments') . '</h3>' . elgg_list_river($options);
} else forward(REFERER);


$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
));

echo elgg_view_page($title, $body);

