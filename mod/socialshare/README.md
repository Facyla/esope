
# socialshare
Privacy-friendly social sharing icons

Share extensions rarely respects user privacy. This plugin does by providing social sharing links that do not track users. 
It also provides sharing a page via email (by opening user's messenger). 


***How does this work?***
By providing plain hypertext links instead of embedding iframes or JS scripts. In that way, third-party services can not track you nor inject cookies. 

***Network privacy***
The sharing menu appears only on public entities, ie. only those which have a "Public" access level. 
The motivation for that is that this plugin does not encourage sharing private resources. It considers that any non-public resource should not be shared to another group or made public without the author's consent (or the consent of the group it belongs to). Keep in mind that sharing a private resource can be considered as a leak and may be reprehensible. 

However, if this is not an issue in your site's context, this behaviour can be easily overrided in your theme by overriding the 'register', 'menu:entity' hook with a custom one:

    elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'socialshare_entity_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'mytheme_entity_menu_setup', 600);

then replace the following line:

    if ($entity->access_id == 2) {
 with your own ; e.g. if you want to allow sharing any non-private entity, it could become:

    if ($entity->access_id > 0) {
or to allow to share any resource (event private or draft):

    //if ($entity->access_id == 2) {
    ...
    //}


## Plugin settings
- Select enabled sharing services
- Extend entity menu : extends the entity menu with sharing icons
 (recommended)
 - Extend owner menu : extends the owner menu with sharing icons, eg. to share a group or a user profile. 


## Supported services
Plugin currently supports the following sharing services: 
 * Email
 * Twitter
 * LinkedIn
 * Google
 * Pinterest
 * Facebook

More third-party services can be added provided they offer a RESTful API. 


## History
 - 1.12.0 : Production version for Elgg 1.12
 - 1.8.0 : Production version for Elgg 1.8
 - 0.2 : 20140902 - First release
   	- extend entity menu
   	- option for group owner block extend
   	- add settings for sharing tools
   	- privacy respect : no trakcing (no embed nor iframe or JS script)
 - 0.1 : 20140114 - Initial version


