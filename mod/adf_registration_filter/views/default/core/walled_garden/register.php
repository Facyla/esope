<?php
/**
 * Walled garden registration
 */

$title = elgg_echo('register');
$body = elgg_view_form('register', array(), array(
	'friend_guid' => (int) get_input('friend_guid', 0),
	'invitecode' => get_input('invitecode'),
));

$content = <<<__HTML
<div style="background: url({$url}_graphics/walled_garden_backgroundfull_top.gif) no-repeat left top;">
  <div style="padding:30px 30px 0 30px;">
    <div class="elgg-inner">
    <h2>$title</h2>
    $body
    </div>
  </div>
  <div style="height:54px; background: url({$url}_graphics/walled_garden_backgroundfull_bottom.gif) no-repeat left bottom;"></div>
</div>
__HTML;

echo elgg_view_module('walledgarden', '', $content, array(
	'class' => 'elgg-walledgarden-single elgg-walledgarden-register hidden',
	'header' => ' ',
	'footer' => ' ',
));
