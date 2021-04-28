Survey plugin for Elgg 3.3
==========================

This plugin was originally forked from Survey plugin 1.10.2.
Some of the implementation ideas also come from knowledge_database plugin from Facyla, with insights from Evan Winslow proposal at https://github.com/Elgg/Elgg/issues/6808

This plugin has a different aim than "survey", and is not backward-compatible. 
Both plugin can be enabled and used at the same time to provide simple surveys and more complex surveys.

Survey is rather intended to admins and optionally group admins than to simple members. However regular 

Survey plugin provides survey features such as:
 - multiple questions,
 - multiple available question types : short and long text, multiple choices, selects, ratings, etc.
 - nice results views, and results filtering per question and per responder
 - CSV results export


## Installation
1. Copy the survey plugin folder into "mod/" folder
2. Enable the Survey plugin in the admin section of your site
3. Check the Survey plugin settings and adjust the settings.


## Changelog
3.3.0 : 20200410 - updated to Elgg 3.3
 - split functions into hooks, functions, and ElggSurvey methods

1.12.0 : 20160412 - updated to Elgg 1.12

1.8.20.1 : 20150312 - rewritten survey plugin
 - multiple questions per survey
 - question types : text, longtext, pulldown, checkboxes, multiselect, rating, date
 - improved results on survey page
 - detailed results page + per question + per user
 - charts (using elgg_dataviz plugin)
 - add comments setting + disable comments by default

1.8.20 : 20150219 - fork based on survey 1.10.2 from iionly
 - back to Elgg 1.8
 - added FR translation
 - start implementing multiple questions and answers types


### Survey Changelog
1.10.2:
- Based on version 1.9.2,
- Fix of deprecation issues occuring on Elgg 1.10 (namely changing output/confirmlink view to output/url view).

1.9.2 (thanks to Juho Jaakkola!!!):
- Major cleanup / simplification / restructuring / updating / move to more object oriented code,
- Conversion of javascript code into an AMD module,
- Finnish translations added.

1.9.1.1:
- Fixed a deprecation issue (with the hopefully soon to be released Widget Manager plugin for Elgg 1.9) with widgets urls (clickable title link).

1.9.1:
- Updated version 1.8.1 for Elgg 1.9.

1.8.1:
- Optional time limitation on surveys (survey results are still shown afterwards but voting is no longer possible). Time limitation on surveys can be enabled/disabled by plugin setting. Thanks to Jerome Bakker for the inspiration to this feature (and some initial code for implementing it, too),
- Optionally make a survey an open survey (it's visible who voted for which survey choice). Thanks to tacid for the inspiration to this feature (and most of the code for implementing it, too),
- Latest comments made on surveys in sidebar on "All" and "Mine" survey pages,
- Consistent display of survey creator, survey creation date, number of votes, number of comments and tags in all widgets, the list view and full view,
- Removal of files no longer in use (that's why you should remove the plugin folder of any previous version to get rid of them, too).

1.9.0:
- Updated version 1.8.0 for Elgg 1.9.

1.8.0:
- Some general code cleanup,
- Fix remaining issues of deprecated function usage,
- Fixed widgets (both with and without usage of Widget Manager plugin),
- Fixed notification sending,
- Added (optional) description field,
- Added convert script for existing surveys that have the old response data structure of the original survey plugin.



## Contributors / History
Survey plugin is maintained by Florian DANIEL aka Facyla. 

### Survey contributors / history
The original Elgg 1.x Survey plugin was written by John Mellberg
(http://www.syslogicinc.com) and modified by Team Webgalli (www.webgalli.com)
to work with Elgg 1.5.

Kevin Jardine at Radagast Solutions (kevin@radagast.biz) rewrote the original
code to create the Surveys plugin for Elgg 1.6/1.7.

Anirup Dutta removed some deprecated functions to create a preliminary version
to work with Elgg 1.8.

Kevin Jardine rewrote the plugin completely for Elgg 1.8.

Stephen Clay contributed some bug fixes and suggestions.

Jerome Bakker (http://www.coldtrick.com) contributed some missing language
strings, title and breadcrumb fixes and fixes to eliminate PHP
warnings/notifications.



## For reference : Parent plugin Survey readme
Survey plugin for Elgg 1.10
Latest Version: 1.10.2
Released: 2015-02-15
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (c) iionly, Juho Jaakkola, Kevin Jardine, John Mellberg and Dr Sanu P Moideen


This plugin allows adding of surveys (both site-wide surveys and optionally also group-specific surveys). The number of choices to vote on is free to choose for each survey. Optionally, a (longer) description can be added to a survey. An admin can also (optionally) make a single survey the site's current featured survey. The widgets included are a "My surveys" widget that shows a user's surveys on his profile page and/or dashboard, a "Latest community surveys" widget for the dashboard (and if the Widget Manager plugin is available also on the index page), a group's surveys widget for group profile pages and the "Featured survey" widget showing the site's current featured survey on the dashboard (and if the Widget Manager plugin is available also on the index page). Notification on creation of new surveys is optional (admin setting) and the creation of river entries for new surveys and voting on surveys can also be enabled/disabled in the plugin settings.

The survey plugin has a long history (see below), has been released in various versions by different developers and a few word about the compatibility of this new release of the survey plugin seem necessary. Basically, there exist two classes of the "survey" plugin (or "surveys" plugin respectively): most of the versions are based quite closely on the original version of the "survey" plugin by John Mellberg. Each of them is compatible to the other versions of the "survey" plugin regarding existing surveys but there is quite a mess regarding compatibilty to Elgg itself (at maximum Elgg 1.7 anyway). The other class consists actually only of the "surveys" plugin of Kevin Jardine. The surveys plugin of Kevin is a complete re-write, works also on Elgg 1.8 but is not compatible with the other survey plugins.

With this new release I've tried to merge the two classes of the survey(s) plugin again. While it's based on Kevin's surveys plugin I've renamed it again to survey plugin, tried to fix the remaining issues and also included an upgrade script for existing surveys created with any former version of the survey plugin.

