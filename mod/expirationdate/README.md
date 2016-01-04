Expirationdate plugin for Elgg 1.10 - 1.12 and Elgg 2.X
=======================================================

Latest Version: 1.10.4  
Released: 2015-09-17  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) Brett Profitt (Original developer) / iionly (for Elgg 1.8 onwards)


Description
-----------

The Expirationdate plugin can be used to define a date of expiration for entities and to delete them automatically via a cron job. The plugin provides no user interface on your site (apart from setting the desired cron interval in the admin section).

For example this plugin can optionally be used with the Elggx Userpoints plugin.

If you only intend to use the Expirationdate plugin in connection with another plugin that already has the expiration date mechanism implemented, you only need to enable it like another Elgg plugin and set the desired cron interval in the plugin's settings. Additionally, at least the cronjob for this interval must be configured on your server!

If you intend to use the methods included in the Expirationdate plugin within your own plugin development, read on.


Usage
-----

Configure cron for Elgg as described in the Elgg documentation.

Install and enable the Expirationdate plugin.  Be sure to set the plugin's period to something that will match nicely with your cron jobs.

Within your plugin, set entity expiration dates by saying:

    expirationdate_set($entity->guid, $expiration_date_string, bool);

where $expiration_date_string is a valid strtotime() string. If the 3rd parameter is true, the entity will be disabled instead of deleted.


Unset expiration dates by saying:

    expirationdate_unset($entity->guid);

Before entities are deleted the plugin_hook expirationdate:expirate_entity is called with $param set as:

array('entity' => entity object)

If you register a function to this hook, the entity will not be deleted/disabled unless the function returns true.

Each entity that has an expiration date will be passed through the plugin hook expirationdate:will_expire_entity with the $param set as:

array('expirationdate' => timestamp of expiration, 'entity' => entity object)

This can be used to send out warning emails, etc.
