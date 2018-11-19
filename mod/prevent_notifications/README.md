# Prevent notifications
Lets user define if a new publication should trigger notifications or not

This plugins adds a special field in content creation forms that allows editors to block outgoing notification.

Admins can define default behaviour : notify, block, or force user choice (required field).

It also presets the notification setting to "no" when embedding content (eg. embed a file in a blog article).


## Technical note
This works by passing a special parameter that basically tells "don't notify anyone" when a new objet is created. The notification process is blocked and **no one** shoud receive anything. 
Exceptions might happen for plugins which do not use the notification queue nor the notifications-related hooks, eg. a plugin that makes a direct call in its action to an email sending function that does not trigger any hook.

Supported object types : blog, bookmarks, brainstorm, discussion, event_calendar, file, file_tools, pages, videos

To support new object types, update your form and add the next line just above the submit button:
    if (!$vars['entity']) { echo elgg_view('prevent_notifications/prevent_form_extend', array()); }


## History
 - 1.12.0 : 201602159 - operational Elgg 1.12 version
	 - rewrite blocking method : use enqueue, notification hook
	 - add README.md file
	 - add default setting to "no" in embed context
 - 0.3 : 20160129 - ported to Elgg 1.12 (not functionnal)
 - 0.2 : 20150812
	 - file tools support (folders) 
 - 0.1 : avril 2013
	 - première version fonctionnelle


## Roadmap
 - hide notification setting field if notification is not available ? (eg. update event)
 - or enable handling for any event + add hook to handle them ?


