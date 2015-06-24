<?php
global $CONFIG;

$slidercontent = elgg_get_plugin_setting('content', 'slider');

// Contenu défini dans la config du slider
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
$max = 3;
$i = 0;
if ($articles) foreach ($articles as $ent) {
	$i++;
	$title = $ent->title;
	if (empty($title)) $title = $ent->name;
	// Image
	$image_url = '';
	if ($ent->icontime) { $image_url = $ent->getIconURL('large'); }
	// Forget empty or default image
	if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
		$image_url = esope_extract_first_image($ent->description, false);
	}
	// Last method if stil nothing : use author image
	if (empty($image_url)) {
		$container = $ent->getOwnerEntity();
		$image_url = $container->getIconURL('large');
	}
	$image = '<img src="' . $image_url . '" style="max-height:200px !important; width:auto !important;" />';
	// Excerpt
	$text = $ent->excerpt;
	if (empty($text)) $text = $ent->briefdescription;
	$text .= $ent->description;
	$text =  htmlspecialchars(html_entity_decode(strip_tags($text)));
	$excerpt = elgg_get_excerpt($text, 300);
	// Compose slider element
	$slidercontent .= '<li>';
	$slidercontent .= '<div class=""><table style="width: 100%;" style="border:0;"><tbody><tr>';
	$slidercontent .= '<td style="width:50%; max-width:50%; text-align: center; height: 200px; vertical-align: middle;">' . $image . '</td>';
	$slidercontent .= '<td style="width:50%;"><div class="textSlide"><h3><a href="' . $ent->getURL() . '">' . $title . '</a></h3><div style="font-size: 16px;">' . $excerpt . '</div></div></td>';
	$slidercontent .= '</tr></table></div></li>';
	//if ($i >= $max) { break; }
}

$vars['slidercontent'] = $slidercontent;
echo elgg_view('slider/slider', $vars);

