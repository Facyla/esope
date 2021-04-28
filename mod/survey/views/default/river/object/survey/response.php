<?php
/**
 * Survey river view
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
if (!$object instanceof ElggSurvey) {
	return;
}

$vars['message'] = $object->getExcerpt();

echo elgg_view('river/elements/layout', $vars);
