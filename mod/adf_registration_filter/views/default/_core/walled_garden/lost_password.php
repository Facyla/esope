<?php
/**
 * Walled garden lost password
 */

$title = elgg_echo('user:password:lost');
$body = elgg_view_form('user/requestnewpassword');
$lost = <<<HTML

<div style="background: url({$url}_graphics/walled_garden_backgroundfull_top.gif) no-repeat left top;">
  <div style="padding:30px 30px 0 30px;">
    <div class="elgg-inner">
    <h3>$title</h3>
    $body
    </div>
  </div>
  <div style="height:54px; background: url({$url}_graphics/walled_garden_backgroundfull_bottom.gif) no-repeat left bottom;"></div>
</div>
HTML;

echo elgg_view_module('walledgarden', '', $lost, array(
	'class' => 'elgg-walledgarden-single elgg-walledgarden-password hidden',
	'header' => ' ',
	'footer' => ' ',
));
