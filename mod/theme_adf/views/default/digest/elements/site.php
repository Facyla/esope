<?php
/**
 * This is a wrapper view to make the body of the site digest
 *
 * Plugins can extend this view to make some content available
 *
 * Available in $vars
 * 	$vars['user'] 		=> the current user for whom we're creating the digest
 * 	$vars['ts_lower']	=> the lower time limit of the content in this digest
 * 	$vars['ts_upper']	=> the upper time limit of the content in this digest
 * 	$vars['interval']	=> the interval of the current digest
 * 							(as defined in DIGEST_INTERVAL_DAILY, DIGEST_INTERVAL_WEEKLY, DIGEST_INTERVAL_FORTNIGHTLY, DIGEST_INTERVAL_MONTHLY)
 *
 */

/* 
 * Esope : we need to set context so we can safely rely on digest/test page to design the digest (many views are based on context)
 */
elgg_push_context('cron');
elgg_push_context('digest');

