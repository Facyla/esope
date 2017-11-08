WebDAV
======

This plugin adds a webDAV server to an Elgg installation, with filesystems based - or not - on Elgg files.

See {elgg_site_url}/webdav for usage instructions


## Installation
- upload repository content to /mod/elgg_webdav/
- Go to Admin > Administer plugins and enable "WebDAV" plugin

## Usage
- Go to {elgg_site_url}/webdav for usage instructions
- Main entry point is at {elgg_site_url}/webdav/virtual for Elgg files shares
- Other entry points are file stores which are not linked to elgg files :
	- {elgg_site_url}/webdav/server for public/shared folder
	- {elgg_site_url}/webdav/user for personal folder
	- {elgg_site_url}/webdav/group for groups folders
	- {elgg_site_url}/webdav/member for members folders

Note that all WebDAV folders are also accessible through a web browser.


## Features
 * Virtual Elgg files server (RW, depending on Elgg access rights) : personal, public, groups and members files
 * Personal file server (RW)
 * Public file server (Read-only)
 * Group file server (RW)
   - subgroups support (if au_subgroups enabled)
   - folders support (if file_tools enabled)
 * Members file server (RW)

## KNOWN ISSUES
 * Moving files DO NOT EXIST in WebDAV ! If you move a file or folder it will create the new files then remove the old ones => this results in Elgg Files losing all properties, metadata, annotations, etc. So it's better not to allow deleting them yet...

## TODO
 * Override => vendors/SabreDAV/vendor/sabre/dav/lib/Tree.php to enable proper moves without losing Elgg properties and etc.
 * Implement locks system
 * Access to other content types (eg. edit other objects content as HTML, etc.)
 * Implement versioning ?


## TROUBLESHOOTING
A known issue happens when the server is hosted on a CGI/FastCGI or PHP-FPM PHP server : 
- the authentication process doesn't work as expected, as is login/pass were not valid, 
- or you might get the following error : 
	Sabre\DAV\Exception\NotAuthenticated
	No 'Authorization: Basic' header found. Either the client didn't send one, or the server is mis-configured

Main solution : you need to enable BASIC_AUTH on the server, by adding the following line to your Elgg .htaccess file (or virtual host) :
	SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1

If this solution does not work, you might try these other options mentionned here and there :

1) Add the following to .htaccess file :
	<IfModule mod_rewrite.c>
	RewriteEngine on
	RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]
	</IfModule>
And this into PHP scripts ; for this plugin we would add it to in the webdav page_handler function) :
	list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

2) Add to .htaccess file or virtual host :
	AuthType Digest



