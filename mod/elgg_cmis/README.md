# CMIS PHP integration

CMIS and Alfresco CMIS plugin
 * Implements access to a CMIS repository, through SOAP and ATOMPUB
 * Also provides widgets and views for Alfresco embeds, using current (browser) authentication



## Developper notes
pccHTML : HTML definitions for PHP CMIS Client

### Included libraries
Apache Chemistry CMIS PHP Client : legacy library, but not-so-up-to-date. Used initially for "User mode""
DKD PHP CMIS Client : most recent and complete library. Required for "Backend mode""

### Files metadata
Some metadata are added to files that are stored in CMIS in "Backend mode" :
 * string cmis_id : CMIS ID on CMIS filestore
 * string cmis_filepath : relative file path on CMIS filestore
 * array latest_filestore : which filestore has the latest file version, accepted values are: elgg|cmis
