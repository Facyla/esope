=============================
PLUGIN NAME
=============================
related items

=============================
PLUGIN DESCRIPTION
=============================

adds an area for all major elgg entity types that renders a list of related items from the installation, matched by tags.
the greater the number of matching tags between the presently viewed item and the others in the site, the more 'related' they are identified to be.

=============================
CHANGELOG
=============================
todo: 
groups integration
links to create a related item (with same tags as present item).
sidebar widget view.
page to show full list of related items.
a way of filtering the list by chooseable sitewide categories.
fix performance issues - switch processing load from php to dbase.


0.6.4
fixed: show dates option was not functional in admin panel
changed: language file strings in admin
---
0.6.3
added: thumbnail images for videos and files
added: css codes to identify thumbnail images that are stored by elgg  
---
0.6.2
added: css theming for default elgg theme
fixed: logic error causing fatal break/continue message in logs.
---
0.6.1
added: options for jquery heights and number of grid columns.
---
0.6
added: admin panel for configuration of search and diplay
fixed: logic errors in certain circumstances
---
0.5.2
fixed: check for zero tags
---
0.5.1
fixed: image thumbnail path is now correctly formed for tidypics
---
0.5
added: image icons for image items
fixed: php warning for array
changed: optimised code for performance 
---
0.4.2
fixed: issue with 0.4.1 where single tagged items were listed incorrectly
---
0.4.1
fixed: php warning for array
---
0.4
added: matched keywords are now displayed for each related item
added: changed css for icon element (you will need to play with this on your own site - icon images are not included).
changed: made css for name and date/time smaller
---
0.3
added: now shows related items of most elgg entity types (defined in the start.php file), not just entities of the same type as the one being viewed.
fixed: added jquery to make all list boxes the same height.
added: the box for each type of entity now has its own css class to allow customisation of appearance (see screenshot)
---
0.2
fixed: removed limit from search query: the related items list now correclty contains items from the entiree database rather than just comparing simlarity for the first 10 found. 
changed: css - hover over colour changes for hyperlinks.
---
0.1 
initial release