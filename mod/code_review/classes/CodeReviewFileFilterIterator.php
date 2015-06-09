<?php
class CodeReviewFileFilterIterator extends FilterIterator {

	/**
	 * @var string
	 */
	private $basePath;

	/**
	 * @param Iterator         $iterator
	 * @param string           $basePath
	 * @param CodeReviewConfig $config
	 * @throws CodeReview_IOException
	 */
	public function __construct($iterator, $basePath, CodeReviewConfig $config) {
		if (!is_dir($basePath)) {
			throw new CodeReview_IOException("Directory $basePath does not exists");
		}
		$basePath = rtrim($basePath, '/\\') . '/';
		$this->basePath = $basePath;

		if ($config->isSkipInactivePluginsEnabled()) {
			$pluginsDirs = $config->getPluginIds(CodeReviewConfig::T_PLUGINS_INACTIVE);
			foreach ($pluginsDirs as $pluginDir) {
				$this->blacklist[] = 'mod/' . $pluginDir . '/.*';
			}
// 			var_dump($this->blacklist);
		}
		
		parent::__construct($iterator);
	}
	
	protected $blacklist = array(
		'\..*',
		'engine/lib/upgrades/.*',
//		'engine/lib/deprecated.*',
		'engine/tests/.*',
		'cache/.*',
		'documentation/.*',
		'vendor/.*',//composer default dir
		'vendors/.*',
	);

	public function accept () {
		//TODO blacklisting documentation, disabled plugins and installation script
		$file = $this->current();
		if ($file instanceof SplFileInfo) {
			$path = $file->getPathname();
			$path = str_replace('\\', '/', $path);
			$path = str_replace('//', '/', $path);
			$path = substr($path, strlen($this->basePath));
			foreach ($this->blacklist as $pattern) {
				if (preg_match("#^$pattern$#", $path)) {
					return false;
				}
			}
			return true;
		}
		return false;
	}
}