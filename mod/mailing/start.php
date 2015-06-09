<?php
/**
 * Elgg mailing plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright (cc) Facyla 2010-2014
 * @link http://id.facyla.net/
 * Description : sends mails to any valid mail address. HTML message content, reply-to etc.
 */

elgg_register_event_handler('init','system','mailing_init');


function mailing_init() {
	global $CONFIG;
	elgg_register_action("mailing/send", $CONFIG->pluginspath . "mailing/actions/mailing/send.php", false);
	
	if (elgg_get_context() == 'admin' && elgg_is_admin_logged_in()) {
		$menu_item = ElggMenuItem::factory(array(
				'name' => 'mailing-mailing',
				'text' => elgg_echo('mailing:menu:title'),
				'href' => $CONFIG->url . "mod/mailing/mailing.php",
			));
			elgg_register_menu_item('page', $menu_item);
	}
	
	elgg_register_page_handler("mailing", "mailing_page_handler");
	
}

function mailing_page_handler($page){
	
	switch($page[0]){
		case "mailing":
		default:
			include(dirname(__FILE__) . '/pages/mailing/mailing.php');
			break;
	}
	
	return true;
}


