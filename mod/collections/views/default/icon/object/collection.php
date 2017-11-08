<?php
$entity = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);
$size = elgg_extract("size", $vars, false);
$align = elgg_extract("align", $vars, false);

// Display image only if set, and also force default image for gallery only (no image otherwise)
if ($entity && elgg_instanceof($entity, "object", "collection") && ($entity->icontime || in_array($size, array('gallery', 'master', 'listing', 'large')))) {
	
	$href = elgg_extract("href", $vars, $entity->getURL());
	
	$class = array("collection_image");
	if (isset($vars["class"])) { $class[] = $vars["class"]; }
	
	$image_params = array(
		"alt" => $entity->title,
		"class" => elgg_extract("img_class", $vars, "")
	);
	
	// which view
	if ($full_view) {
		// full view of a collection
		if (!$size) $size = "master";
		if (!$align) $align = "right";
		
		$href = false;
		$image_params["src"] = $entity->getIconURL($size);
		$class[] = "collection-image-" . $size;
		if ($align == "right") { $class[] = "float-alt"; } else if ($align == "left") { $class[] = "float"; }
	} else {
		// listing view of a collection
		// set listing defaults
		if (!$size) $size = "listing";
		if (!$align) $align = "right";
		
		$image_params["src"] = $entity->getIconURL($size);
		$class[] = "collection-image-" . $size;
		if ($align == "right") { $class[] = "float-alt"; } else if ($align == "left") { $class[] = "float"; }
	}
	
	$image = elgg_view("output/img", $image_params);
	
	echo "<div class='" . implode(" ", $class) . "'>";
	if (!empty($href)) {
		$params = array(
			"href" => $href,
			"text" => $image,
			"is_trusted" => true,
		);
		$class = elgg_extract("link_class", $vars, "");
		if ($class) { $params["class"] = $class; }
		
		echo elgg_view("output/url", $params);
	} else {
		echo $image;
	}
	
	echo "</div>";
} else {
	// Send non-empty so the Elgg function does not switch to default view
	echo ' ';
}

