<?php
/**
 * Expiration Date
 *
 * @package ExpirationDate
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Brett Profitt 2008-2015
 * @link http://eschoolconsultants.com
 *
 * (c) iionly 2012-2015 for Elgg 1.8 onwards
 */

$period = elgg_get_plugin_setting('period', 'expirationdate');
if (!$period) {
	$period = 'fiveminute';
}
// correction for typo.
if ($period=='fifteenminute') {
	$period = 'fifteenmin';
}

?>

<p>

<?php
	echo elgg_echo('expirationdate:period');

	echo elgg_view('input/select', array(
		'name' => 'params[period]',
		'options_values' => array(
			'minute' => elgg_echo('expirationdate:minute'),
			'fiveminute' => elgg_echo('expirationdate:fiveminute'),
			'fifteenmin' => elgg_echo('expirationdate:fifteenminute'),
			'halfhour' => elgg_echo('expirationdate:halfhour'),
			'hourly' => elgg_echo('expirationdate:hourly'),
			'daily' => elgg_echo('expirationdate:daily'),
			'weekly' => elgg_echo('expirationdate:weekly'),
			'monthly' => elgg_echo('expirationdate:monthly'),
			'yearly' => elgg_echo('expirationdate:yearly')
		),
		'value' => $period
	));
?>

</p>
