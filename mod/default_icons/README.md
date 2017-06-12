# default_icons

This plugin provides alternative default unique generated images. 
These images can be used for users (main use case), but can apply to any entity such as sites, groups, objects, or also any text string.

There are visual hashes, meaning that they provide a recognizable shape/pattern that strongly changes if any character is changed, provided a visual shortcut to identify the identity of a user, or the integrity of some data.



## Usage

Main usage is replacing default elgg entities icons with these visual hashes, based on entity GUID - which ensures the unicity on a given site.
Added username, custom user-controlled data or hash of custom data enables having different avatars if some data changes.
Can also be used to provide feedback on password match, email integrity, etc.


### Web API : returns a unique generated image based on custom parameters
	SITE/default_icons/icon?seed=somestring&algorithm=ringicon&width=128&num=4 - recommended call
	SITE/default_icons/icon[/seed[/algorithm[/width[/num]]]] - this may change in the future

### Parameters :
 * seed : mandatory string that is used to generate the unique image
 * algorithm : optional but recommended ; select a custom algorithm (currently defaults to ringicon but this may change in the future)
 * width : integer width in pixels ; optional but highly recommended
 * num : complexity level of visual hash. Range depend of used library
 * background : set background image color or transparency (depends of used library)


## Note on icons override
Their used to be 2 main methods to override an entity icon : plugin hook and icon override. 
Plugin hook is called first, and falls back to views overrides only if there is no return. 
So Method 2 should be set as a global default, and Method 1 as a custom / dynamic feature (eg. entity-specific icon).
Default sizes are : master large, medium, small, tiny, topbar

1. Register a plugin hook on "entity:icon:url,$type" to force a specific, dynamic icon :
	Hook is triggered with : $url = elgg_trigger_plugin_hook('entity:icon:url', $entity->getType(), $params, $url);

2. Override a default view at subtype or type level to provide a default icon for an entity type/subtype
	Subtype icon : $overrideurl = elgg_view("icon/{$type}/{$subtype}/{$size}", array('entity' => $entity));
	Type icon : $overrideurl = elgg_view("icon/{$type}/default/{$size}", array('entity' => $entity));
	Global default : $url = "_graphics/icons/default/$size.png";



# Credits
This plugin uses several external classes or libraries :
 * Exorithm/Unique_image
 * Tiborsaas/Ideinticon
 * Splitbrain/php-ringicon
 * Sebsauvage/VizHash
 * Sametmax/VizHash
