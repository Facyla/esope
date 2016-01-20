<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Load Elgg engine
require_once(elgg_get_root_path() . "/engine/start.php");

// How long does a classifieds live
$market_expire = elgg_get_plugin_setting('market_expire', 'market');

echo "<br><h3>" . elgg_echo('market:terms:title') . "</h3>";
echo "<ul>" . elgg_echo('market:terms', array($market_expire)) . "</ul>";
echo "<br>";
?>

