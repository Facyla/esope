<?php 
$widget = $vars["entity"];

if (!empty($widget->html_content)) {
	if (!empty($widget->backgroundcolor)) {
		echo '<style>
			#elgg-widget-' . $widget->guid . ' header { background: ' . $widget->backgroundcolor . '; }
			#elgg-widget-' . $widget->guid . ' .activites { background-color: ' . $widget->backgroundcolor . '; border-radius: 0 0 8px 8px; }
			#elgg-widget-' . $widget->guid . ' .elgg-widget-content { margin-top:0; }
			#elgg-widget-' . $widget->guid . ' .elgg-widget-content .elgg-output { margin-top:0; }
			#elgg-widget-' . $widget->guid . ' footer { display:none; background: ' . $widget->backgroundcolor . '; border-top:0; }
			</style>';
	}
	
	echo '<div class="elgg-output"">' . $widget->html_content . '</div>';
} else {
	echo elgg_echo("esope:widgets:freehtml:no_content");
}

