<?php
	/**
	 * Elgg iCal viewer plugin
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Facyla
	 * @copyright (c) Facyla 2010
	 * @link http://id.facyla.net/
	 */

?>
	<p>
    <?php echo '<label>' . elgg_echo('ical_viewer:settings:calendartitle') . elgg_view('input/text', array('name' => 'params[calendartitle]', 'value' => $vars['entity']->calendartitle)) . '</label>'; ?>
	</p>
	<p>
    <?php echo '<label>' . elgg_echo('ical_viewer:settings:defaulturl') . elgg_view('input/text', array('name' => 'params[defaulturl]', 'value' => $vars['entity']->defaulturl)) . '</label>'; ?>
	</p>
	<p>
    <?php echo '<label>' . elgg_echo('ical_viewer:settings:timeframe_before') . elgg_view('input/text', array('name' => 'params[timeframe_before]', 'value' => $vars['entity']->timeframe_before)) . '</label>'; ?>
	</p>
	<p>
    <?php echo '<label>' . elgg_echo('ical_viewer:settings:timeframe_after') . elgg_view('input/text', array('name' => 'params[timeframe_after]', 'value' => $vars['entity']->timeframe_after)) . '</label>'; ?>
	</p>
	<p>
    <?php echo '<label>' . elgg_echo('ical_viewer:settings:num_items') . elgg_view('input/text', array('name' => 'params[num_items]', 'value' => $vars['entity']->num_items)) . '</label>'; ?>
	</p>
	
	<p>
    <strong>URL de l'agenda&nbsp;:</strong> <?php echo '<label>' . $vars['url']; ?>ical_viewer/<br />
    <a href="<?php echo $vars['url']; ?>ical_viewer/" target="_new" class="elgg-button elgg-button-action">&rarr;&nbsp;Afficher l'agenda public dans une nouvelle fenêtre</a>
	</p>


