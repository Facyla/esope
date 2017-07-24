<?php
/**
 * Personal notifications form body
 *
 * @uses $vars['user'] ElggUser
 * Facyla accessibility patch : changed save submit text (based on 1.8.16)
 */

/* @var ElggUser $user */
$user = $vars['user'];

echo elgg_view('notifications/subscriptions/personal', $vars);
echo elgg_view('notifications/subscriptions/collections', $vars);
echo elgg_view('notifications/subscriptions/forminternals', $vars);
// Iris note : extended by comment_tracker/settings

?>
<div class="elgg-foot">
<?php
echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
echo elgg_view('input/submit', array('value' => elgg_echo('save:usernotifications')));
?>
</div>
