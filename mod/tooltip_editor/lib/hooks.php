<?php

function tooltip_editor_menu_modify($hook, $type, $return, $params) {
	
	// because we called in on the 'all' supertype we need to make sure we're only affecting
	// menu hooks
	if (strpos($type, 'menu:') !== 0) {
		return $return;
	}
	
	if ($return && is_array($return)) {
		
		// get our defaults
		$defaults = array(
			'positionmy' => elgg_get_plugin_setting('positionmy', 'tooltip_editor'),
			'positionat' => elgg_get_plugin_setting('positinat', 'tooltip_editor'),
			'persistent' => elgg_get_plugin_setting('persistent', 'tooltip_editor'),
			'delay' => elgg_get_plugin_setting('delay', 'tooltip_editor'),
			'tooltip_title' => '',
			'fontsize' => elgg_get_plugin_setting('fontsize', 'tooltip_editor')
		);
		
		foreach ($return as $key => $item) {

			// define a menu item by the item name and the menu it shows up in
			$token = md5($item->getName() . $type);
			
			$annotations = elgg_get_site_entity()->getAnnotations('tooltip-editor-' . $token);

			$params = array(); // reset each iteration
			if ($annotations) {
				$params = unserialize($annotations[0]->value);
				
				if (!is_array($params)) {
					$params = $defaults;
				}
			}
			
			$positionmy = $params['positionmy'] ? $params['positionmy'] : $defaults['positionmy'];
			$positionat = $params['positionat'] ? $params['positionat'] : $defaults['positionat'];
			$persistent = $params['persistent'] ? $params['persistent'] : $defaults['persistent'];
			$delay = (empty($params['delay']) && $params['delay'] !== '0') ? $defaults['delay'] : $params['delay'];
			$title = $params['tooltip_title'] ? $params['tooltip_title'] : $defaults['tooltip_title'];
			$fontsize = $params['fontsize'] ? $params['fontsize'] : $defaults['fontsize'];
			$content = $params['tooltip'] ? $params['tooltip'] : $item->getTooltip();
			
			if ($content) {
				// wrap the content in a div to control font size
				$content = '<div class="tooltip-editor-font-' . $fontsize . '">' . $content . '</div>';
				$content = base64_encode($content); // to prevent breaking markup if html is inside it
			}
			
			if ($title) {
				// wrap the content in a div to control font size
				$title = '<div class="tooltip-editor-font-' . $fontsize . '">' . $title . '</div>';
				$title = base64_encode($title); // to prevent breaking markup if html is inside it
			}
			
			$addon = '';
			if (tooltip_editor_can_edit()) {
				$addon = elgg_view_icon("speech-bubble", "tooltip-editor-edit tooltip-editor-token-$token");
			}
			
			// bit of logic for the persistent state
			$button = '';
			$hide = 'mouseleave';
			if ($persistent == 'yes') {
				$button = 'close';
				$hide = 'false';
			}
			
			//build tooltip options
			$tipoptions = '<span class="tooltip-editor-options"';
			$tipoptions .= ' data-position-my="' . $positionmy . '"';
			$tipoptions .= ' data-position-at="' . $positionat . '"';
			$tipoptions .= ' data-show-delay="' . $delay . '"';
			$tipoptions .= ' data-show-title="' . $title . '"';
			$tipoptions .= ' data-show-content="' . $content . '"';
			$tipoptions .= ' data-show-button="' . $button . '"';
			$tipoptions .= ' data-show-hide="' . $hide . '"';
			$tipoptions .= '></span>';
			
			$text = $item->getText();
			
			$return[$key]->setText($text . $addon . $tipoptions);
			$return[$key]->setTooltip(elgg_strip_tags($content));
		}
	}
	
	return $return;
}