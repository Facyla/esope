<?php

/**
 * The purpose of this central config file is configuring all examples
 * in one place with minimal work for your working environment
 * Just configure all the items in this config according to your environment
 * and rename the file to config.php
 *
 * PHP Version 5
 *
 * @file     config.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */

//$phpcas_path = '../../source/';


///////////////////////////////////////
// Basic Config of the phpCAS client //
///////////////////////////////////////

// Full Hostname of your CAS Server
//$cas_host = 'cas.example.com';
$cas_host = elgg_get_plugin_setting('cas_host', 'elgg_cas');

// Context of the CAS Server
//$cas_context = '/cas';
$cas_context = elgg_get_plugin_setting('cas_context', 'elgg_cas', '/cas');

// Port of your CAS server. Normally for a https server it's 443
//$cas_port = 443;
$cas_port = (int) elgg_get_plugin_setting('cas_port', 'elgg_cas', 443);

// Path to the ca chain that issued the cas server certificate
//$cas_server_ca_cert_path = '/path/to/cachain.pem';
$cas_server_ca_cert_path = elgg_get_plugin_setting('ca_cert_path', 'elgg_cas');

//////////////////////////////////////////
// Advanced Config for special purposes //
//////////////////////////////////////////

// The "real" hosts of clustered cas server that send SAML logout messages
// Assumes the cas server is load balanced across multiple hosts
//$cas_real_hosts = array('cas-real-1.example.com', 'cas-real-2.example.com');
$cas_real_hosts = elgg_get_plugin_setting('cas_real_hosts', 'elgg_cas', array());

// Database config for PGT Storage
//$db = 'pgsql:host=localhost;dbname=phpcas';
$db = elgg_get_plugin_setting('cas_db', 'elgg_cas', 'pgsql:host=localhost;dbname=phpcas');

//$db = 'mysql:host=localhost;dbname=phpcas';
//$db_user = 'phpcasuser';
$db_user = elgg_get_plugin_setting('cas_db_user', 'elgg_cas', 'phpcasuser');
//$db_password = 'mysupersecretpass';
$db_password = elgg_get_plugin_setting('cas_db_password', 'elgg_cas', 'mysupersecretpass');
//$db_table = 'phpcastabel';
$db_table = elgg_get_plugin_setting('cas_db_table', 'elgg_cas', 'phpcastabel');
//$driver_options = '';
$driver_options = elgg_get_plugin_setting('cas_driver_options', 'elgg_cas', '');

///////////////////////////////////////////
// End Configuration -- Don't edit below //
///////////////////////////////////////////

// Generating the URLS for the local cas example services for proxy testing
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	$curbase = 'https://' . $_SERVER['SERVER_NAME'];
} else {
	$curbase = 'http://' . $_SERVER['SERVER_NAME'];
}
if ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) {
	$curbase .= ':' . $_SERVER['SERVER_PORT'];
}

$curdir = dirname($_SERVER['REQUEST_URI']) . "/";

// CAS client nodes for rebroadcasting pgtIou/pgtId and logoutRequest
//$rebroadcast_node_1 = 'http://cas-client-1.example.com';
$rebroadcast_node_1 = elgg_get_plugin_setting('rebroadcast_node_1', 'elgg_cas', 'http://cas-client-1.example.com');
//$rebroadcast_node_2 = 'http://cas-client-2.example.com';
$rebroadcast_node_2 = elgg_get_plugin_setting('rebroadcast_node_2', 'elgg_cas', 'http://cas-client-2.example.com');

// access to a single service
//$serviceUrl = $curbase . $curdir . 'example_service.php';
$serviceUrl = $curbase . $curdir . elgg_get_plugin_setting('serviceUrl', 'elgg_cas', 'example_service.php');
// access to a second service
//$serviceUrl2 = $curbase . $curdir . 'example_service_that_proxies.php';
$serviceUrl2 = $curbase . $curdir . elgg_get_plugin_setting('serviceUrl2', 'elgg_cas', 'example_service_that_proxies.php');

$pgtBase = preg_quote(preg_replace('/^http:/', 'https:', $curbase . $curdir), '/');
$pgtUrlRegexp = '/^' . $pgtBase . '.*$/';

$cas_url = 'https://' . $cas_host;
if ($cas_port != '443') {
	$cas_url = $cas_url . ':' . $cas_port;
}
$cas_url = $cas_url . $cas_context;

// Set the session-name to be unique to the current script so that the client script
// doesn't share its session with a proxied script.
// This is just useful when running the example code, but not normally.
/*
session_name(
    'session_for:'
    . preg_replace('/[^a-z0-9-]/i', '_', basename($_SERVER['SCRIPT_NAME']))
);
*/
// Set an UTF-8 encoding header for internation characters (User attributes)
header('Content-Type: text/html; charset=utf-8');

