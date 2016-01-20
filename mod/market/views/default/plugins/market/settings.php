<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Translations
$yes = elgg_echo('option:yes');
$no = elgg_echo('option:no');

// Get settings
$customchoices = $vars['entity']->market_custom_choices;
$marketcategories = $vars['entity']->market_categories;

echo "<hr>";
echo '<table class="elgg-table-alt">';
echo '<tr><th>' . elgg_echo('market:settings:status') . '</th>';
echo '<th>' . elgg_echo('market:settings:desc') . '</th></tr>';
echo "<tr><td>";
echo elgg_view('input/dropdown', array(
                        'name' => 'params[market_max]',
                        'value' => $vars['entity']->market_max,
                        'options_values' => array(
						'0' => elgg_echo('market:unlimited'),
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'10' => '10',
						'20' => '20',
						'30' => '30',
						),
			));

echo "</td><td>" . elgg_echo('market:max:posts') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/dropdown', array(
			'name' => 'params[market_adminonly]',
			'value' => $vars['entity']->market_adminonly,
			'options_values' => array(
						'no' => $no,
						'yes' => $yes
						)
			));
echo "</td><td>" . elgg_echo('market:adminonly') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/text', array(
			'name' => 'params[market_currency]',
			'class' => 'market-admin-input',
			'value' => $vars['entity']->market_currency,
			));
echo "</td><td>" . elgg_echo('market:currency') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/dropdown', array(
			'name' => 'params[market_allowhtml]',
			'value' => $vars['entity']->market_allowhtml,
			'options_values' => array(
						'no' => $no,
						'yes' => $yes
						)
			));
echo "</td><td>" . elgg_echo('market:allowhtml') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/text', array(
			'name' => 'params[market_numchars]',
			'class' => 'market-admin-input',
			'value' => $vars['entity']->market_numchars,
			));
echo "</td><td>" . elgg_echo('market:numchars') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/dropdown', array(
			'name' => 'params[market_pmbutton]',
			'value' => $vars['entity']->market_pmbutton,
			'options_values' => array(
						'no' => $no,
						'yes' => $yes
						)
			));
echo "</td><td>" . elgg_echo('market:pmbutton') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/dropdown', array(
			'name' => 'params[location]',
			'value' => $vars['entity']->location,
			'options_values' => array(
						'no' => $no,
						'yes' => $yes
						)
			));
echo "</td><td>" . elgg_echo('market:location:field') . "</td></tr>";

echo "<tr><td>";
echo elgg_view('input/dropdown', array(
			'name' => 'params[market_comments]',
			'value' => $vars['entity']->market_comments,
			'options_values' => array(
						'no' => $no,
						'yes' => $yes
						)
			));
echo "</td><td>" . elgg_echo('market:comments') . "</td></tr>";

echo "<tr><td>";
$month = elgg_echo('market:expire:month');
$months = elgg_echo('market:expire:months');
echo elgg_view('input/dropdown', array(
			'name' => 'params[market_expire]',
			'value' => $vars['entity']->market_expire,
                        'options_values' => array(
						'0' => elgg_echo('market:unlimited'),
						'1' => "1 $month",
						'2' => "2 $months",
						'3' => "3 $months",
						'4' => "4 $months",
						'5' => "5 $months",
						'10' => "10 $months",
						'12' => "12 $months",
						),
			));
echo "</td><td>" . elgg_echo('market:expire') . "</td></tr>";

echo "</table>";

echo "<br><br>";

echo "<h3>" . elgg_echo('market:categories') . "</h3><hr>";

	echo elgg_echo('market:categories:explanation');
	echo "<br><br>";
	echo elgg_echo('market:categories:settings:categories');
	echo elgg_view('input/tags',array('value' => $marketcategories, 'name' => 'params[market_categories]'));

echo "<br><br>";

echo "<h3>" . elgg_echo('market:custom') . "</h3><hr>";

echo elgg_echo('market:custom:activate');
echo elgg_view('input/dropdown', array(
			'name' => 'params[market_custom]',
			'value' => $vars['entity']->market_custom,
			'options_values' => array(
						'no' => $no,
						'yes' => $yes
						)
			));
echo "<br><br>";
echo elgg_echo('market:custom:choices');
echo "<br><br>";
echo elgg_echo('market:custom:settings');
echo elgg_view('input/tags',array('value' => $customchoices, 'name' => 'params[market_custom_choices]'));

