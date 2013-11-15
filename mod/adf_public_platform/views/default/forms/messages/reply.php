<?php
/**
 * Reply form
 *
 * @uses $vars['message']
 */

// No more RE: - we use discussions now
$reply_title = $vars['message']->title;
$reply_title = str_replace('RE: ', '', $reply_title);

$recipient_guid = $vars['message']->fromId;
// Self-reply : keep sending to to same recipient if asked
if ($vars['send_to_sender']) $recipient_guid = $vars['message']->toId;

echo elgg_view('input/hidden', array('name' => 'recipient_guid', 'value' => $recipient_guid));
echo elgg_view('input/hidden', array('name' => 'reply', 'value' => $vars['message']->guid));
?>

<div>
	<label for="subject"><?php echo elgg_echo("messages:title"); ?><br /></label>
	<?php echo elgg_view('input/text', array('name' => 'subject', 'value' => $reply_title));
	?>
</div>
<div>
	<label for="body"><?php echo elgg_echo("messages:message"); ?></label>
	<?php echo elgg_view("input/longtext", array('name' => 'body', 'value' => ''));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('messages:send'))); ?>
</div>

