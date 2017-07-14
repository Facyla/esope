<?php
/**
 * File renderer.
 *
 * @package ElggFile
 */

$full = elgg_extract('full_view', $vars, FALSE);
$file = elgg_extract('entity', $vars, FALSE);

if (!$file) { return TRUE; }

$page_owner = elgg_get_page_owner_entity();

$owner = $file->getOwnerEntity();
$container = $file->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = elgg_get_excerpt($file->description);
$mime = $file->mimetype;
$base_type = substr($mime, 0, strpos($mime,'/'));

if ($size = $file->getSize()) { $filesize = '<span class="file-size">' . esope_friendly_size($size, 2) . '</span>'; }
$mimetype = '<span class="file-mimetype">' . $file->getMimeType() . '</span>';
$filename = '<span class="file-filename">' . $file->originalfilename . '</span>';
$simpletype = '<span class="file-simpletype">' . $file->simpletype . '</span>';
$extension = '<span class="file-extension">' . pathinfo($file->originalfilename)['extension'] . '</span>';
$file_meta = '<p class="file-meta">';
$file_meta .= $filename;
$file_meta .= $filesize;
$file_meta .= $extension;
$file_meta .= $simpletype;
$file_meta .= $mimetype;
$file_meta .= '</p>';

$owner_link = elgg_view('output/url', array(
	'href' => "file/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

//$file_icon = elgg_view_entity_icon($file, 'small');
$file_icon = '<a href="' . elgg_get_site_url() . 'file/download/' . $file->guid . '" title="' . elgg_echo('file:download') . '" target="_blank"><img src="' . $file->getIconURL('small') . '" /></a>';

$date = elgg_view_friendly_time($file->time_created);

$comments_count = $file->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $file->getURL() . '#file-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'file',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) { $metadata = ''; }


if ($full && !elgg_in_context('gallery')) {
	$extra = '';
	if (elgg_view_exists("file/specialcontent/$mime")) {
		$extra = elgg_view("file/specialcontent/$mime", $vars);
	} else if (elgg_view_exists("file/specialcontent/$base_type/default")) {
		$extra = elgg_view("file/specialcontent/$base_type/default", $vars);
	}

	$params = array(
		'entity' => $file,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	//$text = elgg_view('output/longtext', array('value' => $file->description));
	if (!empty($file->description)) { $text = elgg_view('output/longtext', array('value' => $file->description)); }
	$body = "$text $extra";

	/*
	echo elgg_view('object/elements/full', array(
		'entity' => $file,
		'icon' => $file_icon,
		'summary' => $summary,
		'body' => $body,
	));
	*/
	$content = $body;

} elseif (elgg_in_context('gallery')) {
	
	echo '<div class="file-gallery-item">';
	echo "<h3>" . $file->title . "</h3>";
	// Pas de dowload direct dans la galerie sinon on perd tout accès à la page du fichier
	// Note : de plus cette fonction est apportée par file_tools...
	$file_icon = elgg_view_entity_icon($file, 'medium');
	//$file_icon = '<a href="' . elgg_get_site_url() . 'file/download/' . $file->guid . '" title="' . elgg_echo('file:download') . '" target="_blank"><img src="' . $file->getIconURL('medium') . '" /></a>';
	echo $file_icon;
	echo "<p class='subtitle'>$owner_link $date</p>";
	echo '</div>';
	
} else {
	
	// brief view
	if (elgg_in_context('workspace')) {
		// Icon = auteur
		$owner = $file->getOwnerEntity();
		$file_icon = '<a href="' . $owner->getURL() . '" class="elgg-avatar"><img src="' . $owner->getIconURL(array('medium')) . '" style="width:54px;" /></a>';
		$metadata_alt = '';
	} else {
	}

	$params = array(
		'entity' => $file,
		'metadata' => $metadata,
		//'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	//echo elgg_view_image_block($file_icon, $list_body);
	
	// Workspace home listing soecific content
	if (elgg_instanceof($page_owner, 'group') && elgg_in_context('workspace')) {
		$content = '';
		$file_icon = elgg_view_entity_icon($file, 'small');
		$content .= elgg_view_image_block($file_icon, $file_meta, array('class' => 'iris-object-inner'));
		$content .= $excerpt;
	} else {
		$content = $file_meta . $excerpt;
	}
	
}


echo elgg_view('page/components/iris_object', $vars + array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt));

