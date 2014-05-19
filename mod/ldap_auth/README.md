== USAGE ==
This plugin lets user connect, or even register, to an Elgg instance with a valid LDAP account, and update profile fields based on LDAP fields.

== INSTALLATION ==
 * Copy plugin into Elgg mod/ directory
 * Duplicate settings_dist.php as settings.php
 * Edit settings.php file with LDAP servers info and matching fields between LDAP and Elgg
 * Activate plugin
 * Configure plugin with desired behaviour
 * (developpers) optionnaly use provided hook to define own behaviour (see lib file for hook details) :
   * 'check_profile', 'ldap_auth'
   * 'update_profile', 'ldap_auth'
   * 'clean_group_name', 'ldap_auth'

== Notes ==
 * To be displayed on user profile, profile fields should be defined in Elgg profile (using profile_manager or a custom plugin)

== For developpers ==
 * Please contact us before forking, is the plugin doesn't work as intended, as it is actively maintained !


