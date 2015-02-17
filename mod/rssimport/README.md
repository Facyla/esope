RSS Import
=============

Import RSS feed items into various Elgg content types

== Installation ==
 - unzip the plugin to the mod directory of your elgg installation
 - enable the plugin through the administration interface
 - set allowable cron import schedules using the plugin settings

== Usage ==
This plugin allows rss items to be imported into blogs, bookmarks, or pages
either manually or on a set schedule.  When adding a blog/bookmark/page or while
viewing your own blogs/bookmarks/pages a new option will be presented in the
side bar for 'Import'.  Clicking it will lead to the feed creation form.  The form
is context-aware, so if you access it from your blogs it will be a blog-import, accessing
from group pages will be a page-import for that group, etc.

Create a new feed by entering all of the data for the rss feed and save the new form.

A list of items in the feed will be presented.  Items on the list can be imported
by checking the checkbox beside each target item, and clicking 'import'.
Additionally, if scheduled imports are enabled the items will automatically be imported
on schedule.

If a list item should not be imported, it can be disabled using the link at the bottom of the
item.  If disabled, it will still be visible in the feed, but grayed out to indicate that
it will not be imported.  Disabled items can be re-enabled the same way.

On the side bar there will be a list of existing feeds for the given context.
Feeds can be deleted by clicking the X, or navigated to by clicking the name.

On each import, whether manual or scheduled, the items are checked for duplication
to reduce the risk of creating multiple identical entries.  While this has been
very good in testing, you should note that identical posts from different sources
will get through.

Each import, whether manual or scheduled, is logged in a history.  The history is
accessible from the feed page via a link in the side bar.  Each import can be rolled
back by clicking the 'undo import' link in the history.


== ESOPE changes ==
This version is now fully supported by ESOPE, with several changes:
 - new handy functions added
 - add content filtering : enable to extract tags, filter the content based on custom rules
 - get source URL : adds a link to the site the article originates from
 - setting to switch author in group : can be set to container instead of member
 - setting : block email notifications
 - setting : enable import tools
 - setting : define access to import tools (member/groupadmin/admin)
 - setting : enable personal import tool


