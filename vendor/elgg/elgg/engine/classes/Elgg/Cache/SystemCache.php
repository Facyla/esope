<?php

namespace Elgg\Cache;

use Elgg\Config;
use Elgg\Traits\Cacheable;

/**
 * System Cache
 *
 * @internal
 * @since 1.10.0
 */
class SystemCache {

	use Cacheable;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param BaseCache $cache  Elgg disk cache
	 * @param Config    $config Elgg config
	 */
	public function __construct(BaseCache $cache, Config $config) {
		$this->cache = $cache;
		$this->config = $config;
	}

	/**
	 * Reset the system cache by deleting the caches
	 *
	 * @return void
	 */
	public function reset() {
		$this->cache->clear();
	}
	
	/**
	 * Saves a system cache.
	 *
	 * @param string $type         The type or identifier of the cache
	 * @param mixed  $data         The data to be saved
	 * @param int    $expire_after Number of seconds to expire the cache after
	 *
	 * @return bool
	 */
	public function save(string $type, $data, int $expire_after = null): bool {
		if ($this->isEnabled()) {
			return $this->cache->save($type, $data, $expire_after);
		}

		return false;
	}
	
	/**
	 * Retrieve the contents of a system cache.
	 *
	 * @param string $type The type of cache to load
	 *
	 * @return mixed null if key not found in cache
	 */
	public function load(string $type) {
		if (!$this->isEnabled()) {
			return;
		}
		
		$cached_data = $this->cache->load($type);
		if (isset($cached_data)) {
			return $cached_data;
		}
	}
	
	/**
	 * Deletes the contents of a system cache.
	 *
	 * @param string $type The type of cache to delete
	 * @return bool
	 */
	public function delete(string $type) {
		return $this->cache->delete($type);
	}
	
	/**
	 * Is system cache enabled
	 *
	 * @return bool
	 */
	public function isEnabled() {
		return (bool) $this->config->system_cache_enabled;
	}
	
	/**
	 * Enables the system disk cache.
	 *
	 * Uses the 'system_cache_enabled' config with a boolean value.
	 * Resets the system cache.
	 *
	 * @return void
	 */
	public function enable() {
		$this->config->save('system_cache_enabled', 1);
		$this->reset();
	}
	
	/**
	 * Disables the system disk cache.
	 *
	 * Uses the 'system_cache_enabled' config with a boolean value.
	 * Resets the system cache.
	 *
	 * @return void
	 */
	public function disable() {
		$this->config->save('system_cache_enabled', 0);
		$this->reset();
	}
	
	/**
	 * Initializes the system cache
	 *
	 * @return void
	 */
	public function init() {
		if (!$this->isEnabled()) {
			return;
		}

		// cache system data if enabled and not loaded
		if (!$this->config->system_cache_loaded) {
			_elgg_services()->views->cacheConfiguration(_elgg_services()->serverCache);
		}
	}
}
