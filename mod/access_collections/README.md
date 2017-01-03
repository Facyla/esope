# Access Collections

This plugin lets create custom access collections (ACL) that can be used globally.
These collections cas be based on custom profile types.
They can also be defined based on user properties, metadata and/or relationships, eg. has user a valid LDAP account.


## Features
 * Custom profile types based ACL : select which profile types should benefit a corresponding access collection
 * TODO: Custom admin-defined collections : static list maintained by admins
 * TODO: Criteria-based collections : pseudo-dynamic ACL based on getter functions criteria


## Usage
 * Profile type based collections : please note the collection members are NOT updated automatically. A hook should be registered to intercept any custom_profile_type metadata update
 * Disabled collections should be kept and not deleted, until all entities using that access level are updated with a new one.
 * Disabled collections cannot be used when creating new content (or updating existing one), but are used when reading content.
 * New collections can be used by regular users


## Translations
 * For profiletype based ACL, add new keys to your theme : profiletype:[profile_type_name]



## Developper notes : 
 * Limitation : only collections owners can see the name of the collections ; this applies to all custom ACLs - see http://reference.elgg.org/1.12/AccessCollections_8php_source.html#l00808




