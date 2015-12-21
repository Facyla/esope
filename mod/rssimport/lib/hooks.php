<?php

namespace AU\RSSImport;

/**
 * Hourly cron
 * 
 * @param type $hook
 * @param type $entity_type
 * @param type $returnvalue
 * @param type $params
 * @return type
 */
function hourly_cron($hook, $entity_type, $returnvalue, $params) {
	cron_import('hourly');
	return $returnvalue;
}

/**
 * Daily cron
 * 
 * @param type $hook
 * @param type $entity_type
 * @param type $returnvalue
 * @param type $params
 * @return type
 */
function daily_cron($hook, $entity_type, $returnvalue, $params) {
	cron_import('daily');
	return $returnvalue;
}

/**
 * Weekly cron
 * 
 * @param type $hook
 * @param type $entity_type
 * @param type $returnvalue
 * @param type $params
 * @return type
 */
function weekly_cron($hook, $entity_type, $returnvalue, $params) {
	cron_import('weekly');
	return $returnvalue;
}

/**
 * allows write permissions when we are adding metadata to an object
 *
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return boolean|null/
 * 
 */
function permissions_check($hook, $type, $return, $params) {
	if (elgg_get_context() == 'rssimport_import') {
		return true;
	}

	if ($params['entity'] instanceof RSSImport) {
		return $params['entity']->getContainerEntity()->canEdit();
	}

	return $return;
}

/**
 * get url for an import
 * 
 * @param type $rssimport
 * @return type
 */
function rssimport_url($hook, $type, $return, $params) {
	if (!($params['entity'] instanceof RSSImport)) {
		return $return;
	}
	$rssimport = $params['entity'];
	$container = $rssimport->getContainerEntity();

	return elgg_get_site_url() . "rssimport/{$container->guid}/{$rssimport->import_into}/{$rssimport->guid}";
}


/**
 * called on the 'enqueue', 'notifications' event
 * we use this to stop rssimports from generating notifications
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 */
function prevent_notifications($hook, $type, $return, $params) {
	if ($params['object']->rssimport_id || elgg_get_context() == 'rssimport') {
		// this is an rssimport entity, we don't want to notify
		return false;
	}
	
	return $return;
}