<div class="contentWrapper">
	<?php
	$entity = array(
			'calendar_url' => $vars['entity']->ical_url, 
			'title' => $vars['entity']->ical_title, 
			'timeframe_before' => $vars['entity']->timeframe_before, 
			'timeframe_after' => $vars['entity']->timeframe_after, 
			'num_items' => $vars['entity']->num_items, 
		);
	echo elgg_view('ical_viewer/read', array('entity' => $entity, 'full_view' => true) );
	?>
</div>

