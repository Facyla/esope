# Content Facets

This plugin extracts linked content from text, and provides it through various means for other plugins.
It is mainly aimed at extracting information from unstructured text, in plain text or HTML.
Content facets basically associates a parser, a scraper and a rendering engine.

Extracts :
 - links (HTML), URLs (text) and emails
 - images
 - @TODO tags
 - @TODO summary

Detects :
 - in-site resources, ie. Elgg entities
 - videos
 - images
 - other resources from various providers (depending on used libraries)

Displays :
 - @TODO embedded resources : video player, image
 - @TODO improved links (with title, description, meta, thumbnail...)
 - @TODO linked data (informal links between Elgg entities)

Enriches Elgg entities : extracted data can be used to enrich the source entity
 - @TODO relationships with other entities, eg. attached files, illustration media, etc.
 - @TODO metadata (tags, summary)

Features & settings :
 - @TODO different modes : inline enrich, external enrich
 - @TODO different views and APIs for different types, subtypes... : inline enrich, external enrich
 - @TODO add displays hooks to control new subtypes
 - @TODO provide helper functions for theme developpers


ROADMAP :
	extend output/longtext with additional data
	provide reusable views / functions for content extraction (can display any extracted resources list by type + rendering settings)
	DATA to be able to identify :
		local entities (users, groups, objects)
		internal links (same site url)
		external resources by type : images, files, videos, etc.


INCLUDED EXTERNAL LIBS :
- Essence : http://essence.github.io/essence/ Media extraction
- Works well with https://github.com/felixgirault/multiplayer Media embed
- Goutte : HTML parser (better that DOMDocument)
- hQuery : HTML parser https://github.com/duzun/hQuery.php
- Miner : https://github.com/yoozi/miner
- ...

POTENTIAL EXTERNAL LIBS :
- Essence : http://essence.github.io/essence/ Media extraction
- Works well with https://github.com/felixgirault/multiplayer Media embed
- Goutte : HTML parser (better that DOMDocument)
- hQuery : HTML parser https://github.com/duzun/hQuery.php
- Miner : https://github.com/yoozi/miner
- ...

