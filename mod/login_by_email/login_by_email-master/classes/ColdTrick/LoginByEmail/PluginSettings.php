<?php

namespace ColdTrick\LoginByEmail;

/**
 * Adjust plugin settings
 */
class PluginSettings {
	
	/**
	 * Change plugin settings
	 *
	 * @param \Elgg\Event $event 'setting', 'plugin'
	 *
	 * @return string|null
	 */
	public function __invoke(\Elgg\Event $event): ?string {
		if ($event->getParam('plugin_id') !== 'login_by_email') {
			return null;
		}
		
		$value = $event->getValue();
		
		if ($event->getParam('name') === 'code_validity') {
			$value = (int) $value;
			
			return $value > 0 ? $value : '';
		}
		
		if (!is_array($value)) {
			return null;
		}
		
		return json_encode($value);
	}
}
