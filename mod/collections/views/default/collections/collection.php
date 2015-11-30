<?php

// Param vars
$collectioncontent = $vars['collectioncontent']; // Complete content - except the first-level <ul> tag (we could use an array instead..)
$collectionparams = $vars['collectionparams']; // JS additional parameters
$collectioncss_main = $vars['collectioncss_main']; // CSS for main ul tag
$collectioncss_textslide = $vars['collectioncss_textslide']; // CSS for li .textslide
$height = $vars['height']; // Slider container height
$width = $vars['width']; // Slider container width
$container_style = '';
if ($height) $container_style .= "height:$height; ";
if ($width) $container_style .= "width:$width; ";

if (empty($collectioncss_main)) { $collectioncss_main = elgg_get_plugin_setting('css_main', 'collection'); }
if (empty($collectioncss_textslide)) { $collectioncss_textslide = elgg_get_plugin_setting('css_textslide', 'collection'); }

if (empty($collectioncontent)) { $collectioncontent = elgg_get_plugin_setting('content', 'collection'); }
if (!empty($collectioncontent)) {
	// Si on a un <ul> ou <ol> au début et </ul> ou </ol> à la fin de la liste
	if (in_array(substr($collectioncontent, 0, 4), array('<ol>', '<ul>'))) {
		$collectioncontent = substr($collectioncontent, 4);
		// Note : this technique avoids errors when an extra line was added after the list..
		if ($start_list == '<ul>') { $end_pos = strripos($collectioncontent, '</ul>'); } else { $end_pos = strripos($collectioncontent, '</ol>'); }
		if ($end_pos !== false) { $collectioncontent = substr($collectioncontent, 0, $end_pos); }
	}
	/*
	if (in_array(substr($collectioncontent, -5), array('</ol>', '</ul>'))) {
		$collectioncontent = substr($collectioncontent, 0, -5);
	}
	*/
}

?>



<ul id="collection<?php echo $anythingSliderUniqueID; ?>" style="<?php echo $container_style; ?>">
	<?php echo $collectioncontent; ?>
</ul>


