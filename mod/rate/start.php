<?php
/**
 *	5 STAR AJAX RATE PLUGIN
 *	@package rate
 *	@author Team Webgalli
 *	@license GNU General Public License (GPL) version 2
 *	@link http://www.webgalli.com/
 *	@Adapted from the rate plugin for Elgg
 *	 from Miguel Montes http://community.elgg.org/profile/mmontesp
 *	 http://community.elgg.org/pg/plugins/mmontesp/read/384429/rate-plugin 
 **/

elgg_register_event_handler('init', 'system', 'rate_init');

function rate_init(){
	elgg_extend_view('js/elgg', 'rate/js');
	$action_path = dirname(__FILE__)."/actions/rate";
	elgg_register_action("rate/rate", "$action_path/rate.php");
	elgg_register_action("rate/rate_wire", "$action_path/rate_wire.php");
	$subtypes = array(	'blog',
						'bookmarks',
						'file',
						'page',
						'page_top',
						'thewire');
	foreach($subtypes as $subtype){
		elgg_extend_view("object/$subtype", "rate/rate");
	}	
}

function rate_is_allowed_to_rate($entity = null){
	if (elgg_is_logged_in() && $entity){
		if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'rated', $entity->guid)) {
			return false;
		}
		return true;
	} else {
		return false;
	}
}

function rate_show_rating($entity = null){
	if($entity){
		return elgg_view_form('rate/rate', array() ,array('entity' => $entity));
	} 
}	
?>