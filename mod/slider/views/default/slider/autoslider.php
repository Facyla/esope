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
	
	$title = $ent->title;
	// Get best suitable image
	$image_url = '';
	if ($ent->icontime) { $image_url = $ent->getIconURL('large'); }
	// Forget empty or default image
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$image_url = esope_extract_first_image($ent->description, false);
	}
	// Last method if no image found : use author image
	if (empty($image_url)) {
		$container = $ent->getOwnerEntity();
		$image_url = $container->getIconURL('large');
	}
	//$image = '<img src="' . $image_url . '" style="max-height: ' . $height . ' !important; width:auto !important; flex: 0 0 auto;" />';
	$image = '<img src="' . $image_url . '" style="max-height: ' . $height . ' !important; width:auto !important;" />'; // not flex
	$image = '<img src="' . $image_url . '" style="margin:auto; max-height: ' . $height . ' !important; width:auto !important;" />'; // flex
	
	// Excerpt
	$text = $ent->excerpt;
	if (empty($text)) $text = $ent->briefdescription;
	$text .= $ent->description;
	$text =  htmlspecialchars(html_entity_decode(strip_tags($text)), ENT_NOQUOTES, 'UTF-8');
	$excerpt = elgg_get_excerpt($text, 300);
	
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
	
	/*
	*/
	$content .= '<li>';
	$content .= '<div style="display: flex;">';
	$content .= '<div class="imageSlide" style="flex: 0 0 auto; display: flex; min-width: ' . $height . '">' . $image . '</div>';
	$content .= '<div class="textSlide" style="flex: 1 1 auto;"><h3><a href="' . $ent->getURL() . '">' . $title . '</a></h3><div style="font-size: 1.25rem;">' . $excerpt . '</div></div>';
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


