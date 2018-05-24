Crontrigger plugin for Elgg 1.8 - 1.12 and Elgg 2.X
===================================================

Latest Version: 1.8.0  
Released: 2016-06-22  
Contact: iionly@gmx.de  
License: GNU General Public License version 2  
Copyright: (c) iionly 2011-2016


Description
-----------

Re-activting the Crontrigger plugin bundled with Elgg up to version 1.7...

This plugin adds a "poor man's" cron trigger to your Elgg site if you can't set up the proper cronjobs of Elgg on your server (one use case could be a Windows / XAMPP server where configuration of cronjobs is not as easy as on a Linux server). If you can set up the cronjobs of Elgg on your server, you won't need the Crontrigger! And it's really better to configure the cronjobs properly instead of using this plugin because triggering of the cronjobs by the Crontrigger plugin requires users to be on your site. Only active users on your site will trigger the cronjobs - no active users no triggering.


Installation
------------

1. If you have a previous version of the Crontrigger plugin installed, disable it and then remove the crontrigger folder from your mod directory before copying the new version on the server,
2. Copy/extract the crontrigger archive into the mod folder,
3. Enable the Crontrigger plugin.
