Group chat
==========

This plugin adds a text chat feature to an Elgg installation.

This chat is text file-based, and does not use any specific database, nor third-party service.

It provides several chat feature that can be enabled :
 - site chat : accessible to any site member
 - group chat (the original plugin feature) : restricted to group members
 - user chat : one-to-one or multi-users
Each chat opens in a separate new window.
The chat history is kept (1 file per chat per day), and displayed timeframe can be defined.
Chat provides live notifications for new chat messages, and is based on multipe mecanisms depending on chat type :
 - site chat : timestamp comparison (between $site->group_chat_unread and $user->group_chat_unread_site)
 - group chat (the original plugin feature)
 - user chat : user metadata keeps ids of unread chats (updated for concerned users when a new message is published)

## Installation
- upload plugin to /mod/
- Go to Admin > Administer plugins and enable "Group chat" plugin



