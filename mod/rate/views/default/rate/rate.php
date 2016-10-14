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

$entity = elgg_extract('entity', $vars, FALSE);
if ($entity) {
	if (!elgg_in_context('listing') && !elgg_in_context('search') && !elgg_in_context('widgets')) {
		echo rate_show_rating($entity);
	}
}

