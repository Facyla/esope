<?php
/**
 * accessibility plugin
 *
 */

elgg_register_event_handler('init', 'system', 'accessibility_init'); // Init



/**
 * Init adf_accessibility plugin.
 */
function accessibility_init() {
  
  global $CONFIG;
  
  elgg_extend_view('css','accessibility/css');
  
}

