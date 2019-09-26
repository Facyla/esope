<?php

namespace ColdTrick\EventManager;

use ColdTrick\EntityTools\Migrate;

class MigrateEvents extends Migrate {
	
	/**
	 * Add events to the supported types for EntityTools
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param mixed  $params       supplied params
	 *
	 * @return array
	 */
	public static function supportedSubtypes($hook, $type, $return_value, $params) {
		
		$return_value[\Event::SUBTYPE] = self::class;
		
		return $return_value;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \ColdTrick\EntityTools\Migrate::setSupportedOptions()
	 */
	protected function setSupportedOptions() {
		$this->supported_options = [
			'backdate' => true,
			'change_owner' => true,
			'change_container' => true,
		];
	}
}
