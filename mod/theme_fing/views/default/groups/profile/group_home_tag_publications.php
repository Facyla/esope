<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 

$group = $vars['entity'];


// Add blog-like homepage

// Liste des types de contenus republiés en home du groupe
$republication_subtypes = elgg_get_plugin_setting('republication_subtypes', 'theme_fing');
if ($republication_subtypes) {
	$subtypes = esope_get_input_array($republication_subtypes);
} else {
	$subtypes = array('page', 'page_top', 'blog', 'groupforumtopic');
}
if (empty($subtypes)) continue;

$group_content = elgg_get_entities(array('types' => 'object', 'subtypes' => $subtypes, 'container_guid' => $group->guid));
// Sort by GUID so we can check doubles
foreach ($group_content as $ent) { $publications[$ent->guid] = $ent; }

$group_tags = $group->getTags();
if ($group_tags) {
	$tag_prefix = 'fing_';
	// Optionnaly filter tags by prefix
	if ($tag_prefix) {
		$tag_prefix_len = strlen($tag_prefix);
		$repub_tags = array();
		foreach($group_tags as $key => $tag) {
			if (substr($tag, 0, $tag_prefix_len) == $tag_prefix) { $repub_tags[] = $tag; }
		}
	} else { $repub_tags = $group_tags; }
	// Find republished articles
	if ($repub_tags) {
		$group_similar = elgg_get_entities_from_metadata(array('types' => 'object', 'subtypes' => $subtypes, 'metadata_names' => 'tags', 'metadata_values' => $repub_tags));
		// Sort by GUID so we can check doubles
		foreach ($group_similar as $ent) { $publications[$ent->guid] = $ent; }
	}
	
}

if ($publications) {
	// Sort by creation date, in reverse order (latest first)
	usort($publications, create_function('$a,$b', 'return strcmp($b->time_created,$a->time_created);'));
	$count = count($publications);
	$offset = get_input('offset', 0);
	$limit = get_input('limit', 5);
	$publications = array_slice($publications, $offset, $limit, true);
	foreach ($publications as $guid => $ent) {
		echo '<br />';
		//echo '<span style="float:right;">' . elgg_view('socialshare/entity_menu_extend', array('entity' => $ent)) . '</span>';
		echo elgg_view_menu('entity', array('entity' => $ent, 'class' => 'elgg-menu-hz'));
		echo '<h2><a href="' . $ent->getURL() . '">' . $ent->title . '</a></h2>';
		// Article republié : on indique d'où il vient
		if ($ent->container_guid != $group->guid) {
			$container = get_entity($ent->container_guid);
			echo '<div class="elgg-output-container">' . elgg_echo('esope:container:publishedin') . '&nbsp;: <a href="' . $container->getURL() . '">' . $container->name . '</a></div>';
		}
		echo elgg_view('output/longtext', array('value' => $ent->description));
		// Commentaires
		echo elgg_view('comments/public_notice');
		echo '<div class="clearfloat"></div><br />';
		echo '<hr /><br />';
	}
	// Add pagination
	echo elgg_view('navigation/pagination', array(
		'base_url' => $group->getURL(),
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
		'offset_key' => 'offset',
	));
}

// Render group content
//echo elgg_view_entity_list($publications, array('full_view' => true, 'count' => $count, 'limit' => $limit));


