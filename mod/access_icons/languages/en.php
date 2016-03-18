<?php
$url = elgg_get_site_url();
$iconurl = $url . 'mod/access_icons/graphics/';

return array(
	'access_icons' => "Access rights icons",
	'access_icons:title' => "Access rights information details.",
	
	// Settings
	'access_icons:settings:helpurl' => "Access rights help page URL",
	'access_icons:settings:helpurl:help' => "Put the complete URL of a page that describes the various access levels available for this site. This page will be displayed in a \"lightbox\" (popup box into the page), so you better use a page that displays without the site interface (the use of cmspages is a good choice).<br />If empty, no link will be displayed at all.",
	'access_icons:settings:helptext' => "Access rights help page content",
	'access_icons:settings:helptext:help' => "Instead of a link to a page, you can set here the text that will be displayed to explain the various available access levels for this site. This text will be displayed in a \"lightbox\" (popup box into the page). You can use any HTML formatting. Leave this field empty if you don't want to display any link, or \"RAZ\" to reload default values.",
	
	'access_icons:settings:helptext:details' => "An easy way to create your explanation page is to use cmspages plugin, which lets you create a page that can be displayed without any interface, by adding ?embed=true. <strong><a href=\"" . $url . "cmspages/?pagetype=help-access\" target=\"_new\">Click here to create that page</a></strong>, then use <strong>" . $url . "p/<i>help-access</i>?embed=true</strong> in the above field.<br />Note : you can replace <i>help-access</i> by any custom text in this URL.<br /><br /><strong>Here is a template of an access levels details page that you can copy/paste and adapt to your site needs&nbsp;:</strong>",
	
	'access_icons:settings:helptext:default' => "<p>It is essential to define correct access levels when you are publishing new content, so you can garantee that the information you publish are shared whith the correct people.</p>
<p>Only people who have access to your publications will be able to read them. People who don't have access will not even know these publications exist.</p>
<p>So if you create a new article with a \"Private\" access level, no one will be able to read it. If you want to illustrate an article with an image, you have to make sure the image is published with at least the same level than the article (or more open). If the article is \"Public\", the image access level must be set to public as well so that the readers can view it as well.</p>
<p>&nbsp;</p>
<table>
<tbody>
<tr><th>Access levels</th><th>Explanations</th></tr>
<tr>
<td><span class=\"elgg-access elgg-access-default\">Default</span></td>
<td>&nbsp;It is not precisely an access level by itself, but the <strong>access level that is set by default</strong> on the site (or in a group) for any new content.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-public\">Public</span></td>
<td>&nbsp;Any public content is <strong>viewable by anyone</strong>. This includes any site visitor, even non-members and not logged in people : there is no need to have an account or to log in the site to have access to it. A public content is also readable and potentially indexed by search engines.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-members\">Site members</span></td>
<td>&nbsp;This publication is viewable by <strong>all and any site members</strong>, which means any person who has an account on this site. Search engines do not have access.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-group\">Group</span></td>
<td>&nbsp;This publication is viewable only by the members of a <strong>particular group</strong>.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-collection\">Liste de contacts</span></td>
<td>&nbsp;La publication est visible par les membres d'une <strong>liste de contacts</strong>. Chaque membre peut cr&eacute;er ses propres listes de contacts, qui sont strictement personnelles (pour une liste partag&eacute;e, il est pr&eacute;f&eacute;rable d'utiliser un groupe).</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-friends\">Friends</span></td>
<td>&nbsp;This publication is viewable only by the <strong>friends of the author</strong>.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-private\">Private / draft</span></td>
<td>&nbsp;This publication is viewable <strong>only by you</strong>.</td>
</tr>
<tr>
<td><span class=\"elgg-access elgg-access-public elgg-access-limited\">Limited</span></td>
<td>&nbsp;Only in walled garden mode: when the site is configured as an \"intranet\", the \"Public\" access level is replaced by \"Limited\" : only logged in users will have access to the content. Practically, this is an equivalent for \"Site Members\".</td>
</tr>
</tbody>
</table>",
	
	// Droits d'accès
	'access_icons:details' => " - Click for more information on available access rights.",
	
	// Default access level (-1)
	'access_icons:default:details' => "Default site access level (or default user access level) apply to this content.",
	
	// Private access level (0)
	'access_icons:private:details' => "This publication is PRIVATE : it is accessible only by its owner (author), or by an administrator (of the site ou of the group it's published in).",
	
	// Members access level (1)
	'access_icons:members:details' => "This publication is RESTRICTED TO SITE MEMBERS : any site member can access it (they need to be logged i).",
	
	// Public access level (2)
	'access_icons:public:details' => "This publication is PUBLIC : any person who knows this publication URL can read it whithout being logged in (it can also be indexed by search engines).",
	
	// Friends access level (-2)
	'access_icons:friends:details' => "This publication is RESTRICTED TO OWNER'S FRIENDS : only the owner's (author) friends can access it.",
	
	// Group access level (>2, owned by a group)
	'access_icons:group:details' => "This publication is RESTRICTED TO GROUP MEMBERS : only the members of the group can read it.",
	
	// Collection access level (>2, owned by a user)
	'access_icons:collection:details' => "This publication is RESTRICTED TO A CUSTOM ACCESS LIST : only the members of a custom access list of the owner can access it.",
	
	// Other / unkwnown access level (>2, owned none or other entity)
	'access_icons:other:details' => "This publication is RESTRICTED TO SOME MEMBERS : only some members and/or some types of members can access it.",
	
	// Access levels
	'access:-2' => 'Friends',
	'access:-1' => 'Default',
	'access:0' => 'Private / draft',
	'access:1' => 'Site members',
	'access:2' => 'Public',
	
);

