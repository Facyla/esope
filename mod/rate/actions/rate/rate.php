<?php
/**
 *	5 STAR AJAX RATE PLUGIN
 *	@package rate
 *	@author Team Webgalli
 *	@license GNU General Public License (GPL) version 2
 *	@link http://www.webgalli.com/
 *	@Adapted from the rate plugin for Elgg 1.7 
 *	 from Miguel Montes http://community.elgg.org/profile/mmontesp
 *	 http://community.elgg.org/pg/plugins/mmontesp/read/384429/rate-plugin 
 **/
 
	$guid = (int) get_input('guid');
	$rate = (int) get_input('rate');
	$isAjax = get_input('ajax');
	if (!$entity = get_entity($guid)){
		register_error(elgg_echo('rate:badguid'));
		forward(REFERER);
	}

	// Make sure we have a correct rate
	if ($rate && ($rate >= 1 || $rate <= 6)){
		$rate--; 
	}else{
		register_error(elgg_echo('rate:badrate'));
		forward(REFERER);
	}

	if (!rate_is_allowed_to_rate($entity)){
		register_error(elgg_echo('rate:rated'));
		forward(REFERER);
	}
	
	if ($entity->annotate('generic_rate', $rate, 2, elgg_get_logged_in_user_guid())){
		add_entity_relationship(elgg_get_logged_in_user_guid(), 'rated', $guid);
		system_message(elgg_echo('rate:saved'));
	}else{
		register_error(elgg_echo('rate:error'));
	}
	
	if($isAjax){
		echo rate_show_rating($entity);
	}	
	
	forward(REFERER);
?>