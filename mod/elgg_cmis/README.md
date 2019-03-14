# CMIS PHP integration
CMIS and Alfresco CMIS plugin
 * Implements access to a CMIS repository, through SOAP and ATOMPUB
 * Also provides widgets and views for Alfresco embeds, using current (browser) authentication


**WARNING**
This plugin was designed mainly for Inria's' Alfresco "Partage"" install, with the idea of being sufficiently generic to be used on other CMIS endpoints, but this plugin will probably require some tweaks on other CMIS repositories. Plugin content and structure might also evolve. If you plan to use and develop on this base, please contact the author to synchronize evolutions.



## Developper notes
pccHTML : HTML definitions for PHP CMIS Client

### Included libraries
Apache Chemistry CMIS PHP Client : legacy library, but not-so-up-to-date. Used initially for "User mode""
DKD PHP CMIS Client : most recent and complete library. Required for "Backend mode""

### Files metadata
Some metadata are added to files that are stored in CMIS in "Backend mode" :
 * string cmis_id : CMIS ID on CMIS filestore
 * string cmis_filepath : relative file path on CMIS filestore
 * array latest_filestore : filestore(s) with the latest file version, accepted values are: elgg|cmis
 Included libraries :
 - Apache Chemistry PHP Client (Incubating) PHP CMIS Client Library
   * Old reference library, but lacks features
   * https://chemistry.apache.org/php/phpclient.html
   * https://github.com/apache/chemistry-phpclient
 - DKD PHP CMIS Client :
   * Better maintained library, with more features including versionning
   * https://github.com/dkd/php-cmis-client


## History
 - 1.8.0 : new versionning
 - 0.4 : production version for Inria. Usersettings for user credentials. Added settings to enable CMIS widgets.
	 - Note : implementation in the site interface should be done in theme plugin.
 - 0.3 : first production release, mainly designed for use with Alfresco repository Partage (but should work with any CMIS endpoint)
 - 0.2 : widgets are functionnal
 - 0.1 : 20130101 - initial version


