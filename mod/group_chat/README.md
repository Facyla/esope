Group chat
==========

This plugin adds a text chat feature to an Elgg installation.

This chat is text file-based, and does not use any specific database, nor third-party service.

It provides several chat types :
 - site chat : accessible to any site member
 - group chat : restricted to group members, can de enable globally, or in each group
 - user chat : one-to-one or multi-users chat

All chat share a set of common features :
 1. Each chat opens in a separate new window.
 2. All chats have a REST URL.
 3. The chat history is kept "forever" (1 file per chat per day), but only message in displayed timeframe can be defined.
 4. Live notifications for new chat messages, which is based on multipe mecanisms depending on chat type :
    ** site chat : timestamp comparison (between $site->group_chat_unread and $user->group_chat_unread_site)
    ** group chat : 
    ** user chat : user metadata keeps ids of unread chats (updated for concerned users when a new message is published)

## Installation
- Upload plugin to /mod/
- Go to Admin > Administer plugins and enable "Group chat" plugin
- Define wanted settings


