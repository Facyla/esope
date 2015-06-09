<p>
  <?php echo elgg_echo("ical_viewer:widget:ical_url"); ?>
  <input type="text" name="params[ical_url]" value="<?php echo htmlentities($vars['entity']->ical_url); ?>" />
</p>

<p>
  <?php echo elgg_echo("ical_viewer:widget:ical_title"); ?>
  <input type="text" name="params[ical_title]" value="<?php echo htmlentities($vars['entity']->ical_title); ?>" />
</p>

<p>
  <?php echo elgg_echo("ical_viewer:widget:timeframe_before"); ?>
  <input type="text" name="params[timeframe_before]" value="<?php echo htmlentities($vars['entity']->timeframe_before); ?>" />
</p>

<p>
  <?php echo elgg_echo("ical_viewer:widget:timeframe_after"); ?>
  <input type="text" name="params[timeframe_after]" value="<?php echo htmlentities($vars['entity']->timeframe_after); ?>" />
</p>

<p>
  <?php echo elgg_echo("ical_viewer:widget:num_items"); ?>
  <input type="text" name="params[num_items]" value="<?php echo htmlentities($vars['entity']->num_items); ?>" />
</p>

