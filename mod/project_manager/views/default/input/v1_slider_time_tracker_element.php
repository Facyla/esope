<?php
if (!isset($vars['name'])) { $vars['name'] = 'range_slider'; }
if (!isset($vars['id'])) {
  global $unique_id; if ($unique_id > 0) $unique_id++; else $unique_id = 1;
  $vars['id'] = $vars['name'] . '_' . $unique_id;
}

if (!isset($vars['text'])) { $vars['text'] = ''; }
if (!isset($vars['value'])) { $vars['value'] = 0; }
if (!isset($vars['min'])) { $vars['min'] = 0; }
if (!isset($vars['max'])) { $vars['max'] = 100; }
if (!isset($vars['step'])) { $vars['step'] = 1; }
if (isset($vars['time_tracker'])) {
//echo implode(', ', $vars['time_tracker']) . '<br />';
  $time_tracker_guid = $vars['time_tracker']['guid'];
  if (empty($time_tracker_guid)) $time_tracker_guid = '0';
  $user_guid = $vars['time_tracker']['user_guid'];
  $user = get_input($user_guid);
  $year = $vars['time_tracker']['year'];
  $month = $vars['time_tracker']['month'];
  $project_guid = $vars['time_tracker']['project_guid'];
  $unique_id = $vars['time_tracker']['unique_id'];
}
$project_guid = '$("#project_' . $unique_id . ' option:selected").val()';
?>

<script>
/*
$(document).ready(function() {
  $("#<?php echo $vars['id']; ?>").slider();
});
*/

//$(function() {
$(document).ready(function() {
  $( "#<?php echo $vars['id']; ?>" ).slider({
    value: <?php echo $vars['value']; ?>,
    orientation: "horizontal",
    range: "min",
    animate: true,
    step: <?php echo $vars['step']; ?>,
    min: <?php echo $vars['min']; ?>,
    max: <?php echo $vars['max']; ?>,
    slide: function( event, ui ) {
      $( "#<?php echo $vars['id']; ?>_val" ).val( ui.value );
    },
    change: function( event, ui ) {
      $( "#<?php echo $vars['id']; ?>_val" ).val( ui.value );
    },
    stop: function( event, ui ) {
      <?php if (isset($vars['time_tracker'])) { ?>
      //edit_time_tracker(<?php echo $time_tracker_guid . ',' . $user_guid . ',' . $year . ',' . (string)$month . ',' . $project_guid . ',"' . $vars['name'] . '",ui.value,' . $unique_id; ?>);
      update_time_tracker(<?php echo $user_guid . ',' . $year . ',' . (string)$month . ',' . $unique_id; ?>);
      <?php } ?>
    },
  });
});

/*
$(function() {
  $( "#<?php echo $vars['id']; ?>" ).slider({
    range: true,
    min: <?php echo $vars['min']; ?>,
    max: <?php echo $vars['max']; ?>,
    values: [ 75, 300 ],
    slide: function( event, ui ) {
      $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    },
  });
  $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
  " - $" + $( "#slider-range" ).slider( "values", 1 ) );
});
*/
</script>

<div>
  <label>
    <input name="<?php echo $vars['name']; ?>" disabled="disabled" type="text" id="<?php echo $vars['id']; ?>_val" value="<?php echo $vars['value']; ?>" style="width:<?php echo (int) strlen($vars['max']) + 3; ?>ex" /> 
    <?php echo $vars['text']; ?> 
    <span style="float:right;"><div id="<?php echo $vars['id']; ?>" style="width: 200px; margin: 6px 10px;"></div></span>
  </label>
</div>
