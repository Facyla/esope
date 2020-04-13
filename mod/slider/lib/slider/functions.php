<?php


/* Populates the ->getUrl() method for slider objects */
function slider_url(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$entity = $hook->getParam('entity');
	if ($entity instanceof ElggSlider) {
		return elgg_get_site_url() . 'slider/view/' . $entity->guid;
	}
}


/* Gets a slider by its name, allowing theming on different instances
 * In case several sliders are found, only first match is displayed with an alert
 */
function slider_get_entity_by_name($name = '') {
	if (!empty($name)) {
		// Check first by GUID
		$slider = get_entity($name);
		if ($slider instanceof ElggSlider) { return $slider; }
		
		// Alternate method #2 by slider name
		$sliders = elgg_get_entities_from_metadata(array(
				'types' => 'object', 'subtypes' => 'slider', 
				'metadata_name_value_pairs' => array('name' => 'name', 'value' => $name), 
			));
		if ($sliders) {
			if (count($sliders) == 1) {
				return $sliders[0];
			} else {
				register_error(elgg_echo('slider:error:multiple'));
			}
		}
	}
	return false;
}

/* Checks if a given name is already used by a slider */
function slider_exists($name = '') {
	$ia = elgg_set_ignore_access(true);
	if (!empty($name)) {
		$slider = slider_get_entity_by_name($name);
		if ($slider instanceof ElggSlider) {
			elgg_set_ignore_access($ia);
			return true;
		}
	}
	elgg_set_ignore_access($ia);
	return false;
}


// Use unique ID to allow multiple sliders into a single page..
function slider_unique_id($base = 'slider-uid-') {
	global $sliderUniqueID;
	if (!isset($sliderUniqueID)) { $sliderUniqueID = 0; }
	$sliderUniqueID++;
	return $base . $sliderUniqueID;
}

