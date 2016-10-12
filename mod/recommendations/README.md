# Recommendations

This plugin provides users with users, groups or content recommendations.

* Recommends people : based on mutual friends, common interests and shared groups
* Recommends groups : based on featured groups and popular groups

## Usage
1. Enable plugin
2. Integrate the recommendations views in your theme OR add a link to the main recommendation page

This plugin is mainly designed for theme developpers who wish to integrate the proper views into their themes :
	elgg_view(recommendations/groups', array('entity' => $user, 'limit' => 5))
	elgg_view(recommendations/users', array('entity' => $user, 'limit' => 5))

However, a specific page can also presents all the recommendations for the current user, at SITE/recommendations


## ROADMAP :
This plugin is currently considered as a functional proof of concept, but could be improved. 
There is no planned roadmap, however i'm very open to suggestions or features requests.

Some foreseen features :
* content recommendations
* use other recommendations algorythms :
   * based not only on shared interests but also on differences (most distant profiles)
   * location-based recommentations
   * 
* general recommendations settings (adjust accuracy settings)
* recommendations caching for a given user / and/or add a mechanism to allow batch-based computation with full accuracy (eg. "Please come back in a minute / wait until you receive a notification when your personal recommentations are computed")
* improved recommendations views and presentation
* slider integration
* widgets



