<?php

$entity = elgg_extract("entity", $vars);
$full_view = elgg_extract("full_view", $vars, false);
$size = elgg_extract("size", $vars, false);
$align = elgg_extract("align", $vars, false);

// do we have a transitions
if (!empty($entity) && elgg_instanceof($entity, "object", "transitions")) {
	$href = elgg_extract("href", $vars, $entity->getURL());
	
	$class = array("transitions_image");
	if (isset($vars["class"])) { $class[] = $vars["class"]; }
	
	$image_params = array(
		"alt" => $entity->title,
		"class" => elgg_extract("img_class", $vars, "")
	);
	
	// does the transitions have an image
	if ($entity->icontime) {
		// which view
		if ($full_view) {
			// full view of a transitions
			if (!$size) $size = "large";
			if (!$align) $align = "right";
			
			$href = false;
			$image_params["src"] = $entity->getIconURL($size);
			$class[] = "transitions-image-" . $size;
			if ($align == "right") { $class[] = "float-alt"; } else if ($align == "left") { $class[] = "float"; }
		} else {
			// listing view of a transitions
			// set listing defaults
			if (!$size) $size = "small";
			if (!$align) $align = "right";
			
			$image_params["src"] = $entity->getIconURL($size);
			$class[] = "transitions-image-" . $size;
			if ($align == "right") { $class[] = "float-alt"; } else if ($align == "left") { $class[] = "float"; }
		}
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
}
