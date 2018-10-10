<?php
// Slider automatique : contenu issu d'une liste d'entités
$height = elgg_extract('height', $vars, '250px'); // CSS value
$width = elgg_extract('width', $vars, '100%'); // CSS value
$max = elgg_extract('max', $vars, '6'); // max number of entity slides
// Both data sources can be used
$html_content = elgg_extract('html_content', $vars, ''); // HTML content (HTML list)
$entities = elgg_extract('entities', $vars, ''); // Entities for slider population (ElggEntity array)
// default content (not used - rather don't display anything than demo data)
$default_content = elgg_get_plugin_setting('content', 'slider');
$max = 20;

$content = '';

// Slider "manuel" : liste HTML (doit commencer par <ul> ou <ol>)
if (!empty($html_content)) {
	// Si on a un <ul> ou <ol> au début et </ul> ou </ol> à la fin de la liste
	//$start_pos = stripos($html_content, '</ul>');
	$start_list = substr($content, 0, 4);
	if (in_array($start_list, array('<ol>', '<ul>'))) {
		$html_content = substr($html_content, 4);
		// Note : this technique avoids errors when an extra line was added after the list..
		if ($start_list == '<ul>') { $end_pos = strripos($html_content, '</ul>'); } else { $end_pos = strripos($html_content, '</ol>'); }
		if ($end_pos !== false) { $html_content = substr($html_content, 0, $end_pos); }
	}
}


// Auto-slider from defined elements
$i = 0;
if ($entities) foreach ($entities as $ent) {
	$i++;
	
	//$access_info = elgg_view('output/access', array('entity' => $ent));
	$owner = $ent->getOwnerEntity();
	$container = $ent->getContainerEntity();
	
	// Content title (or name)
	$title = $ent->title;
	if (empty($title)) { $title = $ent->name; }
	if (!empty($title)) {
		$title = elgg_view('output/url', ['text' => $title, 'href' => $ent->getURL()]);
	}
	
	// Illustration - Get best suitable image
	$image_url = '';
	if ($ent->icontime) { $image_url = $ent->getIconURL('large'); }
	// Forget empty or default image
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$image_url = esope_extract_first_image($ent->description, false);
	}
	// If no image found : use author image
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$image_url = $owner->getIconURL('large');
	}
	// Last option : use container image
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$image_url = $container->getIconURL('large');
	}
	// Default image or none ?  rather none by now
	//$image = '<img src="' . $image_url . '" style="max-height: ' . $height . ' !important; width:auto !important; flex: 0 0 auto;" />';
	//$image = '<img src="' . $image_url . '" style="max-height: ' . $height . ' !important; width:auto !important;" />'; // not flex
	$image = '';
	if (!empty($image_url)) {
		$image = '<img src="' . $image_url . '" style="margin:auto; max-height: ' . $height . ' !important; width:auto !important;" />'; // flex
		$image = elgg_view('output/url', ['text' => $image, 'href' => $ent->getURL()]);
	}
	
	// Excerpt
	$text = $ent->excerpt;
	if (empty($text)) { $text = $ent->briefdescription; }
	$text .= $ent->description;
	$text =  htmlspecialchars(html_entity_decode(strip_tags($text)), ENT_NOQUOTES, 'UTF-8');
	$excerpt = elgg_get_excerpt($text, 300);
	
	// Some basic meta : date, container, author, num comments...
	$meta = '';
	$container_info = '';
	$group_icon = '';
	if (elgg_instanceof($container, 'group')) {
		$group_icon = '<img src="' . $container->getIconURL('topbar') . '" />';
		$container_info .= elgg_view('output/url', array(
					'text' => $group_icon . '&nbsp;' . elgg_get_excerpt($container->name),
					'title' => $container->name,
					'href' => $container->getURL(),
				));
	}
	//if (!empty($access_info)) { $meta .= $access_info . ' &nbsp; '; }
	if (!empty($container_info)) { $meta .= $container_info . ' &nbsp; '; }
	$meta .= elgg_get_friendly_time($ent->time_updated);
	
	
	// Compose slider element
	/*
	$content .= '<li>';
	//$content .= '<div class="" style="display: flex;">';
	$content .= '<div class="">';
	$content .= '<table style="width: 100%;" style="border:0;"><tbody><tr>';
	$content .= '<td style="text-align: center; vertical-align: middle;">' . $image . '</td>';
	$content .= '<td style="width: auto;"><div class="textSlide"><h3><a href="' . $ent->getURL() . '">' . $title . '</a></h3><div style="font-size: 16px;">' . $excerpt . '</div></div></td>';
	$content .= '</tr></table>';
	$content .= '</div></li>';
	*/
	
	$content .= '<li>';
		$content .= '<div style="display: flex; height: 100%;">';
			$content .= '<div class="imageSlide" style="flex: 0 0 auto; display: flex; min-width: ' . $height . '">' . $image . '</div>';
			$content .= '<div class="textSlide" style="flex: 1 1 auto; display: flex; flex-direction: column;">
				<h3 style="flex: 0 0 auto;">' . $title . '</h3>
				<div style="font-size: 1.25rem; flex: 1 1 auto;">' . $excerpt . '</div>
				<div style="margin-bottom: 0; padding-top: 1rem; flex: 0 0 auto; text-align: right;">' . $meta . '</div>
			</div>';
		$content .= '</div>';
	$content .= '</li>';
	
	if ($i >= $max) { break; }
}


// Display slider
echo '<div style="width: ' . $width . '; height: ' . $height . ';">';
echo elgg_view('slider/slider', [
	'slidercontent' => $content,
	'width' => "$width",
	'height' => "$height",
]);
echo '</div>';


