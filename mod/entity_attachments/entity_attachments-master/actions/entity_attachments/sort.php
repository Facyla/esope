<?php

$order = get_input('order');
if (empty($order)) {
	return;
}

$new_order = 1;
foreach ($order as $guid) {
	$attachment = get_entity($guid);
	if (!$attachment instanceof \EntityAttachment) {
		continue;
	}
	
	if (!$attachment->canEdit()) {
		continue;
	}
	
	$attachment->order = $new_order;
	$new_order++;
}
