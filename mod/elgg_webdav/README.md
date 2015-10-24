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

## Features
 * Virtual Elgg files server (RW, depending on Elgg access rights) : personal, public, groups and members files
 * Personal file server (RW)
 * Public file server (Read-only)
 * Group file server (RW)
 * Members file server (RW)

## TODO
 * Implement locks system
 * Access to other content types (eg. edit other objects content as HTML, etc.)
 * Implement versioning ?


