<?php
/**
 * Reply form
 *
 * @uses $vars['message']
 */

// No more RE: at all (as we use discussions now we need the same title)
$reply_title = $vars['message']->title;
$reply_title = str_replace('RE: ', '', $reply_title);

$username = '';
$user = get_user($vars['message']->fromId);
// Self-reply : keep sending to to same recipient if asked
if ($vars['send_to_sender']) $user = $vars['message']->toId;
if ($user) {
	$username = $user->username;
}

echo elgg_view('input/hidden', array(
	'name' => 'recipient_username',
	'value' => $username,
));

echo elgg_view('input/hidden', array(
	'name' => 'original_guid',
	'value' => $vars['message']->guid,
));

/* Hide subject, and force conversations
<div>
	<label for="subject"><?php echo elgg_echo("messages:title"); ?><br /></label>
	?>
</div>
*/
echo elgg_view('input/hidden', array(
	'name' => 'subject',
	'value' => $reply_title,
));
?>

<div>
	<label for="body"><?php echo elgg_echo("messages:message"); ?></label>
	<?php echo elgg_view("input/longtext", array(
		'name' => 'body',
		'value' => '',
	));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('send'))); ?>
</div>
