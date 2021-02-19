<?php

namespace Facyla\Slider;

use Elgg\DefaultPluginBootstrap;

use Menus;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function boot() {
		
	}
	
	// Fonctions à exécuter après le chargement de tous les plugins
	public function ready() {
		// Add slider shortcode for easier embedding of sliders
		if (elgg_is_active_plugin('shortcodes')) {
			elgg_load_library('elgg:shortcode');
			/**
			 * Slider shortcode
			 * [slider id="GUID"]
			 */
			function slider_shortcode_function($atts, $content='') {
				extract(elgg_shortcode_atts(array(
						'width' => '100%',
						'height' => '300px',
						'id' => '',
					), $atts));
				if (!empty($id)) {
					$slider = get_entity($id);
					if ($slider instanceof ElggSlider) {
						$content = elgg_view('slider/view', array('entity' => $slider));
					}
				}
				return $content;
			}
			elgg_add_shortcode('slider', 'slider_shortcode_function');
		}
	}
	
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		// Note : CSS we will be output directly into the view, so we can embed sliders on other sites (without the whole interface)
		elgg_extend_view('elgg.css', 'slider/main.css');
		
		// JS
		elgg_require_js('slider/edit');
		
		// Integration with shortcodes plugin
		elgg_extend_view('shortcodes/embed/extend', 'slider/extend_shortcodes_embed');
		
	}
	
	/**
	 * Register plugin hooks
	 *
	 * @return void
	 */
	protected function registerHooks() {
		$hooks = $this->elgg()->hooks;
		$hooks->registerHandler('register', 'menu:site', __NAMESPACE__ . '\Menus::siteMenu');
		//$hooks->registerHandler('prepare', 'system:email', __NAMESPACE__ . '\Email::limitSubjectLength');
	}
	
}
