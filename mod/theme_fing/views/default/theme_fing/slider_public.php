<?php
global $CONFIG;

$slidercontent = elgg_get_plugin_setting('content', 'slider');

if (!empty($slidercontent)) {
	// Si on a un <ul> ou <ol> au début et </ul> ou </ol> à la fin de la liste
	$start_list = substr($slidercontent, 0, 4);
	if (in_array($start_list, array('<ol>', '<ul>'))) {
		$slidercontent = substr($slidercontent, 4);
		// Note : this technique avoids errors when an extra line was added after the list..
		if ($start_list == '<ul>') { $end_pos = strripos($slidercontent, '</ul>'); } else { $end_pos = strripos($slidercontent, '</ol>'); }
		if ($end_pos !== false) { $slidercontent = substr($slidercontent, 0, $end_pos); }
	}
}

// Now add content auto-loader after the configured elements
$articles = theme_fing_get_pin_entities();
foreach ($articles as $ent) {
	$title = $ent->title;
	if (empty($title)) $title = $ent->name;
	$image_url = $ent->getIconURL('large');
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$container = $ent->getContainerEntity();
		$image_url = $container->getIconURL('large');
	}
	$image = '<img src="' . $image_url . '" style="height:250px; width:auto !important;" />';
	$text = $ent->excerpt;
	if (empty($text)) $text = $ent->briefdescription;
	if (empty($text)) $text = elgg_get_excerpt($ent->description, 200);
	$text =  htmlspecialchars(html_entity_decode(strip_tags($text)));
	$excerpt = elgg_get_excerpt($text, 200);
	$slidercontent .= '<li>';
	$slidercontent .= '<div class=""><table style="width: 100%;" style="border:0;"><tbody><tr>';
	$slidercontent .= '<td style="width:60%; max-width:60%; text-align: center;">' . $image . '</td>';
	$slidercontent .= '<td style="width:40%;"><div class="textSlide"><h3><a href="' . $ent->getURL() . '">' . $title . '</a></h3><div style="font-size: 16px;">' . $excerpt . '</div></div></td>';
	$slidercontent .= '</tr></table></div></li>';
}

$vars['slidercontent'] = $slidercontent;
echo elgg_view('slider/slider', $vars);

