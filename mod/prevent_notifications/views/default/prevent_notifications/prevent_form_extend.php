<?php
$value = elgg_extract('value', $vars, 'yes');
?>
<div id="prevent_notification" style="background: none repeat scroll 0 0 #AAAAAA; border-radius: 6px 6px 6px 6px; padding: 6px;">
  <img src="<?php echo $vars['url']; ?>mod/prevent_notifications/graphics/notify.php" style="float:left; margin-right:12px; height:40px;"/>
  <label><?php echo elgg_echo('prevent_notifications:label'); ?></label><br />
  <?php echo elgg_view("input/radio", array("name" => 'send_notification', "value" => $value, 'options' => array(elgg_echo('prevent_notifications:yes') => 'yes', elgg_echo('prevent_notifications:no') => 'no') )); ?>
</div>
<div class="clearfloat"></div>
<br />

