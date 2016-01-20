<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Display an error

echo "<div>";
echo "<p>";
echo elgg_echo('market:tomany:text');
echo "</p>";
echo "<p>";
echo elgg_view('output/url', array(
			'href' => "mod/market/terms.php",
			'text' => elgg_echo('market:terms:title'),
			'class' => "elgg-lightbox",
			));
echo "</p>";
echo "</div>";
