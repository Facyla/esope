<?php
/**
 * Elgg Slider Plugin
 * @package slider
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2021
 * @link https://facyla.fr
 */

namespace Facyla\Slider;

use Elgg\Menu\MenuItems;

class Menus {
	
	// Site main menu
	public static function siteMenu(\Elgg\Hook $hook) {
		$return = $hook->getValue();
		
		$slider_access = elgg_get_plugin_setting('slider_access', 'slider');
		//if ($slider_access == 'yes') {
		if (true) {
			$return[] = \ElggMenuItem::factory([
				'name' => 'slider',
				'icon' => 'map-o',
				'text' => elgg_echo('slider:index'),
				//'href' => 'slider',
				'href' => elgg_generate_url('slider:index'),
			]);
		}
		return $return;
	}
	
}
