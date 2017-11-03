<?php
$plugin = $vars['entity'];

$yesno_options = array("yes" => elgg_echo("option:yes"), "no" => elgg_echo("option:no"));
$noyes_options = array_reverse($yesno_options, true);

// Load defaults
$reset_registered_events = get_input('reset_registered_events');


// @TODO Register event notification setting
/*
$notify_opt = array(
	'default' => elgg_echo('notification_messages:register:default'), 
	'yes' => elgg_echo('option:yes'), 
	'no' => elgg_echo('option:no'), 
);
*/
$notify_opt = array(
	elgg_echo('notification_messages:notify:create') => 'create', 
	elgg_echo('notification_messages:notify:publish') => 'publish', 
	elgg_echo('notification_messages:notify:update') => 'update', 
	elgg_echo('notification_messages:notify:delete') => 'delete', 
);

// Prepare notification setting
$notify_subject_opt = array(
	'default' => elgg_echo('notification_messages:subject:default'), 
	'allow' => elgg_echo('notification_messages:subject:allow'), 
	//'deny' => elgg_echo('notification_messages:subject:deny'), 
);
$notify_message_opt = array(
	'default' => elgg_echo('notification_messages:message:default'), 
	'allow' => elgg_echo('notification_messages:message:allow'), 
	//'deny' => elgg_echo('notification_messages:subject:deny'), 
);

// @TODO Recipients setting => make several unique settings
$recipients_opt = array(
	'default' => elgg_echo('notification_messages:recipients:default'), // registered group members
	'allgroup' => elgg_echo('notification_messages:recipients:allgroup'), // force all group members
	'author' => elgg_echo('notification_messages:recipients:author'), // default + author
	'thread' => elgg_echo('notification_messages:recipients:thread'), // initial author + thread members
	//'deny' => elgg_echo('notification_messages:subject:deny'), 
);

// Start accordion layout
echo '<div id="notification-messages-accordion">';


// Some explanations on the notification process
echo '<h3><i class="fa fa-info"></i> ' . elgg_echo('notification_messages:process') . '</h3>';
echo '<div>';
	echo '<p>' . elgg_echo('notification_messages:process:details') . '</p>';

	// Type d'objets et events enregistrés pour notifications
	$registered_notification_events = _elgg_services()->notifications->getEvents();
	$registered_notification_events_content = '<pre>' . print_r($registered_notification_events, true) . '</pre>';
	$registered_notification_events_content .= '<p><a href="?reset_registered_events=reset" class="elgg-button elgg-button-action">RESET to default registered events config</a></p>';

	// Contenu et destinataires des notifications
	//$hooks = _elgg_services()->hooks->getOrderedHandlers('get', 'subscriptions');
	$hooks = _elgg_services()->hooks->getAllHandlers();
	foreach ($hooks as $hook => $types) {
		//echo $hook . ', ';
		//if (!in_array($hook, array('prepare', 'get'))) { continue; }
		foreach ($types as $type => $handlers) {
			// Get, subscriptions
			if (($hook == 'get') && ($type == 'subscriptions')) { $get_subscriptions_hooks = $handlers; }
			// Prepare, notification:[action][type][subtype]
			if (($hook == 'prepare') && (substr($type, 0, 13) == 'notification:')) {
				$type = explode(':', $type);
				$prepare_notification_hooks[$type[2]][$type[3]][$type[1]] = array_values($handlers);
			}
		}
	}
	// Contenu des notifications
	$prepare_notification_content = '<pre>' . print_r($prepare_notification_hooks, true) . '</pre>';

	// Destinataires des notifications
	$subscriptions_content = '<pre>' . implode('<br />', $get_subscriptions_hooks) . '</pre>';

	// Other registered events handlers - may add/alter notification behaviour
	$events_handlers = _elgg_services()->events->getAllHandlers();
	foreach ($events_handlers as $event => $types) {
		if (!in_array($event, array('create', 'publish', 'update', 'delete'))) { continue; }
		foreach ($types as $type => $handlers) {
			if (!in_array($event, array('object', 'all'))) { continue; }
			$events_handlers_tree[$event][$type] = array_values($handlers);
		}
	}
	$other_events_content = '<pre>' . print_r($events_handlers_tree, true) . '</pre>';

	// Display detailed information on notifications events and hooks
	// Togglers
	echo '<h4><i class="fa fa-toggle-down"></i>&nbsp;' . elgg_view('output/url', array('text' => "Registered notification events", 'href' => "#registered-notification-events", 'rel' => 'toggle')) . '</h4>';
	echo '<h4><i class="fa fa-toggle-down"></i>&nbsp;' . elgg_view('output/url', array('text' => "Other event handlers", 'href' => "#other-events-handlers", 'rel' => 'toggle')) . '</h4>';
	echo '<h4><i class="fa fa-toggle-down"></i>&nbsp;' . elgg_view('output/url', array('text' => "Prepare notification content hooks", 'href' => "#prepare-notification-hooks", 'rel' => 'toggle')) . '</h4>';
	echo '<h4><i class="fa fa-toggle-down"></i>&nbsp;' . elgg_view('output/url', array('text' => "Recipients subscription hooks", 'href' => "#subscriptions-hooks", 'rel' => 'toggle')) . '</h4>';
	// Hidden content
	echo elgg_view_module('featured', 'Registered events', $registered_notification_events_content, array('id' => 'registered-notification-events', 'class' => 'hidden mtm'));
	echo elgg_view_module('featured', 'Other events handlers', $other_events_content, array('id' => 'other-events-handlers', 'class' => 'hidden mtm'));
	echo elgg_view_module('featured', 'Prepare notifications', $prepare_notification_content, array('id' => 'prepare-notification-hooks', 'class' => 'hidden mtm'));
	echo elgg_view_module('featured', 'Recipients', $subscriptions_content, array('id' => 'subscriptions-hooks', 'class' => 'hidden mtm'));
	
echo '</div>';




/// Settings form

// @TODO Sur chaque type d'action, pouvoir choisir si on notifie ou pas, et qui notifier
/* les notifications s'appuient sur les events
 - enregistrer un type de notification : elgg_register_notification_event('object', 'photo', array('create'));
 _elgg_services()->notifications->registerEvent
 $events = _elgg_services()->events->getAllHandlers();
 
 - préparer la notification : elgg_register_plugin_hook_handler('prepare', 'notification:create:object:photo', 'photos_prepare_notification');
 - déterminer les destinataires : elgg_register_plugin_hook_handler('get', 'subscriptions', 'discussion_get_subscriptions');
*/
echo '<h3><i class="fa fa-arrow-circle-o-right"></i> ' . elgg_echo('notification_messages:settings:objects') . '</h3>';
echo '<div>';
		// get registered objects
		$objects = get_registered_entity_types('object');

		// Blog is different - add it manually
		//if (elgg_is_active_plugin('blog')) { $objects['object']['blog'] = elgg_echo('blog:newpost'); }

		echo '<p>' . elgg_echo('notification_messages:settings:details') . '</p>';
		echo '<p>' . elgg_echo('notification_messages:object:subtype') . '&nbsp;: ' . elgg_echo('notification_messages:setting');
		//echo ' - <em>' . elgg_echo('notification_messages:subject:default') . '</em>';
		echo '</p>';
	
		// @TODO on/off setting, or also allow blocking messages ?
		echo '<table class="notification-messages-admin-table">';
			echo '<thead>';
				echo '<tr>';
					echo '<th style="min-width: 15%;">' . elgg_echo('notification_messages:object:subtype') . '</th>';
					echo '<th style="min-width: 40%;">' . elgg_echo('notification_messages:events') . '&nbsp;: create, publish, update, delete<br /></th>';
					echo '<th style="min-width: 45%;">' . elgg_echo('notification_messages:prepare:setting') . '</th>';
					//echo '<th style="width: 15%;">' . elgg_echo('notification_messages:recipients:setting') . '</th>';
				echo '</tr>';
			echo '</thead>';
		
			echo '<tbody>';
				// Global hooks
				echo '<tr class="global" style="border: 1px solid black;">';
					echo '<td>all</td>';
					echo '<td>' . implode('<br />', (array)$events_handlers_tree['create']['all']);
					echo '<br />' . implode('<br />', (array)$events_handlers_tree['publish']['all']);
					echo '<br />' . implode('<br />', (array)$events_handlers_tree['update']['all']);
					echo '<br />' . implode('<br />', (array)$events_handlers_tree['delete']['all']) . '</td>';
					echo '<td>' . '' . '</td>';
					//echo '<td>' . '' . '</td>';
				echo '</tr>';
			
				// Settings per subtype
				$prepare_object_subtypes = array();
				foreach($objects as $subtype) {
					if (!in_array($subtype, $prepare_object_subtypes)) {
					
						// Prepare objects for notifications
						$prepare_param = 'object_' . $subtype;
						$prepare_params = array(
							'name' => "params[{$prepare_param}]",
							'value' => $plugin->$prepare_param ? $plugin->$prepare_param : 'default',
							'options_values' => $notify_subject_opt,
						);
						// Add to list of prepared notifications
						if ($plugin->$prepare_param == 'allow') { $prepare_object_subtypes[] = $subtype; }
					
						echo '<tr style="border: 1px solid black;">';
						
							// subtype title
							echo '<td><label>' . notification_messages_readable_subtype($subtype) . '<br />(' . $subtype . ')</label></td>';
						
							// Registered notification events
							echo '<td>';
								// Load defaults if settings are not defined yet, or explicitely using reset
								if (!isset($plugin->{"register_object_{$subtype}"}) || ($reset_registered_events== 'reset')) {
									$events = $registered_notification_events['object'][$subtype];
								} else {
									$events = explode(',', $plugin->{"register_object_{$subtype}"});
								}
								// Display actual custom setting
								// soit non global, soit array des events concernés
								// soit un hook pour intercepter l'enregistrement des paramètres, soit autre méthode ?
								echo elgg_view('input/checkboxes', array(
										'name' => "register_object_{$subtype}", 'options' => $notify_opt, 'align' => 'horizontal', 
										'value' => $events,
									));
								// Display defaults
								echo '<div class="settings-defaults"><strong>Defaults :</strong> ' . elgg_view('input/checkboxes', array('value' => $registered_notification_events['object'][$subtype], 'options' => $notify_opt, 'disabled' => 'disabled', 'align' => 'horizontal', 'class' => 'settings-defaults')) . '</div>';
							echo '</td>';
						
						
							// Prepare notification message setting and hooks
							echo '<td>';
								// Enable custom message override or not
								echo elgg_view('input/select', $prepare_params);
							
								if ($registered_notification_events['object'][$subtype]) {
									// Create event
									if (in_array('create', $registered_notification_events['object'][$subtype])) {
										echo '<br />create : ';
										echo elgg_echo('notification_messages:settings:messagehandledby');
										echo implode('<br />', $prepare_notification_hooks['object'][$subtype]['create']);
										if ($events_handlers_tree['create'][$subtype]) {
											echo '</p><p>' . elgg_echo('notification_messages:settings:recipients');
											echo implode('<br />', $events_handlers_tree['create'][$subtype]);
										}
									}// else { echo elgg_echo('notification_messages:settings:nomessage'); }
									// Publish event
									if (in_array('publish', $registered_notification_events['object'][$subtype])) {
										echo '<br />publish : ';
										echo elgg_echo('notification_messages:settings:messagehandledby');
										echo implode('<br />', $prepare_notification_hooks['object'][$subtype]['publish']);
										if ($events_handlers_tree['publish'][$subtype]) {
											echo '</p><p>' . elgg_echo('notification_messages:settings:recipients');
											echo implode('<br />', $events_handlers_tree['publish'][$subtype]);
										}
									 }// else { echo elgg_echo('notification_messages:settings:nomessage'); }
									// Update event
									if (in_array('update', $registered_notification_events['object'][$subtype])) {
										echo '<br />update : ';
										echo elgg_echo('notification_messages:settings:messagehandledby');
										echo implode('<br />', $prepare_notification_hooks['object'][$subtype]['update']);
										if ($events_handlers_tree['update'][$subtype]) {
											echo '</p><p>' . elgg_echo('notification_messages:settings:recipients');
											echo implode('<br />', $events_handlers_tree['update'][$subtype]);
										}
									}// else { echo elgg_echo('notification_messages:settings:nomessage'); }
									// Delete event
									if (in_array('delete', $registered_notification_events['object'][$subtype])) {
										echo '<br />delete : ';
										echo elgg_echo('notification_messages:settings:messagehandledby');
										echo implode('<br />', $prepare_notification_hooks['object'][$subtype]['delete']);
										if ($events_handlers_tree['delete'][$subtype]) {
											echo '</p><p>' . elgg_echo('notification_messages:settings:recipients');
											echo implode('<br />', $events_handlers_tree['delete'][$subtype]);
										}
									}// else { echo elgg_echo('notification_messages:settings:nomessage'); }
								}
							echo '</td>';
						
							// Recipients
							//echo '<td>';
								//echo '<p>See registered get,subscriptions hooks to check recipients - recipients do not rely on subtypes.</p>';
							//echo '</td>';
						
								//echo '<label>' . notification_messages_readable_subtype($subtype) . '&nbsp;: ' . elgg_view('input/select', $prepare_params) . '</label>';
								/* @TODO preview default message ?
								echo ' - ' . elgg_echo('notification_messages:subject:default') . '&nbsp;: ';
								//echo '<em>' . $subject . '</em>';
								//echo elgg_trigger_plugin_hook('prepare', "notification:create:object:$subtype", array(), false);
								//echo elgg_echo("$subtype:notify:subject");
								*/
						echo '</tr>';
					}
				}
			echo '</tbody>';
		echo '</table>';
	
	
		// Save all enabled subtypes in a single fields (for easier processing, so we can loop through the list to get direct params)
		if ($prepare_object_subtypes) { $prepare_object_subtypes = implode(',', $prepare_object_subtypes); }
		elgg_set_plugin_setting('object_subtypes', $prepare_object_subtypes, 'notification_messages');
	
echo '</div>';


// Notification message content override - @TODO could be enabled for any content type, if we want
/* This setting has become useless for blog only => enable for any content, or set both subject + body
*/
echo '<h3><i class="fa fa-envelope-o"></i> ' . elgg_echo('notification_messages:settings:objects:message') . '</h3>';
echo '<div>';
	
	// Blog notificaiton content
	$prepare_param = "object_blog_message";
	$prepare_params = array(
		'name' => "params[{$prepare_param}]",
		'value' => $plugin->$prepare_param ? $plugin->$prepare_param : 'default',
		'options_values' => $notify_message_opt,
	);
	echo '<p><label>' . 'blog' . '&nbsp;: ' . elgg_view('input/select', $prepare_params) . '</label> - ' . elgg_echo('notification_messages:message:default:blog') . '</p>';
	
	// Direct messages in HTML
	echo '<p><label>' . elgg_echo("notification_messages:settings:messages_send");
	echo "&nbsp;" . elgg_view("input/select", array("name" => "params[messages_send]", "options_values" => $yesno_options, "value" => $plugin->messages_send)) . '</label>';
	echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:messages_send:subtext") . "</div>";
	echo '</p>';
	
echo '</div>';



/* Recipients : notify author, all group members (recursive container, not only direct)
 * Design rule : never force if user is not suscribed to the (top level) container
 * - notify initial object owner on replies (if setting 'emailpersonal' is set)
 * - notify self (published object / reply author)
 * - notify replies the same way as initial entities (according to their own notification settings) => use top level container instead of entity
 * - notify all discussion participants (can be not subscribed to group or member)
*/

echo '<h3><i class="fa fa-users"></i> ' . elgg_echo('notification_messages:settings:recipients') . '</h3>';
echo '<div>';
	echo '<p><em>' . elgg_echo('notification_messages:settings:recipients:details') . '</em></p>';
	
	// Notify also the author (of a content or comment) ?
	// Note : this is mostly useful if you want to let owner reply by email
	// Notify initial object owner on replies (if setting 'emailpersonal' is set)
	echo '<p><label>' . elgg_echo("notification_messages:settings:notify_owner");
	if (elgg_is_active_plugin('comment_tracker')) {
		// Synchronize setting with comment tracker's and block editing
		$notify_owner = elgg_get_plugin_setting('notify_owner', 'comment_tracker');
		$plugin->notify_owner = $notify_owner;
		echo '&nbsp;: ' . $noyes_options[$plugin->notify_owner] . '</label>';
		echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:notify_owner:details") . "</div>";
		echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:notify_owner:comment_tracker") . "</div>";
	} else {
		echo "&nbsp;" . elgg_view("input/select", array("name" => "params[notify_owner]", "options_values" => $noyes_options, "value" => $plugin->notify_owner)) . '</label>';
		echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:notify_owner:details") . "</div>";
	}
	echo '</p>';
	
	/* Generic comments support : default comment,save action notifies owner if someone else posted a comment, using a basic title and content
	 * If prepare,notification:create:object:comment is handled by notification_messages then we have to override the action, 
	 * so we can set the proper message title and content.
	 * Note : this is done directly in start.php, no need for a setting anymore.
	 */
	/*
	$prepare_params = array(
			'name' => "params[generic_comment]",
			'value' => $plugin->generic_comment ? $plugin->generic_comment : 'default',
			'options_values' => $notify_subject_opt,
		);
	echo '<p><label>' . elgg_echo('notification_messages:settings:generic_comment') . '&nbsp;: ' . elgg_view('input/select', $prepare_params) . '</label> - ' . elgg_echo('notification_messages:subject:default') . '&nbsp;: <em>' . elgg_echo('generic_comment:email:subject') . '</em></p>';
	*/

	// Notify self (published object / reply author)
	echo '<p><label>' . elgg_echo("notification_messages:settings:notify_self");
		echo "&nbsp;" . elgg_view("input/select", array("name" => "params[notify_self]", "options_values" => $noyes_options, "value" => $plugin->notify_self)) . '</label>';
		echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:notify_self:details") . "</div>";
	echo '</p>';
	
	// Notify discussion participants (even if not subscribed to container entity)
	echo '<p><label>' . elgg_echo("notification_messages:settings:notify_participants");
		echo "&nbsp;" . elgg_view("input/select", array("name" => "params[notify_participants]", "options_values" => $noyes_options, "value" => $plugin->notify_participants)) . '</label>';
		echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:notify_participants:details") . "</div>";
	echo '</p>';
	
	// Notify replies (comments) the same way as the main entity ? = to all group members
	echo '<p><label>' . elgg_echo("notification_messages:settings:notify_replies");
		echo "&nbsp;" . elgg_view("input/select", array("name" => "params[notify_replies]", "options_values" => $noyes_options, "value" => $plugin->notify_replies)) . '</label>';
		echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:notify_replies:details") . "</div>";
	echo '</p>';
	
echo "</div>";





// Advanced settings - for file attachments
/*
// @TODO : this should be updated to Elgg 1.11 standards...
echo "<fieldset>";
	echo '<legend>' . elgg_echo('notification_messages:settings:expert') . '</legend>';

	echo '<p><label>' . elgg_echo("notification_messages:settings:object_notifications_hook");
	echo "&nbsp;" . elgg_view("input/select", array("name" => "params[object_notifications_hook]", "options_values" => $yesno_options, "value" => $plugin->object_notifications_hook)) . '</label>';
	echo "<div class='elgg-subtext'>" . elgg_echo("notification_messages:settings:object_notifications_hook:subtext") . "</div>";
	echo '</p>';
echo "</fieldset>";
*/

/* Gestion des types de notifications
 * Choix de ce qu'on notifie : 
 * subtype, action, type notif
 * Doc : http://learn.elgg.org/en/1.12/guides/notifications.html
 * Doc : http://reference.elgg.org/1.12/notification_8php.html#af7a43dcb0cf13ba55567d9d7874a3b20
 'create', 'update', and 'publish'
 
 1. Définition des actions à notifier => elgg_register_notification_event('object', 'photo', array('create'));
 2. Préparation des notifications : destinataires et contenu : elgg_register_plugin_hook_handler('prepare', 'notification:create:object:photo', 'photos_prepare_notification');
 3. Définition des destinataires : elgg_register_plugin_hook_handler('get', 'subscriptions', 'discussion_get_subscriptions');
 Liste des destinataires : elgg_get_subscriptions_for_container
 
*/


echo '</div>';

echo '<script type="text/javascript">
$(function() {
	$(\'#notification-messages-accordion\').accordion({ header: \'h3\', autoHeight: false, heightStyle: \'content\' });
});
</script>';


// Some specific styles
echo '<style>
.notification-messages-admin-table { display: block; border: 1px solid black; width: 100%; }
.notification-messages-admin-table tr { border: 1px solid black; }
.notification-messages-admin-table tr.global { background: #ccc; }
.notification-messages-admin-table th, 
.notification-messages-admin-table td { border: 1px solid #999; padding: 0.2rem 0.2rem; word-break: break-all; font-size: .75rem; }
.notification-messages-admin-table th { background: #333; color: white; font-weight: bold; }

ul.elgg-input-checkboxes.elgg-horizontal li { display: inline-block; margin-right: 1rem; line-height: 1rem; }

.settings-defaults, .settings-defaults label { color: #AAA; }
ul.settings-defaults.elgg-horizontal { display: inline-block; }
</style>';


