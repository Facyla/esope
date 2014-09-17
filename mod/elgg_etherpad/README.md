# Etherpad Lite

This plugin integrate an Etherpad Lite instance with Elgg, and lets users use it in various ways to collaboratively edit documents.

To use it, you'll need to :
1. Have a running Etherpad Lite instance
2. Set up the API key setting (which is available in etherpad fodler as APIKEY.txt)
3. Change your cookie domain setting according to your installation : if both Elgg and Etherpad Lite are on same subdomain no chnage i needed, if you share the same domain, please set it to domain only.

As an admin :
- You can directly use the API on /pad/admin
- You can edit all pad settings on /pad/edit

As an user :
- You can access your pads on /pad or /pad/index
- You can create new pads on /pad/edit
- You can also (list and) edit your pad settings on /pad/edit
- You can view a pad on /pad/view

Important : by default pads will be mapped onto groups :
- user pads are in a group that corresponds to the creating user
- group pads are in a group that corresponds to the group
- entity pads are in a group that corresponds to the entity



