# Emoji Detection
Adds Unicode Emojis in Elgg. 


## Description
 - Detects and converts input Unicode emojis to HTML entities (`&#xXXXXX;`) for MySQL storage
 - Detects and converts input text emojis (`:emojis:`) to HTML entities
 - Converts escaped html-encoded emojis to displayable HTML emojis


## Plugin settings
 - enable input hooks : required to handle emojis submitted as Unicode
 - enable output hook : required to display emojis stored as encoded html entities or as shortcodes
 - enable TheWire : replacement functions and action for TheWire (which requires a special treatment)
 - debug mode : useful for performance testings and debug (adds additional entries in logs)


## ROADMAP
 - Provide endpoint for emojis search


## Credits
Library : https://github.com/aaronpk/emoji-detector-php


## Developers notes
Included library has been modified for better performance (use session cache for map and regex data, which are stored in $_SESSION)
The plugin provides a mechanism for better performance, based on emojis containing strings stored in a $_SESSION cache.


## History
1.12.1 : 2018.11 - Performance improvements
1.12.0 : 2018.10 - Initial release

